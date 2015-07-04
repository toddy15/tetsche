<?php

namespace App\Http\Controllers;

use App\GuestbookPost;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        $this->validate($request, [
            'name' => 'required',
            'message' => 'required'
        ]);
        $post = $request->all();
        $post['category'] = 'ham';
        GuestbookPost::create($post);
        Session::flash('info', 'Der Eintrag wurde gespeichert.');
        return redirect(action('GuestbookPostsController@index'));
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
        $guestbook_post->update($request->all());
        Session::flash('info', 'Der Eintrag wurde geändert.');
        return redirect(action('GuestbookPostsController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        GuestbookPost::destroy($id);
        Session::flash('info', 'Der Eintrag wurde gelöscht.');
        return redirect(action('GuestbookPostsController@index'));
    }
}
