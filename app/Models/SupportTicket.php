<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo para los tickets de soporte.
 *
 * Cada ticket pertenece a un usuario y tiene un estado,
 * prioridad y opcionalmente una respuesta del administrador.
 */
class SupportTicket extends Model
{
    /**
     * Campos que se pueden asignar de forma masiva.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'admin_response',
    ];

    /**
     * Relación: el ticket pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Devuelve el color del badge según el estado del ticket.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'abierto'     => 'yellow',
            'en_progreso' => 'blue',
            'cerrado'     => 'green',
            default       => 'gray',
        };
    }

    /**
     * Devuelve el label legible del estado.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'abierto'     => 'Abierto',
            'en_progreso' => 'En Progreso',
            'cerrado'     => 'Cerrado',
            default       => $this->status,
        };
    }

    /**
     * Devuelve el color del badge según la prioridad.
     */
    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'baja'  => 'green',
            'media' => 'yellow',
            'alta'  => 'red',
            default => 'gray',
        };
    }

    /**
     * Devuelve el label legible de la prioridad.
     */
    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            'baja'  => 'Baja',
            'media' => 'Media',
            'alta'  => 'Alta',
            default => $this->priority,
        };
    }
}
