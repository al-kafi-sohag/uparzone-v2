@extends('admin.layout.master')

@section('title', 'User Profile')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">User Profile: {{ $user->name }}</h1>
            <div>
                <a href="{{ route('admin.user.list') }}" class="btn btn-secondary">Back to List</a>
                <a href="{{ route('admin.user.loginas', $user->id) }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login As User
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ profile_img($user->profile_image) }}"
                            alt="{{ $user->name }}" class="rounded-circle img-fluid" style="width: 120px; height: 120px; object-fit: cover;">
                        <h5 class="mt-3">{{ $user->name }}</h5>
                        <p class="text-muted">{{ $user->email }}</p>
                        <div class="mt-2">
                            <span class="badge {{ $user->statusBadge }}">{{ $user->statusText }}</span>
                            <span class="badge {{ $user->isPremiumBadge }}">{{ $user->isPremiumText }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}
                    </div>
                    <div class="mb-3">
                        <strong>Balance:</strong> {{ $user->balance ?? '0.00' }}
                    </div>
                    <div class="mb-3">
                        <strong>Joined:</strong> {{ $user->created_at->format('d M Y') }}
                    </div>
                    <div class="mb-3">
                        <strong>Last Active:</strong> {{ $user->last_active_at ? date('d M Y', strtotime($user->last_active_at)) : 'Never' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Age:</strong> {{ $user->age ?? 'Not provided' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Gender:</strong> {{ $user->gender ?? 'Not provided' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Profession:</strong> {{ $user->profession ?? 'Not provided' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Mood:</strong> {{ $user->mood->name ?? 'Not set' }} {{ $user->mood->emoji ?? '' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Religion:</strong> {{ $user->religion->name ?? 'Not set' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Address:</strong> {{ $user->address ?? 'Not provided' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>City:</strong> {{ $user->city ?? 'Not provided' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>State:</strong> {{ $user->state ?? 'Not provided' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Country:</strong> {{ $user->country ?? 'Not provided' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Zip Code:</strong> {{ $user->zip_code ?? 'Not provided' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Referral Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Reference Code:</strong> {{ $user->reference_code ?? 'None' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Total Referrals:</strong> {{ $user->total_referral ?? '0' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Referred By:</strong>
                            @if($user->referer)
                                <a href="{{ route('admin.user.profile', $user->referer->id) }}">{{ $user->referer->name }}</a>
                            @else
                                None
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
