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
        return $this
            ->subject('📋 Tugas Konten Baru: ' . ($this->emailData['title'] ?? 'Brief Baru'))
            ->view('emails.creator-notification')
            ->with('data', $this->emailData);
    }
}
