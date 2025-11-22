@extends('frontend.layouts.master')

@section('title', 'Đặt hàng thành công')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/order_success.css') }}">
@endpush

@section('content')

<div class="container order-success-page">

    <div class="order-success-box text-center">

        <h2 class="fw-bold text-success">🎉 Đặt hàng thành công!</h2>

        <p class="mt-3 mb-4">
            Cảm ơn bạn đã mua hàng tại <strong>KOPPEE</strong> ☕<br>
            Mã đơn hàng của bạn:
            <strong class="text-primary">DH{{ $order->ID_DonHang }}</strong>
        </p>

        {{-- HIỆN NÚT XÁC NHẬN THANH TOÁN (BANK) --}}
        @if($order->PhuongThucThanhToan === 'BANK' && $order->TrangThai === 'CHUA_THANH_TOAN')
            <form action="{{ route('cart.confirmPayment', $order->ID_DonHang) }}" method="POST">
                @csrf
                <button class="btn btn-success w-100 mb-3">
                    ✅ Tôi đã chuyển khoản xong
                </button>
            </form>
        @endif

        {{-- NÚT SAU KHI ĐÃ THANH TOÁN --}}
        @if($order->TrangThai === 'DA_THANH_TOAN')
            <div class="alert alert-success fw-bold">
                ✅ Đơn hàng đã được thanh toán!
            </div>
        @endif

        <div class="order-success-buttons d-flex justify-content-center gap-3 mt-4">

            <a href="{{ route('menu') }}" class="btn btn-warning">
                ← Tiếp tục mua hàng
            </a>

            <a href="{{ route('home') }}" class="btn btn-dark">
                Về trang chủ
            </a>
        </div>

    </div>

</div>

@endsection
