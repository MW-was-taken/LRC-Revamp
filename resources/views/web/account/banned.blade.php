 
@extends('layouts.default', [
    'title' => 'Account Suspended'
])

@section('js')
    <script>
        $(() => {
            $('input[name="accept"]').on('change', function() {
                $('#reactivateButton').attr('disabled', !this.checked);
            });
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h3>{{ ($ban->length != 'warning' && $ban->length != 'closed') ? 'Banned for ' : '' }}{{ $length }}</h3>
            <div class="card">
                <div class="card-body">
                    <p>Your account was suspended for violating our Terms of Service.</p>
                    @if ($ban->length == 'closed')
                        <p>Your account has been permanently banned.</p>
                    @else
                        <p>You will need to change your behaviour in order to continue playing on {{ config('site.name') }}. Repeated violations of our terms of service will result in a permanent suspension.</p>
                    @endif
                    <hr>
                    <div class="row mb-3">
                        <div class="col-4 col-md-2"><strong>Reviewed</strong></div>
                        <div class="col-8 col-md-10">{{ $ban->created_at->format('M d, Y h:i A') }}</div>
                        <div class="col-4 col-md-2"><strong>Reason</strong></div>
                        <div class="col-8 col-md-10">{{ $category }}</div>
                        @if ($ban->note)
                            <div class="col-4 col-md-2"><strong>Mod Note</strong></div>
                            <div class="col-8 col-md-10">{{ $ban->note }}</div>
                        @endif
                    </div>
                    <div class="text-center">
                        @if ($ban->length == 'closed')
                            <p>Your account has been closed. Thank you for playing!</p>
                        @elseif ($canReactivate)
                            <form action="{{ route('account.banned.reactivate') }}" method="POST">
                                @csrf
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="accept">
                                    <label class="form-check-label" for="accept">I have read and agree to follow the Terms of Service.</label>
                                </div>
                                <button class="btn btn-success mb-3" id="reactivateButton" type="submit" disabled>Reactivate Account</button>
                            </form>
                        @endif
                        <a href="{{ route('auth.logout') }}" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
