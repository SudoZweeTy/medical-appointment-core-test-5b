<?php

namespace App\Livewire\Admin\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\SupportTicket;

/**
 * Tabla Livewire para listar los tickets de soporte.
 * Incluye columnas ordenables y buscables con badges de color.
 */
class SupportTicketTable extends DataTableComponent
{
    protected $model = SupportTicket::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            // Columna ID con formato #N
            Column::make('Id', 'id')
                ->sortable()
                ->format(fn ($value) => '#' . $value),

            // Nombre del usuario que creó el ticket
            Column::make('Usuario', 'user.name')
                ->sortable()
                ->searchable(),

            // Título del ticket (buscable)
            Column::make('Título', 'title')
                ->sortable()
                ->searchable(),

            // Estado con badge de color dinámico
            Column::make('Estado', 'status')
                ->sortable()
                ->format(function ($value, $row) {
                    $colors = [
                        'abierto'     => 'bg-yellow-100 text-yellow-800',
                        'en_progreso' => 'bg-blue-100 text-blue-800',
                        'cerrado'     => 'bg-green-100 text-green-800',
                    ];
                    $labels = [
                        'abierto'     => 'Abierto',
                        'en_progreso' => 'En Progreso',
                        'cerrado'     => 'Cerrado',
                    ];
                    $color = $colors[$value] ?? 'bg-gray-100 text-gray-800';
                    $label = $labels[$value] ?? $value;

                    return '<span class="px-2 py-1 text-xs font-semibold rounded-full ' . $color . '">' . $label . '</span>';
                })
                ->html(),

            // Prioridad con badge
            Column::make('Prioridad', 'priority')
                ->sortable()
                ->format(function ($value) {
                    $colors = [
                        'baja'  => 'bg-green-100 text-green-800',
                        'media' => 'bg-yellow-100 text-yellow-800',
                        'alta'  => 'bg-red-100 text-red-800',
                    ];
                    $labels = [
                        'baja'  => 'Baja',
                        'media' => 'Media',
                        'alta'  => 'Alta',
                    ];
                    $color = $colors[$value] ?? 'bg-gray-100 text-gray-800';
                    $label = $labels[$value] ?? $value;

                    return '<span class="px-2 py-1 text-xs font-semibold rounded-full ' . $color . '">' . $label . '</span>';
                })
                ->html(),

            // Fecha de creación formateada
            Column::make('Fecha', 'created_at')
                ->sortable()
                ->format(fn ($value) => $value->format('d/m/Y H:i')),

            // Columna de acciones (ver, editar, eliminar)
            Column::make('Acciones')
                ->label(fn ($row) => view('admin.tickets.actions', ['ticket' => $row])),
        ];
    }
}
