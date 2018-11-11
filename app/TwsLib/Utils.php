<?php

namespace App\TwsLib;

class Utils
{
    public function replaceSmileys($text) {
        $text = nl2br(htmlspecialchars($text));
        $smileys = $this->getSmileysImageHTML();
        foreach ($smileys as $code => $image)	{
            $text = str_replace($code, $image, $text);
        }
        return $text;
    }

    public function getSmileysImages() {
        $smileys = $this->getSmileysImageHTML(true);
        $result = array();
        foreach ($smileys as $code => $image)	{
            $result[] = $image;
        }
        return $result;
    }

    public function getSmileysIDsAndText() {
        $smileys = $this->getSmileys(true);
        $result = array();
        foreach ($smileys as $code => $info)	{
            $result[$code] = $info['filename'];
        }
        return $result;
    }

    private function getSmileysImageHTML($unique = false) {
        $smileys = $this->getSmileys($unique);
        $result = array();
        foreach ($smileys as $code => $info)	{
            $result[$code] = '<img id="smiley-' . $info['filename'] . '" src="' .
                asset(elixir('images/guestbook/' . $info['filename'] . '.svg')) . '" ';
            $result[$code] .= 'width="18" height="18" alt="' . $info['name'] . '" title="' . $info['name'] . '" />';
        }
        return $result;
    }

    private function getSmileys($unique = false) {
        $smileys = array(
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
        );
        $skip = array (':)', ';)', ':(', ':D', ':P', ':-p', ':p', ':-o');
        foreach ($smileys as $code => $name) {
            if ($unique and in_array($code, $skip)) continue;
            $filename = strtolower($name);
            $filename = str_replace("ä", "ae", $filename);
            $filename = str_replace("ö", "oe", $filename);
            $filename = str_replace("ü", "ue", $filename);
            $filename = str_replace("Ä", "Ae", $filename);
            $filename = str_replace("Ö", "Oe", $filename);
            $filename = str_replace("Ü", "Ue", $filename);
            $filename = str_replace("ß", "ss", $filename);
            $filename = str_replace("!", "", $filename);
            $result[$code] = array('filename' => $filename, 'name' => $name);
        }
        return $result;
    }

    /**
     * Check if the new site should be shown after the stern
     * publication has ended.
     *
     * @TODO Include the time in the check as well (18:00)
     * @return Boolean
     */
    public static function showNewSite() {
        if (date("Y-m-d") >= "2018-12-13") {
            return true;
        }
        return false;
    }
}
