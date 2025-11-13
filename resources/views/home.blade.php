<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>KOPPEE - Coffee Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    {{-- Navbar --}}
    @include('frontend.partials.navbar')

    {{-- Carousel --}}
    <div class="container-fluid p-0 mb-5">
        <div id="blog-carousel" class="carousel slide overlay-bottom" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('img/carousel-1.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <h2 class="text-primary font-weight-medium m-0">We Have Been Serving</h2>
                        <h1 class="display-1 text-white m-0">COFFEE</h1>
                        <h2 class="text-white m-0">* SINCE 1950 *</h2>

                        {{-- Nút hiển thị tuỳ trạng thái đăng nhập --}}
                        <!-- @guest
                            <a href="{{ route('login') }}" class="btn btn-primary mt-3 px-4 py-2">
                                <i class="fa fa-sign-in-alt mr-1"></i> Đăng nhập ngay
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light mt-3 px-4 py-2">
                                <i class="fa fa-user-plus mr-1"></i> Đăng ký ngay
                            </a>
                        @endguest

                        @auth
                            <a href="{{ route('profile.edit') }}" class="btn btn-success mt-3 px-4 py-2">
                                <i class="fa fa-user mr-1"></i> Trang cá nhân
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button class="btn btn-danger px-4 py-2">
                                    <i class="fa fa-sign-out-alt mr-1"></i> Đăng xuất
                                </button>
                            </form>
                        @endauth -->
                    </div>
                </div>

                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('img/carousel-2.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <h2 class="text-primary font-weight-medium m-0">We Have Been Serving</h2>
                        <h1 class="display-1 text-white m-0">COFFEE</h1>
                        <h2 class="text-white m-0">* SINCE 1950 *</h2>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#blog-carousel" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#blog-carousel" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>

    {{-- About --}}
    <section id="about">
        @include('frontend.partials.about')
    </section>

    {{-- Services --}}
    <section id="services">
        @include('frontend.partials.services')
    </section>

    {{-- Offer --}}
    <section id="offer">
        @include('frontend.partials.offer')
    </section>

    {{-- Menu --}}
    <section id="menu">
        @include('frontend.partials.menu')
    </section>

    {{-- Reservation --}}
    <section id="reservation">
        @include('frontend.partials.reservation')
    </section>

    {{-- Testimonial --}}
    <section id="testimonial">
        @include('frontend.partials.testimonial')
    </section>

    {{-- Footer --}}
    @include('frontend.partials.footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
        <i class="fa fa-angle-double-up"></i>
    </a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Contact Javascript -->
    <script src="{{ asset('mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>

    {{-- Cuộn mượt khi click navbar --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll('.scroll-link');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    const targetId = this.getAttribute('href').substring(1);
                    const section = document.getElementById(targetId);

                    if (section) {
                        e.preventDefault();
                        const yOffset = -70; // trừ chiều cao navbar
                        const y = section.getBoundingClientRect().top + window.pageYOffset + yOffset;

                        window.scrollTo({
                            top: y,
                            behavior: 'smooth'
                        });
                    } else {
                        // nếu ở trang khác thì quay về home
                        e.preventDefault();
                        window.location.href = '/#' + targetId;
                    }
                });
            });

            // nếu truy cập bằng hash (#about, #services)
            if (window.location.hash) {
                const hash = window.location.hash.substring(1);
                const section = document.getElementById(hash);
                if (section) {
                    setTimeout(() => {
                        const yOffset = -70;
                        const y = section.getBoundingClientRect().top + window.pageYOffset + yOffset;
                        window.scrollTo({ top: y, behavior: 'smooth' });
                    }, 400);
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
