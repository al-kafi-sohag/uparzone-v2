@extends('user.layout.master')

@section('title', __('Create Post'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('user/css/post.css') }}">
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
                            class="absolute top-2 right-2 bg-gray-800 bg-opacity-70 text-white p-1 rounded-full hover:bg-opacity-100 transition-opacity z-10"
                            style="width: 28px; height: 28px;">
                            <span class="x-icon"></span>
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

            <!-- Personalization Options -->
            <div class="space-y-6">
                <!-- Religion -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Preferred Religion
                    </label>
                    <div class="flex flex-wrap" id="religionOptions">
                        <button type="button" class="option-button selected" data-value="all">All</button>
                        <button type="button" class="option-button" data-value="muslim">Muslim</button>
                        <button type="button" class="option-button" data-value="hindu">Hindu</button>
                        <button type="button" class="option-button" data-value="christian">Christian</button>
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
                        <button type="button" class="option-button" data-value="relaxing">😌 Relaxing</button>
                        <button type="button" class="option-button" data-value="angry">😠 Angry</button>
                        <button type="button" class="option-button" data-value="happy">😄 Happy</button>
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
                        <button type="button" class="option-button" data-value="male">Male</button>
                        <button type="button" class="option-button" data-value="female">Female</button>
                    </div>
                    <input type="hidden" id="genderValue" value="all" />
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Post Category
                    </label>
                    <div class="flex flex-wrap" id="categoryOptions">
                        <button type="button" class="option-button selected" data-value="all">All</button>
                        <button type="button" class="option-button" data-value="lifestyle">Lifestyle</button>
                        <button type="button" class="option-button" data-value="blogging">Blogging</button>
                        <button type="button" class="option-button" data-value="travel">Travel</button>
                    </div>
                    <input type="hidden" id="categoryValue" value="all" />
                </div>
            </div>

            <!-- Adult Content Toggle -->
            <div class="flex items-center">
                <input id="adultContent" type="checkbox"
                    class="h-4 w-4 theme-text focus:ring-offset-2 border-gray-300 rounded" />
                <label for="adultContent" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                    This post contains adult content
                </label>
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

            // Set up icon references
            $('.upload-icon').html(lucide.icons.upload.toSvg());
            $('.x-icon').html(lucide.icons.x.toSvg());
            $('.check-icon').html(lucide.icons.check.toSvg());

            // State
            let selectedFile = null;
            let uploading = false;
            const preferences = {
                religion: 'all',
                mood: 'all',
                gender: 'all',
                category: 'all',
                adultContent: false
            };

            // Event Listeners
            $('#uploadPlaceholder').on('click', function () {
                console.log('Upload placeholder clicked');
                $('#fileInput').click();
            });

            $('#fileInput').on('change', function (e) {
                if (this.files && this.files[0]) {
                    selectedFile = this.files[0];

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
                    }

                    // Show preview container, hide placeholder
                    $('#previewContainer').removeClass('hidden');
                    $('#uploadPlaceholder').addClass('hidden');

                    // Enable submit button
                    $('#submitButton').prop('disabled', false);
                }
            });

            $('#removeFileBtn').on('click', function () {
                // Clear file input
                $('#fileInput').val('');
                selectedFile = null;

                // Hide preview, show placeholder
                $('#previewContainer').addClass('hidden');
                $('#uploadPlaceholder').removeClass('hidden');

                // Disable submit button
                $('#submitButton').prop('disabled', true);
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

            // Adult content toggle
            $('#adultContent').on('change', function () {
                preferences.adultContent = $(this).prop('checked');
            });

            // Simulate progress update
            async function simulateProgress() {
                const totalSteps = 10;
                for (let i = 1; i <= totalSteps; i++) {
                    await new Promise(resolve => setTimeout(resolve, 500));
                    const progress = Math.floor((i / totalSteps) * 100);
                    $('#progressBarFill').css('width', `${progress}%`);
                    $('#progressText').text(`${progress}%`);
                }
            }

            // Form submission
            $('#createPostForm').on('submit', async function (e) {
                e.preventDefault();

                if (!selectedFile) return;

                // Start upload
                uploading = true;
                $('#uploadProgress').removeClass('hidden');
                $('#submitButton').prop('disabled', true);
                $('#submitButtonText').html(`
              <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Uploading...
            `);


                    console.log('Post created successfully', {
                        title: $('#title').val(),
                        description: $('#description').val(),
                        fileType: selectedFile.type.startsWith('image/') ? 'image' : 'video',
                        preferences
                    });

                    // Reset form after successful upload
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

                    // Show success message
                    $.when(
                        $('<div>')
                            .addClass('fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50')
                            .text('Post created successfully!')
                            .appendTo('body')
                            .delay(3000)
                            .fadeOut(function () { $(this).remove(); })
                    );
                } catch (error) {
                    console.error('Error creating post:', error);

                    // Show error message
                    $.when(
                        $('<div>')
                            .addClass('fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded shadow-lg z-50')
                            .text('Error creating post. Please try again.')
                            .appendTo('body')
                            .delay(3000)
                            .fadeOut(function () { $(this).remove(); })
                    );
                } finally {
                    uploading = false;
                    $('#uploadProgress').addClass('hidden');
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
