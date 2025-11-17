@php
    use Illuminate\Support\Str;
    $fallback = asset('img/menu-1.jpg');
@endphp

<div class="menu-grid">
    @foreach($mons as $mon)
        <a href="{{ route('menu.show', $mon->ID_Mon) }}" class="menu-card-link">
            <div class="menu-card"
                 data-name="{{ Str::lower($mon->TenMon) }}"
                 data-type="{{ Str::slug($mon->loaiMon->TenLoaiMon ?? '') }}">

                <div class="menu-img">
                    <img
                        src="{{ asset('Mon_images/' . Str::slug($mon->loaiMon->TenLoaiMon ?? '', '') . '/' . Str::slug($mon->TenMon, '') . '.jpg') }}"
                        alt="{{ $mon->TenMon }}"
                        onerror="this.onerror=null;this.src='{{ $fallback }}';"
                    >
                </div>

                <div class="menu-content">
                    <h5 class="menu-title">{{ $mon->TenMon }}</h5>

                    <div class="menu-footer">
                        <div class="price">{{ number_format($mon->Gia, 0, ',', '.') }} đ</div>
                        <button class="btn btn-add">
                            <i class="fa fa-plus me-1"></i> Thêm
                        </button>
                    </div>
                </div>

            </div>
        </a>
    @endforeach
</div>

@if ($mons->hasPages())
    <div class="mt-5 d-flex justify-content-center ajax-pagination">
        {!! $mons->appends(request()->query())->links('pagination::bootstrap-4') !!}
    </div>
@endif
