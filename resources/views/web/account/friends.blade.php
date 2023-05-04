 
@extends('layouts.default', [
    'title' => 'Friend Requests'
])

@section('content')
    <h3>Friend Requests ({{ number_format($friendRequests->count()) }})</h3>
    <div class="card">
        <div class="card-body" @if ($friendRequests->count() > 0) style="padding-bottom:0;" @endif>
            <div class="row">
                @forelse ($friendRequests as $friendRequest)
                    <div class="col-6 col-md-2 text-center">
                        <div class="card" style="border:none;">
                            <a href="{{ route('users.profile', $friendRequest->sender->username) }}">
                                <img src="{{ $friendRequest->sender->thumbnail() }}">
                                <div class="text-truncate mt-1">{{ $friendRequest->sender->username }}</div>
                            </a>
                            <form action="{{ route('account.friends.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $friendRequest->sender->id }}">
                                <div class="row mt-2">
                                    <div class="col">
                                        <button class="btn btn-block btn-success" name="action" value="accept"><i class="fas fa-check"></i></button>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-block btn-danger" name="action" value="decline"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col">You currently have no incoming friend requests.</div>
                @endforelse
            </div>
        </div>
    </div>
    {{ $friendRequests->onEachSide(1) }}
@endsection
