@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2 class="coffee-title mb-4">Tổng quan hệ thống</h2>

    {{-- 4 ô thống kê nhanh --}}
    <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
        <div class="col">
            <div class="p-3 coffee-card shadow-sm h-100 d-flex flex-column justify-content-between">
                <h6 class="text-muted mb-2">Tổng số món</h6>
                <h3 class="mb-0 fw-semibold">{{ $soMon }}</h3>
            </div>
        </div>
        <div class="col">
            <div class="p-3 coffee-card shadow-sm h-100 d-flex flex-column justify-content-between">
                <h6 class="text-muted mb-2">Tổng số đơn</h6>
                <h3 class="mb-0 fw-semibold">{{ $soDon }}</h3>
            </div>
        </div>
        <div class="col">
            <div class="p-3 coffee-card shadow-sm h-100 d-flex flex-column justify-content-between">
                <h6 class="text-muted mb-2">Doanh thu (tất cả)</h6>
                <h3 class="mb-0 fw-semibold">{{ number_format($tongDoanhThu, 0, ',', '.') }} đ</h3>
            </div>
        </div>
        <div class="col">
            <div class="p-3 coffee-card shadow-sm h-100 d-flex flex-column justify-content-between">
                <h6 class="text-muted mb-2">Doanh thu hôm nay</h6>
                <h3 class="mb-0 fw-semibold">{{ number_format($doanhThuHomNay, 0, ',', '.') }} đ</h3>
            </div>
        </div>
    </div>

    {{-- Hàng biểu đồ + top món --}}
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="p-3 coffee-card shadow-sm h-100">
                <h6 class="mb-3 fw-semibold">Doanh thu 7 ngày gần nhất</h6>
                <div style="height: 260px;">
                    <canvas id="chartRevenue7"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 coffee-card shadow-sm h-100">
                <h6 class="mb-3 fw-semibold">Top 5 món bán chạy</h6>
                <ul class="list-group list-group-flush">
                    @forelse($topMons as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>{{ $item->mon->TenMon ?? 'Món đã xoá' }}</span>
                            <span class="badge rounded-pill" style="background-color:#2563eb; color:#fff;">
                                {{ $item->tong_sl }} ly
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted px-0">Chưa có dữ liệu.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    {{-- Đơn hàng gần đây --}}
    <div class="row g-4">
        <div class="col-12">
            <div class="p-3 coffee-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-semibold">Đơn hàng gần đây</h6>
                    <x-button href="{{ route('admin.donhang.index') }}" variant="outline" size="sm">
                        Xem tất cả
                    </x-button>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Khách hàng</th>
                            <th>Bàn</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($donGanDay as $dh)
                            <tr>
                                <td>{{ $dh->ID_DonHang }}</td>
                                <td>{{ $dh->khachHang->TenKH ?? 'Khách lẻ' }}</td>
                                <td>{{ $dh->ban->TenBan ?? '-' }}</td>
                                <td>{{ $dh->ThoiGian?->format('d/m/Y H:i') }}</td>
                                <td>{{ $dh->TrangThai }}</td>
                                <td>{{ number_format($dh->TongTien, 0, ',', '.') }} đ</td>
                                <td class="text-end">
                                    <x-button href="{{ route('admin.donhang.show', $dh->ID_DonHang) }}"
                                              variant="outline" size="sm">
                                        Xem
                                    </x-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3">Chưa có đơn hàng nào.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels7 = @json($labels7);
        const data7   = @json($data7);

        const ctx7 = document.getElementById('chartRevenue7').getContext('2d');
        new Chart(ctx7, {
            type: 'line',
            data: {
                labels: labels7,
                datasets: [{
                    label: 'Doanh thu (đ)',
                    data: data7,
                    tension: 0.3,
                    fill: false,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
