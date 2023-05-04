 
@extends('layouts.default', [
    'title' => $title
])

@section('css')
    <style>
        img.user-headshot {
            background: var(--section_bg);
            border-radius: 6px;
            width: 50px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <ul class="breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ route('forum.index') }}">Forum</a></li>
                <li class="breadcrumb-item active">New {{ ucfirst($type) }}</li>
            </ul>
            <div class="card">
                <div class="card-header bg-primary text-white">{{ $title }}</div>
                <div class="card-body">
                    <form action="{{ route('forum.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="type" value="{{ $type }}">

                        @if ($quote)
                            <div class="card has-bg">
                                <div class="card-body">
                                    <div class="row no-gutters">
                                        <div class="col-auto pr-3 hide-sm">
                                            <a href="{{ route('users.profile', $quote->creator->username) }}">
                                                <img class="user-headshot" src="{{ $quote->creator->headshot() }}">
                                            </a>
                                        </div>
                                        <div class="col">
                                            <div>{{ $quote->created_at->diffForHumans() }}, <a href="{{ route('users.profile', $quote->creator->username) }}">{{ $quote->creator->username }}</a> wrote:</div>
                                            <div class="text-italic">{!! nl2br(e($quote->body)) !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($type == 'thread')
                            <label for="title">Title</label>
                            <input class="form-control mb-2" type="text" name="title" placeholder="Title" required>
                        @endif

                        <label for="body">Body</label>
                        <textarea class="form-control mb-3" name="body" placeholder="Write your post here..." rows="5" required></textarea>
                        <button class="btn btn-block btn-success" type="submit">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
