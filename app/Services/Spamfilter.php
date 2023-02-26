<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\GuestbookPost;
use Illuminate\Support\Facades\DB;

class Spamfilter
{
    private float $threshold_no_autolearn_ham = 0.38;

    private float $threshold_autolearn_ham = 0.48;

    private float $threshold_ham = 0.48;

    private float $threshold_spam = 0.55;

    public float $threshold_autolearn_spam = 0.55;

    private float $threshold_no_autolearn_spam = 0.9;

    /**
     * Initialize the filter database
     *
     * @param  array{'ham': array<int, string>, 'spam': array<int, string>}  $texts
     */
    public function initializeAll(array $texts): void
    {
        DB::table('filter_texts')->delete();
        DB::table('filter_texts')->insert([
            'category' => 'ham',
            'count_texts' => count($texts['ham']),
        ]);
        DB::table('filter_texts')->insert([
            'category' => 'spam',
            'count_texts' => count($texts['spam']),
        ]);
        DB::table('filter_tokens')->delete();
        $table_data = [];
        foreach ($texts as $category => $posts) {
            foreach ($posts as $post) {
                $tokens = $this->parse($post);
                foreach ($tokens as $token => $count) {
                    if (! isset($table_data[$token])) {
                        $table_data[$token] = [
                            'count_ham' => 0,
                            'count_spam' => 0,
                        ];
                    }
                    if ($category == 'ham') {
                        $table_data[$token]['count_ham']++;
                    } else {
                        $table_data[$token]['count_spam']++;
                    }
                }
            }
        }
        // Prepare INSERT array
        $inserts = [];
        foreach ($table_data as $token => $counts) {
            $inserts[] = array_merge(['token' => $token], $counts);
        }
        DB::table('filter_tokens')->insert($inserts);
    }

    /**
     * Check if the given score is spam
     */
    public function isSpam(float $score): bool
    {
        return $score >= $this->threshold_spam;
    }

    /**
     * Check if the given score should be learned as spam
     */
    public function isAutolearnSpam(float $score): bool
    {
        if (
            $score >= $this->threshold_autolearn_spam and
            $score < $this->threshold_no_autolearn_spam
        ) {
            return true;
        }

        return false;
    }

    /**
     * Classify a text
     */
    public function classify(string $text, string $spam_detection): float
    {
        // Make sure there is a text to rate, else return 0.5
        if (trim($text) == '') {
            return 0.5;
        }
        $tokens = $this->parse($text);
        // Add the additional spam detection, but do not parse it.
        $tokens[$spam_detection] = 1;
        // Get all known tokens for this text.
        $known_tokens = DB::table('filter_tokens')
            ->whereIn('token', array_keys($tokens))
            ->get();
        // Get the sums for ham and spam messages.
        // Ensure that the count is not zero, to avoid a division by zero error.
        $count_total_ham = max(
            1,
            DB::table('filter_texts')
                ->where('category', 'ham')
                ->value('count_texts'),
        );
        $count_total_spam = max(
            1,
            DB::table('filter_texts')
                ->where('category', 'spam')
                ->value('count_texts'),
        );
        // Calculate probabilities for each known token
        $rating = [];
        $importance = [];
        foreach ($known_tokens as $known_token) {
            $prob_spam = $known_token->count_spam / $count_total_spam;
            $prob_ham = $known_token->count_ham / $count_total_ham;
            $rating[$known_token->token] =
                $prob_spam / ($prob_spam + $prob_ham);
            // Calculate the better probability proposed by Gary Robinson.
            // This handles the case of rare words much better.
            $total_count = $known_token->count_ham + $known_token->count_spam;
            $rating[$known_token->token] =
                (0.3 * 0.5 + $total_count * $rating[$known_token->token]) /
                (0.3 + $total_count);
            // The "importance" is used to extract the most meaningful
            // tokens, i.e. those which are towards 0 or 1.
            $importance[$known_token->token] = abs(
                0.5 - $rating[$known_token->token],
            );
        }
        // Reverse sorting of array, maintaining key association
        arsort($importance);
        // Use 15 tokens at most for calculation.
        $maximum_number_of_tokens = 15;
        $token_count = 0;
        $relevant_tokens = [];
        foreach ($importance as $token => $value) {
            $relevant_tokens[$token] = $rating[$token];
            $token_count++;
            if ($token_count >= $maximum_number_of_tokens) {
                break;
            }
        }
        // Calculcate the combined probability for all relevant tokens,
        // i.e. the actual spam score
        $hamminess = 1;
        $spamminess = 1;
        foreach ($relevant_tokens as $token => $rating) {
            $hamminess *= 1 - $rating;
            $spamminess *= $rating;
        }
        if ($hamminess == 1 and $spamminess == 1) {
            return 0.5;
        }
        $hamminess = 1 - pow($hamminess, 1 / count($relevant_tokens));
        $spamminess = 1 - pow($spamminess, 1 / count($relevant_tokens));
        // This returns values between -1 and 1
        $spam_score = ($hamminess - $spamminess) / ($hamminess + $spamminess);
        // Adapt the scale to 0 and 1
        $spam_score = (1 + $spam_score) / 2;

        return $spam_score;
    }

    /**
     * Learn status after update.
     */
    public function learnStatus(GuestbookPost $post): void
    {
        $text = $post->name.' '.$post->message;
        $spam_detection = $post->spam_detection;
        if (
            $post->category == 'manual_spam' or
            $post->category == 'autolearn_spam'
        ) {
            $this->addSpam($text, $spam_detection);
        }
        if (
            $post->category == 'manual_ham' or
            $post->category == 'autolearn_ham'
        ) {
            $this->addHam($text, $spam_detection);
        }
    }

    /**
     * Unlearn status after update.
     */
    public function unlearnStatus(GuestbookPost $post): void
    {
        $text = $post->name.' '.$post->message;
        $spam_detection = $post->spam_detection;
        if (
            $post->category == 'manual_spam' or
            $post->category == 'autolearn_spam'
        ) {
            $this->removeSpam($text, $spam_detection);
        }
        if (
            $post->category == 'manual_ham' or
            $post->category == 'autolearn_ham'
        ) {
            $this->removeHam($text, $spam_detection);
        }
    }

    /**
     * Calculate spam category
     */
    public function calculateCategory(float $score): string
    {
        $category = 'unsure';
        if ($score <= $this->threshold_ham) {
            $category = 'ham';
        }
        if ($score <= $this->threshold_autolearn_ham) {
            $category = 'autolearn_ham';
        }
        if ($score <= $this->threshold_no_autolearn_ham) {
            $category = 'no_autolearn_h';
        }
        if ($score >= $this->threshold_spam) {
            $category = 'spam';
        }
        if ($score >= $this->threshold_autolearn_spam) {
            $category = 'autolearn_spam';
        }
        if ($score >= $this->threshold_no_autolearn_spam) {
            $category = 'no_autolearn_s';
        }

        return $category;
    }

    /**
     * Adds a text to the Ham database
     */
    public function addHam(string $text, string $spam_detection): void
    {
        $tokens = $this->parse($text);
        // Add the additional spam detection, but do not parse it.
        $tokens[$spam_detection] = 1;
        // If the token is already known, sum up the current count.
        $known_tokens = DB::table('filter_tokens')
            ->whereIn('token', array_keys($tokens))
            ->get();
        foreach ($known_tokens as $known_token) {
            $tokens[$known_token->token] = [
                'count_ham' => $known_token->count_ham + 1,
                'count_spam' => $known_token->count_spam,
            ];
        }
        // Update the filter_token table
        foreach ($tokens as $token => $count) {
            if (is_array($count)) {
                // Update existing token.
                DB::table('filter_tokens')
                    ->where('token', (string) $token)
                    ->update([
                        'count_ham' => $count['count_ham'],
                        'count_spam' => $count['count_spam'],
                    ]);
            } else {
                // New record.
                DB::table('filter_tokens')->insert([
                    'token' => (string) $token,
                    'count_ham' => $count,
                    'count_spam' => 0,
                ]);
            }
        }
        // Finally, increment the number of known texts
        DB::table('filter_texts')
            ->where('category', 'ham')
            ->increment('count_texts');
    }

    /**
     * Removes a text from the Ham database
     */
    public function removeHam(string $text, string $spam_detection): void
    {
        $tokens = $this->parse($text);
        // Add the additional spam detection, but do not parse it.
        $tokens[$spam_detection] = 1;
        // Sum up the current count.
        $known_tokens = DB::table('filter_tokens')
            ->whereIn('token', array_keys($tokens))
            ->get();
        foreach ($known_tokens as $known_token) {
            $tokens[$known_token->token] = [
                'count_ham' => max($known_token->count_ham - 1, 0),
                'count_spam' => $known_token->count_spam,
            ];
        }
        // Update the filter_token table
        foreach ($tokens as $token => $count) {
            if (is_array($count)) {
                // Update existing token.
                DB::table('filter_tokens')
                    ->where('token', (string) $token)
                    ->update([
                        'count_ham' => $count['count_ham'],
                        'count_spam' => $count['count_spam'],
                    ]);
            }
        }
        // Decrement the number of known texts
        DB::table('filter_texts')
            ->where('category', 'ham')
            ->decrement('count_texts');
        // Clean up the table and remove words where both counts are zero
        DB::table('filter_tokens')
            ->where('count_ham', 0)
            ->where('count_spam', 0)
            ->delete();
    }

    /**
     * Adds a text to the Spam database
     */
    public function addSpam(string $text, string $spam_detection): void
    {
        $tokens = $this->parse($text);
        // Add the additional spam detection, but do not parse it.
        $tokens[$spam_detection] = 1;
        // If the token is already known, sum up the current count.
        $known_tokens = DB::table('filter_tokens')
            ->whereIn('token', array_keys($tokens))
            ->get();
        foreach ($known_tokens as $known_token) {
            $tokens[$known_token->token] = [
                'count_ham' => $known_token->count_ham,
                'count_spam' => $known_token->count_spam + 1,
            ];
        }
        // Update the filter_token table
        foreach ($tokens as $token => $count) {
            if (is_array($count)) {
                // Update existing token.
                DB::table('filter_tokens')
                    ->where('token', (string) $token)
                    ->update([
                        'count_ham' => $count['count_ham'],
                        'count_spam' => $count['count_spam'],
                    ]);
            } else {
                // New record.
                DB::table('filter_tokens')->insert([
                    'token' => (string) $token,
                    'count_ham' => 0,
                    'count_spam' => $count,
                ]);
            }
        }
        // Finally, increment the number of known texts
        DB::table('filter_texts')
            ->where('category', 'spam')
            ->increment('count_texts');
    }

    /**
     * Removes a text from the Spam database
     */
    public function removeSpam(string $text, string $spam_detection): void
    {
        $tokens = $this->parse($text);
        // Add the additional spam detection, but do not parse it.
        $tokens[$spam_detection] = 1;
        // Sum up the current count.
        $known_tokens = DB::table('filter_tokens')
            ->whereIn('token', array_keys($tokens))
            ->get();
        foreach ($known_tokens as $known_token) {
            $tokens[$known_token->token] = [
                'count_ham' => $known_token->count_ham,
                'count_spam' => max($known_token->count_spam - 1, 0),
            ];
        }
        // Update the filter_token table
        foreach ($tokens as $token => $count) {
            if (is_array($count)) {
                // Update existing token.
                DB::table('filter_tokens')
                    ->where('token', (string) $token)
                    ->update([
                        'count_ham' => $count['count_ham'],
                        'count_spam' => $count['count_spam'],
                    ]);
            }
        }
        // Decrement the number of known texts
        DB::table('filter_texts')
            ->where('category', 'spam')
            ->decrement('count_texts');
        // Clean up the table and remove words where both counts are zero
        DB::table('filter_tokens')
            ->where('count_ham', 0)
            ->where('count_spam', 0)
            ->delete();
    }

    /**
     * Split a text into tokens, do not count multiple occurrences of words.
     *
     * @return array<string, int>
     */
    public function parse(string $text): array
    {
        $result = [];
        $text = [$text];
        // Extract possible HTML tags
        $text = $this->parseHTML($text);
        // Extract possible smileys
        $text = $this->parseSmileys($text);
        foreach ($text as $part) {
            $tokens = preg_split('/([\s.,\'"])+/', $part);
            // The result should always be 1, don't count words multiple times.
            foreach ($tokens as $token) {
                $token = trim($token);
                if ($token == '') {
                    continue;
                }
                $result[$token] = 1;
            }
        }

        return $result;
    }

    /**
     * Split a text into HTML tags, if any.
     *
     * @param  array<int, string>  $text
     * @return array<int, string>
     */
    private function parseHTML(array $text): array
    {
        $result = [];
        foreach ($text as $part) {
            $tokens = preg_split(
                '/(<[^>]+?>)/',
                $part,
                -1,
                PREG_SPLIT_DELIM_CAPTURE,
            );
            foreach ($tokens as $token) {
                $token = trim($token);
                if ($token == '') {
                    continue;
                }
                $result[] = $token;
            }
        }

        return $result;
    }

    /**
     * Split smileys into own texts, even if written without delimiters.
     *
     * @param  array<int, string>  $text
     * @return array<int, string>
     */
    private function parseSmileys(array $text): array
    {
        $result = [];
        foreach ($text as $part) {
            $tokens = preg_split(
                '/(\[[^[\]]+?])/',
                $part,
                -1,
                PREG_SPLIT_DELIM_CAPTURE,
            );
            foreach ($tokens as $token) {
                $token = trim($token);
                if ($token == '') {
                    continue;
                }
                $result[] = $token;
            }
        }

        return $result;
    }
}
