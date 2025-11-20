<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                Back to Users
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
            <p class="mt-1 text-sm text-gray-600">Update user information and permissions</p>
        </div>

        <!-- User Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-16 h-16 bg-gray-900 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    <p class="text-xs text-gray-500 mt-1">Member since {{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-900 mb-2">
                        Full Name <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required placeholder="Enter full name" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-900 mb-2">
                        Email Address <span class="text-red-600">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required placeholder="email@example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Section -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 mb-3 flex items-center">
                        <x-heroicon-o-key class="w-4 h-4 mr-2" />
                        Change Password (Optional)
                    </h3>
                    
                    <!-- New Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-900 mb-2">
                            New Password
                        </label>
                        <input type="password" name="password" id="password" placeholder="Leave blank to keep current password" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('password') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters if changing</p>
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900 mb-2">
                            Confirm New Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-enter new password" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                    </div>
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
                                {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'checked' : '' }}
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
                    <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer transition-colors
                        {{ $user->email_verified_at ? 'bg-green-50 border-green-200' : 'bg-gray-50 hover:bg-gray-100' }}">
                        <input type="checkbox" name="email_verified" value="1" 
                            {{ old('email_verified', $user->email_verified_at ? true : false) ? 'checked' : '' }}
                            class="w-4 h-4 text-gray-900 border-gray-300 rounded focus:ring-gray-900" disabled>
                        <div class="ml-3 flex-1">
                            <span class="text-sm font-medium text-gray-900">Email Verified</span>
                            <p class="text-xs text-gray-500">
                                @if($user->email_verified_at)
                                Verified on {{ $user->email_verified_at->format('M d, Y \a\t H:i') }}
                                @else
                                User has not verified their email address yet
                                @endif
                            </p>
                        </div>
                        @if($user->email_verified_at)
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded bg-green-100 text-green-800">
                            <x-heroicon-o-check-circle class="w-3 h-3 mr-1" />
                            Verified
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded bg-yellow-100 text-yellow-800">
                            <x-heroicon-o-clock class="w-3 h-3 mr-1" />
                            Pending
                        </span>
                        @endif
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        <x-heroicon-o-check class="w-4 h-4 mr-2" />
                        Update User
                    </button>
                    <a href="{{ route('users.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- User Stats Card -->
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-900 mb-4 flex items-center">
                <x-heroicon-o-chart-bar class="w-4 h-4 mr-2" />
                User Statistics
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Files Uploaded</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->files->count() }}</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Total Downloads</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $user->downloads->count() }}</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">Last Login</p>
                    <p class="text-sm font-medium text-gray-900">
                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        @if(Auth::id() !== $user->id)
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-red-200 p-6">
            <h3 class="text-sm font-medium text-red-900 mb-2 flex items-center">
                <x-heroicon-o-exclamation-triangle class="w-4 h-4 mr-2" />
                Danger Zone
            </h3>
            <p class="text-sm text-gray-600 mb-4">Permanently delete this user and all associated data. This action cannot be undone.</p>
            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                    <x-heroicon-o-trash class="w-4 h-4 mr-2" />
                    Delete User
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
</x-app-layout>