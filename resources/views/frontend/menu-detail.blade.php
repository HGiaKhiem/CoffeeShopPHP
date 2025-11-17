@extends('frontend.layouts.master')

@section('title', $mon->TenMon . ' - Chi tiết món')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/menu_detail.css') }}">
@endpush

@section('content')

@php
use Illuminate\Support\Str;

$fallback = asset('img/menu-1.jpg');

$imagePath = 'Mon_images/' 
        . Str::slug($mon->loaiMon->TenLoaiMon ?? '', '') 
        . '/' 
        . Str::slug($mon->TenMon, '') 
        . '.jpg';
@endphp

<section class="menu-detail page-detail py-5">

    <div class="container">

        {{-- Breadcrumb --}}
        <div class="mb-3 breadcrumb-text">
            <a href="{{ route('home') }}">Home</a> /
            <a href="{{ route('menu') }}">Menu</a> /
            <span class="text-coffee font-weight-bold">{{ $mon->TenMon }}</span>
        </div>

        <div class="row align-items-start">

            {{-- Ảnh --}}
            <div class="col-md-5 mb-4">
                <div class="menu-image-wrapper">
                    <img 
                        src="{{ asset($imagePath) }}"
                        onerror="this.onerror=null;this.src='{{ $fallback }}';"
                        alt="{{ $mon->TenMon }}"
                    >
                </div>
            </div>

            {{-- Nội dung --}}
            <div class="col-md-7">

                <h1 class="fw-bold text-coffee mb-3">{{ $mon->TenMon }}</h1>

                <p class="text-muted mb-2">
                    Loại: <strong>{{ $mon->loaiMon->TenLoaiMon ?? '---' }}</strong>
                </p>

                {{-- Giá hiển thị --}}
                <h3 id="final-price" class="fw-bold text-primary mb-3">
                    {{ number_format($mon->Gia, 0, ',', '.') }} đ
                </h3>

                {{-- Mô tả --}}
                <p class="mb-4">{{ $mon->MoTa ?? 'Không có mô tả cho món này.' }}</p>

                {{-- FORM GIỎ HÀNG --}}
                <form action="{{ route('cart.add', $mon->ID_Mon) }}" method="POST">
                    @csrf

                    {{-- SIZE --}}
                    <div class="mb-4">
                        <label class="font-weight-bold">Size:</label>
                        <select name="size" id="select-size" class="form-control" style="max-width:170px;">
                            @foreach ($sizes as $size)
                                <option 
                                    value="{{ $size->ID_Size }}"
                                    data-price="{{ $size->GiaTang + 0 }}"
                                >
                                    {{ $size->TenSize }} (+{{ number_format($size->GiaTang, 0, ',', '.') }} đ)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TOPPING --}}
                    <div class="mb-4">
                        <label class="font-weight-bold">Topping:</label>

                        <div class="topping-list mt-2">
                            @foreach ($toppings as $tp)
                                <div class="form-check">
                                    <input 
                                        type="checkbox"
                                        name="toppings[]"
                                        class="form-check-input topping-check"
                                        value="{{ $tp->ID_Topping }}"
                                        data-price="{{ $tp->GiaTang + 0 }}"
                                        id="tp{{ $tp->ID_Topping }}">

                                    <label class="form-check-label" for="tp{{ $tp->ID_Topping }}">
                                        {{ $tp->TenTopping }} (+{{ number_format($tp->GiaTang, 0, ',', '.') }} đ)
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SỐ LƯỢNG --}}
                    <div class="d-flex align-items-center mb-4">
                        <label class="font-weight-bold mb-0 mr-3">Số lượng:</label>
                        <input id="quantity" type="number" name="quantity"
                               value="1" min="1"
                               class="form-control"
                               style="max-width:90px;">
                    </div>

                    {{-- NÚT --}}
                    <button class="btn btn-primary btn-lg px-4 py-2">
                        <i class="fa fa-shopping-cart me-2"></i>
                        Thêm vào giỏ hàng
                    </button>

                </form>
            </div>
        </div>
    </div>

</section>

{{-- SCRIPT TÍNH TIỀN --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    var basePrice = Number({!! json_encode($mon->Gia) !!});
    var sizeSelect = document.getElementById("select-size");
    var toppingCheckboxes = document.querySelectorAll(".topping-check");
    var qtyInput = document.getElementById("quantity");
    var priceLabel = document.getElementById("final-price");

    function calcTotal() {
        let total = basePrice;

        // size
        let opt = sizeSelect.options[sizeSelect.selectedIndex];
        total += parseInt(opt.dataset.price) || 0;

        // topping
        toppingCheckboxes.forEach(tp => {
            if (tp.checked) {
                total += parseInt(tp.dataset.price) || 0;
            }
        });

        // quantity
        let qty = parseInt(qtyInput.value) || 1;
        total *= qty;

        priceLabel.textContent = total.toLocaleString("vi-VN") + " đ";
    }

    sizeSelect.addEventListener("change", calcTotal);
    qtyInput.addEventListener("input", calcTotal);
    toppingCheckboxes.forEach(tp => tp.addEventListener("change", calcTotal));

    calcTotal();
});
</script>
@endpush

@endsection
