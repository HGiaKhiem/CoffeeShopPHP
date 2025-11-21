@extends('admin.layouts.app')

@section('title', 'Thêm loại món')

@section('content')
    <h3 class="coffee-title mb-3">Thêm loại món</h3>

    <form action="{{ route('admin.loaimon.store') }}" method="POST" class="card coffee-card p-3 shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên loại món</label>
            <input type="text" name="TenLoaiMon" class="form-control" value="{{ old('TenLoaiMon') }}" required>
            @error('TenLoaiMon')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <x-button type="submit" variant="primary" size="sm" class="btn-coffee">Lưu</x-button>

        <x-button href="{{ route('admin.loaimon.index') }}" 
            variant="outline" size="sm" 
            class="btn-coffee">Hủy</x-button>
    </form>
@endsection
