@extends('frontend.layouts.master')

@section('title', 'Lịch sử mua hàng')

@section('content')

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

<div class="container py-5">

    <!-- Tiêu đề -->
    <h2 class="section-title mb-4">
        <i class="fas fa-receipt"></i> Lịch sử mua hàng
    </h2>

    <!-- Nút quay lại -->
    <div class="mb-4">
        <a href="{{ route('profile.edit') }}" class="btn-history">
            <i class="fas fa-arrow-left"></i> Quay lại hồ sơ
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    @endif

    @foreach($orders as $order)
        <div class="profile-card">

            <!-- Header đơn -->
            <h4 class="profile-label mb-2">
                <i class="fas fa-shopping-cart text-warning"></i>
                Mã đơn: #{{ $order->ID_DonHang }}
            </h4>

            <p class="mb-1">
                <b>Ngày mua:</b> {{ $order->ThoiGian }}
            </p>

            <p class="mb-2">
                <b>Trạng thái:</b>
                <span class="badge {{ $order->TrangThai === 'DA_THANH_TOAN' ? 'bg-success' : 'bg-danger' }}">
                    {{ $order->TrangThai }}
                </span>
            </p>

            <!-- Bảng chi tiết -->
            <table class="table table-bordered mt-3">
                <thead class="bg-light">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Size</th>
                        <th>Topping</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th width="260px">Đánh giá</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($order->details as $ct)
                        @php
                            $json = json_decode($ct->TuyChon_JSON, true);
                            $size = $json['size'] ?? '-';
                            $tops = $json['toppings'] ?? [];
                        @endphp

                        <tr>
                            <td>{{ $ct->TenMon }}</td>
                            <td>{{ $size }}</td>

                            <td>
                                @if(!empty($tops))
                                    {{ implode(', ', $tops) }}
                                @else
                                    Không
                                @endif
                            </td>

                            <td>{{ $ct->SoLuong }}</td>

                            <td>{{ number_format($ct->ThanhTien) }} đ</td>
            <!-- Form đánh giá -->
                            <td>
                                @if ($ct->reviewed)
                                        <span class="text-success">✔ Đã đánh giá</span>
                                    @else
                                        <form action="{{ route('review.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_mon" value="{{ $ct->ID_Mon }}">
                                            <input type="hidden" name="id_donhang" value="{{ $order->ID_DonHang }}">

                                            <select name="rating" required class="form-select">
                                                <option value="5">5 ⭐</option>
                                                <option value="4">4 ⭐</option>
                                                <option value="3">3 ⭐</option>
                                                <option value="2">2 ⭐</option>
                                                <option value="1">1 ⭐</option>
                                            </select>

                                            <textarea name="noidung" class="form-control mt-1"
                                                placeholder="Nhận xét"></textarea>

                                            <button class="btn btn-warning btn-sm mt-2">
                                                Gửi đánh giá
                                            </button>
                                        </form>
                                    @endif

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tổng tiền -->
            <div class="text-end mt-3">
                <b>Tổng tiền:</b>
                <span class="text-danger fs-5">{{ number_format($order->TongTien) }} đ</span>
            </div>

        </div>
    @endforeach
</div>

@endsection
