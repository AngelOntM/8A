<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ URL::signedRoute('users.updatepassword', $user) }}">
                        @csrf @method('PUT')
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block my-4 w-full" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block my-4 w-full" type="password" name="password_confirmation" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <a href="{{ URL::signedRoute('users.index') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150 mt-4">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button class="mt-4">
                            {{ __('Save') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>