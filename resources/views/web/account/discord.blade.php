 
@extends('layouts.default', [
    'title' => 'Verify Discord Account'
])

@section('css')
    @if (empty(Auth::user()->discord_id) && !empty(Auth::user()->discord_code))
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    @endif
@endsection

@section('js')
    @if (empty(Auth::user()->discord_id) && !empty(Auth::user()->discord_code))
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            $(function() {
                $('input[name="code"]').click(function() {
                    this.select();
                    document.execCommand('copy');

                    toastr.success('Code copied to clipboard!');
                });
            });
        </script>
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fab fa-discord mb-2" style="color:#7289da;font-size:80px;"></i>
                    <h4>Verify your Discord Account</h4>
                    @if (empty(Auth::user()->discord_id))
                        @if (empty(Auth::user()->discord_code))
                            <p>Click the 'Generate' button below to generate a unique key which you will then DM to our bot.</p>
                            <form action="{{ route('account.discord.generate') }}" method="POST">
                                @csrf
                                <button class="btn btn-success">Generate Code</button>
                            </form>
                        @else
                            <p>To finish this process, DM the code posted below to our verification bot.</p>
                            <input class="form-control" style="cursor:pointer;" type="text" name="code" placeholder="Discord Code" value="{{ Auth::user()->discord_code }}" readonly>
                        @endif
                    @else
                        <p>If you would like to unlink your Discord account, click the 'Unlink' button.</p>
                        <form action="{{ route('account.discord.generate') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger">Unlink Account</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
