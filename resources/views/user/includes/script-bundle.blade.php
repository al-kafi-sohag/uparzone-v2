
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.9.0/axios.min.js" integrity="sha512-FPlUpimug7gt7Hn7swE8N2pHw/+oQMq/+R/hH/2hZ43VOQ+Kjh25rQzuLyPz7aUWKlRpI7wXbY6+U3oFPGjPOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    lucide.createIcons();
</script>
<script src="{{ asset('user/js/custom.js') }}"></script>
<script src="{{ asset('user/js/theme.js') }}"></script>
<script src="{{ asset('user/js/timer.js') }}"></script>

<script>
    window.active_time = {{ $active_time }};
    window.heartbeatInterval = {{ (int)config('app.heartbeat_interval', 60) }};
    window.balance = {{ $balance }};
    window.AppUrl = {
        heartbeat: '{{ route('user.heartbeat') }}',
        home: '{{ route('user.home') }}',
        reaction: '{{ route('user.post.reaction') }}',
        comment: '{{ route('user.post.comment') }}',
        comments: '{{ route('user.post.comments') }}',
    }
    window.ImageUrl = {
        logo: '{{ asset('frontend/img/logo.svg') }}'
    }
</script>
