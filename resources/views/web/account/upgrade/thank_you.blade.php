 
@extends('layouts.default', [
    'title' => 'Thank You'
])

@section('content')
    <h3>Thank You</h3>
    <div class="card">
        <div class="card-body">
            <p>Your purchased currency should be granted to your account shortly.</p>
            <p>If you don't receive your purchased product within 24 hours <a href="{{ route('info.index', 'team') }}">please contact an administrator</a>.</p>
            <p>Thank you for supporting Avasquare!</p>
        </div>
    </div>
@endsection
