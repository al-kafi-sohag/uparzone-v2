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
            @php
                $media = $post->getFirstMedia('post_media');
            @endphp
            <div class="relative w-full bg-gray-100 {{ $media ? starts_with($media->mime_type, 'image/') ? 'h-96' : 'h-64' : 'h-64' }}">
                @if($media)
                    @if(starts_with($media->mime_type, 'image/'))
                        <img src="{{ $media->getFullUrl('thumb') }}"
                             data-src="{{ $media->getFullUrl('original') }}"
                             alt="Post image"
                             class="lazyload object-cover absolute inset-0 w-full h-full">

                    @elseif(starts_with($media->mime_type, 'video/'))
                        <video controls
                               class="post-video object-cover absolute inset-0 w-full h-full" id="my-video-{{ $post->id }}">
                            <source src="{{ $media->getFullUrl() }}" type="{{ $media->mime_type }}">
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
                        <button class="flex items-center text-gray-600 hover:text-gray-900 love-button group" type="button"
                            data-post-id="{{ $post->id }}" data-loved="{{ $post->user_has_reacted ? 'true' : 'false' }}"
                            aria-label="{{ $post->user_has_reacted ? 'Unlike post' : 'Like post' }}"
                            title="{{ $post->user_has_reacted ? 'Unlike post' : 'Like post' }}"
                            >
                            <i data-lucide="heart" class="mr-1 w-4 h-4 transition-all duration-200 ease-in-out
                            {{ $post->user_has_reacted ? 'text-red-500 fill-red-500' : 'text-gray-600 fill-transparent' }}
                            group-hover:text-red-500 group-hover:scale-110"></i>
                            <span class="text-xs love-count font-medium">{{ $post->reactions ?? 0 }}</span>
                        </button>
                        <button class="flex items-center text-gray-600 hover:text-gray-900 comment-button" data-post-id="{{ $post->id }}" type="button">
                            <i data-lucide="message-circle" class="mr-1 w-4 h-4"></i>
                            <span class="text-xs popup-comment-count">{{ $post->comments ?? 0 }}</span>
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
@include('user.home.comment-popup')
