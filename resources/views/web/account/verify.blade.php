 
@extends('layouts.default', [
    'title' => 'Verify'
])

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-envelope text-primary mb-2" style="font-size:80px;"></i>
                    <h4>Verify your {{ config('site.name') }} Account</h4>
                    @if (empty(Auth::user()->email_verified_at))
                        @if ($emailSent)
                            <p>An email has been sent to your inbox. You can re-try again after 5 minutes.</p>
                            <p>Be sure to check your spam folder if you can't find the email.</p>
                        @else
                            <p>You are not verified! Click the "Send Email" button below to send an email to your account!</p>
                            <form action="{{ route('account.verify.send') }}" method="POST">
                                @csrf
                                <button class="btn btn-success" type="submit">Send Email</button>
                            </form>
                        @endif
                    @else
                        <p>Your account has been verified.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
