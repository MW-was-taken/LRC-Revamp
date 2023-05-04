 
@extends('layouts.admin', [
    'title' => 'New Forum Topic'
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.manage.forum_topics.create') }}" method="POST">
                @csrf
                <label for="name">Name</label>
                <input class="form-control mb-2" type="text" name="name" placeholder="Name" required>
                <label for="description">Description</label>
                <textarea class="form-control mb-2" name="description" placeholder="Write topic description here..." rows="5" required></textarea>
                <label for="home_page_priority">Home Page Priority</label>
                <input class="form-control mb-2" type="number" name="home_page_priority" placeholder="Home Page Priority" min="1" max="255" required>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_staff_only_viewing">
                    <label class="form-check-label" for="staff_only_viewing">Staff Only Viewing</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_staff_only_posting">
                    <label class="form-check-label" for="staff_only_posting">Staff Only Posting</label>
                </div>
                <button class="btn btn-block btn-success" type="submit">Create</button>
            </form>
        </div>
    </div>
@endsection
