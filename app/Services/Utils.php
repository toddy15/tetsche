<?php

declare(strict_types=1);

namespace App\Services;

class Utils
{
    public function replaceSmileys(string $text): string
    {
        $text = nl2br(htmlspecialchars($text));
        $smileys = $this->getSmileysImageHTML();
        foreach ($smileys as $code => $image) {
            $text = str_replace($code, $image, $text);
        }

        return $text;
    }

    /**
     * @return array<int, string>
     */
    public function getSmileysImages(): array
    {
        $smileys = $this->getSmileysImageHTML(true);
        $result = [];
        foreach ($smileys as $image) {
            $result[] = $image;
        }

        return $result;
    }

    /**
     * @return array<int, string>
     */
    public function getSmileysButtons(): array
    {
        $smileys_ids = $this->getSmileys(true);
        $smileys = $this->getSmileysImageHTML(true);
        $result = [];
        foreach ($smileys as $code => $image) {
            $html
                = '<button type="button" class="btn btn-light" '
                .'id="smiley-'.$smileys_ids[$code]['filename'].'">';
            $html .= $image;
            $html .= '</button>';
            $result[] = $html;
        }

        return $result;
    }

    /**
     * @return array<string, string>
     */
    private function getSmileysImageHTML(bool $unique = false): array
    {
        $smileys = $this->getSmileys($unique);
        $result = [];
        foreach ($smileys as $code => $info) {
            $result[$code]
                = '<img src="'.
                asset('images/guestbook/'.$info['filename'].'.svg').
                '" ';
            $result[$code]
                .= 'width="18" height="18" alt="'.$info['name'].'"/>';
        }

        return $result;
    }

    /**
     * @return array<string, array{'filename': string, 'name': string}>
     */
    private function getSmileys(bool $unique = false): array
    {
        $smileys = [
            ':-)' => 'Smile',
            ':)' => 'Smile',
            ';-)' => 'Blinzeln',
            ';)' => 'Blinzeln',
            ':-(' => 'Traurig',
            ':(' => 'Traurig',
            ':-D' => 'Lachen',
            ':D' => 'Lachen',
            ':-P' => 'Bäh!',
            ':P' => 'Bäh!',
            ':-O' => 'Oh!',
            // Replace lowercase too
            ':-p' => 'Bäh!',
            ':p' => 'Bäh!',
            ':-o' => 'Oh!',
            '[sauer]' => 'Sauer',
            '[cool]' => 'Cool',
            '[Herz]' => 'Herz',
            '[Pümpel]' => 'Pümpel',
            '[Spiegelei]' => 'Spiegelei',
            '[Kondom]' => 'Kondom',
            '[Säge]' => 'Säge',
            '[Knochen]' => 'Knochen',
        ];
        $skip = [':)', ';)', ':(', ':D', ':P', ':-p', ':p', ':-o'];
        $result = [];
        foreach ($smileys as $code => $name) {
            if ($unique and in_array($code, $skip)) {
                continue;
            }
            $filename = strtolower($name);
            $filename = str_replace('ä', 'ae', $filename);
            $filename = str_replace('ö', 'oe', $filename);
            $filename = str_replace('ü', 'ue', $filename);
            $filename = str_replace('Ä', 'Ae', $filename);
            $filename = str_replace('Ö', 'Oe', $filename);
            $filename = str_replace('Ü', 'Ue', $filename);
            $filename = str_replace('ß', 'ss', $filename);
            $filename = str_replace('!', '', $filename);
            $result[$code] = ['filename' => $filename, 'name' => $name];
        }

        return $result;
    }
}
