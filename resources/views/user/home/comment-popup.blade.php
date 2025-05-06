 <!-- Comments Popup -->
 <div id="comments-popup" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end justify-center sm:items-center hidden">
    <div class="bg-white w-full max-w-lg rounded-t-xl sm:rounded-xl max-h-[80vh] overflow-hidden flex flex-col animate-slide-up">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white z-10">
            <h3 class="font-medium">Comments (<span class="popup-comment-count">{{ $post->comments ?? 0 }}</span>)</h3>
            <button class="close-comments-button text-gray-500 hover:text-gray-700">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>

        <div class="overflow-y-auto flex-1 p-4">
            <div id="comments-container" class="space-y-4">
                <!-- Comments will be inserted here by jQuery -->
            </div>
            <div id="no-comments-message" class="text-center text-gray-500 py-6 hidden">
                {{ __('No comments yet. Be the first to comment!') }}
            </div>
        </div>

        <!-- Comment Form -->
        <form id="comment-form" class="p-4 border-t border-gray-100 sticky bottom-0 bg-white">
            <div class="flex items-center gap-2">
                <div class="flex-1 relative">
                    <textarea id="comment-text" placeholder="Write a comment..." class="min-h-[50px] px-3 py-3 pr-10 resize-none w-full rounded-md border border-gray-300 focus:border-transparent"></textarea>
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-teal-600 hover:text-teal-600">
                        <i data-lucide="send" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Reply Form Template (hidden, will be cloned by jQuery) -->
<template id="reply-form-template">
    <form class="reply-form mt-2 flex items-center gap-2">
        <div class="flex-1 relative">
            <textarea class="reply-text min-h-[40px] px-2 py-2 resize-none text-sm w-full rounded-md border border-gray-300 focus:border-transparent"></textarea>
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 h-6 w-6 text-teal-600 hover:text-teal-600">
                <i data-lucide="send" class="h-4 w-4"></i>
            </button>
        </div>
    </form>
</template>
