<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin Login') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/css/admin_login.css') }}">
</head>

<body>
    <div class="position-relative container">
        <div class="login-card mx-auto">
            <div class="login-header">
                <img src="{{ asset('frontend/img/logo.svg') }}" alt="{{ config('app.name') }}" class="login-logo">
                <h1 class="login-title">{{ __('Admin Login') }}</h1>
                <p class="login-subtitle">{{ __('Welcome back! Please login to your account') }}</p>
            </div>

            <div class="login-form">
                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="Email" required>
                        <label for="email">{{ __('Email address') }}</label>
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Password" required>
                        <label for="password">{{ __('Password') }}</label>
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>

                    <button type="submit" class="btn btn-login">{{ __('Log In') }}</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
