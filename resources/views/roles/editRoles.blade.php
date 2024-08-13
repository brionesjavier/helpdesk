<x-app-layout>
<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Modificar Roles de Usuario</h1>

    @if (session('success'))
        <div class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 dark:border-green-700 text-green-700 dark:text-green-300 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form action="{{ route('users.updateRoles', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="user" class="block text-gray-700 dark:text-gray-300 font-medium">Usuario</label>
            <input type="text" id="user" value="{{ $user->name }}" class="w-full mt-2 p-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-300" disabled>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Roles</label>
            @foreach($roles as $role)
                <div class="flex items-center mb-2">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" id="role-{{ $role->id }}" 
                           class="h-4 w-4 text-indigo-600 dark:text-indigo-500 border-gray-300 dark:border-gray-600 rounded focus:ring-indigo-500 dark:focus:ring-indigo-400"
                           @if($user->roles->contains($role->id)) checked @endif>
                    <label for="role-{{ $role->id }}" class="ml-2 text-gray-700 dark:text-gray-300">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="w-full bg-indigo-600 dark:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition duration-200">
            Guardar Cambios
        </button>
    </form>
</div>

</x-app-layout>