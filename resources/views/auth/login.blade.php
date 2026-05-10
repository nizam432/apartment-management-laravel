@extends('layouts.auth')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <b><i class="fas fa-building mr-2"></i>AMS</b>
        <p class="text-muted" style="font-size: 14px;">Apartment Management System</p>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to your account</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                {{-- Mobile / Email / Username --}}
                <div class="input-group mb-3">
                    <input
                        type="text"
                        name="login"
                        class="form-control @error('login') is-invalid @enderror"
                        placeholder="Mobile, Email or Username"
                        value="{{ old('login') }}"
                        required
                        autofocus
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                {{-- Password --}}
                <div class="input-group mb-3">
                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password"
                        required
                    >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="row mb-3">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember Me</label>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection