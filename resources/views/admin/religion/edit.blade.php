@extends('admin.layout.master')

@section('title', __('Religion Edit'))

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ __('Religion Edit') }}</h1>

            <a href="{{ route('admin.religion.list') }}" class="btn btn-primary">{{ __('Back') }}</a>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('admin.religion.update', $religion->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $religion->name) }}">
                    @include('alerts.feedback', ['field' => 'name'])
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                    <div class="input-group align-items-center">
                        <input type="radio" class="btn-check" name="status" value="1" id="status-yes" autocomplete="off"
                            {{ old('status', $religion->status) == App\Models\Religion::STATUS_ACTIVE ? 'checked' : '' }}>
                        <label class="btn btn-outline-success w-50 m-0" for="status-yes">{{ __('Active') }}</label>

                        <input type="radio" class="btn-check" name="status" value="0" id="status-no" autocomplete="off"
                            {{ old('status', $religion->status) == App\Models\Religion::STATUS_INACTIVE ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger w-50 m-0" for="status-no">{{ __('Inactive') }}</label>
                    </div>
                    @include('alerts.feedback', ['field' => 'status'])
                </div>

                <div class="mb-3 mt-3">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
