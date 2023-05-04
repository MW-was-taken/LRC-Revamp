 
@extends('layouts.default', [
    'title' => $message->title
])

@section('css')
    <style>
        img.user-headshot {
            background: var(--headshot_bg);
            border-radius: 50%;
            width: 50%;
            margin: 0 auto;
            display: block;
        }

        @media only screen and (min-width: 768px) {
            img.user-headshot {
                width: 60%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <a href="{{ route('users.profile', $message->sender->username) }}">
                                <img class="user-headshot" src="{{ $message->sender->headshot() }}">
                                <div class="text-truncate text-center">{{ $message->sender->username }}</div>
                            </a>

                            @if ($message->sender->id != Auth::user()->id)
                                <a href="{{ route('account.inbox.new', ['reply', $message->id]) }}" class="btn btn-block btn-success mt-2 mb-3">Reply</a>
                            @endif

                            @if ($message->sender->id != Auth::user()->id && !$message->sender->isStaff() && $message->receiver->id == Auth::user()->id)
                                <div class="text-center">
                                    <a href="{{ route('report.index', ['message', $message->id]) }}" class="text-danger">
                                        <i class="fas fa-flag"></i>
                                        <span>Report</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h3><strong>{{ $message->title }}</strong></h3>
                            <h5>Received on {{ $message->created_at->format('M d, Y h:i A') }}</h5>
                            <hr>
                            {!! nl2br(e($message->body)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
