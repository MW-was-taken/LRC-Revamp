@extends('layouts.default', [
    'title' => 'Forum',
])

@section('css')
    <style>
        .topic {
            padding-top: 15px;
            padding-bottom: 15px;
            transition: 125ms ease all;
            background: var(--section_bg);
        }

        .topic {
            border-bottom: 1px solid var(--divider_color);
        }

        .topic:hover {
            background: var(--section_bg_hover);
        }
    </style>
    <style>
        .thread {
            padding-top: 15px;
            padding-bottom: 15px;
            transition: 125ms ease all;
            background: var(--section_bg);
        }

        .thread {
            border-bottom: 1px solid var(--divider_color);
        }


        .thread:hover {
            background: var(--section_bg_hover);
        }

        .topic .user-headshot {
            width: 50px;
            height: 50px;
            float: left;
            position: relative;
            overflow: hidden;
        }

        .topic .user-headshot img {
            background: var(--headshot_bg);
            border-radius: 50%;
        }

        .topic .details {
            padding-left: 25px;
        }

        .topic .status {
            font-size: 11px;
            border-radius: 4px;
            margin-top: -2px;
            margin-right: 5px;
            padding: 0.5px 5px;
            font-weight: 600;
            display: inline-block;
        }

        .topic .status i {
            font-size: 10px;
            vertical-align: middle;
        }

        .topic .status i.fa-lock {
            margin-top: -1px;
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-8">
            <h4>
                Browse Topics
            </h4>
            <hr>
            @if ($categories->count() == 0)
                <p>There are currently no topics. Check back later.</p>
            @else
                <div class="p-2 px-4 bg-primary text-white rounded">
                    <div class="row">
                        <div class="col-md-6">Topic</div>
                        <div class="col-md-3 text-center hide-sm">Posts</div>
                        <div class="col-md-3 text-center hide-sm">Last Thread</div>
                    </div>
                </div>
                <div class="mb-2"></div>
                @foreach ($categories as $category)
                    <h4>
                        {{ $category->name }}
                    </h4>
                    <div class="card-body" style="padding-top:0;padding-left:15px;padding-right:15px;padding-bottom:0;">
                        @foreach ($category->topics() as $topic)
                            <div class="row topic rounded mb-1 shadow">
                                <div class="col-md-6">
                                    <a href="{{ route('forum.topic', [$topic->id, $topic->slug()]) }}"
                                        style="color:inherit;font-weight:600;text-decoration:none;">{{ $topic->name }}</a>
                                    <div class="text-muted">{{ $topic->description }}</div>
                                </div>
                                <div class="col-md-3 text-center align-self-center hide-sm">
                                    {{ number_format($topic->threads(false)->count()) }}</div>
                                <div class="col-md-3 align-self-center hide-sm align-items-center d-flex">
                                    @if ($topic->lastPost())
                                    <img src="{{$topic->lastPost()->creator->headshot()}}" alt="{{$topic->lastPost()->creator->username}}'s Portrait" width="50" class="img-fluid d-inline-block">
                                        <div class="text-truncate d-inline-block pl-3">
                                            <a
                                                href="{{ route('forum.thread', $topic->lastPost()->id) }}">{{ $topic->lastPost()->title }}
                                            </a>
                                            <div>{{ $topic->lastPost()->updated_at->diffForHumans() }}</div>
                                        </div>
                                    @else
                                        <span>N/A</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-4">
            <h4>
                Recent Posts
            </h4>
            <hr>
            <div class="p-2 px-4 bg-primary text-white rounded">
                <div class="row">
                    <div class="col-md-8">Thread</div>
                    <div class="col-md-3">Replies</div>
                </div>
            </div>
            <div class="mb-2"></div>
            <div class="card-body p-2 px-3">
                @foreach ($posts as $thread)
                    <div class="row topic rounded" @if ($thread->is_deleted) style="opacity:.5;" @endif>
                        <div class="col-md-8">
                            <div class="details text-truncate">
                                <a href="{{ route('forum.thread', $thread->id) }}" style="color:inherit;font-size:18px;font-weight:600;text-decoration:none;">{{ $thread->title }}</a>
                                <div class="text-muted" style="margin-top:-3px;">
                                    <a href="{{ route('users.profile', $thread->creator->username) }}"
                                        @if ($thread->creator->isStaff()) class="text-danger" @endif>{{ $thread->creator->username }}</a>
                                    <span>- {{ $thread->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center align-self-center">
                            {{ number_format($thread->replies(false)->count()) }}
                        </div>
                    </div>
                    <div class="mb-1"></div>
                @endforeach
            </div>
        </div>
    </div>
    <!--
        <h3>Forum</h3>
        <div class="row">
            <div class="col-6">
                <h4>
                    Recent Posts
                </h4>
                <hr>
                <div class="p-2 px-4 bg-primary text-white rounded">
                    <div class="row">
                        <div class="col-md-6">Thread</div>
                        <div class="col-md-3 text-center hide-sm">Replies</div>
                        <div class="col-md-3 text-center hide-sm">Last Reply</div>
                    </div>
                </div>
                <div class="mb-2"></div>
                <div class="card-body" style="padding-top:0;padding-left:15px;padding-right:15px;padding-bottom:0;">
                    @foreach ($posts as $thread)
    <div class="row topic rounded" @if ($thread->is_deleted) style="opacity:.5;" @endif>
                            <div class="col-md-6">
                                <div class="user-headshot">
                                    <img src="{{ $thread->creator->headshot() }}">
                                </div>
                                <div class="details text-truncate">
                                    <a href="{{ route('forum.thread', $thread->id) }}"
                                        style="color:inherit;font-size:18px;font-weight:600;text-decoration:none;">{{ $thread->title }}</a>
                                    <div class="text-muted" style="margin-top:-3px;">
                                        @if ($thread->is_pinned)
    <span class="status bg-danger text-white"><i class="fas fa-thumbtack mr-1"></i>
                                                Pinned</span>
@elseif ($thread->is_locked)
    <span class="status text-white" style="background:#000;"><i
                                                    class="fas fa-lock mr-1"></i> Locked</span>
    @endif
       
                                        <span class="hide-sm">Posted by</span>
                                        <a href="{{ route('users.profile', $thread->creator->username) }}"
                                            @if ($thread->creator->isStaff()) class="text-danger" @endif>{{ $thread->creator->username }}</a>
                                        <span>- {{ $thread->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-center align-self-center hide-sm">
                                {{ number_format($thread->replies(false)->count()) }}</div>
                            <div class="col-md-3 text-center align-self-center text-truncate hide-sm">
                                @if ($thread->lastReply())
    <a href="{{ route('users.profile', $thread->lastReply()->creator->username) }}"
                                        @if ($thread->lastReply()->creator->isStaff()) class="text-danger" @endif>{{ $thread->lastReply()->creator->username }}</a>
                                    <div>{{ $thread->lastReply()->created_at->diffForHumans() }}</div>
@else
    <a href="{{ route('users.profile', $thread->creator->username) }}"
                                        @if ($thread->creator->isStaff()) class="text-danger" @endif>{{ $thread->creator->username }}</a>
                                    <div>{{ $thread->created_at->diffForHumans() }}</div>
    @endif
                            </div>
                        </div>
                        <div class="mb-1"></div>
    @endforeach
                </div>
            </div>
        </div>
    -->
@endsection
