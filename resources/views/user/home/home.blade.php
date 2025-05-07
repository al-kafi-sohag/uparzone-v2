@extends('user.layout.master')

@section('title', 'Home')

@push('styles')
<style>
    .lazyload {
        opacity: 0.9;
        transition: opacity 300ms ease-in;
    }
    .lazyloaded {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="overflow-y-auto px-4 py-4" id="home-content">
    @include('user.home.create-post')
    @include('user.home.posts', ['posts' => $posts])


<!-- Create Post Button -->
<a href="{{ $posts->nextPageUrl() }}"
    class="flex justify-center items-center px-4 py-3 mb-4 w-full font-medium text-gray-800 bg-gray-100 rounded-lg transition-colors hover:bg-gray-200 mt-2">
    <i data-lucide="plus-circle" class="mr-2 w-5 h-5"></i>
    {{ __('Load More') }}
</a>

</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
<script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>
<script src="{{ asset('user/js/reaction.js') }}"></script>
<script src="{{ asset('user/js/comment.js') }}"></script>
<script>

let throttleTimer;
let currentPage = 1;
let isLoading = false;
const loadMoreThreshold = 500;
let hasMorePosts = true;
let nextPageUrl = null;
const postsContainer = $('.space-y-4');
const $window = $(window);

function initializeFluidPlayers() {
    document.querySelectorAll('video[id^="my-video-"]:not([data-fluid-initialized])').forEach(video => {
        fluidPlayer(video.id, {
            layoutControls: {
                primaryColor: "#14b8a6",
                autoPlay: false,
                preload: 'metadata',
                allowDownload: false,
                htmlOnPauseBlock: {
                    html: '<b>Paused</b>',
                    height: 50,
                    width: 100,
                    playButtonShowing: true,
                    playPauseAnimation: true,
                    subtitlesEnabled: true,
                    preload: 'auto',
                }
            }
        });
        video.setAttribute('data-fluid-initialized', 'true');
    });

}

function createPostHtml(post) {
        let mediaHtml = '';
        if (post.media && post.media.length > 0) {
            const media = post.media[0];
            if (media.mime_type.startsWith('image/')) {
                mediaHtml = `
                    <img src="${media.thumb_url}"
                         data-src="${media.original_url}"
                         alt="Post image"
                         class="lazyload object-cover absolute inset-0 w-full h-full">
                `;
            } else if (media.mime_type.startsWith('video/')) {
                mediaHtml = `
                    <video controls class="object-cover absolute inset-0 w-full h-full">
                        <source src="${media.url}" type="${media.mime_type}">
                        Your browser does not support the video tag.
                    </video>
                `;
            }
        } else {
            mediaHtml = `
                <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            `;
        }

        return `
            <article class="overflow-hidden bg-white rounded-lg border border-gray-200">
                <!-- Post Header -->
                <div class="flex items-center p-3">
                    <div class="overflow-hidden relative w-8 h-8 bg-gray-200 rounded-full">
                        <img src="" alt="${post.user.name}"
                            class="object-cover absolute inset-0 w-full h-full">
                    </div>
                    <div class="ml-2">
                        <a href="" class="text-decoration-none">
                            <h3 class="text-xs font-medium">${post.user.name}</h3>
                        </a>
                        <p class="text-xs text-gray-500">${post.created_at_human}</p>
                    </div>
                </div>

                <!-- Post Content -->
                <div class="px-3 pb-2" id="post-content-${post.id}">
                    <h2 class="mb-1 text-base font-semibold">${post.title}</h2>
                    <p class="mb-2 text-sm text-gray-700">${post.content}</p>
                </div>

                <!-- Post Image -->
                <div class="relative w-full bg-gray-100 ${post.media && post.media.length > 0 ? (post.media[0].mime_type.startsWith('image/') ? 'h-96' : 'h-64') : 'h-64'}">
                    ${mediaHtml}
                </div>

                <!-- Post Actions -->
                <div class="px-3 py-3 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-4">
                            <button class="flex items-center text-gray-600 hover:text-gray-900 love-button"
                                data-post-id="${post.id}" data-loved="false"
                                >
                                <i data-lucide="heart" class="mr-1 w-4 h-4 transition-colors duration-200
                                text-gray-600 fill-transparent
                                group-hover:text-red-500"></i>
                                <span class="text-xs love-count">${post.loves_count || 0}</span>
                            </button>
                            <button class="flex items-center text-gray-600 hover:text-gray-900">
                                <i data-lucide="message-circle" class="mr-1 w-4 h-4"></i>
                                <span class="text-xs">${post.comments_count || 0}</span>
                            </button>
                        </div>
                        <button class="text-gray-600 hover:text-gray-900">
                            <i data-lucide="share-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </article>
        `;
    }

function loadMorePosts() {
        if (isLoading || !nextPageUrl) return;
        isLoading = true;
        console.log('Loading more posts from:', nextPageUrl);
        axios.get(nextPageUrl)
            .then(function(response) {
                if (response.data.success) {
                    const postsHtml = response.data.data.data.map(function(post) {
                        return createPostHtml(post);
                    }).join('');

                    postsContainer.append(postsHtml);

                    nextPageUrl = response.data.pagination.next_page_url;
                    currentPage++;

                    lazySizes.loader.checkElems();
                    initializeFluidPlayers();

                    lucide.createIcons();
                }
                isLoading = false;
            })
            .catch(function(error) {
                console.error('Error loading more posts:', error);
                isLoading = false;
            });
    }

$(document).ready(function() {
    initializeFluidPlayers();
    $('video').on('play', function() {
        $('video').not(this).each(function() {
            this.pause();
        });
    });
});

// Scroll event moved inside document.ready
$(window).on('scroll', function() {
    console.log('Scrolling...');
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - loadMoreThreshold) {
        loadMorePosts();
    }
});

</script>
@endpush

