<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Eshop') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

         <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('theme/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('theme/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('theme/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('theme/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('theme/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('theme/remixicon/remixicon.css') }}" rel="stylesheet">
        <link href="{{ asset('theme/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/card.css') }}" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top ">
            <div class="container d-flex align-items-center justify-content-lg-between">

            <h1 class="logo me-auto me-lg-0"><a href="/">{{ config('app.name', 'E-shop') }}<span>.</span></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#about">About</a></li>
                    <li><a class="nav-link scrollto" href="#services">Services</a></li>
                    <li><a class="nav-link scrollto " href="#portfolio">Portfolio</a></li>
                    <li><a class="nav-link scrollto" href="#team">Team</a></li>
                    @role('Admin')
                    <li class="dropdown"><a href="#" class="text-decoration-none"><span>Admin</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="{{ route('admin.index') }}">Admin Panel</a></li>
                            <li><a href="{{ route('admin.messages.index') }}">Upozornenia</a></li>
                            <li><a href="{{ route('admin.calendar') }}">Kalendár</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                 {{ __('Odhlásiť sa') }}
                                </a>
    
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endrole
                    @guest
                    <li class="dropdown ">
                        <a href="#" class="text-decoration-none"><span>Možnosti</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="{{ route('login') }}">Prihlásiť sa</a></li>
                            <li><a href="{{ route('register') }}">Registrovať sa sa</a></li> 
                        </ul>
                    </li>
                    @endguest
                    @auth
                    <li class="dropdown">
                        <a href="#" class="text-decoration-none"><span>Možnosti</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="{{ route('users.show', auth()->user()->id) }}">{{ auth()->user()->name }}</a></li>
                            <li><a href="{{ route('orders.index') }}">Objednávky</a></li> 
                        </ul>
                    </li>
                    @endauth
                    
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

            
            <a href="#about" class="get-started-btn scrollto">Get Started</a>
            
            {{-- for shopping card --}}
            <a href="{{ route('card.show') }}" class="text-light">
                <i class="bi bi-cart display-6"></i>
                @if (session()->has('items_number'))
                    <span class="position-absolute translate-middle badge rounded-pill bg-danger">
                        {{ session('items_number') }}
                        <span class="visually-hidden">unread messages</span>
                    </span>
                @endif
            </a>
            </div>
        </header><!-- End Header -->

        <!-- ======= Hero Section ======= -->
        <section id="hero" class="d-flex align-items-center justify-content-center" style=" background: url({{ Storage::url('public/img/hero-bg.jpg') }}) top center;">
            {{-- Img for better load time, not waiting on css background --}}
            <img src="{{ Storage::url('public/img/hero-bg.jpg') }}" alt="" style="display: none !important;" width="0" height="0">
            <div class="container" data-aos="fade-up">

            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
                <div class="col-xl-6 col-lg-8">
                <h1>Volupta provident<span>.</span></h1>
                <h2>sed do eiusmod </h2>
                </div>
            </div>

            <div class="row gy-4 mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="250">
                <div class="col-xl-2 col-md-4">
                <div class="icon-box">
                    <i class="ri-store-line"></i>
                    <h3><a href="">Lorem Ipsum</a></h3>
                </div>
                </div>
                <div class="col-xl-2 col-md-4">
                <div class="icon-box">
                    <i class="ri-bar-chart-box-line"></i>
                    <h3><a href="">Dolor Sitema</a></h3>
                </div>
                </div>
                <div class="col-xl-2 col-md-4">
                <div class="icon-box">
                    <i class="ri-calendar-todo-line"></i>
                    <h3><a href="">Sedare Perspiciatis</a></h3>
                </div>
                </div>
                <div class="col-xl-2 col-md-4">
                <div class="icon-box">
                    <i class="ri-paint-brush-line"></i>
                    <h3><a href="">Magni Dolores</a></h3>
                </div>
                </div>
                <div class="col-xl-2 col-md-4">
                <div class="icon-box">
                    <i class="ri-database-2-line"></i>
                    <h3><a href="">Nemos Enimade</a></h3>
                </div>
                </div>
            </div>

            </div>
        </section><!-- End Hero -->
        
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger col-8 m-auto mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                            <div class="alert alert-success col-10 m-auto" id="status" role="alert">
                                {{ session('status') }} 
                            </div>
            @endif

            @if (session()->has('info'))
                <div id="flash-message" class="alert alert-{{ session('type')}} col-8 m-auto mt-3">
                    <p>
                        {{session('info')}}
                    </p>
                </div>
            @endif


            @yield('main')
        </div>

        <!-- ======= Footer ======= -->
        <footer id="footer">
            <div class="footer-top">
            <div class="container">
                <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="footer-info">
                    <h3>Gp<span>.</span></h3>
                    <p>
                        A108 Adam Street <br>
                        NY 535022, USA<br><br>
                        <strong>Phone:</strong> +1 5589 55488 55<br>
                        <strong>Email:</strong> info@example.com<br>
                    </p>
                    <div class="social-links mt-3">
                        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                    </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-newsletter">
                    <h4>Our Newsletter</h4>
                    <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                    <form action="" method="post">
                    <input type="email" name="email"><input type="submit" value="Subscribe">
                    </form>

                </div>

                </div>
            </div>
            </div>

            <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Gp</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
            </div>
        </footer><!-- End Footer -->

        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



        <!-- Vendor JS Files -->
        <script src="{{ asset('theme/purecounter/purecounter_vanilla.js') }}"></script>
        <script src="{{ asset('theme/aos/aos.js') }}"></script>
        <script src="{{ asset('theme/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <script src="{{ asset('theme/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('theme/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('theme/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('theme/php-email-form/validate.js') }}"></script>

        

        
        <script src="{{ asset('js/main.js') }}"></script>

    </body>
</html>