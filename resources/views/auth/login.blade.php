<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - KOPPEE Coffee Shop</title>

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f1ee url("{{ asset('img/bg-coffee.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            font-family: "Roboto", sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            max-width: 420px;
            margin: 80px auto;
        }
        .login-card h2 {
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
    <div class="login-card">
        <h2><i class="fas fa-coffee mr-2"></i>Đăng nhập</h2>

        <!-- Hiển thị thông báo lỗi -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Hiển thị thông báo trạng thái (nếu có) -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Địa chỉ Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required autofocus placeholder="Nhập email của bạn">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Nhập mật khẩu">
            </div>

            <div class="form-group form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>

            @if (Route::has('register'))
                <p class="text-center mt-3">
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}" class="text-primary font-weight-bold">Đăng ký ngay</a>
                </p>
            @endif

            @if (Route::has('password.request'))
                <p class="text-center">
                    <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                </p>
            @endif

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
