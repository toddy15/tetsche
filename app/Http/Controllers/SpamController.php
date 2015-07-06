<?php

namespace App\Http\Controllers;

use App\GuestbookPost;
use App\TwsLib\Spamfilter;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SpamController extends Controller
{
    /**
     * Relearn all ham and spam texts
     */
    public function relearn(Request $request)
    {
        // Initialize the arrays.
        $texts = [
            'ham' => [],
            'spam' => [],
        ];
        $posts = GuestbookPost::whereIn('category', ['manual_ham', 'autolearn_ham'])->get();
        foreach ($posts as $post) {
            $text = $post->name . ' ' . $post->message;
            $texts['ham'][] = $text;
        }
        $posts = GuestbookPost::whereIn('category', ['manual_spam', 'autolearn_spam'])->get();
        foreach ($posts as $post) {
            $text = $post->name . ' ' . $post->message;
            $texts['spam'][] = $text;
        }
        $spamfilter = new Spamfilter();
        $spamfilter->initializeAll($texts);
        $request->session()->flash('info', 'Alle Ham- und Spamtexte wurden neu gelernt.');
        return redirect('gästebuch');
    }

    public function showPosts($category)
    {
        switch ($category) {
            case 'manual_ham':
                $description = 'Manuell als Ham gelernt';
                break;
            case 'unsure':
                $description = 'Keine Zuordnung';
                break;
            case 'manual_spam':
                $description = 'Manuell als Spam gelernt';
                break;
            case 'autolearn_ham':
                $description = 'Automatisch als Ham gelernt';
                break;
            case 'autolearn_spam':
                $description = 'Automatisch als Spam gelernt';
                break;
            default:
                return redirect(action('GuestbookPostsController@index'));
        }
        $guestbook_posts = GuestbookPost::where('category', $category)
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);
        return view('guestbook_posts.index', [
            'guestbook_posts' => $guestbook_posts,
            'title' => 'Gästebuch - ' . $description,
            'keywords' => 'Gästebuch - ' . $description,
            'description' => 'Gästebuch der Tetsche-Website - ' . $description,
        ]);
    }
}
