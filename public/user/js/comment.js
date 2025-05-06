$(document).ready(function () {
    const $container = $("#comments-container");

    function renderComments() {
        $container.empty();

        if (commentsData.length === 0) {
            $("#no-comments-message").removeClass("hidden");
        } else {
            $("#no-comments-message").addClass("hidden");

            commentsData.forEach((comment) => {
                const $commentEl = renderComment(comment);
                $container.append($commentEl);
            });
        }

        // Update comment counts
        $(".comment-count, .popup-comment-count").text(commentsData.length);
    }

    // Render a single comment with its replies
    function renderComment(comment) {
        const $comment = $(`
        <div class="comment-item border-b border-gray-100 pb-4 last:border-0" data-comment-id="${comment.id}">
            <div class="flex items-start gap-2">
                <div class="w-8 h-8 bg-gray-200 rounded-full overflow-hidden">
                    <img src="${comment.user.avatar}" alt="${comment.user.name}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="flex justify-between items-start">
                            <h4 class="text-sm font-medium">${comment.user.name}</h4>
                            <span class="text-xs text-gray-500">${comment.createdAt}</span>
                        </div>
                        <p class="text-sm mt-1">${comment.content}</p>
                    </div>
                    <button class="reply-button text-xs text-gray-500 mt-1 hover:text-gray-700" data-comment-id="${comment.id}">
                        Reply
                    </button>

                    <div class="reply-container-${comment.id} ml-6 mt-3 space-y-3">
                        <!-- Replies will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    `);

        return $comment;
    }

    $(".comment-button").on("click", function () {
        $("#comments-popup").removeClass("hidden");
        renderComments();
    });

    $(".close-comments-button").on("click", function () {
        $("#comments-popup").addClass("hidden");
        // Remove any open reply forms
        $(".reply-form").remove();
    });

    // Handle comment form submission
    $("#comment-form").on("submit", function (e) {
        e.preventDefault();
        const commentText = $("#comment-text").val().trim();
        if (!commentText) return;

        // Create new comment
        const newComment = {
            id: Date.now(),
            user: {
                name: "Current User",
                avatar: "https://via.placeholder.com/32",
            },
            content: commentText,
            createdAt: "Just now",
            replies: [],
        };

        // Add to comments data
        commentsData.push(newComment);

        // Clear form
        $("#comment-text").val("");

        // Re-render comments
        renderComments();
    });

    // Handle reply button click (delegated event)
    $(document).on("click", ".reply-button", function () {
        const commentId = $(this).data("comment-id");

        // Remove any existing reply forms
        $(".reply-form").remove();

        // Clone the reply form template
        const $replyForm = $("#reply-form-template").contents().clone();

        // Add the comment ID as data attribute
        $replyForm.attr("data-comment-id", commentId);

        // Insert after the reply button
        $(this).after($replyForm);

        // Focus the textarea
        $replyForm.find("textarea").focus();
    });

    // Handle reply form submission (delegated event)
    $(document).on("submit", ".reply-form", function (e) {
        e.preventDefault();
        const commentId = parseInt($(this).data("comment-id"));
        const replyText = $(this).find(".reply-text").val().trim();

        if (!replyText) return;

        // Create new reply
        const newReply = {
            id: Date.now(),
            user: {
                name: "Current User",
                avatar: "https://via.placeholder.com/32",
            },
            content: replyText,
            createdAt: "Just now",
            replies: [],
        };

        // Find the comment and add the reply
        commentsData.forEach((comment) => {
            if (comment.id === commentId) {
                comment.replies.push(newReply);
            }
        });

        // Re-render comments
        renderComments();
    });

    // Initial render
    renderComments();
});
