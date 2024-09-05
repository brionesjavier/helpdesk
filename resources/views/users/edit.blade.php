<x-app-layout>
        <x-slot name="header">
            {{-- mensaje de evento --}}
            @if(session()->has('message'))
            <div class="text-center bg-gray-100 rounded-md p-2">
                <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
            </div>
            @endif
    
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Users 
                </h2>
                <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-4 text-gray-900 dark:text-gray-100s space-x-8">
                        <a href="#" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('boton') }}</a>
                        
                    </div>
                </div>
                
            </div>
    
        </x-slot>
    
        {{-- El contenido principal de la página --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        
                        <form method="POST" action="{{ route('users.update',$user) }}">
                            @csrf
                            @method('put')
                            <!-- Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('Nombre')" />
                                <x-text-input   id="first_name" 
                                                class="block mt-1 w-full" 
                                                type="text" name="first_name" 
                                                value="{{ $user->first_name }}" 
                                                required autofocus autocomplete="first_name" />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="last_name" :value="__('Apellido')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" value="{{ $user->last_name }}" required autofocus autocomplete="last_name" />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                    
                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $user->email }}" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            {{-- phone --}}
                            <div class="mt-4">
                                <x-input-label for="phone" :value="__('Telefono')" />
                                <x-text-input   id="phone" 
                                                class="block mt-1 w-full" 
                                                type="tel"
                                                name="phone" 
                                                value="{{ $user->phone }}" 
                                                required autofocus autocomplete="phone" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                            </div>


                                
                    
                             
                             <!-- Asignar ticket -->
                            <div class="mt-4">
                                <x-input-label for="assignable" :value="__('Asignar ticket?')" />
                                <select name="assignable" id="assignable" class="block w-full mt-1 p-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400 text-gray-900 dark:text-gray-100">
                                    <option value="1" {{ $user->assignable == 1 ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ $user->assignable == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                <x-input-error :messages="$errors->get('assignable')" class="mt-2" />
                            </div>
                    
                            <div class="flex items-center justify-end mt-4">
                                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('users.index') }}">
                                    {{ __('Cancelar') }}
                                </a>
                    
                                <x-primary-button class="ms-4">
                                    {{ __('Actualizar') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    
