<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la cola de correos electrónicos.
 *
 * @property int $id
 * @property int $linkable_id
 * @property string $linkable_type
 * @property string $subject
 * @property string $email
 * @property string $view
 * @property array $params
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $sent
 * @property int $attempt
 */
class EmailQueue extends Model
{
    protected $table = 'email_queues';
    protected $fillable = [
        'linkable_id',
        'linkable_type',
        'subject',
        'email',
        'view',
        'params',
        'status',
        'sent',
        'attempt',
    ];

    protected $casts = [
        'params' => 'array',
        'sent' => 'datetime',
    ];

    /**
     * Enviar correo electrónico.
     *
     * @return bool
     */
    public function sendEmail()
        {
            try {
                // Obtener los parámetros necesarios para la vista del correo
                $params = $this->params;
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