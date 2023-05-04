 
@extends('layouts.admin', [
    'title' => 'Manage Staff'
])

@section('header')
    <a href="{{ route('admin.manage.staff.new') }}" class="btn btn-success"><i class="fas fa-plus"></i></a>
@endsection

@section('content')
    @if ($users->count() == 0)
        <p>No staff were found.</p>
    @else
        <div class="card" style="border:none;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Since</th>
                        <th>Online</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><a href="{{ route('admin.users.view', $user->user->id) }}">{{ $user->id }}</a></td>
                            <td><a href="{{ route('admin.users.view', $user->user->id) }}">{{ $user->user->username }}</a></td>
                            <td>{{ $user->created_at }}</td>
                            <td>{!! ($user->user->online()) ? '<span class="badge bg-success text-white">YES</span>' : '<span class="badge bg-danger text-white">NO</span>' !!}</td>
                            <td><a href="{{ route('admin.manage.staff.edit', $user->user->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->onEachSide(1) }}
    @endif
@endsection
