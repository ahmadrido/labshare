<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('files.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-4">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                Back to Files
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Upload New File</h1>
            <p class="mt-1 text-sm text-gray-600">Upload course materials for students</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Subject -->
                <div class="mb-6">
                    <label for="subject_id" class="block text-sm font-medium text-gray-900 mb-2">
                        Subject <span class="text-red-600">*</span>
                    </label>
                    <select name="subject_id" id="subject_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('subject_id') border-red-500 @enderror">
                        <option value="">Select a subject</option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
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
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g., Chapter 1 - Introduction" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('title') border-red-500 @enderror">
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
                        <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="doc" {{ old('type') == 'doc' ? 'selected' : '' }}>DOC/DOCX</option>
                        <option value="ppt" {{ old('type') == 'ppt' ? 'selected' : '' }}>PPT/PPTX</option>
                        <option value="xls" {{ old('type') == 'xls' ? 'selected' : '' }}>XLS/XLSX</option>
                        <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-900 mb-2">
                        File <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="file" name="file" id="file" required class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('file') border-red-500 @enderror">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Maximum file size: 5MB</p>
                    @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-900 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="4" placeholder="Add a description..." class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                        <x-heroicon-o-arrow-up-tray class="w-4 h-4 mr-2" />
                        Upload File
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