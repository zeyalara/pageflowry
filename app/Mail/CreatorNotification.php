<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatorNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    public function build()
    {
        $m = $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Tugas konten baru: '.($this->emailData['title'] ?? 'Brief baru'))
            ->view('emails.creator-notification')
            ->with('data', $this->emailData);

        if (! empty($this->emailData['reply_to']) && filter_var($this->emailData['reply_to'], FILTER_VALIDATE_EMAIL)) {
            $m->replyTo($this->emailData['reply_to']);
        }

        return $m;
    }
}
