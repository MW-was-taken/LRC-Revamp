 
@extends('layouts.admin', [
    'title' => "Delete \"{$topic->name}\""
])

@section('content')
    <div class="card text-center">
        <div class="card-body">
            <h3>Are you sure that you want to delete this topic?</h3>
            <h4 class="text-danger">This can <strong>NOT</strong> be undone.</h4>
            <hr>
            <form action="{{ route('admin.manage.forum_topics.delete') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $topic->id }}">
                <a href="{{ route('admin.manage.forum_topics.index') }}" class="btn btn-success">No</a>
                <button class="btn btn-danger" type="submit">Yes</button>
            </form>
        </div>
    </div>
@endsection
