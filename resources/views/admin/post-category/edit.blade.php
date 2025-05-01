@extends('admin.layout.master')

@section('title', __('Post Category Edit'))

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ __('Post Category Edit') }}</h1>

            <a href="{{ route('admin.post-category.list') }}" class="btn btn-primary">{{ __('Back') }}</a>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('admin.post-category.update', $post_category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $post_category->name) }}">
                    @include('alerts.feedback', ['field' => 'name'])
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">{{ __('Order') }}</label>
                    <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $post_category->order) }}">
                    @include('alerts.feedback', ['field' => 'order'])
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                    <div class="input-group align-items-center">
                        <input type="radio" class="btn-check" name="status" value="1" id="status-yes" autocomplete="off"
                            {{ old('status', $post_category->status) == App\Models\PostCategory::STATUS_ACTIVE ? 'checked' : '' }}>
                        <label class="btn btn-outline-success w-50 m-0" for="status-yes">{{ __('Active') }}</label>

                        <input type="radio" class="btn-check" name="status" value="0" id="status-no" autocomplete="off"
                            {{ old('status', $post_category->status) == App\Models\PostCategory::STATUS_INACTIVE ? 'checked' : '' }}>
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
