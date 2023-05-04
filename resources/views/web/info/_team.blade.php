 
@section('css')
    <style>
        .user:not(:first-child) {
            padding-top: 15px;
        }

        .user:not(:last-child) {
            padding-bottom: 15px;
            border-bottom: 1px solid var(--divider_color);
        }
    </style>
@endsection

@forelse ($users as $user)
    <div class="row user">
        <div class="col-4 col-md-2 text-center">
            <a href="{{ route('users.profile', $user->username) }}">
                <img src="{{ $user->thumbnail() }}">
            </a>
        </div>
        <div class="col-8 col-md-10">
            <h5 class="mb-2 text-truncate"><a href="{{ route('users.profile', $user->username) }}">{{ $user->username }}</a></h5>
            <div class="text-muted">{{ $user->description ?? 'This user does not have a description.' }}</div>
        </div>
    </div>
@empty
    <p>No team members found.</p>
@endforelse
