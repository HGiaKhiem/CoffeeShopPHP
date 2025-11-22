@extends('frontend.layouts.master')

@section('title', 'Thanh toán')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush

@section('content')

<div class="checkout-page">

    @if(session('success'))
        <div class="alert alert-success text-center mb-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center mb-4 py-3">
            {{ session('error') }}
        </div>
    @endif

<div class="checkout-page">  
<div class="container py-5 checkout-container">

    <h2 class="fw-bold mb-4">Thông tin đặt hàng</h2>

    <div class="row checkout-row">

{{-- FORM --}}
<div class="col-lg-8 col-md-12 mb-4">

    <form action="{{ route('cart.placeOrder') }}" method="POST" id="checkout-form">
        @csrf

        {{-- HỌ TÊN --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Họ và tên</label>
            <input type="text" class="form-control"
                value="{{ $user->name }}"
                disabled>

            {{-- gửi kèm vào form --}}
            <input type="hidden" name="TenKH" value="{{ $user->name }}">
        </div>

        {{-- EMAIL --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Email</label>
            <input type="email" class="form-control"
                value="{{ $user->email }}"
                disabled>

            <input type="hidden" name="Email" value="{{ $user->email }}">
        </div>

        {{-- SỐ ĐIỆN THOẠI --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Số điện thoại nhận hàng</label>
            <input type="text" name="SDT_NhanHang" class="form-control"
                value="{{ old('SDT_NhanHang', $kh->SDT ?? '') }}"
                required>
        </div>

        {{-- ĐỊA CHỈ --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Địa chỉ giao hàng</label>
            <textarea name="DiaChi" class="form-control" rows="2" required>{{ old('DiaChi') }}</textarea>
        </div>

        {{-- PHƯƠNG THỨC THANH TOÁN --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Phương thức thanh toán</label>
            <select name="PhuongThucThanhToan" id="payment-method" class="form-select" required>
                <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                <option value="BANK">Chuyển khoản ngân hàng (QR)</option>
            </select>
        </div>

        {{-- QR PREVIEW --}}
        <div id="qr-preview" class="d-none text-center">
            <h5 class="fw-bold">Quét QR để thanh toán</h5>
            <img id="qr-img" style="max-width:260px; border-radius:10px;">
            <p class="mt-3 mb-0">
                Nội dung chuyển khoản:
                <strong id="qr-note">PREVIEW</strong>
            </p>
        </div>

        {{-- GHI CHÚ --}}
        <div class="mb-3 mt-4">
            <label class="form-label fw-bold">Ghi chú</label>
            <textarea name="GhiChu" class="form-control" rows="2"></textarea>
        </div>

        {{-- BUTTONS --}}
        <button type="submit" class="btn btn-success w-100 btn-checkout mt-3">
            ✅ Xác nhận đặt hàng
        </button>

        <a href="{{ route('cart') }}" class="btn btn-dark w-100 btn-checkout mt-3">
            ← Quay lại giỏ hàng
        </a>
    </form>

</div>


        {{-- SUMMARY --}}
        <div class="col-lg-4 col-md-12 checkout-summary">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">
                    Tóm tắt đơn hàng
                </div>

                <ul class="list-group list-group-flush">
                    @php $total = 0; @endphp

                    @foreach($cart as $item)
                        @php $line = $item['price'] * $item['quantity']; $total += $line; @endphp

                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <strong>{{ $item['name'] }}</strong>
                                <div class="small text-muted">x {{ $item['quantity'] }}</div>
                            </div>

                            <span class="fw-bold text-danger">
                                {{ number_format($line) }} đ
                            </span>
                        </li>
                    @endforeach

                    <li class="list-group-item bg-light d-flex justify-content-between fw-bold">
                        <span>Tổng cộng</span>
                        <span class="text-danger">{{ number_format($total) }} đ</span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
const totalAmount = @json($total);

document.getElementById('payment-method').addEventListener('change', function () {
    const qrBox = document.getElementById('qr-preview');
    const qrImg = document.getElementById('qr-img');
    const qrNote = document.getElementById('qr-note');

    if (this.value === 'BANK') {
        qrBox.classList.remove('d-none');

        const bankId = "VCB";
        const accountNumber = "103032294";
        const accountName = "LUONG QUOC HUY";
        const note = "DH{{ $lastOrderId ?? 'PREVIEW' }}";

        qrNote.textContent = note;

        qrImg.src =
            `https://img.vietqr.io/image/${bankId}-${accountNumber}-compact.jpg` +
            `?amount=${totalAmount}` +
            `&addInfo=${note}` +
            `&accountName=${encodeURIComponent(accountName)}`;

    } else {
        qrBox.classList.add('d-none');
    }
});
</script>
@endpush
