 @extends('layouts.default', [
     'title' => 'Forum',
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
         <style>
            .thread {
                padding-top: 15px;
                padding-bottom: 15px;
                overflow: hidden;
                border: 1px solid var(--divider_color);
            }

    
            .thread:hover {
                background: var(--section_bg_hover);
            }
    
            .thread .user-headshot {
                width: 50px;
                height: 50px;
                float: left;
                position: relative;
                overflow: hidden;
            }
    
            .thread .user-headshot img {
                background: var(--headshot_bg);
                border-radius: 50%;
            }
    
            .thread .details {
                padding-left: 25px;
            }
    
            .thread .status {
                font-size: 11px;
                border-radius: 4px;
                margin-top: -2px;
                margin-right: 5px;
                padding: 0.5px 5px;
                font-weight: 600;
                display: inline-block;
            }
    
            .thread .status i {
                font-size: 10px;
                vertical-align: middle;
            }
    
            .thread .status i.fa-lock {
                margin-top: -1px;
            }
        </style>
 @endsection
 

 @section('content')
     <h3>Forum</h3>
     <div class="row">
        <div class="col-6">
            <h4>
                Browse Topics
            </h4>
            <hr>
            @if ($topics->count() == 0)
                <p>There are currently no topics. Check back later.</p>
            @else
                <div class="p-2 bg-primary text-white" style="padding-left:15px;padding-right:15px;">
                    <div class="row">
                        <div class="col-md-6">Topic</div>
                        <div class="col-md-3 text-center hide-sm">Posts</div>
                        <div class="col-md-3 text-center hide-sm">Last Thread</div>
                    </div>
                </div>
                <div class="card-body" style="padding-top:0;padding-left:15px;padding-right:15px;padding-bottom:0;">
                    @foreach ($topics as $topic)
                        <div class="row topic">
                            <div class="col-md-6">
                                <a href="{{ route('forum.topic', [$topic->id, $topic->slug()]) }}"
                                    style="color:inherit;font-weight:600;text-decoration:none;">{{ $topic->name }}</a>
                                <div class="text-muted">{{ $topic->description }}</div>
                            </div>
                            <div class="col-md-3 text-center align-self-center hide-sm">
                                {{ number_format($topic->threads(false)->count()) }}</div>
                            <div class="col-md-3 text-center align-self-center hide-sm">
                                @if ($topic->lastPost())
                                    <div class="text-truncate"><a
                                            href="{{ route('forum.thread', $topic->lastPost()->id) }}">{{ $topic->lastPost()->title }}</a>
                                    </div>
                                    <div>{{ $topic->lastPost()->updated_at->diffForHumans() }}</div>
                                @else
                                    <span>N/A</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
         <div class="col-6">
             <h4>
                 Recent Posts
             </h4>
             <hr>
             <div class="p-2 bg-primary text-white" style="padding-left:15px;padding-right:15px;">
                <div class="row">
                    <div class="col-md-6">Topic</div>
                    <div class="col-md-3 text-center hide-sm">Replies</div>
                    <div class="col-md-3 text-center hide-sm">Last Reply</div>
                </div>
            </div>
             @foreach($posts as $thread)
             <div class="d-block" style="overflow: hidden; padding: 0 12px;">
                 <div class="row thread" @if ($thread->is_deleted) style="opacity:.5;" @endif>
                    <div class="col-md-6">
                        <div class="user-headshot">
                            <img src="{{ $thread->creator->headshot() }}">
                        </div>
                        <div class="details text-truncate">
                            <a href="{{ route('forum.thread', $thread->id) }}" style="color:inherit;font-size:18px;font-weight:600;text-decoration:none;">{{ $thread->title }}</a>
                            <div class="text-muted" style="margin-top:-3px;">
                                @if ($thread->is_pinned)
                                    <span class="status bg-danger text-white"><i class="fas fa-thumbtack mr-1"></i> Pinned</span>
                                @elseif ($thread->is_locked)
                                    <span class="status text-white" style="background:#000;"><i class="fas fa-lock mr-1"></i> Locked</span>
                                @endif
    
                                <span class="hide-sm">Posted by</span>
                                <a href="{{ route('users.profile', $thread->creator->username) }}" @if ($thread->creator->isStaff()) class="text-danger" @endif>{{ $thread->creator->username }}</a>
                                <span>- {{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center align-self-center hide-sm">{{ number_format($thread->replies(false)->count()) }}</div>
                    <div class="col-md-3 text-center align-self-center text-truncate hide-sm">
                        @if ($thread->lastReply())
                            <a href="{{ route('users.profile', $thread->lastReply()->creator->username) }}" @if ($thread->lastReply()->creator->isStaff()) class="text-danger" @endif>{{ $thread->lastReply()->creator->username }}</a>
                            <div>{{ $thread->lastReply()->created_at->diffForHumans() }}</div>
                        @else
                            <a href="{{ route('users.profile', $thread->creator->username) }}" @if ($thread->creator->isStaff()) class="text-danger" @endif>{{ $thread->creator->username }}</a>
                            <div>{{ $thread->created_at->diffForHumans() }}</div>
                        @endif
                    </div>
                </div>
             </div>
             @endforeach
         </div>
     </div>
 @endsection
