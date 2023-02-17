<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\GuestbookPost;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewGuestbookPost extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public GuestbookPost $guestbook_post)
    {
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return $this->text('emails.guestbook');
    }
}
