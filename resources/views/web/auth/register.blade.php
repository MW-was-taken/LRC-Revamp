 
@extends('layouts.default', [
    'title' => $title,
    'image' => $icon
])

@section('css')
    <style>
        @media only screen and (max-width: 768px) {
            img.referrer {
                width: 50%;
            }
        }
    </style>
@endsection

@section('js')
    @if (config('app.env') == 'production' && site_setting('registration_enabled'))
        {!! NoCaptcha::renderJs() !!}
    @endif
@endsection

@section('content')
    @if (!site_setting('registration_enabled'))
        <p>Account creation is currently disabled.</p>
    @else
        <div class="row">
            <div class="col-md-4 offset-md-1 text-center hide-sm">
                <img class="referrer mb-2" src="{{ $image }}">
                <div class="font-italic mb-2">{!! $text !!}</div>
            </div>
            <div class="col-md-6">
                <h3>Register</h3>
                <div class="card">
                    <div class="card-body">
                        @if ($referred)
                            <div class="show-sm-only text-center">
                                <img class="referrer mb-2" src="{{ $image }}">
                                <div class="font-italic">{!! $text !!}</div>
                                <hr>
                            </div>
                        @endif
                        <form action="{{ route('auth.register.authenticate') }}" method="POST">
                            @csrf

                            @if ($referred)
                                <input type="hidden" name="referral_code" value="{{ $referralCode }}">
                            @endif

                            <label for="username">Username</label>
                            <input class="form-control mb-2" type="text" name="username" placeholder="Username" required>
                            <label for="email">Email Address</label>
                            <input class="form-control mb-2" type="email" name="email" placeholder="Email Address" required>
                            <label for="password">Password</label>
                            <input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
                            <label for="password_confirmation">Confirm Password</label>
                            <input class="form-control mb-{{ (config('app.env') == 'production') ? '2' : '3' }}" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                            @if (config('app.env') == 'production')
                                <div class="mt-3 mb-3">
                                    {!! NoCaptcha::display(['data-theme' => 'dark']) !!}
                                </div>
                            @endif
                            <button class="btn btn-block btn-success">Register</button>
                            <hr>
                            <div class="text-center">Already have an account? <a href="{{ route('auth.login.index') }}">Login</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
