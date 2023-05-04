 
@extends('layouts.default', [
    'title' => 'Trade'
])

@section('content')
    <div class="row">
        <div class="col">
            <h3>{{ (Auth::user()->id == $trade->receiver->id) ? "Trade sent by {$trade->sender->username}" : "Trade sent to {$trade->receiver->username}" }}</h3>
        </div>
        @if ($trade->status == 'pending')
            <div class="col text-right hide-sm">
                <form action="{{ route('account.trades.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $trade->id }}">
                    @if (Auth::user()->id == $trade->receiver->id)
                        <button class="btn btn-success mr-2" name="action" value="accept">Accept</button>
                    @endif
                    <button class="btn btn-danger" name="action" value="decline">Decline</button>
                </form>
            </div>
        @endif
    </div>
    <div class="row">
        @if (Auth::user()->id == $trade->receiver->id)
            @include('web.account.trades._section', [
                'title' => ($trade->status != 'pending') ? 'You Gave' : 'You Are Giving',
                'items' => $receiving,
                'currency' => $trade->receiving_currency
            ])

            @include('web.account.trades._section', [
                'title' => ($trade->status != 'pending') ? 'You Received' : 'You Are Receiving',
                'items' => $giving,
                'currency' => $trade->giving_currency
            ])
        @else
            @include('web.account.trades._section', [
                'title' => ($trade->status != 'pending') ? 'You Gave' : 'You Are Giving',
                'items' => $giving,
                'currency' => $trade->giving_currency
            ])

            @include('web.account.trades._section', [
                'title' => ($trade->status != 'pending') ? 'You Received' : 'You Are Receiving',
                'items' => $receiving,
                'currency' => $trade->receiving_currency
            ])
        @endif

    @if ($trade->status == 'pending')
        <div class="col text-right show-sm-only">
            <form action="{{ route('account.trades.process') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $trade->id }}">
                <div class="row">
                    @if (Auth::user()->id == $trade->receiver->id)
                        <div class="col">
                            <button class="btn btn-block btn-success" name="action" value="accept">Accept</button>
                        </div>
                    @endif
                    <div class="col">
                        <button class="btn btn-block btn-danger" name="action" value="decline">Decline</button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="col-md-12">This trade has been {{ $trade->status }}.</div>
    @endif
@endsection
