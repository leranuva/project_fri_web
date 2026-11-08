<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">Editar borrador de tema</h2>
    </x-slot>

    @include('admin.themes.form', ['action' => route('admin.themes.update', $theme)])
</x-app-layout>
