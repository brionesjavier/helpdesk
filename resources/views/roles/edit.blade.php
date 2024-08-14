<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container">
                        <h1>Edit Role</h1>
                    
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    
                        @can('roles.update')
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Permissions</label>
                                @foreach($permissions as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}"
                                            @if($role->permissions->contains($permission)) checked @endif>
                                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                                            {{ $permission->name }} -¬- {{ $permission->description }}-
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </form>
                       
                            
                        @endcan
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>