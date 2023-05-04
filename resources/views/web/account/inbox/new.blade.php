 
@extends('layouts.default', [
    'title' => $title
])

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ $title }}</div>
                <div class="card-body">
                    <form action="{{ route('account.inbox.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="type" value="{{ $type }}">
                        @if ($type == 'message')
                            <label for="title">Title</label>
                            <input class="form-control mb-2" type="text" name="title" placeholder="Title" required>
                        @endif
                        <label for="body">Body</label>
                        <textarea class="form-control mb-3" name="body" placeholder="Write your message here..." rows="5" required></textarea>
                        <button class="btn btn-block btn-success" type="submit">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
