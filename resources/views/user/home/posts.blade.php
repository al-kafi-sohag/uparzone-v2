<div class="space-y-4">
    @forelse($posts as $post)
        <article class="overflow-hidden bg-white rounded-lg border border-gray-200">
            <!-- Post Header -->
            <div class="flex items-center p-3">
                <div class="overflow-hidden relative w-8 h-8 bg-gray-200 rounded-full">
                    <img src="{{ $post->user->profile_img == 'noimage' ? asset('profile/default_profile.png') : asset('public/profile/' . $post->user->profile_img) }}" alt="{{ $post->user->name }}"
                        class="object-cover absolute inset-0 w-full h-full">
                </div>
                <div class="ml-2">
                    <a href="{{ route('user.profile', $post->user->id) }}" class="text-decoration-none">
                        <h3 class="text-xs font-medium">{{ $post->user->name }}</h3>
                    </a>
                    <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Post Content -->
            <div class="px-3 pb-2" id="post-content-{{ $post->id }}">
                <h2 class="mb-1 text-base font-semibold">{{ $post->title }}</h2>
                <p class="mb-3 text-sm text-gray-700">{{ $post->content }}</p>
            </div>

            <!-- Post Image -->


            <div class="relative w-full h-44 bg-gray-100">
                @if ($post->media && (strpos($post->media, '.mp4') !== false || strpos($post->media, '.mov') !== false || strpos($post->media, '.avi') !== false))
                <div class="video-container">
                    <video id="my-video-{{ $post->id }}" controls style="width: 100%; height: auto;">
                        <source data-fluid-hd src="{{ asset('public/posts/720p_' . basename($post->media)) }}" title="720p" type="video/mp4" />
                        <source data-fluid-hd src="{{ asset('public/posts/480p_' . basename($post->media)) }}" title="480p" type="video/mp4" />
                        <source src="{{ asset('public/posts/240p_' . basename($post->media)) }}" title="240p" type="video/mp4" />
                    </video>
                </div>
                @elseif ($post->media)
                    <img src="{{ asset('public/' .$post->media) }}" class="object-cover w-full h-full" alt="Image">
                @else
                    <img src="{{ asset('img/feed/ca.gif') }}" class="object-cover w-full h-full" alt="No media">
                @endif
            </div>

            <!-- Post Actions -->
            <div class="p-5 border-t border-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-4">
                        <button class="flex items-center text-gray-600 hover:text-gray-900 love-button"
                            data-post-id="{{ $post->id }}" data-loved="{{ $post->has_loved ? 'true' : 'false' }}"
                            >
                            <i data-lucide="heart" class="mr-1 w-4 h-4 transition-colors duration-200
                            {{ $post->has_loved ? 'text-red-500 fill-current' : 'text-gray-600 fill-transparent' }}
                            group-hover:text-red-500"></i>
                            <span class="text-xs love-count">{{ $post->loves_count }}</span>
                        </button>
                        {{-- <button class="flex items-center text-gray-600 hover:text-gray-900"> --}}
                            {{-- <i data-lucide="message-circle" class="mr-1 w-4 h-4"></i>
                            <span class="text-xs">8</span>
                        </button> --}}
                    </div>
                    {{-- <button class="text-gray-600 hover:text-gray-900">
                        <i data-lucide="share-2" class="w-4 h-4"></i>
                    </button> --}}
                </div>
            </div>
        </article>
    @empty
    <article class="overflow-hidden bg-white rounded-lg border border-gray-200">
        <!-- Post Header -->
        <div class="flex items-center p-3">
            <div class="overflow-hidden relative w-8 h-8 bg-gray-200 rounded-full">
                <img src="{{ asset('profile/default_profile.png') }}" alt="Post User"
                    class="object-cover absolute inset-0 w-full h-full">
            </div>
            <div class="ml-2">
                <a href="#" class="text-decoration-none">
                    <h3 class="text-xs font-medium">Post User</h3>
                </a>
                <p class="text-xs text-gray-500">Post Time</p>
            </div>
        </div>

        <!-- Post Content -->
        <div class="px-3 pb-2" id="post-content">
            <h2 class="mb-1 text-base font-semibold">Post Title</h2>
            <p class="mb-3 text-sm text-gray-700">Post Content</p>
        </div>

        <!-- Post Image -->


        <div class="relative w-full h-44 bg-gray-100">
          <div class="video-container">
                <video id="my-video" controls style="width: 100%; height: auto;">
                    <source data-fluid-hd src="{{ asset('public/posts/720p_' . basename('')) }}" title="720p" type="video/mp4" />
                    <source data-fluid-hd src="{{ asset('public/posts/480p_' . basename('')) }}" title="480p" type="video/mp4" />
                    <source src="{{ asset('public/posts/240p_' . basename('')) }}" title="240p" type="video/mp4" />
                </video>
            </div>
        </div>

        <!-- Post Actions -->
        <div class="p-5 border-t border-gray-100">
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
    @endforelse

</div>
