 
@extends('layouts.error', [
    'title' => 'Error 403'
])

@section('content')
    <h2 style="font-weight:600;">Error 403</h2>
    <p>You are not allowed to access this resource.</p>
    <a href="/" class="btn btn-large btn-success"><i class="fas fa-home"></i> Return Home</a>
@endsection
