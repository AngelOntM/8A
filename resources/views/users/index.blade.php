<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <x-auth-session-status class="mb-4" :status="session('status')" />


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg divide-y dark:divide-gray-900">
                @foreach($users as $user)
                    <div class="p-6 flex space-x-2">
                        <svg class="h-6 w-6 text-gray-600 dark:text-gray-400 -scale-x-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>


                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-gray-800 dark:text-gray-200">
                                        {{ $user->name }}
                                    </span>
                                    <small class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->format('j M Y, g:i a') }}</small>
                                    <small class="text-sm text-gray-600 dark:text-gray-400"> &middot; {{ $user->updated_at->format('j M Y, g:i a') }}</small>

                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="space-x-6">
                                    <span class="text-md text-gray-900 dark:text-gray-100">
                                        {{ $user->email }}
                                    </span>
                                    <span class="text-md text-gray-900 dark:text-gray-100">
                                        {{ \App\Models\Rol::find($user->rol_id)->role }}
                                    </span>
                                </div>
                            </div>

                            
                        </div>
                        @if (Auth::user()->rol_id == 1)
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button>
                                        <svg class="w-6 h-6 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="URL::signedRoute('users.edit', $user)">
                                        {{ __('Edit User') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="URL::signedRoute('users.editpassword', $user)">
                                        {{ __('Edit Password') }}
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ URL::signedRoute('users.destroy', $user) }}">
                                        @csrf @method('DELETE')
                                        <x-dropdown-link :href="URL::signedRoute('users.destroy', $user)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Delete User') }}
                                        </x-dropdown-link>
                                    </form>

                                </x-slot>
                            </x-dropdown>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>