 
@extends('layouts.admin', [
    'title' => "Edit \"{$topic->name}\""
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.manage.forum_topics.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $topic->id }}">
                <label for="name">Name</label>
                <input class="form-control mb-2" type="text" name="name" placeholder="Name" value="{{ $topic->name }}" required>
                <label for="description">Description</label>
                <textarea class="form-control mb-2" name="description" placeholder="Write topic description here..." rows="5" required>{{ $topic->description }}</textarea>
                <label for="home_page_priority">Home Page Priority</label>
                <input class="form-control mb-2" type="number" name="home_page_priority" placeholder="Home Page Priority" value="{{ $topic->home_page_priority }}" min="1" max="255" required>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_staff_only_viewing" @if ($topic->is_staff_only_viewing) checked @endif>
                    <label class="form-check-label" for="staff_only_viewing">Staff Only Viewing</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_staff_only_posting" @if ($topic->is_staff_only_posting) checked @endif>
                    <label class="form-check-label" for="staff_only_posting">Staff Only Posting</label>
                </div>
                <button class="btn btn-block btn-success" type="submit">Edit</button>
            </form>
        </div>
    </div>
@endsection
