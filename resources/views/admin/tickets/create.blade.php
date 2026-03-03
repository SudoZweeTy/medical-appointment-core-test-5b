<x-admin-layout
    title="Nuevo Ticket | MediCitas"
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
            'name' => 'Nuevo Ticket',
        ],
    ]">

    <x-wire-card>
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Reportar un problema</h3>
            <p class="text-sm text-gray-500 mt-1">
                Describe tu problema o duda y nuestro equipo de soporte se pondrá en contacto contigo.
            </p>
        </div>

        <form action="{{ route('admin.tickets.store') }}" method="POST">
            @csrf

            {{-- Título del problema --}}
            <div class="mb-4">
                <x-wire-input
                    label="Título del problema"
                    name="title"
                    placeholder="Ej: No puedo acceder al módulo de citas"
                    value="{{ old('title') }}"
                />
            </div>

            {{-- Descripción detallada --}}
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción detallada
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Describe el problema con el mayor detalle posible..."
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Prioridad --}}
            <div class="mb-6">
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                    Prioridad
                </label>
                <select
                    id="priority"
                    name="priority"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                >
                    <option value="baja" {{ old('priority') === 'baja' ? 'selected' : '' }}>🟢 Baja</option>
                    <option value="media" {{ old('priority', 'media') === 'media' ? 'selected' : '' }}>🟡 Media</option>
                    <option value="alta" {{ old('priority') === 'alta' ? 'selected' : '' }}>🔴 Alta</option>
                </select>
                @error('priority')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-end gap-3">
                <x-wire-button href="{{ route('admin.tickets.index') }}" flat>
                    Cancelar
                </x-wire-button>
                <x-wire-button type="submit" blue>
                    <i class="fa-solid fa-paper-plane mr-1"></i>
                    Enviar Ticket
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>
