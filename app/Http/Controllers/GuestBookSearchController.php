<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\GuestbookPost;
use App\Services\Images;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GuestBookSearchController extends Controller
{
    /**
     * Filter guestbook by search string.
     */
    public function __invoke(Request $request): View|RedirectResponse
    {
        $query = $request->query('q');
        if (empty($query)) {
            return to_route('gaestebuch.index');
        }
        $guestbook_posts = GuestbookPost::whereNotIn('category', [
            'manual_spam',
            'autolearn_spam',
        ])
            ->where(function ($sql) use ($query) {
                $sql->where('name', 'LIKE', "%$query%")
                    ->orWhere('message', 'LIKE', "%$query%")
                    ->orWhere('cheffe', 'LIKE', "%$query%");
            })
            ->latest()
            ->simplePaginate(10);

        // Choose a random image
        $image = new Images();
        $guestbook_image = $image->getRandomImageForGuestbook();

        return view('guestbook_posts.index', [
            'guestbook_posts' => $guestbook_posts,
            'title' => 'Gästebuch-Suche',
            'description' => 'Gästebuch der Tetsche-Website',
            'pagetitle' => 'Gästebuch – Suche nach »'.$query.'«',
            'query' => $query,
            'image' => $guestbook_image,
        ]);
    }
}
