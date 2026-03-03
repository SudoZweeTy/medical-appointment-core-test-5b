<x-admin-layout
    title="Ticket #{{ $ticket->id }} | MediCitas"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Soporte',
            'href' => route('admin.tickets.index'),
        ],
        [
            'name' => 'Ticket #' . $ticket->id,
        ],
    ]">

    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.tickets.edit', $ticket) }}">
            <i class="fa-solid fa-pen-to-square mr-1"></i>
            Editar
        </x-wire-button>
    </x-slot>

    {{-- Información principal del ticket --}}
    <x-wire-card>
        <div class="space-y-6">

            {{-- Encabezado con título y badges --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h3 class="text-xl font-bold text-gray-800">{{ $ticket->title }}</h3>
                <div class="flex gap-2">
                    @php
                        $statusColors = [
                            'abierto'     => 'bg-yellow-100 text-yellow-800',
                            'en_progreso' => 'bg-blue-100 text-blue-800',
                            'cerrado'     => 'bg-green-100 text-green-800',
                        ];
                        $priorityColors = [
                            'baja'  => 'bg-green-100 text-green-800',
                            'media' => 'bg-yellow-100 text-yellow-800',
                            'alta'  => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $ticket->status_label }}
                    </span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $priorityColors[$ticket->priority] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $ticket->priority_label }}
                    </span>
                </div>
            </div>

            <hr class="border-gray-200">

            {{-- Metadatos del ticket --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-gray-500 font-medium">Creado por:</span>
                    <p class="text-gray-800 font-semibold">{{ $ticket->user->name }}</p>
                </div>
                <div>
                    <span class="text-gray-500 font-medium">Email:</span>
                    <p class="text-gray-800">{{ $ticket->user->email }}</p>
                </div>
                <div>
                    <span class="text-gray-500 font-medium">Fecha:</span>
                    <p class="text-gray-800">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <hr class="border-gray-200">

            {{-- Descripción del problema --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">
                    <i class="fa-solid fa-align-left mr-1"></i> Descripción
                </h4>
                <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $ticket->description }}
                </div>
            </div>

            {{-- Respuesta del administrador (si existe) --}}
            @if($ticket->admin_response)
                <div>
                    <h4 class="text-sm font-semibold text-blue-600 uppercase tracking-wide mb-2">
                        <i class="fa-solid fa-reply mr-1"></i> Respuesta del administrador
                    </h4>
                    <div class="bg-blue-50 border-l-4 border-blue-400 rounded-lg p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $ticket->admin_response }}
                    </div>
                </div>
            @else
                <div class="bg-gray-50 rounded-lg p-4 text-center text-sm text-gray-400">
                    <i class="fa-solid fa-clock mr-1"></i>
                    Aún no hay respuesta del equipo de soporte.
                </div>
            @endif
        </div>
    </x-wire-card>

    @push('js')
        @if (session('swal'))
            <script>
                Swal.fire({
                    icon: "{{ session('swal.icon') }}",
                    title: "{{ session('swal.title') }}",
                    text: "{{ session('swal.text') }}",
                    confirmButtonColor: '#3085d6',
                });
            </script>
        @endif
    @endpush
</x-admin-layout>
