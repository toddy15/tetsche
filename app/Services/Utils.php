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

    public function getSmileysImages(): array
    {
        $smileys = $this->getSmileysImageHTML(true);
        $result = [];
        foreach ($smileys as $code => $image) {
            $result[] = $image;
        }

        return $result;
    }

    public function getSmileysButtons(): array
    {
        $smileys = $this->getSmileysImageHTML(true);
        $result = [];
        foreach ($smileys as $code => $image) {
            $html =
                '<button type="button" class="btn btn-light" onclick="insert(\''.
                $code.
                '\')">';
            $html .= $image;
            $html .= '</button>';
            $result[] = $html;
        }

        return $result;
    }

    public function getSmileysIDsAndText(): array
    {
        $smileys = $this->getSmileys(true);
        $result = [];
        foreach ($smileys as $code => $info) {
            $result[$code] = $info['filename'];
        }

        return $result;
    }

    private function getSmileysImageHTML(bool $unique = false): array
    {
        $smileys = $this->getSmileys($unique);
        $result = [];
        foreach ($smileys as $code => $info) {
            $result[$code] =
                '<img id="smiley-'.
                $info['filename'].
                '" src="'.
                asset('images/guestbook/'.$info['filename'].'.svg').
                '" ';
            $result[$code] .=
                'width="18" height="18" alt="'.$info['name'].'"/>';
        }

        return $result;
    }

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
