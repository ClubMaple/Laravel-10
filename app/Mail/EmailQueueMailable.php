<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailQueueMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Parámetros para pasar a la vista
    public $view; // la vista seleccionada

    public function __construct($data, $view = 'default')
    {
        $this->data = $data;
        $this->view = 'emails.' . $view;
    }

    public function build()
    {
        return $this->view($this->view)
                    ->with([
                        'data' => $this->data
                    ]);
    }
}
