@extends('admin.layouts.app')

@section('title', 'Khách hàng')

@section('content')
    {{-- Tiêu đề --}}
    <h2 class="coffee-title mb-4">Khách hàng</h2>

    {{-- Bảng khách hàng --}}
    <div class="coffee-card shadow-sm">
        <div class="p-0 table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên khách</th>
                    <th>SĐT</th>
                    <th>Số đơn</th>
                    <th>Tổng tiền</th>
                    <th class="text-center" width="110"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($khachs as $kh)
                    <tr>
                        <td>{{ $kh->ID_KhachHang }}</td>
                        <td>{{ $kh->TenKH }}</td>
                        <td>{{ $kh->SDT }}</td>
                        <td>{{ $kh->don_hangs_count }}</td>
                        <td>{{ number_format($kh->tong_tien ?? 0, 0, ',', '.') }} đ</td>
                        <td class="text-center">
                            <x-button href="{{ route('admin.khachhang.show', $kh->ID_KhachHang) }}"
                                      variant="outline" size="sm">
                                Xem
                            </x-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">
                            Chưa có khách hàng nào.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $khachs->withQueryString()->links() }}
    </div>
@endsection
