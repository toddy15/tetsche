<?php

namespace App\Mail;

use App\Models\GuestbookPost;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewGuestbookPost extends Mailable
{
    use Queueable, SerializesModels;

    public GuestbookPost $guestbook_post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(GuestbookPost $guestbook_post)
    {
        $this->guestbook_post = $guestbook_post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.guestbook');
    }
}
