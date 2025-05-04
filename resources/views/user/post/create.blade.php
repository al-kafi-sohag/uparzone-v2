@extends('user.layout.master')

@section('title', __('Create Post'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('user/css/post.css') }}">
    <style>
        .content-type-tab {
            background-color: #f3f4f6;
            color: #4b5563;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .content-type-tab.selected {
            background-color: var(--theme-color);
            color: white;
        }

        .content-type-tab:not(.selected):hover {
            background-color: #e5e7eb;
        }

        .dark .content-type-tab {
            background-color: #374151;
            color: #e5e7eb;
        }

        .dark .content-type-tab:not(.selected):hover {
            background-color: #4b5563;
        }

        .dark .content-type-tab.selected {
            background-color: var(--theme-color);
            color: white;
        }
    </style>
@endpush
@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Create New Post</h1>

        <form id="createPostForm" class="space-y-6" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Title
                </label>
                <input type="text" id="title"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md theme-ring focus:border-transparent dark:bg-gray-700 dark:text-white"
                    placeholder="Give your post a title" required />
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Description
                </label>
                <textarea id="description" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md theme-ring focus:border-transparent dark:bg-gray-700 dark:text-white"
                    placeholder="Add a short description" required></textarea>
            </div>

            <!-- File Upload -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Media</label>

                <div id="uploadContainer">
                    <div id="uploadPlaceholder" class="file-upload theme-border-hover">
                        <i data-lucide="upload" class="w-10 h-10 upload-icon text-gray-400 mx-auto"></i>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Click to upload an image or video</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF, MP4, MOV up to 10MB</p>
                    </div>

                    <div id="previewContainer" class="relative hidden">
                        <button type="button" id="removeFileBtn"
                            class="absolute top-2 right-2 bg-gray-800 bg-opacity-70 text-white p-1 rounded-full hover:bg-opacity-100 transition-opacity z-10">
                            <i data-lucide="x"></i>
                        </button>

                        <div id="imagePreview" class="relative h-64 w-full rounded-lg overflow-hidden hidden">
                            <img src="" alt="Preview" class="object-contain w-full h-full" />
                        </div>

                        <video id="videoPreview" src="" controls
                            class="w-full h-64 rounded-lg object-contain bg-black hidden"></video>
                    </div>
                </div>

                <input type="file" id="fileInput" accept="image/*,video/*" class="hidden" />
            </div>

            <!-- Upload Progress -->
            <div id="uploadProgress" class="space-y-2 hidden">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-700 dark:text-gray-300">Uploading...</span>
                    <span id="progressText" class="text-gray-700 dark:text-gray-300">0%</span>
                </div>
                <div class="progress-bar">
                    <div id="progressBarFill" class="progress-bar-fill" style="width: 0%"></div>
                </div>
            </div>



            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Post Category
                </label>
                <div class="flex flex-wrap" id="categoryOptions">
                    <button type="button" class="option-button selected" data-value="all">All</button>
                    @foreach($categories as $category)
                        <button type="button" class="option-button" data-value="{{ $category->id }}">{{ $category->name }}</button>
                    @endforeach
                </div>
                <input type="hidden" id="categoryValue" value="all" />
            </div>

            <!-- Adult Content Toggle -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Content Type
                </label>
                <div class="grid grid-cols-2 w-full rounded-md overflow-hidden border border-gray-200 dark:border-gray-700">
                    <button type="button" id="notAdultContentBtn" class="content-type-tab selected py-2 px-1 text-center">
                        <i data-lucide="shield-check" class="inline-block mr-1 align-text-bottom text-sm text-white"></i>
                        <span>Not Adult Content</span>
                    </button>
                    <button type="button" id="adultContentBtn" class="content-type-tab py-2 px-1 text-center">
                        <i data-lucide="alert-triangle" class="inline-block mr-1 align-text-bottom text-sm text-red-500"></i>
                        <span>Adult Content</span>
                    </button>
                </div>
                <input type="hidden" id="adultContentValue" value="false" />
            </div>

            <!-- Advanced Options (Collapsible) -->
            <div class="border border-gray-200 dark:border-gray-700 rounded-md mt-6">
                <button type="button" id="advancedOptionsToggle" class="flex justify-between items-center w-full px-4 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-50 focus:outline-none transition-colors">
                    <span class="flex items-center">
                        <i data-lucide="sliders" class="mr-2"></i>
                        Advanced Options
                    </span>
                    <i data-lucide="chevron-down" id="advancedOptionsIcon" class="transition-transform duration-200"></i>
                </button>

                <!-- Collapsible Content -->
                <div id="advancedOptionsContent" class="hidden overflow-hidden transition-all duration-300 max-h-0 px-4 space-y-6">
                    <!-- Religion -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Preferred Religion
                        </label>
                        <div class="flex flex-wrap" id="religionOptions">
                            <button type="button" class="option-button selected" data-value="all">All</button>
                            @foreach($religions as $religion)
                                <button type="button" class="option-button" data-value="{{ $religion->id }}">{{ $religion->name }}</button>
                            @endforeach
                        </div>
                        <input type="hidden" id="religionValue" value="all" />
                    </div>

                    <!-- Mood -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mood
                        </label>
                        <div class="flex flex-wrap" id="moodOptions">
                            <button type="button" class="option-button selected" data-value="all">🌟 All</button>
                            @foreach($moods as $mood)
                                <button type="button" class="option-button" data-value="{{ $mood->id }}">{{ $mood->emoji ?? '😊' }} {{ $mood->name }}</button>
                            @endforeach
                        </div>
                        <input type="hidden" id="moodValue" value="all" />
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Gender
                        </label>
                        <div class="flex flex-wrap" id="genderOptions">
                            <button type="button" class="option-button selected" data-value="all">All</button>
                            @foreach($genders as $gender)
                                <button type="button" class="option-button" data-value="{{ $gender->id }}">{{ $gender->name }}</button>
                            @endforeach
                        </div>
                        <input type="hidden" id="genderValue" value="all" />
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" id="submitButton" disabled class="submit-button">
                    <span id="submitButtonText" class="flex items-center">
                        <span class="check-icon mr-2"></span>
                        Create Post
                    </span>
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            // State
            let selectedFile = null;
            let uploading = false;
            let uploadController = null;
            const preferences = {
                religion: 'all',
                mood: 'all',
                gender: 'all',
                category: 'all',
                adultContent: false
            };

            // Event Listeners
            $('#uploadPlaceholder').on('click', function () {
                $('#fileInput').click();
            });

            $('#fileInput').on('change', function (e) {
                if (this.files && this.files[0]) {
                    selectedFile = this.files[0];

                    // Validate file size (10MB max)
                    const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                    if (selectedFile.size > maxSize) {
                        alert('File size exceeds 10MB limit. Please select a smaller file.');
                        $('#fileInput').val('');
                        selectedFile = null;
                        return;
                    }

                    // Create preview URL
                    const fileUrl = URL.createObjectURL(selectedFile);

                    // Show preview based on file type
                    if (selectedFile.type.startsWith('image/')) {
                        $('#imagePreview img').attr('src', fileUrl);
                        $('#imagePreview').removeClass('hidden');
                        $('#videoPreview').addClass('hidden');
                    } else if (selectedFile.type.startsWith('video/')) {
                        $('#videoPreview').attr('src', fileUrl);
                        $('#videoPreview').removeClass('hidden');
                        $('#imagePreview').addClass('hidden');
                    } else {
                        alert('Unsupported file type. Please select an image or video file.');
                        $('#fileInput').val('');
                        selectedFile = null;
                        return;
                    }

                    // Show preview container, hide placeholder
                    $('#previewContainer').removeClass('hidden');
                    $('#uploadPlaceholder').addClass('hidden');

                    // Start file upload immediately
                    uploadFile();
                }
            });

            $('#removeFileBtn').on('click', async function () {
                // Cancel ongoing upload if any
                if (uploadController) {
                    uploadController.abort();
                    uploadController = null;
                }

                // Get the temp_id if it exists
                const tempId = $('#fileInput').data('temp-id');

                // If we have a temp_id, delete the file from the server
                if (tempId) {
                    try {
                        await axios.delete(`{{ route('user.post.remove.media') }}`, {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                temp_id: tempId
                            }
                        });
                    } catch (error) {
                        console.error('Error removing file:', error);
                    }

                    // Clear the temp-id
                    $('#fileInput').removeData('temp-id');
                }

                // Clear file input
                $('#fileInput').val('');
                selectedFile = null;

                // Hide preview, show placeholder
                $('#previewContainer').addClass('hidden');
                $('#uploadPlaceholder').removeClass('hidden');
                $('#uploadProgress').addClass('hidden');

                // Disable submit button
                $('#submitButton').prop('disabled', true);

                // Reset progress bar
                $('#progressBarFill').css('width', '0%');
                $('#progressText').text('0%');
            });

            // Set up option buttons
            function setupOptionButtons(containerId, hiddenInputId) {
                const $container = $(`#${containerId}`);
                const $hiddenInput = $(`#${hiddenInputId}`);

                $container.find('.option-button').on('click', function () {
                    // Remove selected class from all buttons
                    $container.find('.option-button').removeClass('selected');

                    // Add selected class to clicked button
                    $(this).addClass('selected');

                    // Update hidden input value
                    $hiddenInput.val($(this).data('value'));

                    // Update preferences object
                    const preferenceName = containerId.replace('Options', '').toLowerCase();
                    preferences[preferenceName] = $(this).data('value');
                });
            }

            setupOptionButtons('religionOptions', 'religionValue');
            setupOptionButtons('moodOptions', 'moodValue');
            setupOptionButtons('genderOptions', 'genderValue');
            setupOptionButtons('categoryOptions', 'categoryValue');

            // Adult content toggle tabs
            $('#notAdultContentBtn, #adultContentBtn').on('click', function() {
                // Remove selected class from both buttons
                $('#notAdultContentBtn, #adultContentBtn').removeClass('selected');

                // Add selected class to clicked button
                $(this).addClass('selected');

                // Update hidden input and preferences
                const isAdult = $(this).attr('id') === 'adultContentBtn';
                $('#adultContentValue').val(isAdult);
                preferences.adultContent = isAdult;
            });

            // Advanced options toggle with smooth transition
            $('#advancedOptionsToggle').on('click', function() {
                const $content = $('#advancedOptionsContent');
                const $icon = $('#advancedOptionsIcon');

                $icon.toggleClass('rotate-180');

                if ($content.hasClass('hidden')) {
                    // Opening the panel
                    $content.removeClass('hidden');
                    $content.css('max-height', '0');
                    // Force a reflow to ensure the transition works
                    $content[0].offsetHeight;
                    // Set the max-height to a large value to ensure content fits
                    $content.css('max-height', '1000px');
                    $content.css('padding-top', '0.5rem');
                    $content.css('padding-bottom', '1rem');
                } else {
                    // Closing the panel
                    $content.css('max-height', '0');
                    $content.css('padding-top', '0');
                    $content.css('padding-bottom', '0');
                    // Add hidden class after transition completes
                    setTimeout(function() {
                        $content.addClass('hidden');
                    }, 300);
                }
            });

            // Upload file with progress tracking
            async function uploadFile() {
                if (!selectedFile) return;

                // Show upload progress
                $('#uploadProgress').removeClass('hidden');
                $('#submitButton').prop('disabled', true);

                // Create form data
                const formData = new FormData();
                formData.append('file', selectedFile);
                formData.append('_token', $('input[name="_token"]').val());

                // Create abort controller for cancellation
                uploadController = new AbortController();
                const signal = uploadController.signal;

                try {
                    // Use Axios to upload the file
                    const response = await axios.post('{{ route("user.post.upload.media") }}', formData, {
                        signal,
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        onUploadProgress: (progressEvent) => {
                            const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                            $('#progressBarFill').css('width', `${percentCompleted}%`);
                            $('#progressText').text(`${percentCompleted}%`);
                        }
                    });

                    // Store the temp_id for later use when submitting the form
                    if (response.data.success) {
                        const tempId = response.data.data.temp_id;
                        $('#fileInput').data('temp-id', tempId);

                        // Enable submit button after successful upload
                        $('#submitButton').prop('disabled', false);

                        // Hide progress bar but keep the file preview
                        $('#uploadProgress').addClass('hidden');

                        // Show success notification
                        showNotification('File uploaded successfully!', 'success');
                    } else {
                        throw new Error(response.data.message || 'Upload failed');
                    }
                } catch (error) {
                    if (error.name === 'AbortError') {
                        console.log('Upload cancelled');
                    } else {
                        console.error('Upload error:', error);
                        let errorMessage = 'Error uploading file. Please try again.';

                        // Extract error message from response if available
                        if (error.response && error.response.data) {
                            errorMessage = error.response.data.message || errorMessage;

                            // Handle validation errors
                            if (error.response.data.errors && error.response.data.errors.file) {
                                errorMessage = error.response.data.errors.file[0];
                            }
                        }

                        showNotification(errorMessage, 'error');
                    }

                    // Reset everything on error
                    $('#removeFileBtn').click();
                } finally {
                    uploadController = null;
                }
            }

            // Simulate file upload with progress updates
            async function simulateFileUpload() {
                const totalSteps = 10;
                for (let i = 1; i <= totalSteps; i++) {
                    await new Promise(resolve => setTimeout(resolve, 300));
                    const progress = Math.floor((i / totalSteps) * 100);
                    $('#progressBarFill').css('width', `${progress}%`);
                    $('#progressText').text(`${progress}%`);
                }
            }

            // Show notification
            function showNotification(message, type = 'success') {
                const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
                $('<div>')
                    .addClass(`fixed top-4 right-4 ${bgColor} text-white px-4 py-2 rounded shadow-lg z-50`)
                    .text(message)
                    .appendTo('body')
                    .delay(3000)
                    .fadeOut(function () { $(this).remove(); });
            }

            // Form submission
            $('#createPostForm').on('submit', async function (e) {
                e.preventDefault();

                const tempId = $('#fileInput').data('temp-id');
                if (!tempId) {
                    showNotification('Please upload an image or video first', 'error');
                    return;
                }

                // Start submission
                $('#submitButton').prop('disabled', true);
                $('#submitButtonText').html(`
                  <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Creating Post...
                `);

                try {
                    // Gather form data
                    const formData = new FormData();
                    formData.append('title', $('#title').val());
                    formData.append('description', $('#description').val());
                    formData.append('temp_id', tempId);
                    formData.append('category_id', preferences.category);
                    formData.append('religion_id', preferences.religion);
                    formData.append('mood_id', preferences.mood);
                    formData.append('gender_id', preferences.gender);
                    formData.append('is_adult_content', preferences.adultContent);
                    formData.append('_token', $('input[name="_token"]').val());

                    // Send the post data to the server
                    const response = await axios.post('{{ route("user.post.store") }}', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    if (response.data.success) {
                        // Reset form after successful submission
                        $('#createPostForm')[0].reset();
                        $('#removeFileBtn').click();

                        // Reset preferences
                        $('.option-button.selected').each(function () {
                            if ($(this).data('value') !== 'all') {
                                $(this).removeClass('selected');
                                $(this).closest('div').find('[data-value="all"]').addClass('selected');
                            }
                        });

                        preferences.religion = 'all';
                        preferences.mood = 'all';
                        preferences.gender = 'all';
                        preferences.category = 'all';
                        preferences.adultContent = false;

                        // Reset adult content toggle
                        $('#notAdultContentBtn').addClass('selected');
                        $('#adultContentBtn').removeClass('selected');
                        $('#adultContentValue').val('false');

                        // Show success message
                        showNotification(response.data.message || 'Post created successfully!', 'success');
                    } else {
                        throw new Error(response.data.message || 'Failed to create post');
                    }
                } catch (error) {
                    console.error('Error creating post:', error);
                    let errorMessage = 'Error creating post. Please try again.';

                    // Extract error message from response if available
                    if (error.response && error.response.data) {
                        errorMessage = error.response.data.message || errorMessage;

                        // Handle validation errors
                        if (error.response.data.errors) {
                            const firstError = Object.values(error.response.data.errors)[0];
                            if (Array.isArray(firstError) && firstError.length > 0) {
                                errorMessage = firstError[0];
                            }
                        }
                    }

                    showNotification(errorMessage, 'error');
                } finally {
                    // Reset button state
                    $('#submitButton').prop('disabled', false);
                    $('#submitButtonText').html(`
                        <span class="check-icon mr-2"></span>
                        Create Post
                    `);
                    $('.check-icon').html(lucide.icons.check.toSvg());
                }
            });
        });
    </script>

@endpush
