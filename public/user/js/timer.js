const $progressBar = $('#time-tracking-bar');
const heartbeatInterval = window.heartbeatInterval || 60; //in seconds

$(document).ready(function () {
    startProgress();

    setInterval(function () {
        balanceLoading();
        axios.post(AppUrl.heartbeat)
            .then(function (response) {
                $('#balance').html(parseFloat(response.data.data.balance).toFixed(4));
            })
            .catch(function (error) {
                console.log(error);
            });
        startProgress();
    }, heartbeatInterval * 1000);

    setInterval(function () {
        active_time++;
        $('#timer').html(formatTime(active_time));
    }, 1000);
});

function formatTime(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = Math.floor(seconds % 60);

    // Format time as HH:MM:SS
    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
}

function balanceLoading() {
    $('#balance').html(`
        <div class="border-2 border-teal-600 border-t-transparent rounded-full animate-spin h-3 w-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    `);
}

function startProgress() {
    $progressBar.css("width", "0%");

    let progress = 0;
    const totalTime = heartbeatInterval;
    const updateInterval = 1000;
    const increment = 100 / totalTime;

    const interval = setInterval(function() {
      // Increment progress
      progress += increment;

      // If progress reaches or exceeds 100%, reset
      if (progress >= 100) {
        clearInterval(interval);
        progress = 100;
        $progressBar.css("width", "100%");
      } else {
        $progressBar.css("width", progress + "%");
      }
    }, updateInterval);
  }
