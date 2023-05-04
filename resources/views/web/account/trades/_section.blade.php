 
<div class="col-md-6">
    <h3>{{ $title }}</h3>
    <div class="card">
        <div class="card-body" style="padding-bottom:0;">
            <div class="row">
                @foreach ($items as $item)
                    <div class="col-6 col-md-4">
                        <a href="{{ route('catalog.item', [$item['id'], $item['slug']]) }}" style="color:inherit;text-decoration:none;" target="_blank">
                            <div class="card" style="border:none;">
                                <img style="background:var(--section_bg_inside);border-radius:6px;padding:{{ itemTypePadding($item->type) }};" src="{{ $item['thumbnail'] }}">
                                <div class="text-truncate mt-1"><strong>{{ $item['name'] }}</strong></div>
                            </div>
                        </a>
                    </div>
                @endforeach

                @if ($currency)
                    <div class="col-md-12">
                        <span>+ <i class="currency"></i> {{ number_format($currency) }}</span>
                        <div class="mb-3"></div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
