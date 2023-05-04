 
@extends('layouts.default', [
    'title' => 'Forum'
])

@section('css')
    <style>
        .topic {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .topic:not(:last-child) {
            border-bottom: 1px solid var(--divider_color);
        }

        .topic:hover {
            background: var(--section_bg_hover);
        }
    </style>
@endsection

@section('content')
    <h3>Forum</h3>
    @if ($topics->count() == 0)
        <p>There are currently no topics. Check back later.</p>
    @else
        <div class="card">
            <div class="card-header bg-primary text-white" style="padding-left:15px;padding-right:15px;">
                <div class="row">
                    <div class="col-md-9">Topic</div>
                    <div class="col-md-1 text-center hide-sm">Posts</div>
                    <div class="col-md-2 text-center hide-sm">Last Thread</div>
                </div>
            </div>
            <div class="card-body" style="padding-top:0;padding-left:15px;padding-right:15px;padding-bottom:0;">
                @foreach ($topics as $topic)
                    <div class="row topic">
                        <div class="col-md-9">
                            <a href="{{ route('forum.topic', [$topic->id, $topic->slug()]) }}" style="color:inherit;font-weight:600;text-decoration:none;">{{ $topic->name }}</a>
                            <div class="text-muted">{{ $topic->description }}</div>
                        </div>
                        <div class="col-md-1 text-center align-self-center hide-sm">{{ number_format($topic->threads(false)->count()) }}</div>
                        <div class="col-md-2 text-center align-self-center hide-sm">
                            @if ($topic->lastPost())
                                <div class="text-truncate"><a href="{{ route('forum.thread', $topic->lastPost()->id) }}">{{ $topic->lastPost()->title }}</a></div>
                                <div>{{ $topic->lastPost()->updated_at->diffForHumans() }}</div>
                            @else
                                <span>N/A</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
