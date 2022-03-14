<?php

namespace App\Http\Controllers;

use App\GuestbookPost;
use App\Mail\NewGuestbookPost;
use App\PublicationDate;
use App\TwsLib\Spamfilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GuestbookPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $guestbook_posts = GuestbookPost::whereNotIn('category', ['manual_spam', 'autolearn_spam'])
            ->latest()
            ->simplePaginate(10);

        return view('guestbook_posts.index', [
            'guestbook_posts' => $guestbook_posts,
            'title' => 'Gästebuch',
            'keywords' => 'Gästebuch',
            'description' => 'Gästebuch der Tetsche-Website',
            'query' => '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('guestbook_posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $spamfilter = new Spamfilter();
        $text = $post['name'].' '.$post['message'];
        // Use IP address and browser identification for more robust spam detection
        $spam_detection = "IP: ".$request->ip();
        $spam_detection .= ", Browser: ".$request->server('HTTP_USER_AGENT');
        $post['score'] = $spamfilter->classify($text, $spam_detection);
        // @FIXME: Filter out the fuckheads, based on IP address
        if (!$spamfilter->isSpam($post['score'])) {
            $ip = explode('.', $request->ip());
            if (($ip[0] == 141) and ($ip[1] == 48)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if (($ip[0] == 80) and ($ip[1] == 187)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if (($ip[0] == 217) and ($ip[1] == 240) and ($ip[2] == 29)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if (($ip[0] == 194) and ($ip[1] == 230) and ($ip[2] == 77)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if (($ip[0] == 36) and ($ip[1] == 80)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if (($ip[0] == 93) and ($ip[1] == 214) and ($ip[2] == 118)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if (($ip[0] == 93) and ($ip[1] == 207)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if (($ip[0] == 79) and ($ip[1] == 232) and ($ip[2] == 145)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if (($ip[0] == 212) and ($ip[1] == 6) and ($ip[2] == 125)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if (($ip[0] == 112) and ($ip[1] == 206) and ($ip[2] == 2)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
            if (($ip[0] == 109) and ($ip[1] == 43) and ($ip[2] == 113)) {
                $post['score'] = $spamfilter->threshold_autolearn_spam;
            }
        }
        // New feature: detect the solution to current rebus
        // @todo: This code is copied from CartoonController, remove duplication.
        $date = date('Y-m-d', time() + 6 * 60 * 60);
        $current_cartoon = PublicationDate::where('publish_on', '<=', $date)
            ->orderBy('publish_on', 'DESC')
            ->first();
        $cartoon = PublicationDate::where(
            'publish_on',
            '=',
            $current_cartoon->publish_on
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
                    'Der Eintrag wurde als Spam eingestuft und daher nicht gespeichert.'
                );
                // @FIXME: Remove this part if sending all spam mails is no longer necessary.
                if (!$spamfilter->isAutolearnSpam($post['score'])) {
                    $data = [
                        'id' => 0,
                        'name' => $post['name'],
                        // Watch out: the variable message is automatically
                        // created, so we need to use another name.
                        'body' => $post['message'],
                        'score' => $post['score'],
                        'category' => $post['category'],
                        'spam_detection' => $post['spam_detection'],
                    ];
                    // @TODO: Implement mailable
                    /*
                    Mail::queue(['text' => 'emails.guestbook'], $data, function ($message) {
                        $message->from('webmaster@tetsche.de', 'Gästebuch');
                        $message->to('toddy@example.org', 'Toddy');
                        $message->subject('Neuer Eintrag im Tetsche-Gästebuch (als Spam abgelehnt)');
                    });
                    */
                }
            }
            // Special case: autolearning spam
            if ($spamfilter->isAutolearnSpam($post['score'])) {
                $new_post = GuestbookPost::create($post);
                $spamfilter->learnStatus($new_post);
                $data = [
                    'id' => $new_post->id,
                    'name' => $post['name'],
                    // Watch out: the variable message is automatically
                    // created, so we need to use another name.
                    'body' => $post['message'],
                    'score' => $post['score'],
                    'category' => $post['category'],
                    'spam_detection' => $post['spam_detection'],
                ];
                // @TODO: Implement mailable
                /*
                Mail::queue(['text' => 'emails.guestbook'], $data, function ($message) {
                    $message->from('webmaster@tetsche.de', 'Gästebuch');
                    $message->to('toddy@example.org', 'Toddy');
                    $message->subject('Neuer Eintrag im Tetsche-Gästebuch (als Spam gelernt)');
                });
                */
            }
        });
        if ($validator->fails()) {
            return redirect(action([GuestbookPostsController::class, 'create']))
                ->withErrors($validator)
                ->withInput();
        }
        // Store the post.
        // @TODO: Do not truncate the category ...
        $post['category'] = substr($post['category'], 0, 14);
        $new_post = GuestbookPost::create($post);
        // Learn status.
        $spamfilter->learnStatus($new_post);
        $data = [
            'id' => $new_post->id,
            'name' => $post['name'],
            // Watch out: the variable message is automatically
            // created, so we need to use another name.
            'body' => $post['message'],
            'score' => $post['score'],
            'category' => $post['category'],
            'spam_detection' => $post['spam_detection'],
        ];

        Mail::to([
            (object)['name' => 'Toddy', 'email' => 'toddy@example.org'],
            (object)['name' => 'Tetsche', 'email' => 'tetsche@example.org'],
        ])->send(new NewGuestbookPost($new_post));
//        subject('Neuer Eintrag im Tetsche-Gästebuch');
        $request->session()->flash('info', 'Der Eintrag wurde gespeichert.');

        return redirect(action([GuestbookPostsController::class, 'index']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $guestbook_post = GuestbookPost::findOrFail($id);
        // Calculate spam score
        $spamfilter = new Spamfilter();
        $text = $guestbook_post->name.' '.$guestbook_post->message;
        $guestbook_post->score = round($spamfilter->classify($text, $guestbook_post->spam_detection) * 100, 1);

        return view('guestbook_posts.edit', compact('guestbook_post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
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

        return redirect(action('GuestbookPostsController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $guestbook_post = GuestbookPost::findOrFail($id);
        $spamfilter = new Spamfilter();
        $spamfilter->unlearnStatus($guestbook_post);
        GuestbookPost::destroy($id);
        $request->session()->flash('info', 'Der Eintrag wurde gelöscht.');

        return redirect(action('GuestbookPostsController@index'));
    }

    /**
     * Filter guestbook by search string.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        if (trim($query) == '') {
            return redirect(action([GuestbookPostsController::class, 'index']));
        }
        $guestbook_posts = GuestbookPost::whereNotIn('category', ['manual_spam', 'autolearn_spam'])
            ->where(function ($sql) use ($query) {
                $sql->where('name', 'LIKE', "%$query%")
                    ->orWhere('message', 'LIKE', "%$query%")
                    ->orWhere('cheffe', 'LIKE', "%$query%");
            })
            ->latest()
            ->simplePaginate(10);

        return view('guestbook_posts.index', [
            'guestbook_posts' => $guestbook_posts,
            'title' => 'Gästebuch-Suche',
            'keywords' => 'Gästebuch, Suche',
            'description' => 'Gästebuch der Tetsche-Website',
            'pagetitle' => 'Gästebuch&nbsp;&ndash; Suche nach »'.$query.'«',
            'query' => $query,
        ]);
    }
}
