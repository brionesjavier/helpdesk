<x-app-layout>
    <x-slot name="header">
        {{-- Mensaje de evento --}}
        @if(session()->has('message'))
            <div class="text-center bg-gray-100 dark:bg-gray-800 rounded-md p-2 mb-4">
                <span class="text-indigo-600 dark:text-indigo-400 text-xl font-semibold">{{ session('message') }}</span>
            </div>
        @endif

        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Editar Usuario
            </h2>
        </div>
    </x-slot>

    {{-- El contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    <!-- Información del Usuario -->
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-md shadow-md">
                        <h1 class="text-2xl font-semibold mb-4">Detalles del Usuario</h1>
                        <div class="space-y-4">
                            <form method="POST" action="{{ route('users.update', $user) }}">
                                @csrf
                                @method('PUT')

                                <!-- First Name -->
                                <div>
                                    <x-input-label for="first_name" :value="__('Nombre')" />
                                    <x-text-input 
                                        id="first_name" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="first_name" 
                                        value="{{ old('first_name', $user->first_name) }}" 
                                        required 
                                        autofocus 
                                        autocomplete="given-name" 
                                    />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <x-input-label for="last_name" :value="__('Apellido')" />
                                    <x-text-input 
                                        id="last_name" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="last_name" 
                                        value="{{ old('last_name', $user->last_name) }}" 
                                        required 
                                        autofocus 
                                        autocomplete="family-name" 
                                    />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>

                                <!-- Birthdate -->
                                <div>
                                    <x-input-label for="birthdate" :value="__('Fecha de nacimiento')" />
                                    <x-text-input 
                                        id="birthdate" 
                                        class="block mt-1 w-full" 
                                        type="date" 
                                        name="birthdate" 
                                        value="{{ old('birthdate', $user->birthdate) }}" 
                                        required 
                                        autofocus 
                                        autocomplete="bday"
                                    />
                                    <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                                </div>

                                <!-- Email Address -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input 
                                        id="email" 
                                        class="block mt-1 w-full" 
                                        type="email" 
                                        name="email" 
                                        value="{{ old('email', $user->email) }}" 
                                        required 
                                        autocomplete="email" 
                                    />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Phone -->
                                <div>
                                    <x-input-label for="phone" :value="__('Teléfono')" />
                                    <x-text-input 
                                        id="phone" 
                                        class="block mt-1 w-full" 
                                        type="tel" 
                                        name="phone" 
                                        value="{{ old('phone', $user->phone) }}" 
                                        required 
                                        autofocus 
                                        autocomplete="tel" 
                                    />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <!-- Address (Optional) -->
                                <div>
                                    <x-input-label for="address" :value="__('Dirección *(opcional)')" />
                                    <x-text-input 
                                        id="address" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="address" 
                                        value="{{ old('address', $user->address) }}" 
                                        autofocus 
                                        autocomplete="address" 
                                    />
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                           
                                <!-- City (Optional) -->
                                <div>
                                    <x-input-label for="city" :value="__('Ciudad *(opcional)')" />
                                    <x-text-input 
                                        id="city" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="city" 
                                        value="{{ old('city', $user->city) }}" 
                                        autofocus 
                                        autocomplete="address-level2" 
                                    />
                                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                </div>

                                <!-- Assignable -->
                                <div>
                                    <x-input-label for="assignable" :value="__('Soporte/Administracion Asignable')" />
                                    <select 
                                        id="assignable" 
                                        name="assignable" 
                                        class="block mt-1 w-full border border-gray-300 dark:border-gray-800 rounded-md shadow-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-700 focus:ring-opacity-50"
                                    >
                                        <option value="" disabled selected>Selecciona una opción</option>
                                        <option value="1" {{ old('assignable', $user->assignable) == '1' ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ old('assignable', $user->assignable) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('assignable')" class="mt-2" />
                                </div>

                                <x-primary-button class="mt-4">
                                    Actualizar
                                </x-primary-button>
                            </form>
                        </div>
                    </div>

                    <!-- Roles Asignados -->
                    <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-md shadow-md">
                        <h2 class="text-lg font-semibold mb-2">Roles Asignados:</h2>
                        <ul class="list-disc list-inside">
                            @forelse ($user->roles as $role)
                                <li>{{ $role->name }}</li>
                            @empty
                                <li>El usuario no tiene roles asignados.</li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
