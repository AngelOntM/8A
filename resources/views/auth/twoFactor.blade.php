<x-guest-layout>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="h-20 w-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        <div class="mb-4 text-sm text-gray-600">
            <x-input-label for="code" :value="__('Recibiste un codigo en tu correo.')" />
        </div>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('verify.store') }}">
            @csrf
            <div>
                <x-input-label for="codigo" :value="__('Codigo')" />
                <x-text-input id="codigo" class="mt-1 block w-full" type="text" name="codigo" required autofocus />
                <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('verify.resend') }}">
                    {{ __('Reenviar') }}
                </a>
                <x-primary-button class="g-recaptcha ml-4">
                    {{ __('Enviar') }}
                </x-primary-button>
            </div>
        </form>
        <div class="-mt-[30px]">
            <form method="POST" action="{{ route('logout') }}" >
                @csrf
                <a :href="route('logout')" onclick="event.preventDefault();
                    this.closest('form').submit();" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 cursor-pointer">
                    {{ __('Logout') }}
                </a>
            </form>
        </div>
</x-guest-layout>