@extends('admin.layout.master')

@section('title', __('Mood Create'))

@push('styles')
    <style>
        #emoji-picker {
            position: absolute;
            display: none;
            z-index: 1000;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ __('Mood Create') }}</h1>

            <a href="{{ route('admin.mood.list') }}" class="btn btn-primary">{{ __('Back') }}</a>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('admin.mood.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                    @include('alerts.feedback', ['field' => 'name'])
                </div>

                <div class="mb-3">
                    <label for="emoji" class="form-label">{{ __('Emoji') }}</label>
                    <div class="d-flex align-items-center gap-2">
                        <textarea id="emoji-input" name="emoji" rows="1" cols="1" class="form-control w-50"></textarea>
                        <button type="button" id="emoji-trigger" class="btn btn-primary w-25">😀 Add Emoji</button>
                    </div>

                    <emoji-picker id="emoji-picker" class="mt-2"></emoji-picker>
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">{{ __('Order') }}</label>
                    <input type="number" class="form-control" id="order" name="order" value="{{ old('order', 0) }}">
                    @include('alerts.feedback', ['field' => 'order'])
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                    <div class="input-group align-items-center">
                        <input type="radio" class="btn-check" name="status" value="1" id="status-yes" autocomplete="off"
                            {{ old('status') == App\Models\Mood::STATUS_ACTIVE ? 'checked' : '' }}>
                        <label class="btn btn-outline-success w-50 m-0" for="status-yes">{{ __('Active') }}</label>

                        <input type="radio" class="btn-check" name="status" value="0" id="status-no" autocomplete="off"
                            {{ old('status') == App\Models\Mood::STATUS_INACTIVE ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger w-50 m-0" for="status-no">{{ __('Inactive') }}</label>
                    </div>
                    @include('alerts.feedback', ['field' => 'status'])
                </div>


                <div class="mb-3 mt-3">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Create') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <script>
        $(document).ready(function() {
            const $picker = $('#emoji-picker');
            const $trigger = $('#emoji-trigger');
            const $input = $('#emoji-input');

            // Toggle picker visibility
            $trigger.on('click', function() {
                $picker.toggle();
            });

            // Handle emoji selection
            $picker.on('emoji-click', function(event) {
                const emoji = event.originalEvent.detail.unicode;
                $input.val(function(i, val) {
                    return emoji;
                });
                $picker.hide();
            });

            // Optional: Close picker when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#emoji-picker, #emoji-trigger').length) {
                    $picker.hide();
                }
            });
        });
    </script>
@endpush
