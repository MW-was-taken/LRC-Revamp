 
@extends('layouts.default', [
    'title' => $title
])

@section('css')
    <style>
        img.user-headshot {
            background: var(--section_bg);
            border-radius: 6px;
            max-width: 140%;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <ul class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('forum.index') }}">Forum</a></li>
                <li class="breadcrumb-item active">Edit {{ ucfirst($type) }}</li>
            </ul>
            <div class="card">
                <div class="card-header bg-primary text-white">{{ $title }}</div>
                <div class="card-body">
                    <form action="{{ route('forum.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="type" value="{{ $type }}">

                        @if ($post->quote)
                            <div class="card has-bg">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-1 hide-sm">
                                            <a href="{{ route('users.profile', $post->quote->creator->username) }}">
                                                <img class="user-headshot" src="{{ $post->quote->creator->headshot() }}">
                                            </a>
                                        </div>
                                        <div class="col-md-11">
                                            <div>{{ $post->quote->created_at->diffForHumans() }}, <a href="{{ route('users.profile', $post->quote->creator->username) }}">{{ $post->quote->creator->username }}</a> wrote:</div>
                                            <div class="text-italic">{!! nl2br(e($post->quote->body)) !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($type == 'thread')
                            <label for="title">Title</label>
                            <input class="form-control mb-2" type="text" name="title" placeholder="Title" value="{{ $post->title }}" required>
                        @endif
                        <label for="body">Body</label>
                        <textarea class="form-control mb-3" name="body" placeholder="Write your post here..." rows="5" required>{{ $post->body }}</textarea>
                        <button class="btn btn-block btn-success" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
