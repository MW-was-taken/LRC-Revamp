 
@extends('layouts.error', [
    'title' => 'Maintenance'
])

@section('content')
    <h2 style="font-weight:600;">Maintenance</h2>
    <div class="mb-3">We will be back up soon!</div>
    @if (count($errors) > 0)
        <div class="alert bg-danger text-white">
            @foreach ($errors->all() as $error)
                <div>{!! $error !!}</div>
            @endforeach
        </div>
    @endif
    <form action="{{ route('maintenance.authenticate') }}" method="POST">
        @csrf
        <div class="input-group">
            <input class="form-control" type="password" name="password" placeholder="Developer Password">
            <div class="input-group-append">
                <button class="btn btn-success" type="submit">Login</button>
            </div>
        </div>
    </form>
    @if (config('site.socials.discord') || config('site.socials.twitter'))
            <div class="mt-2">
                @if (config('site.socials.discord'))
                    <a href="{{ config('site.socials.discord') }}" style="color:#7289da;font-size:40px;text-decoration:none;" title="Join our Discord server!" target="_blank" data-toggle="tooltip">
                        <i class="fab fa-discord"></i>
                    </a>
                @endif

                @if (config('site.socials.twitter'))
                    <a href="{{ config('site.socials.twitter') }}" style="color:#00acee;font-size:43px;text-decoration:none;" title="Follow us on Twitter!" target="_blank" data-toggle="tooltip">
                        <i class="fab fa-twitter-square"></i>
                    </a>
                @endif
            </div>
        @endif
@endsection
