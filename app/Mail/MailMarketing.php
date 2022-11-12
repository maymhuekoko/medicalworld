<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailMarketing extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $title;
    public $subtitle;
    public $description;
    public $link;
    public $photo;
    public $attach;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data1,$data2,$data3,$data4,$data5,$filename1,$filename2)
    {
        $this->subject = $data1;
        $this->title = $data2;
        $this->subtitle = $data3;
        $this->description = $data4;
        $this->link = $data5;
        $this->photo = public_path('uploadedfiles' . '/' . $filename1);
        $this->attach = public_path('uploadedfiles' . '/' . $filename2);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Admin.emailTemplate')
        ->subject('You have one new message from Medical World')
        ->attach($this->attach);
    }
}
