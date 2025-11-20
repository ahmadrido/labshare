<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600">Welcome back, {{ Auth::user()->name }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Files -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Files</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalFiles }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <x-heroicon-o-document-text class="w-6 h-6 text-gray-900" />
                    </div>
                </div>
            </div>

            <!-- Total Subjects -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Subjects</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSubjects }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <x-heroicon-o-book-open class="w-6 h-6 text-gray-900" />
                    </div>
                </div>
            </div>

            <!-- Total Downloads -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Downloads</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalDownloads }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <x-heroicon-o-arrow-down-tray class="w-6 h-6 text-gray-900" />
                    </div>
                </div>
            </div>

            <!-- My Uploads -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">My Uploads</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $myUploads }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <x-heroicon-o-user class="w-6 h-6 text-gray-900" />
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Files -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Files</h2>
                        <a href="{{ route('files.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center">
                            View all
                            <x-heroicon-o-arrow-right class="w-4 h-4 ml-1" />
                        </a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($recentFiles as $file)
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start flex-1 min-w-0">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                        @if($file->file_type == 'pdf')
                                        <x-heroicon-o-document-text class="w-5 h-5 text-red-600" />
                                        @elseif($file->file_type == 'doc')
                                        <x-heroicon-o-document class="w-5 h-5 text-blue-600" />
                                        @elseif($file->file_type == 'ppt')
                                        <x-heroicon-o-presentation-chart-bar class="w-5 h-5 text-orange-600" />
                                        @elseif($file->file_type == 'xls')
                                        <x-heroicon-o-table-cells class="w-5 h-5 text-green-600" />
                                        @elseif($file->file_type == 'image')
                                        <x-heroicon-o-photo class="w-4 h-4 text-purple-600" />
                                        @else
                                        <x-heroicon-o-document class="w-5 h-5 text-gray-600" />
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-medium text-gray-900 truncate">{{ $file->title }}</h3>
                                        <div class="flex items-center gap-3 mt-1">
                                            <span class="text-xs text-gray-600">{{ $file->subject->nama_matkul }}</span>
                                            <span class="text-xs text-gray-400">•</span>
                                            <span class="text-xs text-gray-500">{{ $file->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('files.download', $file) }}" class="ml-4 inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                    <x-heroicon-o-arrow-down-tray class="w-3.5 h-3.5 mr-1" />
                                    Download
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-12 text-center">
                            <x-heroicon-o-document class="w-12 h-12 mx-auto text-gray-400 mb-3" />
                            <p class="text-sm text-gray-600">No files uploaded yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        @can('upload files')
                        <a href="{{ route('files.create') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-gray-900 transition-colors">
                                <x-heroicon-o-arrow-up-tray class="w-5 h-5 text-gray-900 group-hover:text-white transition-colors" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Upload File</p>
                                <p class="text-xs text-gray-500">Add new material</p>
                            </div>
                        </a>
                        @endcan

                        <a href="{{ route('files.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-gray-900 transition-colors">
                                <x-heroicon-o-folder-open class="w-5 h-5 text-gray-900 group-hover:text-white transition-colors" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Browse Files</p>
                                <p class="text-xs text-gray-500">View all materials</p>
                            </div>
                        </a>

                        @can('view files')
                        <a href="{{ route('files.index', ['subject' => '']) }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-gray-900 transition-colors">
                                <x-heroicon-o-book-open class="w-5 h-5 text-gray-900 group-hover:text-white transition-colors" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">By Subject</p>
                                <p class="text-xs text-gray-500">Filter by course</p>
                            </div>
                        </a>
                        @endcan
                    </div>
                </div>

                <!-- File Types Distribution -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">File Types</h2>
                    <div class="space-y-3">
                        @foreach($fileTypeStats as $type => $count)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                    @if($type == 'pdf')
                                    <x-heroicon-o-document-text class="w-4 h-4 text-red-600" />
                                    @elseif($type == 'doc')
                                    <x-heroicon-o-document class="w-4 h-4 text-blue-600" />
                                    @elseif($type == 'ppt')
                                    <x-heroicon-o-presentation-chart-bar class="w-4 h-4 text-orange-600" />
                                    @elseif($type == 'xls')
                                    <x-heroicon-o-table-cells class="w-4 h-4 text-green-600" />
                                    @elseif($type == 'image')
                                    <x-heroicon-o-photo class="w-4 h-4 text-purple-600" />
                                    @elseif($type == 'video')
                                    <x-heroicon-o-video-camera class="w-4 h-4 text-pink-600" />
                                    @elseif($type == 'other')
                                    <x-heroicon-o-document class="w-4 h-4 text-gray-600" />
                                    @else
                                    <x-heroicon-o-document class="w-4 h-4 text-gray-600" />
                                    @endif
                                </div>
                                <span class="text-sm font-medium text-gray-700 uppercase">{{ $type }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Popular Downloads -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Popular Downloads</h2>
                    <div class="space-y-3">
                        @forelse($popularFiles as $file)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                @if($file->file_type == 'pdf')
                                <x-heroicon-o-document-text class="w-4 h-4 text-red-600" />
                                @elseif($file->file_type == 'doc')
                                <x-heroicon-o-document class="w-4 h-4 text-blue-600" />
                                @elseif($file->file_type == 'ppt')
                                <x-heroicon-o-presentation-chart-bar class="w-4 h-4 text-orange-600" />
                                @elseif($file->file_type == 'xls')
                                <x-heroicon-o-table-cells class="w-4 h-4 text-green-600" />
                                @else
                                <x-heroicon-o-document class="w-4 h-4 text-gray-600" />
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $file->title }}</p>
                                <p class="text-xs text-gray-500 flex items-center mt-0.5">
                                    <x-heroicon-o-arrow-down-tray class="w-3 h-3 mr-1" />
                                    {{ $file->downloads_count }} downloads
                                </p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 text-center py-4">No downloads yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>