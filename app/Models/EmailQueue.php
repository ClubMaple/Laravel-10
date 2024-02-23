<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    // Definir los atributos que son asignables en masa.
    protected $fillable = [
        'linkable_id',
        'linkable_type',
        'subject',
        'email',
        'view',
        'params',
        'status',
        'sent',
        'attempt'
    ];

    //Marca de tiempo
    public $timestamps = true;

    /**
     * Método para enviar el correo electrónico.
     *
     * @return void
     */
    public function sendEmail()
    {
        //Estructura del correo
        $mailData = [
            'subject' => $this->subject,
            'view' => $this->view,
            'params' => json_decode($this->params, true)
        ];

        try {
            Mail::to($this->email)->send(new YourCustomMailableClass($mailData));

            $this->update([
                'status' => 'completed',
                'sent' => now(),
                'attempt' => $this->attempt + 1
            ]);
        } catch (\Exception $e) {
            $this->update([
                'status' => 'failed',
                'attempt' => $this->attempt + 1
            ]);
        }
    }
}
