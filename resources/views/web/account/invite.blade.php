 
@extends('layouts.default', [
    'title' => 'Invite'
])

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(function() {
            $('input[name="invite_link"]').click(function() {
                this.select();
                document.execCommand('copy');

                toastr.success('Invite link copied to clipboard!');
            });
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-7">
            <h3>Invite</h3>
            <div class="card">
                <div class="card-body">
                    <p>Invite your friends to {{ config('site.name') }} to get rewarded and help us grow!</p>
                    <p>Every time a user you referred purchases currency, you will get 10% of the amount they purchased for free!</p>
                    <p>You can find your invite link below.</p>
                    <input class="form-control" style="cursor:pointer;" type="text" name="invite_link" placeholder="Invite Link" value="{{ config('site.route_domains.referral_site') }}/{{ Auth::user()->referral_code }}" readonly>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <h3>Invited Users</h3>
            @forelse ($users as $user)
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-3">
                                <a href="{{ route('users.profile', $user->username) }}">
                                    <img src="{{ $user->thumbnail() }}">
                                </a>
                            </div>
                            <div class="col-8 col-md-9">
                                <div class="text-truncate">
                                    <a href="{{ route('users.profile', $user->username) }}" style="color:inherit;text-decoration:none;font-size:21px;">{{ $user->username }}</a>
                                    <hr style="margin-top:10px;margin-bottom:10px;">
                                    <strong>Date:</strong>
                                    <span>{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>You haven't invited any users yet.</p>
            @endforelse
            {{ $users->onEachSide(1) }}
        </div>
    </div>
@endsection
