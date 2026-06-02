<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $messageContent;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->subject = $data['subject'] ?? 'Tidak ada subjek';
        $this->messageContent = $data['message'];
    }

    public function build()
    {
        return $this->from($this->email, $this->name)
                    ->to('rzrakbar345@gmail.com')
                    ->replyTo($this->email, $this->name)
                    ->subject('📧 Pesan dari ' . $this->name)
                    ->view('emails.contact');
    }
}