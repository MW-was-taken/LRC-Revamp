 
@extends('layouts.email', [
    'title' => 'Verify Your Email'
])

@section('content')
    <p>Hi there {{ $user->username }}! Someone (hopefully you!) has created a {{ config('site.name') }} account with your email.</p>
    <div style="height:16px;"></div>
    <p>To verify simply click the URL below to verify your account.</p>
    <div style="height:16px;"></div>
    <p><a href="{{ route('account.verify.confirm', $code) }}">{{ route('account.verify.confirm', $code) }}</a></p>
    <div style="height:16px;"></div>
    <p>If you didn't request this email, please ignore it.</p>
@endsection
