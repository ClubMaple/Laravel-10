<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailQueueMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $params; // Parámetros para pasar a la vista

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function build()
    {
        return $this->view('emails.' . $this->params['view'])
                    ->with([
                        'data' => $this->params['data']
                    ]);
    }
}
