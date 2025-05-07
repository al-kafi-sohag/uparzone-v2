$(document).ready(function () {
    const $container = $("#comments-container");
    let currentPostId = null;
    const allCommentsData = {};

    function showLoading() {
        $container.html(`
            <div class="flex justify-center items-center py-10">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-teal-500"></div>
            </div>
        `);
        $("#no-comments-message").addClass("hidden");
    }

    function handleError(error) {
        console.error('Error:', error);
        $("#comments-popup").addClass("hidden");
        toastify(error.response?.data?.message || 'An error occurred while loading comments', 'error');
    }

    function updateCommentCount(count) {
        $("#comments-popup .popup-comment-count").text(count);
        if (currentPostId) {
            $(`.comment-button[data-post-id="${currentPostId}"] .popup-comment-count`).text(count);
        }
    }

    function renderComments() {
        $container.empty();
        const commentsData = allCommentsData[currentPostId] || [];
        if (commentsData.length === 0) {
            $("#no-comments-message").removeClass("hidden");
        } else {
            $("#no-comments-message").addClass("hidden");
            commentsData.forEach((comment) => {
                const $commentEl = renderComment(comment);
                $container.prepend($commentEl);
            });
        }

        updateCommentCount(commentsData.length);
    }

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
                    <div class="reply-container-${comment.id} ml-6 mt-3 space-y-3">
                        <!-- Replies will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    `);
        return $comment;
    }

    function closeComments() {
        $("#comments-popup").addClass("hidden");
        $(".reply-form").remove();
    }

    // <button class="reply-button text-xs text-gray-500 mt-1 hover:text-gray-700" data-comment-id="${comment.id}">
    //                     Reply
                    // </button>

    $(document).on("click", ".comment-button", function () {
        currentPostId = $(this).data("post-id");
        $("#comments-popup").removeClass("hidden");
        showLoading();
        axios.post(window.AppUrl.comments, {
            post_id: currentPostId
        })
        .then(function (response) {
            if (response.data.success) {
                allCommentsData[currentPostId] = response.data.comments;
                updateCommentCount(response.data.count);
                renderComments();
            } else {
                handleError({ response: { data: { message: 'Failed to load comments' } } });
            }
        })
        .catch(function (error) {
            handleError(error);
        });
    });

    $(document).on("click", ".close-comments-button", function () {
        closeComments();
    });

    $(document).on("submit", "#comment-form", function (e) {
        e.preventDefault();
        const commentText = $("#comment-text").val().trim();
        if (!commentText || !currentPostId) return;

        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const originalBtnHtml = $submitBtn.html();

        $submitBtn.html('<div class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></div>');
        $form.find('textarea').prop('disabled', true);

        axios.post(window.AppUrl.comment, {
            post_id: currentPostId,
            content: commentText,
            parent_id: null
        })
        .then(function (response) {
            if (response.data.success) {
                if (!allCommentsData[currentPostId]) {
                    allCommentsData[currentPostId] = [];
                }

                allCommentsData[currentPostId].unshift(response.data.comment);
                $("#comment-text").val("");
                renderComments();
                toastify('Comment posted successfully', 'success');
            } else {
                toastify('Failed to post comment', 'error');
            }
        })
        .catch(function (error) {
            console.error('Error posting comment:', error);
            toastify(error.response?.data?.message || 'An error occurred while posting your comment', 'error');
        })
        .finally(function () {
            $submitBtn.html(originalBtnHtml);
            $form.find('textarea').prop('disabled', false);
            $form.find('textarea').focus();
        });
    });

    $(document).on("click", ".reply-button", function () {
        const commentId = $(this).data("comment-id");
        $(".reply-form").remove();
        const $replyForm = $("#reply-form-template").contents().clone();
        $replyForm.attr("data-comment-id", commentId);
        $(this).after($replyForm);
        $replyForm.find("textarea").focus();
    });

    $(document).on("submit", ".reply-form", function (e) {
        e.preventDefault();
        const commentId = parseInt($(this).data("comment-id"));
        const replyText = $(this).find(".reply-text").val().trim();
        if (!replyText || !currentPostId) return;
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const originalBtnHtml = $submitBtn.html();
        $submitBtn.html('<div class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></div>');
        $form.find('textarea').prop('disabled', true);
        axios.post(window.AppUrl.comment, {
            post_id: currentPostId,
            content: replyText,
            parent_id: commentId
        })
        .then(function (response) {
            if (response.data.success) {
                const commentsData = allCommentsData[currentPostId] || [];
                commentsData.forEach((comment) => {
                    if (comment.id === commentId) {
                        if (!comment.replies) {
                            comment.replies = [];
                        }

                        comment.replies.push(response.data.comment);
                    }
                });

                $form.remove();
                renderComments();
            } else {
                toastify('Failed to post reply', 'error');
            }
        })
        .catch(function (error) {
            console.error('Error posting reply:', error);
            toastify(error.response?.data?.message || 'An error occurred while posting your reply', 'error');
        })
        .finally(function () {
            if ($form.length) {
                $submitBtn.html(originalBtnHtml);
                $form.find('textarea').prop('disabled', false);
                $form.find('textarea').focus();
            }
        });
    });
});
