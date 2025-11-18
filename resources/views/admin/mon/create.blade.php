@extends('admin.layouts.app')

@section('title', 'Thêm món')

@section('content')
    <h3 class="coffee-title mb-3">Thêm món mới</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card coffee-card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.mon.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Tên món</label>
                    <input type="text" name="TenMon" class="form-control"
                           value="{{ old('TenMon') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại món</label>
                    <select name="ID_LoaiMon" class="form-select" required>
                        <option value="">-- Chọn loại --</option>
                        @foreach($loaiMons as $loai)
                            <option value="{{ $loai->ID_LoaiMon }}"
                                {{ old('ID_LoaiMon') == $loai->ID_LoaiMon ? 'selected' : '' }}>
                                {{ $loai->TenLoaiMon }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="Gia" class="form-control" min="0"
                           value="{{ old('Gia') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="MoTa" class="form-control" rows="3">{{ old('MoTa') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="TrangThai" class="form-select">
                        <option value="1" {{ old('TrangThai', 1) == 1 ? 'selected' : '' }}>Đang bán</option>
                        <option value="0" {{ old('TrangThai') == 0 ? 'selected' : '' }}>Ngưng bán</option>
                    </select>
                </div>

                <x-button type="submit" variant="primary">Lưu</x-button>
                <x-button href="{{ route('admin.mon.index') }}" variant="secondary">Quay lại</x-button>
            </form>
        </div>
    </div>
@endsection
