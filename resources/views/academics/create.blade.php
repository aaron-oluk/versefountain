@extends('layouts.app')

@section('title', 'Add Academic Resource - VerseFountain')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Add Academic Resource</h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Share educational materials</p>
                </div>
                <a href="{{ route('academics.index') }}" 
                   class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
                    <i class="bx bx-arrow-back text-base mr-1"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm p-4 sm:p-6">
            <form id="resource-create-form" data-resource-form>
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input id="title" 
                               name="title" 
                               type="text" 
                               required
                               placeholder="Enter resource title"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    <!-- Type & Language -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type <span class="text-red-500">*</span>
                            </label>
                            <select id="type" 
                                    name="type" 
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select type</option>
                                <option value="research_paper">Research Paper</option>
                                <option value="thesis">Thesis</option>
                                <option value="dissertation">Dissertation</option>
                                <option value="essay">Essay</option>
                                <option value="article">Article</option>
                                <option value="book_chapter">Book Chapter</option>
                                <option value="presentation">Presentation</option>
                                <option value="lecture_notes">Lecture Notes</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Language
                            </label>
                            <input id="language" 
                                   name="language" 
                                   type="text" 
                                   placeholder="e.g., English"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
                    </div>

                    <!-- Author & Subject -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Author
                            </label>
                            <input id="author" 
                                   name="author" 
                                   type="text" 
                                   placeholder="Enter author name"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Subject
                            </label>
                            <input id="subject" 
                                   name="subject" 
                                   type="text" 
                                   placeholder="e.g., Literature, Philosophy"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Upload File
                        </label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-md p-6 text-center">
                            <input type="file" id="file-input" accept=".pdf,.doc,.docx,.ppt,.pptx" class="hidden">
                            <div id="file-upload-area">
                                <i class="bx bx-cloud-upload text-4xl text-gray-400 dark:text-gray-500 mb-2"></i>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    <button type="button" id="select-file-btn" class="text-blue-600 hover:text-blue-700 font-medium">
                                        Click to upload
                                    </button> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOC, DOCX, PPT, PPTX up to 50MB</p>
                            </div>
                            <div id="file-info" class="hidden">
                                <i class="bx bx-file text-3xl text-blue-600 mb-2"></i>
                                <p class="text-sm text-gray-900 dark:text-white font-medium" id="file-name"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400" id="file-size"></p>
                                <button type="button" id="remove-file-btn" class="mt-2 text-sm text-red-600 hover:text-red-700">
                                    Remove
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="fileUrl" id="file-url">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="6"
                                  placeholder="Describe the resource, its content, and key findings..."
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="bx bx-info-circle"></i> Admin access required
                        </p>
                        <div class="flex space-x-3">
                            <a href="{{ route('academics.index') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Add Resource
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resource-create-form');
    const fileInput = document.getElementById('file-input');
    const selectFileBtn = document.getElementById('select-file-btn');
    const removeFileBtn = document.getElementById('remove-file-btn');
    const fileUploadArea = document.getElementById('file-upload-area');
    const fileInfo = document.getElementById('file-info');
    const fileNameEl = document.getElementById('file-name');
    const fileSizeEl = document.getElementById('file-size');
    const fileUrlInput = document.getElementById('file-url');
    
    const resourceManager = new AcademicResourceManager();
    let selectedFile = null;

    // File selection
    selectFileBtn.addEventListener('click', () => fileInput.click());
    
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            selectedFile = file;
            displayFileInfo(file);
        }
    });

    removeFileBtn.addEventListener('click', function() {
        selectedFile = null;
        fileInput.value = '';
        fileUrlInput.value = '';
        fileUploadArea.classList.remove('hidden');
        fileInfo.classList.add('hidden');
    });

    function displayFileInfo(file) {
        fileNameEl.textContent = file.name;
        fileSizeEl.textContent = formatFileSize(file.size);
        fileUploadArea.classList.add('hidden');
        fileInfo.classList.remove('hidden');
    }

    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    // Form handler
    const formHandler = new CRUDFormHandler(form, {
        async onSubmit(formData) {
            // Create resource first
            const resource = await resourceManager.create(formData);
            
            // Upload file if selected
            if (resource && selectedFile) {
                const fileUrl = await resourceManager.uploadFile(resource.id, selectedFile);
                if (fileUrl) {
                    resource.fileUrl = fileUrl;
                }
            }
            
            return resource;
        },
        onSuccess(resource) {
            if (resource) {
                setTimeout(() => {
                    window.location.href = '/academics';
                }, 1500);
            }
        },
        onError(error) {
            console.error('Resource creation error:', error);
        }
    });
});
</script>
@endsection
