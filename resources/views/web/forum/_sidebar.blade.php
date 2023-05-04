 
@auth
    <div class="col-md-3 {{ ($mobile) ? 'show-sm-only' : 'hide-sm' }}">
        @if ((Auth::user()->isStaff() && $topic->is_staff_only_posting) || !$topic->is_staff_only_posting)
            <a href="{{ route('forum.new', ['thread', $topic->id]) }}" class="btn btn-block btn-success mb-3"><i class="fas fa-plus"></i> Create Thread</a>
        @endif
        <form action="{{ route('forum.search') }}" method="GET">
            <input class="form-control" type="text" name="search" placeholder="Search..." required>
        </form>
        <div class="mb-3"></div>
        <h5>Forum Level</h5>
        <div class="card text-center">
            <div class="card-body">
                <h3>{{ Auth::user()->forum_level }}</h3>
                <div class="text-muted" style="margin-top:-10px;">{{ Auth::user()->forum_exp }}/{{ round(Auth::user()->forumLevelMaxExp()) }} EXP to level up</div>
            </div>
        </div>
    </div>
@endauth
