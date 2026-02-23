<x-app-layout>
    <x-slot name="header"><h2>Create User</h2></x-slot>
    @include('super-admin.users.partials.form', ['action' => route('super-admin.users.store'), 'method' => 'POST', 'user' => null])
</x-app-layout>
