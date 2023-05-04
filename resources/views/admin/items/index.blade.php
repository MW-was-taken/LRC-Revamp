 
@extends('layouts.admin', [
    'title' => 'Items'
])

@section('content')
    <form action="{{ route('admin.items.index') }}" method="GET">
        <input class="form-control mb-3" type="text" name="search" placeholder="Search..." value="{{ request()->search }}">
    </form>
    @if ($items->count() == 0)
        <p>No items were found.</p>
    @else
        <div class="card" style="border:none;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td><a href="{{ route('admin.items.view', $item->id) }}">{{ $item->id }}</a></td>
                            <td><a href="{{ route('admin.items.view', $item->id) }}">{{ $item->name }}</a></td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ ucfirst($item->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $items->onEachSide(1) }}
    @endif
@endsection
