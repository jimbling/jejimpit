<section class="mx-auto p-2 mt-6">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Update Password
        </h2>

        <p class="text-gray-600 mt-2">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6">
        @csrf
        @method('put')

        <div class="mb-5">
            <label for="update_password_current_password" class="block text-gray-700 mb-2">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                autocomplete="current-password">
            @error('current_password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-5">
            <label for="update_password_password" class="block text-gray-700 mb-2">New Password</label>
            <input id="update_password_password" name="password" type="password"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                autocomplete="new-password">
            @error('password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-5">
            <label for="update_password_password_confirmation" class="block text-gray-700 mb-2">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                autocomplete="new-password">
            @error('password_confirmation')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                Save
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-green-600 mb-0" x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)">
                    Saved.
                </p>
            @endif
        </div>
    </form>
</section>
