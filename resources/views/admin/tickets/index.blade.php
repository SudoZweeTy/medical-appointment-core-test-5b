<x-admin-layout
    title="Soporte | MediCitas"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Soporte',
        ],
    ]">

    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.tickets.create') }}">
            <i class="fa-solid fa-plus"></i>
            Nuevo Ticket
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.support-ticket-table')

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
