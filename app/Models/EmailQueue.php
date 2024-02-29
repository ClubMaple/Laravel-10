<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    use HasFactory;
    
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

    
}