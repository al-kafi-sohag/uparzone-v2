$(document).ready(function() {
    $(document).on('click', '.love-button', function() {
        const button = $(this);
        const postId = button.attr('data-post-id');
        const isLoved = button.attr('data-loved') == 'true';

        console.log(isLoved);

        toggleLoveButton(button, !isLoved);
        sendReaction(postId, !isLoved, button);
    });
});

function toggleLoveButton(button, isLoved) {
    button.attr('data-loved', isLoved.toString());
    const heartIcon = button.find('.lucide-heart');
    const countElement = button.find('.love-count');
    console.log(heartIcon);

    let count = parseInt(countElement.text() || '0');

    if (isLoved) {
        count = count + 1;
        countElement.text(count);
        heartIcon.removeClass('text-gray-600 fill-transparent').addClass('text-red-500 fill-red-500');
    } else {
        count = count - 1;
        countElement.text(count);
        heartIcon.removeClass('text-red-500 fill-red-500').addClass('text-gray-600 fill-transparent');
    }

    console.log(count);
}

function sendReaction(postId, isLoved, button) {
    button.prop('disabled', true);

    $.ajax({
        url: window.AppUrl.reaction,
        type: 'POST',
        data: {
            post_id: postId,
            reaction: isLoved.toString()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function(response) {
            if (!response.success) {
                toastify(response.message, 'error');
            } else if (response.success && response.message) {
                toastify(response.message, 'success');
            }
        },
        error: function(xhr, status, error) {
            const errorMsg = xhr.responseJSON?.message || 'Error saving reaction';
            toastify(errorMsg, 'error');
        },
        complete: function() {
            button.prop('disabled', false);
        }
    });
}
