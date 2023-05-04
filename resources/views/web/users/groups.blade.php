 
@extends('layouts.default', [
    'title' => "{$user->username}'s Groups"
])

@section('content')
    <h3>{{ $user->username }}'s Groups</h3>
    <div class="card">
        <div class="card-body" @if ($groups->count() > 0) style="padding-bottom:0;" @endif>
            <div class="row">
                @forelse ($groups as $group)
                    <div class="col-6 col-md-2">
                        <div class="card text-center" style="border:none;">
                            <a href="{{ route('groups.view', [$group->id, $group->slug()]) }}">
                                <img src="{{ $group->thumbnail() }}">
                                <div class="text-truncate mt-1">{{ $group->name }}</div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col text-center">
                        <i class="fas fa-frown text-warning mb-2" style="font-size:50px;"></i>
                        <div>This user is not in any groups.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    {{ $groups->onEachSide(1) }}
@endsection
