<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailqueueController extends Controller
{
    /**
     * Enviar correo electrónico.
     *
     * @return bool
     */
    public function sendEmail()
        {
            try {
                // Obtener los parámetros necesarios para la vista del correo
                $params['data'] = $this->params;
                $params['view'] = $this->view;
    
                // Enviar el correo electrónico usando la fachada Mail
                Mail::to($this->email)->send(new EmailQueueMailable($params));
    
                // Actualizar el estado y los intentos en caso de éxito
                $this->status = 'completed';
                $this->sent = now();
                $this->save();
    
                return true;
            } catch (\Exception $e) {
                // Manejar la excepción y actualizar el estado y los intentos en caso de error
                $this->status = 'failed';
                $this->attempt += 1;
                $this->save();
    
                Log::error("Error al enviar correo: " . $e->getMessage());
    
                return false;
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
