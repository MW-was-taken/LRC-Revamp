 
@extends('layouts.error', [
    'title' => 'Error 404'
])

@section('content')
    <h2 style="font-weight:600;">Error 404</h2>
    <p>The requested resource could not be found.</p>
    <a href="/" class="btn btn-large btn-success"><i class="fas fa-home"></i> Return Home</a>
@endsection
