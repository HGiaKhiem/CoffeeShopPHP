@extends('admin.layouts.app')

@section('title', 'Loại món')

@section('content')
    {{-- Tiêu đề + nút thêm --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <h2 class="coffee-title mb-0">Loại món</h2>
        <x-button href="{{ route('admin.loaimon.create') }}" variant="primary" size="sm">
            + Thêm loại món
        </x-button>
    </div>

    @if(session('success'))
        <div class="alert alert-success py-2 px-3 mb-3">{{ session('success') }}</div>
    @endif

    {{-- Bảng loại món --}}
    <div class="coffee-card shadow-sm">
        <div class="p-0 table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên loại món</th>
                    <th width="150" class="text-center">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @forelse($loais as $loai)
                    <tr>
                        <td>{{ $loai->ID_LoaiMon }}</td>
                        <td>{{ $loai->TenLoaiMon }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <x-button href="{{ route('admin.loaimon.edit', $loai->ID_LoaiMon) }}"
                                          variant="outline" size="sm">
                                    Sửa
                                </x-button>

                                <form action="{{ route('admin.loaimon.destroy', $loai->ID_LoaiMon) }}"
                                      method="POST"
                                      onsubmit="return confirm('Xoá loại món này?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="sm">
                                        Xoá
                                    </x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-3">Chưa có loại món nào.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

        <div class="mt-3">
            {{ $loais->withQueryString()->links() }}
        </div>
@endsection
