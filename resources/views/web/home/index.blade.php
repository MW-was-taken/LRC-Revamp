 
@extends('layouts.default', [
    'title' => 'Welcome'
])

@section('css')
    <style>
        html, body {
            height: 100%;
        }

        .alert, .navbar-nav.mr-auto, .sidebar, footer {
            display: none;
        }

        .navbar-toggler {
            opacity: 0!important;
            cursor: default;
        }

        .alert {
            margin-bottom: 0!important;
        }

        .landing-header {
            margin-top: -100px;
            padding: 50px 0 50px 0;
            align-items: stretch;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 95vh;
        }

        @media only screen and (max-width: 768px) {
            .landing-header {
                margin-top: -85px;
            }
        }

        .landing-header .header-content {
            align-items: center;
            display: flex;
            flex-grow: 1;
            flex-shrink: 0;
        }

        @media only screen and (min-width: 768px) {
            .landing-header h1 {
                font-size: 50px;
            }

            .landing-header p {
                font-size: 23px;
            }

            .landing-header .btn {
                font-size: 18px;
            }

            .landing-header .btn:first-child {
                margin-right: 25px;
            }
        }
    </style>
@endsection

@section('content')
    </div>
    <header class="landing-header">
        <div class="header-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 align-self-center text-center-sm">
                        <h1>The place to create.</h1>
                        <p>{{ config('site.name') }} is an online 3D gaming platform where users can enable their creativity. Customize your character, create your own clothing, participate in a virtual economy, create groups, chat with others, and much more.</p>
                        <div class="buttons">
                            <a href="{{ route('auth.register.index') }}" class="btn btn-success"><i class="fas fa-user-plus mr-1"></i> Create Account</a>
                            <div class="mb-2 show-sm-only"></div>
                            <a href="{{ route('auth.login.index') }}" class="btn btn-warning"><i class="fas fa-key mr-1"></i> Existing User</a>
                        </div>
                        <div class="mt-5"><strong>Copyright &copy; {{ config('site.name') }} {{ date('Y') }}</strong></div>
                        <div class="text-muted" style="font-size:13px;"><strong>Powered by <a href="https://github.com/FoxxoSnoot/laravel-roblox-clone" target="_blank">Laravel Roblox Clone</a></strong></div>
                    </div>
                    <div class="col-md-4 hide-sm">
                        <img src="{{ config('site.icon') }}">
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection
