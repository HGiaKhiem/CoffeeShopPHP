<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coffee Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-buttons.css') }}">

    <style>
        body {
            background-color: #F5EFE6; /* light warm beige */
            font-family: 'Poppins', sans-serif;
            color: #2b2b2b;
        }

        /* Navbar */
        .navbar {
            background-color: #4B2E2A; /* dark brown */
        }
        .navbar-brand,
        .navbar-text,
        .navbar a {
            color: #F7F1E8 !important; /* light text */
        }

        /* Layout */
        .layout-wrapper {
            display: flex;
            min-height: calc(100vh - 56px); /* trừ chiều cao navbar */
        }

        /* Sidebar */
        .sidebar {
            width: 230px;
            background-color: #D8BFAA; /* warm light brown */
            padding-top: 15px;
            flex-shrink: 0;
        }
        .sidebar a {
            display: block;
            padding: 10px 18px;
            color: #3C2F2F;
            text-decoration: none;
            font-weight: 500;
        }
        .sidebar a:hover {
            background-color: #BFA283;
            color: #fff;
            border-radius: 8px;
        }
        .sidebar a.active {
            background-color: #4B2E2A;
            color: #fff;
            border-radius: 0 16px 16px 0;
            font-weight: 600;
        }

        /* Content */
        .content {
            flex: 1;
            padding: 30px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Card chung */
        .coffee-card {
            background-color: #fff;
            border-radius: 12px;
            border-left: 5px solid #BFA283; /* accent light brown */
        }
        .coffee-title {
            color: #4B2E2A;
            font-weight: 600;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/admin-buttons.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-lg px-3">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
        <strong>Coffee Admin ☕</strong>
    </a>

    <div class="ms-auto d-flex align-items-center gap-3">
        {{-- Hiển thị tên người dùng nếu đã đăng nhập --}}
        @if(auth()->check())
            <span class="navbar-text">
                Xin chào, {{ auth()->user()->name }}
                @if(!empty(auth()->user()->role))
                    ({{ auth()->user()->role }})
                @endif
            </span>
        @else
            <span class="navbar-text">
                Xin chào, Admin
            </span>
        @endif

        {{-- Dropdown tài khoản --}}
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-light dropdown-toggle"
                    type="button"
                    id="dropdownUserMenu"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                Tài khoản
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUserMenu">
                @if(auth()->check())
                    <li class="dropdown-header small text-muted px-3">
                        {{ auth()->user()->email }}
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            Thông tin cá nhân
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="px-3 py-1 m-0">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 text-danger">
                                Đăng xuất
                            </button>
                        </form>
                    </li>
                @else
                    <li>
                        <a class="dropdown-item" href="{{ route('login') }}">
                            Đăng nhập
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="layout-wrapper">
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('admin.loaimon.index') }}"
           class="{{ request()->routeIs('admin.loaimon.*') ? 'active' : '' }}">
            Loại món
        </a>

        <a href="{{ route('admin.mon.index') }}"
           class="{{ request()->routeIs('admin.mon.*') ? 'active' : '' }}">
            Quản lý món
        </a>

        <a href="{{ route('admin.donhang.index') }}"
           class="{{ request()->routeIs('admin.donhang.*') ? 'active' : '' }}">
            Đơn hàng
        </a>

        <a href="{{ route('admin.khachhang.index') }}"
           class="{{ request()->routeIs('admin.khachhang.*') ? 'active' : '' }}">
            Khách hàng
        </a>

        {{-- Sau này thêm POS, v.v… --}}
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>

@yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<style>
    /* Thu nhỏ và làm đẹp pagination */
    .pagination {
        justify-content: center;
        margin-top: 20px;
    }
    .pagination .page-link {
        padding: 4px 10px;
        font-size: 13px;
        border-radius: 6px;
        color: #4B2E2A;
        border: 1px solid #d1c5b6;
    }
    .pagination .page-link:hover {
        background-color: #BFA283;
        color: white;
    }
    .pagination .active .page-link {
        background-color: #4B2E2A;
        border-color: #4B2E2A;
        color: white;
    }
</style>
