 
@extends('layouts.default', [
    'title' => 'Login'
])

@section('css')
    <style>
        img.login-headshot {
            background: var(--headshot_bg);
            border-radius: 50%;
            width: 96px;
            height: 96px;
            margin-bottom: -70px;
            z-index: 100;
            position: relative;
        }

        .bounce-in {
            animation: bounce-in .5s ease 1;
            animation-fill-mode: forwards;
        }

        @keyframes bounce-in {
            0% {
                opacity: 0;
                transform: scale(.3);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }

            70% {
                transform: scale(.9);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('js/login.js') }}"></script>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center">
                <img class="login-headshot" id="headshot" src="{{config('site.route_domains.storage_site')}}/{{ config('site.renderer.default_filename') }}_headshot.png">
            </div>
            <h3>Login</h3>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('auth.login.authenticate') }}" method="POST">
                        @csrf
                        <label for="username">Username</label>
                        <input class="form-control mb-2" type="text" name="username" placeholder="Username" required>
                        <label for="password">Password</label>
                        <input class="form-control mb-2" type="password" name="password" placeholder="Password" required>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <button class="btn btn-block btn-success">Login</button>
                        @if (site_setting('registration_enabled'))
                            <hr>
                            <div class="text-center">Don't have an account? <a href="{{ route('auth.register.index') }}">Register</a></div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
