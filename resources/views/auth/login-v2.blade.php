<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#004AAD">
    <title>{{ $title }}</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon/logo-maha-akbar.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icon-512.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inc/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inc/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inc/owl-carousel/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.v2.css') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
</head>

<body id="login__page">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    {{-- START: HEADER SECTION --}}
    <header id="login-header">
        <div class="auth-header-wrapper">
            <img src="{{ asset('assets/img/logo-maha-akbar.png') }}" alt="maha akbar logo" class="header-logo">
        </div>
    </header>
    {{-- END: HEADER SECTION --}}


    {{-- START: FORM SECTION --}}
    <section id="login-section">
        <div class="auth-wrapper">
            <div class="auth-header">
                <p class="auth-title">Login</p>
            </div>
            <div class="auth-form-inner">
                @if (Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (Session::get('google_err'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('google_err') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('login.proses') }}" method="POST">
                    @csrf
                    <div class="form-group icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24ZM74.08,197.5a64,64,0,0,1,107.84,0,87.83,87.83,0,0,1-107.84,0ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120Zm97.76,66.41a79.66,79.66,0,0,0-36.06-28.75,48,48,0,1,0-59.4,0,79.66,79.66,0,0,0-36.06,28.75,88,88,0,1,1,131.52,0Z"></path></svg>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" autofocus required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M160,12A84.05,84.05,0,0,0,79.38,119.65L23.51,175.51A12,12,0,0,0,20,184v40a12,12,0,0,0,12,12H72a12,12,0,0,0,12-12V212H96a12,12,0,0,0,12-12V188h12a12,12,0,0,0,8.49-3.51l7.86-7.87A84,84,0,1,0,160,12Zm0,144a59.58,59.58,0,0,1-22.1-4.2,12,12,0,0,0-13.22,2.55L115,164H96a12,12,0,0,0-12,12v12H72a12,12,0,0,0-12,12v12H44V189l57.65-57.65a12,12,0,0,0,2.55-13.21A60,60,0,1,1,160,156Zm36-80a16,16,0,1,1-16-16A16,16,0,0,1,196,76Z"></path></svg>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="password" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-button-group my-4">
                        <button type="submit" class="btn primary btn-block btn-lg">Login</button>
                        {{-- <a href="{{ route('google.login') }}" class="btn-rounded btn-block mt-3 d-flex justify-content-center align-items-center bg-primary text-white text-decoration-none py-1 w-90 mx-auto">
                            <img src="{{ asset('assets/img/google.png') }}" alt="">
                            <p class="m-0 ml-2">Continue with Google</p>
                        </a> --}}
                    </div>
                </form>

                <div class="auth-form-footer text-center">
                    <p>Tidak Punya Akun ? <a href="{{ route('register') }}">Register</a></p>
                </div>
            </div>
        </div>
    </section>
    {{-- END: FORM SECTION --}}

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <!-- Base Js File -->
    <script src="{{ asset('assets/js/base.js') }}"></script>


</body>

</html>
