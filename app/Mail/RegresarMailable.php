<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegresarMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $subject="";
    public $head="";
    public $body="";
    public $footer="";
    public $url="";

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
        $head=$this->head;
        $body=$this->body;
        $footer=$this->footer;
        $url=$this->url;
        return $this->view('emails.plantilla',compact('head','body','footer','url'));
    }
}
