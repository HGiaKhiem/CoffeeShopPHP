@php
    use Illuminate\Support\Str;

    $fallback = asset('img/menu-1.jpg');

    // 🔥 FIX: Lấy loại món từ toàn bộ DB (không giới hạn paginate)
    $loaiMons = \App\Models\Mon::with('loaiMon')
                ->get()
                ->pluck('loaiMon.TenLoaiMon')
                ->unique()
                ->filter();
@endphp

<section id="menu" class="menu-section">
  <div class="container py-5">

    {{-- Nút quay lại --}}
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

        {{-- Search --}}
        <input
            id="menuSearch"
            type="text"
            class="menu-search form-control shadow-sm"
            placeholder="🔍 Tìm kiếm món..."
        >

        {{-- Filter loại món --}}
        <div class="menu-filters mt-3">
            <button class="filter-btn active" data-filter="all">Tất cả</button>

            @foreach($loaiMons as $loai)
                <button class="filter-btn" data-filter="{{ Str::slug($loai) }}">
                    {{ $loai }}
                </button>
            @endforeach
        </div>

    </div>

    {{-- 🔥 AJAX Container --}}
    <div id="ajaxMenuContainer">
        @include('frontend.partials.menu-ajax')
    </div>

  </div>
</section>

<link rel="stylesheet" href="{{ asset('css/menu.css') }}">
<script src="{{ asset('js/menu.js') }}"></script>
