<x-admin-layout
    title="Editar Ticket #{{ $ticket->id }} | MediCitas"
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
            'href' => route('admin.tickets.show', $ticket),
        ],
        [
            'name' => 'Editar',
        ],
    ]">

    <x-wire-card>
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Gestionar ticket de soporte</h3>
            <p class="text-sm text-gray-500 mt-1">
                Actualiza el estado, la prioridad o agrega una respuesta para el usuario
                <strong>{{ $ticket->user->name }}</strong>.
            </p>
        </div>

        {{-- Información del ticket (solo lectura) --}}
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h4 class="font-semibold text-gray-700 mb-2">{{ $ticket->title }}</h4>
            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $ticket->description }}</p>
            <p class="text-xs text-gray-400 mt-3">
                <i class="fa-regular fa-clock mr-1"></i>
                Creado el {{ $ticket->created_at->format('d/m/Y H:i') }}
            </p>
        </div>

        <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Estado y prioridad en grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                {{-- Estado --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Estado
                    </label>
                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                    >
                        <option value="abierto" {{ old('status', $ticket->status) === 'abierto' ? 'selected' : '' }}>🟡 Abierto</option>
                        <option value="en_progreso" {{ old('status', $ticket->status) === 'en_progreso' ? 'selected' : '' }}>🔵 En Progreso</option>
                        <option value="cerrado" {{ old('status', $ticket->status) === 'cerrado' ? 'selected' : '' }}>🟢 Cerrado</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Prioridad --}}
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                        Prioridad
                    </label>
                    <select
                        id="priority"
                        name="priority"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                    >
                        <option value="baja" {{ old('priority', $ticket->priority) === 'baja' ? 'selected' : '' }}>🟢 Baja</option>
                        <option value="media" {{ old('priority', $ticket->priority) === 'media' ? 'selected' : '' }}>🟡 Media</option>
                        <option value="alta" {{ old('priority', $ticket->priority) === 'alta' ? 'selected' : '' }}>🔴 Alta</option>
                    </select>
                    @error('priority')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Respuesta del administrador --}}
            <div class="mb-6">
                <label for="admin_response" class="block text-sm font-medium text-gray-700 mb-1">
                    Respuesta del administrador
                </label>
                <textarea
                    id="admin_response"
                    name="admin_response"
                    rows="5"
                    placeholder="Escribe una respuesta para el usuario..."
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                >{{ old('admin_response', $ticket->admin_response) }}</textarea>
                @error('admin_response')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-end gap-3">
                <x-wire-button href="{{ route('admin.tickets.show', $ticket) }}" flat>
                    Cancelar
                </x-wire-button>
                <x-wire-button type="submit" blue>
                    <i class="fa-solid fa-floppy-disk mr-1"></i>
                    Guardar cambios
                </x-wire-button>
            </div>
        </form>
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
