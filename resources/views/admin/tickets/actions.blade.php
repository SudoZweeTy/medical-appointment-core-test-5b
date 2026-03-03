<div class="flex items-center gap-2">
    {{-- Botón para ver el detalle del ticket --}}
    <x-wire-button href="{{ route('admin.tickets.show', $ticket) }}" blue xs>
        <i class="fa-solid fa-eye"></i>
    </x-wire-button>

    {{-- Botón para editar el ticket --}}
    <x-wire-button href="{{ route('admin.tickets.edit', $ticket) }}" yellow xs>
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    {{-- Formulario para eliminar el ticket --}}
    <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <x-wire-button type="submit" red xs>
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>
