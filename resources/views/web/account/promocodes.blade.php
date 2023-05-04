 
@extends('layouts.default', [
    'title' => 'Promocodes'
])

@section('meta')
    <meta name="routes" data-redeem="{{ route('account.promocodes.redeem') }}">
@endsection

@section('js')
    <script src="{{ asset('js/promocodes.js') }}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <h4>How It Works</h4>
            <div class="card">
                <div class="card-body">
                    <p>Enter special codes in the text box and press the button for unique and special items!</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h4>Promocodes</h4>
            <div class="card">
                <div class="card-body">
                    <form id="codeForm">
                        <div class="input-group">
                            <input class="form-control" type="text" name="code" placeholder="Code" required>
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">Redeem</button>
                            </div>
                        </div>
                    </form>
                    <div id="message"></div>
                </div>
            </div>
            <h4>Current Code Items</h4>
            <div class="card">
                <div class="card-body" @if (count($items) > 0) style="padding-bottom:0;" @endif>
                    <div class="row">
                        @forelse ($items as $item)
                            <div class="col-4 col-md-3">
                                <div class="card has-bg" style="border:none;padding:{{ itemTypePadding($item->type) }};">
                                    <a href="{{ route('catalog.item', [$item->id, $item->slug()]) }}" target="_blank">
                                        <img src="{{ $item->thumbnail() }}">
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col">There are currently no code items.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
