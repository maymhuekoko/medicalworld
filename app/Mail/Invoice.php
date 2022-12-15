<?php

namespace App\Mail;

use App\Size;
use App\Colour;
use App\Design;
use App\Fabric;
use App\Gender;
use App\CountingUnit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invoice extends Mailable
{
    use Queueable, SerializesModels;

    public $id;
    public $name;
    public $phone;
    public $address;
    public $preorders;
    public $type;
    public $attachs;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data1,$data2,$data3,$data4,$data5,$data6,$data7)
    {
        //
        $this->id = $data1;
        $this->name = $data2;
        $this->phone= $data3;
        $this->address = $data4;
        $this->preorders = $data5;
        $this->type = $data6;
        $this->attachs = $data7;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.invoice_mail')->subject('Your Preorders List');
    }
}
