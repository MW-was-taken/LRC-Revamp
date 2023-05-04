 
@extends('layouts.admin', [
    'title' => $title
])

@section('content')
    @if ($type == 'currency')
        <div class="row">
            @if (staffUser()->staff('can_give_currency'))
                <div class="col-md">
                    <h3>Give Currency</h3>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.users.manage.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input type="hidden" name="action" value="give_currency">
                                <input class="form-control mb-3" name="amount" type="number" min="1" placeholder="Amount" required>
                                <button class="btn btn-success" type="submit">Give</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if (staffUser()->staff('can_take_currency'))
                <div class="col-md">
                    <h3>Take Currency</h3>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.users.manage.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input type="hidden" name="action" value="take_currency">
                                <input class="form-control mb-3" name="amount" type="number" min="1" placeholder="Amount" required>
                                <button class="btn btn-danger" type="submit">Take</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @elseif ($type == 'inventory')
        <div class="row">
            @if (staffUser()->staff('can_give_items'))
                <div class="col-md">
                    <h3>Give Item</h3>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.users.manage.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input type="hidden" name="action" value="give_items">
                                <input class="form-control mb-3" name="item_id" type="number" min="1" placeholder="Item ID" required>
                                <button class="btn btn-success" type="submit">Give</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if (staffUser()->staff('can_take_items'))
                <div class="col-md">
                    <h3>Take Item</h3>
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.users.manage.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input type="hidden" name="action" value="take_items">
                                <input class="form-control mb-3" name="item_id" type="number" min="1" placeholder="Item ID" required>
                                <button class="btn btn-danger" type="submit">Take</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
@endsection
