<?php

namespace App\Mail;

use App\Staff;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailStaffPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $staff;
    public $position;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Staff $staff, $position, $password)
    {
        $this->staff = $staff;
        $this->position = $position;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $vowels = ['a','e','i','o','u'];
        $position = in_array(substr($this->position,0,1),$vowels) ? 'an '.$this->position : 'a '.$this->position;
        return $this->subject($this->staff->firstname.', You are now '.$position.'!')
                    ->view('emails.staff-password');
    }
}
