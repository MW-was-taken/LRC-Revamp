 
@extends('layouts.admin', [
    'title' => 'Reports'
])

@section('content')
    <div class="row mb-2">
        @forelse ($reports as $report)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"><strong>Reporter:</strong></div>
                            <div class="col-md-9"><a href="{{ route('users.profile', $report->reporter->username) }}" target="_blank">{{ $report->reporter->username }}</a></div>
                            <div class="col-md-3"><strong>Type:</strong></div>
                            <div class="col-md-9">
                                <span>{{ $report->type() }}</span>
                                @if ($report->url())
                                    <a href="{{ $report->url() }}" target="_blank">[Click to view]</a>
                                @endif
                            </div>
                            <div class="col-md-3"><strong>Category:</strong></div>
                            <div class="col-md-9">{{ $report->category }}</div>
                            <div class="col-md-12">
                                <div class="mb-2 hide-sm"></div>
                                <strong>Comment:</strong>
                                <div>{!! (!empty($report->comment)) ? nl2br(e($report->comment)) : '<div class="text-muted">This report does not have a comment.</div>' !!}</div>
                            </div>
                            @if (!$report->url())
                                <div class="col-md-12">
                                    <div class="mb-2 hide-sm"></div>
                                    <strong>Content:</strong>
                                    <div>{{ $report->content->body }}</div>
                                </div>
                            @endif
                        </div>
                        <hr>
                        <form action="{{ route('admin.reports.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $report->id }}">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-block btn-success" type="submit"><i class="fas fa-eye"></i></button>
                                </div>
                                @if (staffUser()->staff('can_ban_users'))
                                    <div class="col">
                                        <a href="{{ route('admin.users.ban.index', $report->reported_user_id) }}" class="btn btn-block btn-danger" target="_blank"><i class="fas fa-gavel"></i></a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">There are currently no pending reports.</div>
        @endforelse
    </div>
    {{ $reports->onEachSide(1) }}
@endsection
