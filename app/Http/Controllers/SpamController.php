<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\GuestbookPost;
use App\Services\Images;
use App\Services\Spamfilter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpamController extends Controller
{
    /**
     * Show overview of possible actions.
     */
    public function index(): View
    {
        return view('admin.guestbook');
    }

    /**
     * Relearn all ham and spam texts
     */
    public function relearn(Request $request): RedirectResponse
    {
        // Initialize the arrays.
        $texts = [
            'ham' => [],
            'spam' => [],
        ];
        $posts = GuestbookPost::whereIn('category', [
            'manual_ham',
            'autolearn_ham',
        ])->get();
        foreach ($posts as $post) {
            $text = $post->name.' '.$post->message;
            $texts['ham'][] = $text;
        }
        $posts = GuestbookPost::whereIn('category', [
            'manual_spam',
            'autolearn_spam',
        ])->get();
        foreach ($posts as $post) {
            $text = $post->name.' '.$post->message;
            $texts['spam'][] = $text;
        }
        $spamfilter = new Spamfilter;
        $spamfilter->initializeAll($texts);
        $request
            ->session()
            ->flash('info', 'Alle Ham- und Spamtexte wurden neu gelernt.');

        return redirect()->to('spam');
    }

    /**
     * Show all posts of a category.
     */
    public function showPosts(string $category): View
    {
        $description = match ($category) {
            'manual_ham' => 'Manuell als Ham gelernt',
            'unsure' => 'Keine Zuordnung',
            'manual_spam' => 'Manuell als Spam gelernt',
            'autolearn_ham' => 'Automatisch als Ham gelernt',
            'autolearn_spam' => 'Automatisch als Spam gelernt',
            default => 'Kategorie nicht erkannt',
        };

        $guestbook_posts = GuestbookPost::where('category', $category)
            ->latest()
            ->simplePaginate(10);

        // Choose a random image
        $image = new Images;
        $guestbook_image = $image->getRandomImageForGuestbook();

        return view('guestbook_posts.index', [
            'guestbook_posts' => $guestbook_posts,
            'title' => 'Gästebuch – '.$description,
            'description' => 'Gästebuch der Tetsche-Website – '.$description,
            'image' => $guestbook_image,
        ]);
    }
}
