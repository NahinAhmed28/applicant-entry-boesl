<x-app-layout>
    <x-slot name="header"><h2>Edit User</h2></x-slot>
    @include('super-admin.users.partials.form', ['action' => route('super-admin.users.update', $user), 'method' => 'PUT', 'user' => $user])
</x-app-layout>
