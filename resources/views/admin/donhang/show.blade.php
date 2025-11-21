@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <h3 class="coffee-title mb-3">
        Đơn #{{ $donHang->ID_DonHang }}
    </h3>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card coffee-card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Thông tin chung</h6>
                    <p class="mb-1"><strong>Khách hàng:</strong> {{ $donHang->khachHang->TenKH ?? 'Khách lẻ' }}</p>
                    <p class="mb-1"><strong>SĐT:</strong> {{ $donHang->khachHang->SDT ?? '-' }}</p>
                    <p class="mb-1"><strong>Bàn:</strong> {{ $donHang->ban->TenBan ?? '-' }}</p>
                    <p class="mb-1"><strong>Thời gian:</strong> {{ $donHang->ThoiGian?->format('d/m/Y H:i') }}</p>
                    <p class="mb-1">
                        <strong>Trạng thái:</strong>
                        @if($donHang->TrangThai === 'DA_THANH_TOAN')
                            <span class="badge text-bg-success">Đã thanh toán</span>
                        @elseif($donHang->TrangThai === 'CHUA_THANH_TOAN')
                            <span class="badge text-bg-warning">Chưa thanh toán</span>
                        @elseif($donHang->TrangThai === 'HUY_DON')
                            <span class="badge text-bg-secondary">Hủy đơn</span>
                        @else
                            <span class="badge text-bg-light">{{ $donHang->TrangThai }}</span>
                        @endif
                    </p>
                    <p class="mb-1"><strong>Ghi chú:</strong> {{ $donHang->GhiChu ?? '-' }}</p>
                    <p class="mt-2 mb-0">
                        <strong>Tổng tiền:</strong>
                        <span class="fs-5">
                            {{ number_format($donHang->TongTien, 0, ',', '.') }} đ
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="coffee-title mb-2">Chi tiết món</h5>

    <div class="card coffee-card shadow-sm">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Món</th>
                    <th>Số lượng</th>
                    <th>Giá bán</th>
                    <th>Thành tiền</th>
                    <th>Tuỳ chọn</th>
                </tr>
                </thead>
                <tbody>
                @foreach($donHang->chiTiet as $i => $ct)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $ct->mon->TenMon ?? 'Món đã xóa' }}</td>
                        <td>{{ $ct->SoLuong }}</td>
                        <td>{{ number_format($ct->GiaBan, 0, ',', '.') }} đ</td>
                        <td>{{ number_format($ct->ThanhTien, 0, ',', '.') }} đ</td>
                        <td>
                            @php
                            // Nếu lưu dạng JSON string thì decode về array
                            $opts = $ct->TuyChon_JSON ?? [];
                            if (is_string($opts)) {
                                $opts = json_decode($opts, true) ?? [];
                            }
                        @endphp

                        @if(is_array($opts) && count($opts))
                            <ul class="mb-0 small">
                                @foreach($opts as $k => $v)
                                    @php
                                        // Nếu value là mảng (vd: nhiều topping) thì nối lại bằng dấu phẩy
                                        $val = is_array($v) ? implode(', ', $v) : $v;
                                    @endphp
                                    <li>{{ $k }}: {{ $val }}</li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif

                        </td>
                    </tr>
                @endforeach
                @if($donHang->chiTiet->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-3">Chưa có chi tiết món.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <x-button href="{{ route('admin.donhang.index') }}" variant="secondary" class="mt-3">← Quay lại danh sách</x-button>
@endsection

