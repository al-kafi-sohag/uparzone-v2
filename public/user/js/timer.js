$(document).ready(function () {
    setInterval(function () {
        balanceLoading();
        axios.post(AppUrl.heartbeat)
            .then(function (response) {
                $('#balance').html(parseFloat(response.data.data.balance).toFixed(2));
            })
            .catch(function (error) {
                console.log(error);
            });
    }, 25000);

    setInterval(function () {
        active_time++;
        window.active_time = active_time;
        $('#timer').html(formatTime(active_time));
    }, 1000);
});

function formatTime(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = seconds % 60;

    // Format time as HH:MM:SS
    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
}

function balanceLoading() {
    $('#balance').html(`
        <div class="spinner-grow text-gray h-4 w-4" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    `);
}
