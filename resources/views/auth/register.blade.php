<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - KOPPEE Coffee Shop</title>

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f1ee url("{{ asset('img/bg-coffee.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            font-family: "Roboto", sans-serif;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            max-width: 450px;
            margin: 80px auto;
        }
        .register-card h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4b2c20;
            font-weight: 700;
        }
        .btn-primary {
            background-color: #6f4e37;
            border: none;
        }
        .btn-primary:hover {
            background-color: #5a3f2c;
        }
        .back-btn {
            display: inline-block;
            margin-top: 10px;
            color: #6f4e37;
            text-decoration: none;
            font-weight: 500;
        }
        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-card">
        <h2><i class="fas fa-user-plus mr-2"></i>Tạo tài khoản</h2>

        <!-- Hiển thị lỗi -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Họ và tên -->
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-control" placeholder="Nhập họ tên của bạn">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Địa chỉ Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control" placeholder="Nhập email của bạn">
            </div>

            <!-- Mật khẩu -->
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input id="password" type="password" name="password" required class="form-control" placeholder="Nhập mật khẩu">
            </div>

            <!-- Xác nhận mật khẩu -->
            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control" placeholder="Nhập lại mật khẩu">
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-user-plus mr-1"></i> Đăng ký
            </button>

            <p class="text-center mt-3">
                Đã có tài khoản?
                <a href="{{ route('login') }}" class="text-primary font-weight-bold">Đăng nhập ngay</a>
            </p>

            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="back-btn">
                    <i class="fas fa-arrow-left mr-1"></i> Quay lại trang chủ
                </a>
            </div>
        </form>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
