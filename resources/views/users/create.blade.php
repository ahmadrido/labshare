<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                Back to Users
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Add New User</h1>
            <p class="mt-1 text-sm text-gray-600">Create a new user account</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-900 mb-2">
                        Full Name <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Enter full name" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-900 mb-2">
                        Email Address <span class="text-red-600">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="email@example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-900 mb-2">
                        Password <span class="text-red-600">*</span>
                    </label>
                    <input type="password" name="password" id="password" required placeholder="Minimum 8 characters" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('password') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters long</p>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-900 mb-2">
                        Confirm Password <span class="text-red-600">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Re-enter password" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                </div>

                <!-- Roles -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-900 mb-2">
                        Assign Roles <span class="text-red-600">*</span>
                    </label>
                    <div class="space-y-2 p-4 border border-gray-300 rounded-lg bg-gray-50">
                        @foreach($roles as $role)
                        <label class="flex items-center p-3 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                class="w-4 h-4 text-gray-900 border-gray-300 rounded focus:ring-gray-900">
                            <div class="ml-3 flex-1">
                                <span class="text-sm font-medium text-gray-900">{{ ucfirst($role->name) }}</span>
                                @if($role->name == 'admin')
                                <p class="text-xs text-gray-500">Full system access and user management</p>
                                @elseif($role->name == 'teacher')
                                <p class="text-xs text-gray-500">Can upload and manage course materials</p>
                                @elseif($role->name == 'student')
                                <p class="text-xs text-gray-500">Can view and download materials</p>
                                @endif
                            </div>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded 
                                @if($role->name == 'admin') bg-red-100 text-red-800
                                @elseif($role->name == 'teacher') bg-blue-100 text-blue-800
                                @elseif($role->name == 'student') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $role->permissions->count() }} permissions
                            </span>
                        </label>
                        @endforeach
                    </div>
                    @error('roles')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Verification Status -->
                <div class="mb-6">
                    <label class="flex items-center p-4 border border-gray-300 rounded-lg bg-gray-50 cursor-pointer hover:bg-gray-100 transition-colors">
                        <input type="checkbox" name="email_verified" value="1" {{ old('email_verified') ? 'checked' : '' }} class="w-4 h-4 text-gray-900 border-gray-300 rounded focus:ring-gray-900">
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-900">Verify Email Immediately</span>
                            <p class="text-xs text-gray-500">User can access system without email verification</p>
                        </div>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        <x-heroicon-o-user-plus class="w-4 h-4 mr-2" />
                        Create User
                    </button>
                    <a href="{{ route('users.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0" />
                <div class="text-sm text-blue-800">
                    <p class="font-medium mb-1">Important Notes:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs">
                        <li>Users will receive login credentials via email</li>
                        <li>Multiple roles can be assigned to a single user</li>
                        <li>Permissions are inherited from assigned roles</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>