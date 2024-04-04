<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Delete User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex-1">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Are you sure you want to delete this user?') }}
                            </h2>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <div>
                                <span class="text-gray-800 dark:text-gray-200">
                                    {{ $user->name }}
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="space-x-6">
                                <span class="text-md text-gray-900 dark:text-gray-100">
                                    {{ $user->email }}
                                </span>
                            </div>
                        </div>
                                                <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800 dark:text-gray-200">
                                    {{  $user->rol->role }}
                                </span>
                            </div>
                        </div>
                        <div class="py-4">
                            <form method="POST" action="{{ URL::signedRoute('users.destroy', $user) }}">
                                @csrf @method('delete')
                                <div>
                                    <x-input-label for="name" :value="__('Enter the name of the user')" />
                                    <x-text-input id="name" name="name" type="text" class="mr-4 my-4 block w-full" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
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
        </div>
    </div>
</x-app-layout>