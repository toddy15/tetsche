<?php

namespace App\TwsLib;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Better404
{
    /**
     * Implement custom 404 routine
     *
     * Use the approach from a more useful 404.
     * @see http://alistapart.com/article/amoreuseful404
     */
    public static function handleNotFound(Request $request)
    {
        $referer = $request->server->get('HTTP_REFERER');
        $my_host = $request->getHost();
        $requested_uri = $request->getRequestUri();
        // Short cut: Do not send e-mails for some URIs.
        $no_mail_uris = [
            '#/archiv/[0-9]{4}-[0-9]{2}-[0-9]{2}#',
            '#/favicon\.ico#',
            '#/g&auml;stebuch#',
        ];
        foreach ($no_mail_uris as $no_mail_uri) {
            if (preg_match($no_mail_uri, $requested_uri)) {
                $referer = '';
            }
        }
        // Set up message for user
        $msg_lines = [];
        $msg_lines[] = 'Die Seite, die Sie aufrufen wollten, existiert nicht.';
        if ($referer == '') {
            // There is no referer
            $msg_lines[] = 'Die Ursache scheint ein Tippfehler in der Adresse oder ein veraltetes Lesezeichen in Ihrem Browser zu sein.';
            $msg_lines[] = 'Bitte benutzen Sie die Navigation, um die gewünschte Seite zu finden.';
        }
        else {
            // There is a referer, extract the host
            $referer_host = explode('//', $referer)[1];
            $referer_host = explode('/', $referer_host)[0];
            // Create data array for e-mail
            $data = [
                'referer' => $referer,
                'requested_uri' => $requested_uri,
            ];
            if ($referer_host == $my_host) {
                // There is a bad link on this site
                $msg_lines[] = 'Anscheinend haben wir einen falschen Link auf unserer Seite. Es wurde gerade eine E-Mail an den Webmaster geschickt, damit das schnell behoben werden kann.';
                $msg_lines[] = 'Sie müssen nichts weiter tun.';
                $data['origin'] = 'own_website';
                $subject = 'HTTP 404: Interner Link fehlerhaft';
            }
            else {
                if (self::isSearchEngine($referer_host)) {
                    $msg_lines[] = 'Anscheinend hat eine Suchmaschine einen veralteten Link in ihrem Index. Diese veralteten Links werden nach einiger Zeit automatisch aus dem Index der Suchmaschine entfernt.';
                    $msg_lines[] = 'Bitte benutzen Sie die Navigation, um die gewünschte Seite zu finden.';
                    $data['origin'] = 'search_engine';
                    $subject = 'HTTP 404: Link von Suchmaschine fehlerhaft';
                }
                else {
                    // Bad link from someone else's website
                    $msg_lines[] = 'Anscheinend ist der Link auf der Webseite, von der Sie gerade hierher gekommen sind, falsch. Wir wurden darüber informiert und werden versuchen, den Link auf der anderen Webseite ändern zu lassen.';
                    $msg_lines[] = 'Bitte benutzen Sie die Navigation, um die gewünschte Seite zu finden.';
                    $data['origin'] = 'other_website';
                    $subject = 'HTTP 404: Link von anderer Website fehlerhaft';
                }
            }
            // Optional: send e-mail to webmaster
            /*
            Mail::queue(['text' => 'emails.better404'], $data, function ($message) use ($subject) {
                $message->from('webmaster@tetsche.de', 'Webmaster');
                $message->to('webmaster@tetsche.de', 'Webmaster');
                $message->subject($subject);
            });
            */
        }
        return response()
            ->view('errors.better404', compact('msg_lines'))
            ->setStatusCode(404);
    }

    /**
     * Detect if a given host is a known search engine.
     *
     * @param $host
     * @return bool
     */
    private static function isSearchEngine($host)
    {
        $is_search_engine = false;
        // Detect search engines
        $search_engines = [
            'google', 'bing', 'duckduckgo', 'yahoo',
        ];
        foreach ($search_engines as $search_engine) {
            if (strpos($host, $search_engine) !== false) {
                $is_search_engine = true;
                break;
            }
        }
        return $is_search_engine;
    }
}
