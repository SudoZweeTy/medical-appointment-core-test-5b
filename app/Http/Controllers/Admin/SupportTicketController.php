<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de tickets de soporte.
 *
 * Maneja las operaciones CRUD completas: listar, crear,
 * ver detalle, editar estado/respuesta y eliminar tickets.
 */
class SupportTicketController extends Controller
{
    /**
     * Mostrar la lista de todos los tickets de soporte.
     */
    public function index()
    {
        return view('admin.tickets.index');
    }

    /**
     * Mostrar el formulario para crear un nuevo ticket.
     */
    public function create()
    {
        return view('admin.tickets.create');
    }

    /**
     * Almacenar un nuevo ticket en la base de datos.
     * Se asigna automáticamente el usuario autenticado.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'priority'    => 'required|in:baja,media,alta',
        ]);

        // Asignar el usuario autenticado y estado inicial
        $data['user_id'] = auth()->id();
        $data['status']  = 'abierto';

        SupportTicket::create($data);

        return redirect()
            ->route('admin.tickets.index')
            ->with('swal', [
                'icon'  => 'success',
                'title' => '¡Ticket creado!',
                'text'  => 'Tu ticket de soporte ha sido registrado exitosamente.',
            ]);
    }

    /**
     * Mostrar el detalle de un ticket específico.
     */
    public function show(SupportTicket $ticket)
    {
        $ticket->load('user');
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Mostrar formulario para editar un ticket (estado, prioridad, respuesta).
     */
    public function edit(SupportTicket $ticket)
    {
        $ticket->load('user');
        return view('admin.tickets.edit', compact('ticket'));
    }

    /**
     * Actualizar el ticket en la base de datos.
     * Permite cambiar estado, prioridad y agregar respuesta del admin.
     */
    public function update(Request $request, SupportTicket $ticket)
    {
        $data = $request->validate([
            'status'         => 'required|in:abierto,en_progreso,cerrado',
            'priority'       => 'required|in:baja,media,alta',
            'admin_response' => 'nullable|string|max:5000',
        ]);

        // Detectar si hubo cambios reales
        $hasChanges = false;
        foreach ($data as $key => $value) {
            if ($ticket->{$key} != $value) {
                $hasChanges = true;
                break;
            }
        }

        if (! $hasChanges) {
            return redirect()
                ->route('admin.tickets.edit', $ticket)
                ->with('swal', [
                    'icon'  => 'info',
                    'title' => 'Sin cambios',
                    'text'  => 'No se detectaron cambios en el ticket.',
                ]);
        }

        $ticket->update($data);

        return redirect()
            ->route('admin.tickets.show', $ticket)
            ->with('swal', [
                'icon'  => 'success',
                'title' => '¡Ticket actualizado!',
                'text'  => 'El ticket de soporte ha sido actualizado exitosamente.',
            ]);
    }

    /**
     * Eliminar un ticket de soporte.
     */
    public function destroy(SupportTicket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('admin.tickets.index')
            ->with('swal', [
                'icon'  => 'success',
                'title' => '¡Ticket eliminado!',
                'text'  => 'El ticket de soporte ha sido eliminado correctamente.',
            ]);
    }
}
