@extends('frontend.layouts.master')

@section('title', 'Thanh toán QR')

@section('content')
<div class="container py-5 text-center">

    <h2 class="fw-bold mb-4">Thanh toán đơn {{ $maDon }}</h2>

    <img src="{{ $qrUrl }}" class="img-fluid mb-4" width="320">

    <h4 class="text-success fw-bold mb-3">
        {{ number_format($don->TongTien) }} đ
    </h4>

    <p>Vui lòng ghi nội dung chuyển khoản: <strong>{{ $maDon }}</strong></p>

    <a href="{{ route('menu') }}" class="btn btn-primary mt-4">
        ✅ Hoàn tất
    </a>

</div>
@endsection
