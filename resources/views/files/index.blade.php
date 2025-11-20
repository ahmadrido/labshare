<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Files</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage and download course materials</p>
                </div>
                @can('upload files')
                <a href="{{ route('files.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                    <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                    Upload File
                </a>
                @endcan
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <form method="GET" action="{{ route('files.index') }}" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Search by Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                </div>

                <!-- Filter by Subject -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <select name="subject" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->nama_matkul }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="pdf" {{ request('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="doc" {{ request('type') == 'doc' ? 'selected' : '' }}>DOC</option>
                        <option value="ppt" {{ request('type') == 'ppt' ? 'selected' : '' }}>PPT</option>
                        <option value="xls" {{ request('type') == 'xls' ? 'selected' : '' }}>XLS</option>
                        <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Image</option>
                        <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-4 flex gap-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        <x-heroicon-o-funnel class="w-4 h-4 mr-2" />
                        Apply Filters
                    </button>
                    <a href="{{ route('files.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <x-heroicon-o-x-mark class="w-4 h-4 mr-2" />
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
            <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
            {{ session('success') }}
        </div>
        @endif

        <!-- Files Grid -->
        @if($files->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($files as $file)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                <div class="p-6">
                    <!-- File Icon & Type -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            @if($file->file_type == 'pdf')
                            <x-heroicon-o-document-text class="w-6 h-6 text-red-600" />
                            @elseif($file->file_type == 'doc')
                            <x-heroicon-o-document class="w-6 h-6 text-blue-600" />
                            @elseif($file->file_type == 'ppt')
                            <x-heroicon-o-presentation-chart-bar class="w-6 h-6 text-orange-600" />
                            @elseif($file->file_type == 'xls')
                            <x-heroicon-o-table-cells class="w-6 h-6 text-green-600" />
                            @elseif($file->file_type == 'image')
                            <x-heroicon-o-photo class="w-6 h-6 text-purple-600" />
                            @else
                            <x-heroicon-o-document class="w-6 h-6 text-gray-600" />
                            @endif
                        </div>
                        <span class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded">
                            {{ strtoupper($file->file_type) }}
                        </span>
                    </div>

                    <!-- File Info -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                        {{ $file->title }}
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-1">
                        <x-heroicon-o-book-open class="w-4 h-4 inline mr-1" />
                        {{ $file->subject->nama_matkul }}
                    </p>
                    
                    <p class="text-sm text-gray-600 mb-1">
                        <x-heroicon-o-user class="w-4 h-4 inline mr-1" />
                        {{ $file->user->name }}
                    </p>

                    <p class="text-xs text-gray-500 mb-4">
                        <x-heroicon-o-clock class="w-4 h-4 inline mr-1" />
                        {{ $file->created_at->diffForHumans() }}
                    </p>

                    @if($file->description)
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $file->description }}
                    </p>
                    @endif

                    <!-- Actions -->
                    <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('files.download', $file) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                            <x-heroicon-o-arrow-down-tray class="w-4 h-4 mr-1" />
                            Download
                        </a>
                        
                        @can('edit files')
                        <a href="{{ route('files.edit', $file) }}" class="inline-flex items-center justify-center px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            <x-heroicon-o-pencil class="w-4 h-4" />
                        </a>
                        @endcan

                        @can('delete files')
                        <form action="{{ route('files.destroy', $file) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition-colors">
                                <x-heroicon-o-trash class="w-4 h-4" />
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <x-heroicon-o-folder-open class="w-16 h-16 mx-auto text-gray-400 mb-4" />
            <h3 class="text-lg font-medium text-gray-900 mb-2">No files found</h3>
            <p class="text-gray-600 mb-6">Get started by uploading your first file.</p>
            @can('upload files')
            <a href="{{ route('files.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                Upload File
            </a>
            @endcan
        </div>
        @endif
    </div>
</div>
</x-app-layout>