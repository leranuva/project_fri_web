<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">Crear borrador de tema</h2>
    </x-slot>

    @include('admin.themes.form', ['theme' => null, 'action' => route('admin.themes.store')])
</x-app-layout>
