<x-guest-layout>
    <div class="mb-4 sm:mb-6 text-sm sm:text-base text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <x-ui.form-group name="password" label="{{ __('Password') }}">
            <x-text-input 
                id="password" 
                class="block w-full"
                type="password"
                name="password"
                required 
                autocomplete="current-password" 
            />
        </x-ui.form-group>

        <div class="flex justify-end mt-6 sm:mt-8">
            <x-ui.button type="submit" variant="primary" full-width class="sm:w-auto">
                {{ __('Confirm') }}
            </x-ui.button>
        </div>
    </form>
</x-guest-layout>
