 
@extends('layouts.default', [
    'title' => $title
])

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size:80px;"></i>
                    <h3>{{ $title }}</h3>
                    <p>This feature is currently disabled.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
