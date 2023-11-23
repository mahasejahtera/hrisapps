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
    <link rel="icon" type="image/png" href="{{ asset('icon-512.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icon-512.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inc/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inc/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inc/owl-carousel/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.v2.css') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
</head>

<body id="register__page">

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
                <p class="auth-title">Register</p>
            </div>
            <div class="auth-form-inner">
                @if (Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('register.proses') }}" method="POST">
                    @csrf
                    <div class="form-group icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24ZM74.08,197.5a64,64,0,0,1,107.84,0,87.83,87.83,0,0,1-107.84,0ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120Zm97.76,66.41a79.66,79.66,0,0,0-36.06-28.75,48,48,0,1,0-59.4,0,79.66,79.66,0,0,0-36.06,28.75,88,88,0,1,1,131.52,0Z"></path></svg>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" placeholder="Nama Lengkap" value="{{ old('nama_lengkap') }}" autofocus required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- <div class="form-group icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M128,20A108,108,0,1,0,236,128,108.12,108.12,0,0,0,128,20ZM79.57,196.57a60,60,0,0,1,96.86,0,83.72,83.72,0,0,1-96.86,0ZM100,120a28,28,0,1,1,28,28A28,28,0,0,1,100,120ZM194,179.94a83.48,83.48,0,0,0-29-23.42,52,52,0,1,0-74,0,83.48,83.48,0,0,0-29,23.42,84,84,0,1,1,131.9,0Z"></path></svg>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username" value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}

                    <div class="form-group icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M224,44H32A12,12,0,0,0,20,56V192a20,20,0,0,0,20,20H216a20,20,0,0,0,20-20V56A12,12,0,0,0,224,44ZM193.15,68,128,127.72,62.85,68ZM44,188V83.28l75.89,69.57a12,12,0,0,0,16.22,0L212,83.28V188Z"></path></svg>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"  value="{{ old('email') }}" placeholder="Email" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M160,12A84.05,84.05,0,0,0,79.38,119.65L23.51,175.51A12,12,0,0,0,20,184v40a12,12,0,0,0,12,12H72a12,12,0,0,0,12-12V212H96a12,12,0,0,0,12-12V188h12a12,12,0,0,0,8.49-3.51l7.86-7.87A84,84,0,1,0,160,12Zm0,144a59.58,59.58,0,0,1-22.1-4.2,12,12,0,0,0-13.22,2.55L115,164H96a12,12,0,0,0-12,12v12H72a12,12,0,0,0-12,12v12H44V189l57.65-57.65a12,12,0,0,0,2.55-13.21A60,60,0,1,1,160,156Zm36-80a16,16,0,1,1-16-16A16,16,0,0,1,196,76Z"></path></svg>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Kata Sandi" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>  

                    <div class="form-group icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M240,204H228V96a20,20,0,0,0-20-20H172V32a20,20,0,0,0-28.45-18.12l-104,48.54A20.06,20.06,0,0,0,28,80.55V204H16a12,12,0,0,0,0,24H240a12,12,0,0,0,0-24ZM204,100V204H172V100ZM52,83.09,148,38.3V204H52ZM132,112v12a12,12,0,0,1-24,0V112a12,12,0,0,1,24,0Zm-40,0v12a12,12,0,0,1-24,0V112a12,12,0,0,1,24,0Zm0,52v12a12,12,0,0,1-24,0V164a12,12,0,0,1,24,0Zm40,0v12a12,12,0,0,1-24,0V164a12,12,0,0,1,24,0Z"></path></svg>

                        <select name="kode_dept" id="kode_dept" class="form-control @error('kode_dept') is-invalid @enderror" required>
                            <option value="">--Pilih Departemen--</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('kode_dept') == $department->id)>{{ $department->nama_dept }}</option>
                            @endforeach
                        </select>
                        @error('kode_dept')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M240,204H228V96a20,20,0,0,0-20-20H172V32a20,20,0,0,0-28.45-18.12l-104,48.54A20.06,20.06,0,0,0,28,80.55V204H16a12,12,0,0,0,0,24H240a12,12,0,0,0,0-24ZM204,100V204H172V100ZM52,83.09,148,38.3V204H52ZM132,112v12a12,12,0,0,1-24,0V112a12,12,0,0,1,24,0Zm-40,0v12a12,12,0,0,1-24,0V112a12,12,0,0,1,24,0Zm0,52v12a12,12,0,0,1-24,0V164a12,12,0,0,1,24,0Zm40,0v12a12,12,0,0,1-24,0V164a12,12,0,0,1,24,0Z"></path></svg>

                        <select name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" required>
                            {{-- <option value="">--Pilih Jabatan--</option>
                            @foreach ($jabatans as $jabatan)
                                <option value="{{ $jabatan->id }}" @selected(old('jabatan') == $jabatan->id)>{{ $jabatan->nama_jabatan }}</option>
                            @endforeach --}}
                        </select>
                        @error('jabatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M240,204H228V96a20,20,0,0,0-20-20H172V32a20,20,0,0,0-28.45-18.12l-104,48.54A20.06,20.06,0,0,0,28,80.55V204H16a12,12,0,0,0,0,24H240a12,12,0,0,0,0-24ZM204,100V204H172V100ZM52,83.09,148,38.3V204H52ZM132,112v12a12,12,0,0,1-24,0V112a12,12,0,0,1,24,0Zm-40,0v12a12,12,0,0,1-24,0V112a12,12,0,0,1,24,0Zm0,52v12a12,12,0,0,1-24,0V164a12,12,0,0,1,24,0Zm40,0v12a12,12,0,0,1-24,0V164a12,12,0,0,1,24,0Z"></path></svg>

                        <select name="kode_cabang" id="kode_cabang" class="form-control @error('kode_cabang') is-invalid @enderror" required>
                            <option value="">--Pilih Penempatan--</option>
                            @foreach ($kantor_cabang as $kc)
                                <option value="{{ $kc->kode_cabang }}" @selected(old('kode_cabang') == $kc->kode_cabang)>{{ $kc->nama_cabang }}</option>
                            @endforeach
                        </select>
                        @error('kode_cabang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-button-group my-4">
                        <button type="submit" class="btn btn-danger btn-block btn-lg">Register</button>
                    </div>
                </form>

                <div class="auth-form-footer text-center">
                    <p>Sudah Punya Akun ? <a href="{{ route('login') }}">Login</a></p>
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


    <script>
        $(document).ready(function(e) {
            $('#jabatan').html("<option value=''>--Pilih Jabatan--</option>");
            const oldJabatan = "{{ old('jabatan') }}";

            if(oldJabatan) {
                const valueDept = $('#kode_dept').val();

                $.ajax({
                    url: "{{ route('register.jabatan') }}",
                    type: "post",
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        value: valueDept,
                        oldJabatan: oldJabatan,
                        isSet: true
                    },
                    success: function(response) {
                        $('#jabatan').html(response.jabatanOption);
                    }
                });
            }
        });

        $('#kode_dept').on('change', function(e) {
            const $this = $(this);
            const deptValue = $this.val();

            if(deptValue != '')
            {
                $.ajax({
                    url: "{{ route('register.jabatan') }}",
                    type: "post",
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        value: deptValue
                    },
                    success: function(response) {
                        $('#jabatan').html(response.jabatanOption);
                    }
                });
            } else {
                $('#jabatan').html("<option value=''>--Pilih Jabatan--</option>");
            }
        });
    </script>

</body>

</html>
