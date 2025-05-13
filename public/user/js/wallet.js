$(document).ready(function() {
    $('#withdrawal-form').submit(function(e) {
        const $form = $(this);
        $form.html('<div class="flex justify-center items-center py-10"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-teal-500"></div></div>');
        console.log('Withdrawal form submitted');
    });
});
