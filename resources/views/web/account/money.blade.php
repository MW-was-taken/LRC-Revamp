 
@extends('layouts.default', [
    'title' => 'Money'
])

@section('css')
    <style>
        img.user-headshot {
            background: var(--headshot_bg);
            border-radius: 50%;
        }

        .transaction:not(:last-child) {
            margin-bottom: 16px;
        }
    </style>
@endsection

@section('content')
    <h3>{{ ucfirst($category) }}</h3>
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li class="nav-item">
                    <a href="{{ route('account.money.index', 'purchases') }}" class="nav-link @if ($category == 'purchases') active @endif">Purchases</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('account.money.index', 'sales') }}" class="nav-link @if ($category == 'sales') active @endif">Sales</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @forelse ($transactions as $transaction)
                <div class="row transaction text-center-sm">
                    <div class="col-md-2 align-self-center offset-md-1" style="font-size:20px;">
                        <strong>{{ $transaction->created_at->format('M d, Y') }}</strong>
                        <div class="mb-2 show-sm-only"></div>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="{{ route('users.profile', ($category == 'purchases') ? $transaction->sellerName() : $transaction->buyer->username) }}">
                            <img class="user-headshot" src="{{ ($category == 'purchases') ? $transaction->sellerImage() : $transaction->buyer->headshot() }}" width="64px">
                            <div class="text-truncate">{{ ($category == 'purchases') ? $transaction->sellerName() : $transaction->buyer->username }}</div>
                        </a>
                        <div class="mb-2 show-sm-only"></div>
                    </div>
                    <div class="col-md-2 offset-md-2 text-center">
                        <a href="{{ route('catalog.item', [$transaction->item->id, $transaction->item->slug()]) }}">
                            <img style="background:var(--section_bg_inside);border-radius:6px;padding:{{ itemTypePadding($transaction->item->type) }};" src="{{ $transaction->item->thumbnail() }}" width="64px">
                            <div class="text-truncate">{{ $transaction->item->name }}</div>
                        </a>
                        <div class="mb-2 show-sm-only"></div>
                    </div>
                    <div class="col-md-2 text-right text-center-sm align-self-center" style="font-size:20px;">
                        @if ($transaction->price > 0)
                            <span><i class="currency"></i> {{ number_format($transaction->price) }}</span>
                        @else
                            <span class="text-primary">Free</span>
                        @endif
                    </div>
                </div>
            @empty
                <p>No transactions found.</p>
            @endforelse
        </div>
    </div>
    {{ $transactions->onEachSide(1) }}
@endsection
