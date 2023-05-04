 
@extends('layouts.default', [
    'title' => "Edit \"{$item->name}\""
])

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h3>Edit Item</h3>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('catalog.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <label for="name">Name</label>
                        <input class="form-control mb-2" type="text" name="name" placeholder="Item Name" value="{{ $item->name }}" required>
                        <label for="description">Description</label>
                        <textarea class="form-control mb-2" name="description" placeholder="Item Description" rows="5">{{ $item->description }}</textarea>
                        <label for="price">Price</label>
                        <input class="form-control mb-2" type="number" name="price" placeholder="Item Price" min="0" max="1000000" value="{{ $item->price }}">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="onsale" @if ($item->onsale()) checked @endif>
                            <label class="form-check-label" for="onsale">For Sale</label>
                        </div>
                        <button class="btn btn-block btn-success" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Thumbnail</h3>
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ $item->thumbnail() }}">
                </div>
            </div>
        </div>
    </div>
@endsection
