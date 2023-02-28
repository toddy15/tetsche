<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\NewGuestbookPost;
use App\Models\GuestbookPost;
use App\Models\PublicationDate;
use App\Models\User;
use App\Services\Spamfilter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class GuestbookPostsController extends Controller
{
    public function index(): View
    {
        $guestbook_posts = GuestbookPost::whereNotIn('category', [
            'manual_spam',
            'autolearn_spam',
        ])
            ->latest()
            ->simplePaginate(10);

        return view('guestbook_posts.index', [
            'guestbook_posts' => $guestbook_posts,
            'title' => 'Gästebuch',
            'description' => 'Gästebuch der Tetsche-Website',
            'query' => '',
        ]);
    }

    public function create(): View
    {
        return view('guestbook_posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $post = $request->all();
        $spamfilter = new Spamfilter();
        $text = $post['name'].' '.$post['message'];
        // Use IP address and browser identification for more robust spam detection
        $spam_detection = 'IP: '.$request->ip();
        $spam_detection .= ', Browser: '.$request->server('HTTP_USER_AGENT');
        $post['score'] = $spamfilter->classify($text, $spam_detection);
        // @FIXME: Filter out the fuckheads, based on IP address
        if (! $spamfilter->isSpam($post['score'])) {
            $ip = explode('.', $request->ip());
            if ($ip[0] == 141 and $ip[1] == 48) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if ($ip[0] == 80 and $ip[1] == 187) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if ($ip[0] == 217 and $ip[1] == 240 and $ip[2] == 29) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if ($ip[0] == 194 and $ip[1] == 230 and $ip[2] == 77) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if ($ip[0] == 36 and $ip[1] == 80) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if ($ip[0] == 93 and $ip[1] == 214 and $ip[2] == 118) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if ($ip[0] == 93 and $ip[1] == 207) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if ($ip[0] == 79 and $ip[1] == 232 and $ip[2] == 145) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if ($ip[0] == 212 and $ip[1] == 6 and $ip[2] == 125) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if ($ip[0] == 112 and $ip[1] == 206 and $ip[2] == 2) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if ($ip[0] == 109 and $ip[1] == 43 and $ip[2] == 113) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
        }
        // New feature: detect the solution to current rebus
        // @todo: This code is copied from CartoonController, remove duplication.
        $date = date('Y-m-d', time() + 6 * 60 * 60);
        $current_cartoon = PublicationDate::where('publish_on', '<=', $date)
            ->latest('publish_on')
            ->first();
        $cartoon = PublicationDate::where(
            'publish_on',
            '=',
            $current_cartoon->publish_on,
        )->first()->cartoon;
        // Compare case insensitive for better results
        if (stripos($text, $cartoon->rebus) !== false) {
            $post['score'] = $spamfilter->threshold_autolearn_spam;
        }

        $post['category'] = $spamfilter->calculateCategory($post['score']);
        $post['spam_detection'] = $spam_detection;
        $validator = Validator::make($post, [
            'name' => 'required',
            'message' => 'required',
        ]);
        // Add the spam check
        $validator->after(function ($validator) use ($post, $spamfilter) {
            if ($spamfilter->isSpam($post['score'])) {
                $validator->errors()->add(
                    'message',
                    'Der Eintrag wurde als Spam eingestuft und daher nicht gespeichert.',
                );
                // @FIXME: Remove this part if sending all spam mails is no longer necessary.
                if (! $spamfilter->isAutolearnSpam($post['score'])) {
                    $new_post = new GuestbookPost($post);
                    $new_post->score = $post['score'];

                    $mail = new NewGuestbookPost($new_post);
                    $mail->subject('Neuer Eintrag im Tetsche-Gästebuch (als Spam abgelehnt)');
                    $toddy = User::find(1) ?? ['email' => "none@example.org"];
                    Mail::to($toddy)->send($mail);
                }
            }
            // Special case: autolearning spam
            if ($spamfilter->isAutolearnSpam($post['score'])) {
                $new_post = GuestbookPost::create($post);
                $spamfilter->learnStatus($new_post);
                $new_post->score = $post['score'];

                $mail = new NewGuestbookPost($new_post);
                $mail->subject('Neuer Eintrag im Tetsche-Gästebuch (als Spam gelernt)');
                $toddy = User::find(1) ?? ['email' => "none@example.org"];
                Mail::to($toddy)->send($mail);
            }
        });
        if ($validator->fails()) {
            return redirect()->action([
                GuestbookPostsController::class, 'create',
            ])
                ->withErrors($validator)
                ->withInput();
        }
        // Store the post.
        $new_post = GuestbookPost::create($post);
        $new_post->score = $post['score'];

        // Learn status.
        $spamfilter->learnStatus($new_post);

        $mail = new NewGuestbookPost($new_post);
        $mail->subject('Neuer Eintrag im Tetsche-Gästebuch');
        // Send mail to first two users
        $toddy = User::find(1) ?? ['email' => "none@example.org"];
        $tetsche = User::find(2) ?? ['email' => "none@example.org"];
        Mail::to([$toddy, $tetsche])->send($mail);

        $request->session()->flash('info', 'Der Eintrag wurde gespeichert.');

        return redirect()->action([GuestbookPostsController::class, 'index']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $guestbook_post = GuestbookPost::findOrFail($id);
        // Calculate spam score
        $spamfilter = new Spamfilter();
        $text = $guestbook_post->name.' '.$guestbook_post->message;
        $guestbook_post->score = round(
            $spamfilter->classify($text, $guestbook_post->spam_detection) * 100,
            1,
        );

        return view('guestbook_posts.edit', compact('guestbook_post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $guestbook_post = GuestbookPost::findOrFail($id);
        // First, unlearn status.
        $spamfilter = new Spamfilter();
        $spamfilter->unlearnStatus($guestbook_post);
        $new_data = $request->all();
        // Add a safety net for accidentally choosing the wrong category
        if ($new_data['category'] == '-') {
            $new_data['category'] = 'unsure';
        }
        $guestbook_post->update($new_data);
        // Relearn spam status
        $spamfilter->learnStatus($guestbook_post);
        $request->session()->flash('info', 'Der Eintrag wurde geändert.');

        return to_route('gaestebuch.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        $guestbook_post = GuestbookPost::findOrFail($id);
        $spamfilter = new Spamfilter();
        $spamfilter->unlearnStatus($guestbook_post);
        GuestbookPost::destroy($id);
        $request->session()->flash('info', 'Der Eintrag wurde gelöscht.');

        return to_route('gaestebuch.index');
    }
}
