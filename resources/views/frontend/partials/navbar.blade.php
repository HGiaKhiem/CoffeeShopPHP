<div class="container-fluid p-0 nav-bar">
    <nav class="navbar navbar-expand-lg navbar-dark 
        {{ request()->routeIs('home') ? 'bg-none position-absolute w-100' : 'bg-dark shadow-sm' }} 
        py-3">

        <a href="{{ route('home') }}" class="navbar-brand px-lg-4 m-0">
            <h1 class="m-0 display-4 text-uppercase text-white">KOPPEE</h1>
        </a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav ml-auto p-4">

                <a href="{{ route('home') }}" 
                   class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>

                <a href="#about" class="nav-item nav-link scroll-link">About</a>
                <a href="#services" class="nav-item nav-link scroll-link">Services</a>

                <a href="{{ route('menu') }}" 
                   class="nav-item nav-link {{ request()->is('menu') ? 'active' : '' }}">
                    Menu
                </a>

                {{-- ACCOUNT --}}
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Account</a>
                    <div class="dropdown-menu text-capitalize">
                        @guest
                            <a href="{{ route('login') }}" class="dropdown-item">
                                <i class="fa fa-sign-in-alt mr-1"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="dropdown-item">
                                <i class="fa fa-user-plus mr-1"></i> Register
                            </a>
                        @endguest

                        @auth
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="fa fa-user mr-1"></i> Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa fa-sign-out-alt mr-1"></i> Logout
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>

                {{-- CART --}}
                <a href="{{ route('cart') }}" 
                   class="nav-item nav-link {{ request()->routeIs('cart') ? 'active' : '' }}">
                    Giỏ hàng
                </a>

            </div>
        </div>
    </nav>
</div>


{{-- Script cuộn mượt --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const links = document.querySelectorAll('.scroll-link');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href').substring(1);
            const section = document.getElementById(targetId);

            if (section) {
                e.preventDefault();
                const yOffset = -70;
                const y = section.getBoundingClientRect().top + window.pageYOffset + yOffset;

                window.scrollTo({ top: y, behavior: 'smooth' });
            } else {
                e.preventDefault();
                window.location.href = '/#' + targetId;
            }
        });
    });

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
