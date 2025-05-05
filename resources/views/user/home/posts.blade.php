<div class="space-y-4">
    @forelse($posts as $post)
        <article class="overflow-hidden bg-white rounded-lg border border-gray-200">
            <!-- Post Header -->
            <div class="flex items-center p-3">
                <div class="overflow-hidden relative w-8 h-8 bg-gray-200 rounded-full">
                    <img src="" alt="{{ $post->user->name }}"
                        class="object-cover absolute inset-0 w-full h-full">
                </div>
                <div class="ml-2">
                    <a href="" class="text-decoration-none">
                        <h3 class="text-xs font-medium">{{ $post->user->name }}</h3>
                    </a>
                    <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Post Content -->
            <div class="px-3 pb-2" id="post-content-{{ $post->id }}">
                <h2 class="mb-1 text-base font-semibold">{{ $post->title }}</h2>
                <p class="mb-2 text-sm text-gray-700">{{ $post->content }}</p>
            </div>

            <!-- Post Image -->
            <div class="relative w-full h-56 bg-gray-100">
                @if($media = $post->getFirstMedia('post_media'))
                    @if($media->mime_type === 'image/jpeg' || $media->mime_type === 'image/png')
                        <img src="{{ $media->getFullUrl('thumb') }}"
                             data-src="{{ $media->getFullUrl() }}"
                             alt="Post image"
                             class="lazyload object-cover absolute inset-0 w-full h-full">

                    @elseif($media->mime_type === 'video/mp4')
                        <video controls
                               class="object-cover absolute inset-0 w-full h-full">
                            <source src="{{ $media->getFullUrl() }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Post Actions -->
            <div class="px-3 py-3 border-t border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-4">
                        <button class="flex items-center text-gray-600 hover:text-gray-900 love-button"
                            data-post-id="" data-loved="false"
                            >
                            <i data-lucide="heart" class="mr-1 w-4 h-4 transition-colors duration-200
                            text-gray-600 fill-transparent
                            group-hover:text-red-500"></i>
                            <span class="text-xs love-count">0</span>
                        </button>
                        <button class="flex items-center text-gray-600 hover:text-gray-900">
                            <i data-lucide="message-circle" class="mr-1 w-4 h-4"></i>
                            <span class="text-xs">8</span>
                        </button>
                    </div>
                    <button class="text-gray-600 hover:text-gray-900">
                        <i data-lucide="share-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </article>
    @empty
        <p>No posts found.</p>
    @endforelse

</div>
