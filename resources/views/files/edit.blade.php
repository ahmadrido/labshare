<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('files.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                Back to Files
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit File</h1>
            <p class="mt-1 text-sm text-gray-600">Update file information</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form action="{{ route('files.update', $file) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Current File Info -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm font-medium text-gray-900 mb-2">Current File</p>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-white rounded-lg flex items-center justify-center mr-3">
                            @if($file->file_type == 'pdf')
                            <x-heroicon-o-document-text class="w-5 h-5 text-red-600" />
                            @elseif($file->file_type == 'doc')
                            <x-heroicon-o-document class="w-5 h-5 text-blue-600" />
                            @elseif($file->file_type == 'ppt')
                            <x-heroicon-o-presentation-chart-bar class="w-5 h-5 text-orange-600" />
                            @elseif($file->file_type == 'xls')
                            <x-heroicon-o-table-cells class="w-5 h-5 text-green-600" />
                            @else
                            <x-heroicon-o-document class="w-5 h-5 text-gray-600" />
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ basename($file->file_path) }}</p>
                            <p class="text-xs text-gray-500">Uploaded {{ $file->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Subject -->
                <div class="mb-6">
                    <label for="subject_id" class="block text-sm font-medium text-gray-900 mb-2">
                        Subject <span class="text-red-600">*</span>
                    </label>
                    <select name="subject_id" id="subject_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('subject_id') border-red-500 @enderror">
                        <option value="">Select a subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $file->subject_id) == $subject->id ? 'selected' : '' }}>
                            {{ $subject->nama_matkul }}
                        </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-900 mb-2">
                        Title <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $file->title) }}" required placeholder="e.g., Chapter 1 - Introduction" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('title') border-red-500 @enderror">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Type -->
                <div class="mb-6">
                    <label for="type" class="block text-sm font-medium text-gray-900 mb-2">
                        File Type <span class="text-red-600">*</span>
                    </label>
                    <select name="type" id="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('type') border-red-500 @enderror">
                        <option value="">Select file type</option>
                        <option value="pdf" {{ old('type', $file->file_type) == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="doc" {{ old('type', $file->file_type) == 'doc' ? 'selected' : '' }}>DOC/DOCX</option>
                        <option value="ppt" {{ old('type', $file->file_type) == 'ppt' ? 'selected' : '' }}>PPT/PPTX</option>
                        <option value="xls" {{ old('type', $file->file_type) == 'xls' ? 'selected' : '' }}>XLS/XLSX</option>
                        <option value="image" {{ old('type', $file->file_type) == 'image' ? 'selected' : '' }}>Image</option>
                        <option value="other" {{ old('type', $file->file_type) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload (Optional) -->
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-900 mb-2">
                        Replace File (Optional)
                    </label>
                    <div class="relative">
                        <input type="file" name="file" id="file" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('file') border-red-500 @enderror">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Leave empty to keep the current file. Maximum file size: 5MB</p>
                    @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-900 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="4" placeholder="Add a description..." class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $file->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        <x-heroicon-o-check class="w-4 h-4 mr-2" />
                        Update File
                    </button>
                    <a href="{{ route('files.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>