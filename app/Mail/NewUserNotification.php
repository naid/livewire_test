<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->from('naid.rm@gmail.com', 'Mailtrap')
            ->subject('Mailtrap Confirmation')
            ->markdown('mails.new_user_welcome')
            ->with([
                'name' => 'New Mailtrap User',
                'link' => '/inboxes/'
        ]);
    }
}
