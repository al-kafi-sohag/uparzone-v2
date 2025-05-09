
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    lucide.createIcons();
</script>

<script>
    window.active_time = {{ $active_time }};
    window.heartbeatInterval = {{ config('app.heartbeat_interval', 60) }};
    window.balance = {{ $balance }};
    window.minFlaggingAmount = {{ config('app.min_flagging_amount', 200) }};
    window.AppUrl = {
        heartbeat: '{{ route('user.heartbeat') }}',
        home: '{{ route('user.home') }}',
        reaction: '{{ route('user.post.reaction') }}',
        comment: '{{ route('user.post.comment') }}',
        comments: '{{ route('user.post.comments') }}',
    }
    window.ImageUrl = {
        logo: '{{ secure_asset('frontend/img/logo.svg') }}'
    }
</script>


<script src="{{ secure_asset('user/js/custom.js') }}"></script>
<script src="{{ secure_asset('user/js/theme.js') }}"></script>
<script src="{{ secure_asset('user/js/timer.js') }}"></script>
