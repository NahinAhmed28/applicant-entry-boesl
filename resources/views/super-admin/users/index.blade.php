<x-app-layout>
    <x-slot name="header"><h2>User Management</h2></x-slot>

    <div class="bg-white rounded-lg shadow p-4">
        @if (session('success'))<div class="mb-3 text-green-700">{{ session('success') }}</div>@endif
        @if (session('error'))<div class="mb-3 text-red-700">{{ session('error') }}</div>@endif

        <div class="mb-4">
            <a href="{{ route('super-admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Create User</a>
        </div>

        <div class="overflow-auto">
            <table class="min-w-full text-sm">
                <thead><tr class="border-b"><th class="p-2 text-left">Name</th><th class="p-2 text-left">Email</th><th class="p-2 text-left">Role</th><th class="p-2 text-left">Action</th></tr></thead>
                <tbody>
                @forelse($users as $u)
                    <tr class="border-b">
                        <td class="p-2">{{ $u->name }}</td>
                        <td class="p-2">{{ $u->email }}</td>
                        <td class="p-2">{{ $u->roles->pluck('name')->join(', ') ?: 'N/A' }}</td>
                        <td class="p-2 flex gap-2">
                            <a href="{{ route('super-admin.users.edit', $u) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('super-admin.users.destroy', $u) }}" onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-2" colspan="4">No users found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
