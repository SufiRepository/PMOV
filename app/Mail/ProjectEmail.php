<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProjectEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @author Farez@mindwave.my
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->email_data  = $data;
    }

    /**
     *  @author Farez@mindwave.my
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('mail.signup-email');
    return $this->subject('New Project had been Created')
        -> view('mail.Project-email',['email_data'=>$this->email_data]);
    }
}
