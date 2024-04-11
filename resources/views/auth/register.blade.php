<x-guest-layout>
    <x-input-error :messages="$errors->all()" class="mb-4" />

    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />

            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
        </div>

        <!-- Rol -->
        <div class="mt-4">
            <x-input-label for="rol" :value="__('¿Qué tipo de cuenta deseas en DevJobs?')" />

            <select name="rol" id="rol"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                <option value="">-- Selecciona un rol --</option>
                <option value="1">Developer - Obtener Empleo</option>
                <option value="2">Recruiter - Publicar Empleos</option>
            </select>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex justify-between my-5">
            <x-link :href="route('login')">
                {{ __('Log in') }}
            </x-link>

            <x-link :href="route('password.request')">
                {{ __('Forgot your password?') }}
            </x-link>
        </div>

        <x-primary-button class="w-full justify-center">
            {{ __('Register') }}
        </x-primary-button>
    </form>
</x-guest-layout>
