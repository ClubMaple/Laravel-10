<?php

namespace App\Http\Controllers;

use App\Models\EmailQueue;
use Illuminate\Http\Request;

class EmailqueueController extends Controller
{
    /**
     * Enviar correo electrónico.
     *
     * @return bool
     */
    public function checkEmails()
    {

        // TODO: instalar la paqueteria de mail de sparkpost
        // "clarification/sparkpost-laravel-driver": "^1.2",

        // Generar pruebas unitarias "php artisan test"


        // Pasos para verificar
        // - Usando el seeder, debe crear 5 pendientes, y arrancando el cron, debe mandar 5 correos, usando la plantilla designdada
        // Debe pasar todos los unit testing de php artisan test


        EmailQueue::where('status', 'pending')
            ->orWhere(function ($query) {
                $query->where('status', 'failed')
                        ->where('attempt', '<', 3);
            })
            ->take(5)
            ->map(function($emailQueue) {
                $this->sendEmail($emailQueue);
            });
    }

    private function sendEmail(EmailQueue $emailQueue)
    {
        $emailQueue->update(['status' => 'processing']);
        $emailQueue->attempt += 1;

        try {
            // Enviar el correo electrónico usando la fachada Mail
            Mail::to($emailQueue->email)->send(new EmailQueueMailable($emailQueue->params, $emailQueue->view));

            // Actualizar el estado y los intentos en caso de éxito
            $emailQueue->status = 'completed';
            $emailQueue->sent   = now();
            $emailQueue->save();

        } catch (\Exception $e) {
            // Manejar la excepción y actualizar el estado y los intentos en caso de error
            $emailQueue->status = 'failed';
            $emailQueue->save();

            Log::error("Error al enviar correo: " . $e->getMessage(), $emailQueue->toArray());
        }
    }

    /**
     * Determina si el correo está listo para ser enviado.
     *
     * @return bool
     */
    public function isReadyToSend()
    {
        return $this->status === 'pending' && $this->attempt < 3;
    }
}
