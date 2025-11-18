@extends('admin.layouts.app')

@section('title', 'Chi tiết khách hàng')

@section('content')
    <h3 class="coffee-title mb-3">Khách hàng: {{ $kh->TenKH }}</h3>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card coffee-card shadow-sm">
                <div class="card-body">
                    <p class="mb-1"><strong>ID:</strong> {{ $kh->ID_KhachHang }}</p>
                    <p class="mb-1"><strong>SĐT:</strong> {{ $kh->SDT }}</p>
                    <p class="mb-1"><strong>Ngày tạo:</strong> {{ $kh->NgayTao?->format('d/m/Y') }}</p>
                    <p class="mb-1"><strong>Điểm tích luỹ:</strong> {{ $kh->DiemTichLuy ?? 0 }}</p>
                    <hr>
                    <p class="mb-1"><strong>Số đơn đã đặt:</strong> {{ $kh->don_hangs_count }}</p>
                    <p class="mb-1"><strong>Tổng tiền:</strong>
                        {{ number_format($kh->tong_tien ?? 0, 0, ',', '.') }} đ
                    </p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="coffee-title mb-2">Đơn hàng gần đây</h5>

    <div class="card coffee-card shadow-sm">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($kh->donHangs as $dh)
                    <tr>
                        <td>{{ $dh->ID_DonHang }}</td>
                        <td>{{ $dh->ThoiGian?->format('d/m/Y H:i') }}</td>
                        <td>{{ $dh->TrangThai }}</td>
                        <td>{{ number_format($dh->TongTien, 0, ',', '.') }} đ</td>
                        <td>
                            <x-button href="{{ route('admin.donhang.show', $dh->ID_DonHang) }}" variant="outline" size="sm">Xem đơn</x-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-3">Khách này chưa có đơn hàng.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <x-button href="{{ route('admin.khachhang.index') }}" variant="secondary" class="mt-3">← Quay lại danh sách</x-button>
@endsection
