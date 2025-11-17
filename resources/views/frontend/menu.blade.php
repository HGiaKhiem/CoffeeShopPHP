@php
    use Illuminate\Support\Str;
    $fallback = asset('img/menu-1.jpg');
    $loaiMons = collect($mons)->pluck('loaiMon.TenLoaiMon')->unique()->filter();
@endphp

<section id="menu" class="menu-section">
  <div class="container py-5">
    <div class="text-start mb-4">
        <button class="btn btn-back" onclick="window.location.href='{{ url('/') }}'">
        <i class="fa fa-arrow-left me-2"></i> Trang chủ
        </button>
    </div>


    {{-- Title --}}
    <div class="text-center mb-5">
      <h1 class="fw-bold text-coffee">Thực đơn của chúng tôi</h1>
      <p class="text-muted">Thưởng thức hương vị cà phê và đồ uống tinh tế</p>
    </div>

    {{-- Search + Filters --}}
    <div class="menu-controls mb-5">
      <input
        id="menuSearch"
        type="text"
        class="menu-search form-control shadow-sm"
        placeholder="🔍 Tìm kiếm món..."
      >

      <div class="menu-filters mt-3">
        <button class="filter-btn active" data-filter="all">Tất cả</button>
        @foreach($loaiMons as $loai)
          <button class="filter-btn" data-filter="{{ Str::slug($loai) }}">{{ $loai }}</button>
        @endforeach
      </div>
    </div>

    {{-- Menu Grid --}}
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
            <!-- <p class="text-muted small">{{ $mon->loaiMon->TenLoaiMon ?? '' }}</p> -->
            <div class="menu-footer">
              <div class="price">{{ number_format($mon->Gia, 0, ',', '.') }} đ</div>
              <button class="btn btn-add"><i class="fa fa-plus me-1"></i> Thêm</button>
            </div>
          </div>

        </div>
      </a>
    @endforeach
  </div>


  </div>
</section>

<link rel="stylesheet" href="{{ asset('css/menu.css') }}">
<script src="{{ asset('js/menu.js') }}"></script>
