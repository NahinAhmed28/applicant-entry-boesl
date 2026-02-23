<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ $action }}" class="space-y-4">
        @csrf
        @if($method !== 'POST') @method($method) @endif

        <div>
            <label class="text-sm">Name</label>
            <input type="text" name="name" value="{{ old('name', $user?->name) }}" class="w-full rounded border-gray-300" required>
        </div>

        <div>
            <label class="text-sm">Email</label>
            <input type="email" name="email" value="{{ old('email', $user?->email) }}" class="w-full rounded border-gray-300" required>
        </div>

        <div>
            <label class="text-sm">Role</label>
            <select name="role" class="w-full rounded border-gray-300" required>
                <option value="">Select role</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" @selected(old('role', $user?->roles->first()?->name) === $role)>{{ $role }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm">Password {{ $user ? '(leave blank to keep current)' : '' }}</label>
            <input type="password" name="password" class="w-full rounded border-gray-300" {{ $user ? '' : 'required' }}>
        </div>

        <div>
            <label class="text-sm">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full rounded border-gray-300" {{ $user ? '' : 'required' }}>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>
