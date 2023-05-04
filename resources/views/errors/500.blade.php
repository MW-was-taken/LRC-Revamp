 
@extends('layouts.error', [
    'title' => 'Error 500'
])

@section('content')
    <h2 style="font-weight:600;">Error 500</h2>
    <p>Something went wrong on our end. Try again.</p>
    <a href="/" class="btn btn-large btn-success"><i class="fas fa-home"></i> Return Home</a>
@endsection
