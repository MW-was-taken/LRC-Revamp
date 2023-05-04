 
@extends('layouts.admin', [
    'title' => 'Users'
])

@section('content')
    <form action="{{ route('admin.users.index') }}" method="GET">
        <input class="form-control mb-3" type="text" name="search" placeholder="Search..." value="{{ request()->search }}">
    </form>
    @if ($users->count() == 0)
        <p>No users were found.</p>
    @else
        <div class="card" style="border:none;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Created</th>
                        <th>Last Seen</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><a href="{{ route('admin.users.view', $user->id) }}">{{ $user->id }}</a></td>
                            <td><a href="{{ route('admin.users.view', $user->id) }}">{{ $user->username }}</a></td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>
                                @if ($user->isBanned())
                                    <span class="badge bg-danger text-white">BANNED</span>
                                @elseif (!$user->hasVerifiedEmail())
                                    <span class="badge bg-warning">EMAIL NOT VERIFIED</span>
                                @else
                                    <span class="badge bg-success text-white">OK</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->onEachSide(1) }}
    @endif
@endsection
