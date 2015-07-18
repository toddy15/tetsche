<?php

namespace App\Http\Controllers;

use App\GuestbookPost;
use App\Http\Requests;
use App\Http\Controllers\Controller;
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
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);
        return view('guestbook_posts.index', [
            'guestbook_posts' => $guestbook_posts,
            'title' => 'Gästebuch',
            'keywords' => 'Gästebuch',
            'description' => 'Gästebuch der Tetsche-Website',
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $post = $request->all();
        $spamfilter = new Spamfilter();
        $text = $post['name'] . ' ' . $post['message'];
        $post['score'] = $spamfilter->classify($text);
        $post['category'] = $spamfilter->calculateCategory($post['score']);
        $validator = Validator::make($post, [
            'name' => 'required',
            'message' => 'required'
        ]);
        // Add the spam check
        $validator->after(function($validator) use ($post, $spamfilter) {
            if ($spamfilter->isSpam($post['score'])) {
                $validator->errors()->add('message', 'Der Eintrag wurde als Spam eingestuft und daher nicht gespeichert.');
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
                ];
                Mail::queue(['text' => 'emails.guestbook'], $data, function($message) {
                    $message->from('webmaster@tetsche.de', 'Gästebuch');
                    $message->to('toddy@example.org', 'Toddy');
                    $message->subject('Neuer Eintrag im Tetsche-Gästebuch (als Spam gelernt)');
                });
            }
        });
        if ($validator->fails()) {
            return redirect(action('GuestbookPostsController@create'))
                ->withErrors($validator)
                ->withInput();
        }
        // Store the post.
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
        ];
        Mail::queue(['text' => 'emails.guestbook'], $data, function($message) {
            $message->from('webmaster@tetsche.de', 'Gästebuch');
            $message->to('tetsche@example.org', 'Tetsche');
            $message->to('toddy@example.org', 'Toddy');
            $message->subject('Neuer Eintrag im Tetsche-Gästebuch');
        });
        $request->session()->flash('info', 'Der Eintrag wurde gespeichert.');
        return redirect(action('GuestbookPostsController@index'));
        // @TODO: This should probably go into an own Request class.
//        $post = $request->all();
//        $post['category'] = 'ham';
//        GuestbookPost::create($post);
//        $request->session()->flash('info', 'Der Eintrag wurde gespeichert.');
//        return redirect(action('GuestbookPostsController@index'));
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
        $text = $guestbook_post->name. ' ' . $guestbook_post->message;
        $guestbook_post->score = round($spamfilter->classify($text) * 100, 1);
        return view('guestbook_posts.edit', compact('guestbook_post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
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
     * @param Request $request
     * @param  int $id
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
}
