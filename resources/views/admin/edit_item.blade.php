 
@extends('layouts.admin', [
    'title' => "Edit \"{$item->name}\""
])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.edit_item.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Name</label>
                                <input class="form-control mb-2" type="text" name="name" placeholder="Item Name" value="{{ $item->name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="price">Price</label>
                                <input class="form-control mb-2" type="number" name="price" placeholder="Item Price" min="0" max="1000000" value="{{ $item->price }}">
                            </div>
                        </div>
                        <label for="description">Description</label>
                        <textarea class="form-control mb-2" name="description" placeholder="Item Description" rows="5">{{ $item->description }}</textarea>
                        <label for="stock">Stock</label>
                        <input class="form-control mb-2" type="number" name="stock" placeholder="Limited Stock" min="0" max="500" value="{{ $item->stock }}">
                        <label for="onsale_for">
                            <span>Onsale For</span>
                            @if ($item->isTimed())
                                <span class="text-danger">(Onsale Until: {{ $item->onsale_until }})</span>
                            @endif
                        </label>
                        <select class="form-control mb-2" name="onsale_for">
                            <option selected disabled hidden>--</option>
                            <option value="forever">Forever</option>
                            <option value="1_hour">1 Hour</option>
                            <option value="12_hours">12 Hours</option>
                            <option value="1_day">1 Day</option>
                            <option value="3_days">3 Days</option>
                            <option value="7_days">7 Days</option>
                            <option value="14_days">14 Days</option>
                            <option value="21_days">21 Days</option>
                            <option value="1_month">1 Month</option>
                        </select>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="image">Image</label><br>
                                <input class="mb-3" name="image" type="file">
                            </div>

                            @if ($item->type != 'face')
                                <div class="col-md-6">
                                    <label for="model">Model</label><br>
                                    <input class="mb-3" name="model" type="file">
                                </div>
                            @endif
                        </div>
                        <label>Options</label>
                        <div class="row mb-1">
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="onsale" @if ($item->onsale()) checked @endif>
                                    <label class="form-check-label" for="onsale">For Sale</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="limited" @if ($item->limited) checked @endif>
                                    <label class="form-check-label" for="limited">Limited</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="public" @if ($item->public_view) checked @endif>
                                    <label class="form-check-label" for="public_view">Public</label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-block btn-success" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ $item->thumbnail() }}">
                </div>
            </div>
        </div>
    </div>
@endsection
