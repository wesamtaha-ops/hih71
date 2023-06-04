<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private $name, private $date, private $time, private $teacher_name, private $meeting_url)
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
        return $this->view('mail.invitation', [
            'name' => $this->name,
            'date' => $this->date,
            'time' => $this->time,
            'teacher_name' => $this->teacher_name,
            'meeting_url' => $this->meeting_url
        ]);
    }
}
