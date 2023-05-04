 
@extends('layouts.default', [
    'title' => $title
])

@section('content')
    <div class="row">
        <div class="col">
            <h3>{{ $title }}</h3>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @include("web.info._{$view}", $variables)
        </div>
    </div>
@endsection
