
function toastify(message, type) {
    if (typeof Toastify !== 'undefined') {
        Toastify({
            text: message,
            duration: 2000,
            close: false,
            gravity: 'bottom',
            position: 'right',
            style: {
                background: type === 'success' ? '#14b8a6' : '#f44336'
            }
        }).showToast();
    }
}
