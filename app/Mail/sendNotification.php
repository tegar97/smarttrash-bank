<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $balance,$totalBottle)
    {
        $this->name = $name;
        $this->balance = $balance;
        $this->totalBottle = $totalBottle;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('smartbanktrash@smartbanktrash.com')
        ->view('email')
        ->with([
            'nama' => $this->name,
            'balance' => $this->balance,
            'totalBottle' => $this->totalBottle,
        ]);
        
    }
}
