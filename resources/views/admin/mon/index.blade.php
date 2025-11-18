@extends('admin.layouts.app')

@section('title', 'Quản lý món')

@section('content')
    {{-- Tiêu đề + nút thêm --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <h2 class="coffee-title mb-0">Quản lý món</h2>
        <x-button href="{{ route('admin.mon.create') }}" variant="primary" size="sm">
            + Thêm món
        </x-button>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 px-3 mb-3">{{ session('success') }}</div>
    @endif

    {{-- Form tìm kiếm --}}
    <form method="GET" class="row g-2 align-items-center mb-3">
        <div class="col-12 col-sm-4 col-md-3">
            <input type="text"
                   name="q"
                   value="{{ $search }}"
                   class="form-control form-control-sm"
                   placeholder="Tìm theo tên món...">
        </div>
        <div class="col-auto">
            <x-button type="submit" variant="outline" size="sm">Tìm kiếm</x-button>
        </div>
    </form>

    {{-- Bảng món --}}
    <div class="coffee-card shadow-sm">
        <div class="p-0 table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên món</th>
                    <th>Loại</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th width="150" class="text-center">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @forelse($mons as $mon)
                    <tr>
                        <td>{{ $mon->ID_Mon }}</td>
                        <td>{{ $mon->TenMon }}</td>
                        <td>{{ $mon->loaiMon->TenLoaiMon ?? '' }}</td>
                        <td>{{ number_format($mon->Gia, 0, ',', '.') }} đ</td>
                        <td>
                            @if($mon->TrangThai)
                                <span class="badge text-bg-success">Đang bán</span>
                            @else
                                <span class="badge text-bg-secondary">Ngưng</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <x-button href="{{ route('admin.mon.edit', $mon->ID_Mon) }}"
                                          variant="warning" size="sm">
                                    Sửa
                                </x-button>

                                <form action="{{ route('admin.mon.destroy', $mon->ID_Mon) }}"
                                      method="POST"
                                      onsubmit="return confirm('Xóa món này?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="sm">
                                        Xóa
                                    </x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">Chưa có món nào</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $mons->withQueryString()->links() }}
    </div>
@endsection
