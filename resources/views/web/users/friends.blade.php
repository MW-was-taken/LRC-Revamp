 
@extends('layouts.default', [
    'title' => "{$user->username}'s Friends"
])

@section('content')
    <h3>{{ $user->username }}'s Friends</h3>
    <div class="card">
        <div class="card-body" @if ($friends->count() > 0) style="padding-bottom:0;" @endif>
            <div class="row">
                @forelse ($friends as $friend)
                    <div class="col-6 col-md-2">
                        <div class="card text-center" style="border:none;">
                            <a href="{{ route('users.profile', $friend->username) }}">
                                <img src="{{ $friend->thumbnail() }}">
                                <div class="text-truncate mt-1">{{ $friend->username }}</div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col text-center">
                        <i class="fas fa-frown text-warning mb-2" style="font-size:50px;"></i>
                        <div>This user has no friends. What a party pooper!</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    {{ $friends->onEachSide(1) }}
@endsection
