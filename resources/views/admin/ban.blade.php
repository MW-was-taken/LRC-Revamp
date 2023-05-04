 
@extends('layouts.admin', [
    'title' => "Ban {$user->username}"
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.ban.create') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <label for="length">Length</label>
                <select class="form-control mb-2" name="length" required>
                    @foreach ($lengths as $name => $value)
                        <option value="{{ $value }}">{{ $name }}</option>
                    @endforeach
                </select>
                <label for="category">Category</label>
                <select class="form-control mb-2" name="category" required>
                    @foreach ($categories as $name => $value)
                        <option value="{{ $value }}">{{ $name }}</option>
                    @endforeach
                </select>
                <label for="note">Note (optional)</label>
                <textarea class="form-control mb-3" name="note" placeholder="Note" rows="5"></textarea>
                <button class="btn btn-block btn-success" type="submit">Ban User</button>
            </form>
        </div>
    </div>
@endsection
