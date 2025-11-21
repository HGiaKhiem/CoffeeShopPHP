@extends('admin.layouts.app')

@section('title', 'Đơn hàng')

@section('content')
    {{-- Tiêu đề --}}
    <h2 class="coffee-title mb-4">Danh sách đơn hàng</h2>

    {{-- Bộ lọc --}}
    <form method="GET" class="row g-2 align-items-end mb-3">
        <div class="col-12 col-sm-4 col-md-3">
            <label class="form-label mb-1 small">Trạng thái</label>
            <select name="trang_thai" class="form-select form-select-sm">
                <option value="">-- Tất cả --</option>
                <option value="CHUA_THANH_TOAN" {{ $st === 'CHUA_THANH_TOAN' ? 'selected' : '' }}>
                    Chưa thanh toán
                </option>
                <option value="DA_THANH_TOAN" {{ $st === 'DA_THANH_TOAN' ? 'selected' : '' }}>
                    Đã thanh toán
                </option>
                <option value="HUY_DON" {{ $st === 'HUY_DON' ? 'selected' : '' }}>
                    Hủy đơn
                </option>
            </select>
        </div>

        <div class="col-12 col-sm-4 col-md-3">
            <label class="form-label mb-1 small">Ngày</label>
            <input type="date"
                   name="ngay"
                   value="{{ $ngay }}"
                   class="form-control form-control-sm">
        </div>

        <div class="col-auto">
            <x-button type="submit" variant="outline" size="sm" class="mt-2 mt-sm-0">
                Lọc
            </x-button>
        </div>
    </form>

    {{-- Bảng đơn hàng --}}
    <div class="coffee-card shadow-sm">
        <div class="p-0 table-responsive">
            <table class="table mb-0 table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>Bàn</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th width="120" class="text-center">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @forelse($donHangs as $dh)
                    <tr>
                        <td>{{ $dh->ID_DonHang }}</td>
                        <td>{{ $dh->khachHang->TenKH ?? 'Khách lẻ' }}</td>
                        <td>{{ $dh->ban->TenBan ?? '-' }}</td>
                        <td>{{ $dh->ThoiGian?->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($dh->TrangThai === 'DA_THANH_TOAN')
                                <span class="badge text-bg-success">Đã thanh toán</span>
                            @elseif($dh->TrangThai === 'CHUA_THANH_TOAN')
                                <span class="badge text-bg-warning">Chưa thanh toán</span>
                            @elseif($dh->TrangThai === 'HUY_DON')
                                <span class="badge text-bg-secondary">Hủy đơn</span>
                            @else
                                <span class="badge text-bg-light">{{ $dh->TrangThai }}</span>
                            @endif
                        </td>
                        <td>{{ number_format($dh->TongTien, 0, ',', '.') }} đ</td>
                        <td class="text-center">
                            <x-button href="{{ route('admin.donhang.show', $dh->ID_DonHang) }}"
                                      variant="outline" size="sm">
                                Xem
                            </x-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-3">
                            Chưa có đơn hàng nào.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $donHangs->withQueryString()->links() }}
    </div>
@endsection
