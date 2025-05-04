
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.9.0/axios.min.js" integrity="sha512-FPlUpimug7gt7Hn7swE8N2pHw/+oQMq/+R/hH/2hZ43VOQ+Kjh25rQzuLyPz7aUWKlRpI7wXbY6+U3oFPGjPOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    lucide.createIcons();
</script>
<script src="{{ asset('user/js/theme.js') }}"></script>
<script src="{{ asset('user/js/timer.js') }}"></script>

<script>
    window.active_time = {{ $active_time }};
    sessionStorage.setItem('active_time', {{ $active_time }});
    window.balance = {{ $balance }};
    window.AppUrl = {
        heartbeat: '{{ route('user.heartbeat') }}',
    }
</script>
