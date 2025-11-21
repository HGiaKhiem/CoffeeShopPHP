@extends('frontend.layouts.master')

@section('title', 'Hồ sơ khách hàng')

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</style>

@section('content')
<div class="profile-wrapper">


    {{-- HEADER --}}
    <div class="text-center mb-4">
        <h2 class="profile-title"><i class="fas fa-user-circle mr-2"></i> Hồ sơ khách hàng</h2>
        <p class="text-muted">{{ auth()->user()->email }}</p>
    </div>
    

    {{-- PROFILE FORM --}}
    <div class="profile-card">
          <div class="mb-4">
            <a href="{{ route('home') }}" class="btn-history">
                <i class="fas fa-arrow-left"></i> Quay lại trang chủ            </a>
        </div>
        <h4 class="section-title"><i class="fas fa-id-card mr-2"></i>Thông tin tài khoản</h4>

        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- CHANGE PASSWORD --}}
    <div class="profile-card">
        <h4 class="section-title"><i class="fas fa-key mr-2"></i>Đổi mật khẩu</h4>

        @include('profile.partials.update-password-form')
    </div>

    {{-- ORDER HISTORY --}}
    <div class="profile-card text-center">
        <h4 class="section-title"><i class="fas fa-receipt mr-2"></i>Lịch sử mua hàng</h4>

        <a href="{{ route('history') }}" class="btn history-btn px-4 py-2">
            <i class="fas fa-history mr-1"></i> Xem lịch sử mua hàng
        </a>
    </div>
    {{-- DELETE ACCOUNT --}}
    <div class="profile-card">
        <h4 class="section-title text-danger"><i class="fas fa-trash-alt mr-2"></i>Xóa tài khoản</h4>

        @include('profile.partials.delete-user-form')
    </div>

    {{-- BACK --}}
    <div class="text-center mt-3">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Quay lại trang chủ
        </a>
    </div>

</div>


<script src="{{ asset('js/profile.js') }}"></script>
@endsection
