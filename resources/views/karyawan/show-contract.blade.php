<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>{{ $title }}</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-maha-akbar.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">

    {{-- PLUGIN STYLE --}}
    <link rel="stylesheet" href="{{ asset('assets/css/inc/bootstrap/bootstrap.min.css') }}">
    {{-- CUSTOM STYLE --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.v2.css') }}">

    <link rel="manifest" href="__manifest.json">
</head>

<body>

    <header class="huader-profile-wrapper">
        <a href="{{ route('admin.karyawan.detail', $karyawan->email) }}" class="header-profile-inner">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256"><path d="M224,128a8,8,0,0,1-8,8H120v64a8,8,0,0,1-13.66,5.66l-72-72a8,8,0,0,1,0-11.32l72-72A8,8,0,0,1,120,56v64h96A8,8,0,0,1,224,128Z"></path></svg>

            <p>Kontrak Kerja</p>
        </a>
    </header>

    <section id="pakta-integritas-section">
        @if ($karyawanBiodata[0]->karyawan->contract->contract_status == 'pkwt')
            @include('frontend.karyawan.contract_template.kontrak_pkwt')
        @endif

        @if ($karyawanBiodata[0]->karyawan->contract->contract_status == 'percobaan')
            @include('frontend.karyawan.contract_template.kontrak_percobaan')
        @endif

        @if ($karyawanBiodata[0]->karyawan->contract->contract_status == 'tetap')
            @include('frontend.karyawan.contract_template.kontrak_tetap')
        @endif

        @if ($karyawanBiodata[0]->karyawan->contract->contract_status == 'project')
            @include('frontend.karyawan.contract_template.kontrak_project')
        @endif

        @if ($karyawanBiodata[0]->karyawan->contract->contract_status == 'harian')
            @include('frontend.karyawan.contract_template.kontrak_harian')
        @endif
    </section>

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    {{-- signature pad --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('') }}assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <!-- Base Js File -->
    <script src="{{ asset('assets/js/base.js') }}"></script>

    <script>
        $(document).ready(function() {
            const urlSPTatasanApprove = "{{ route('spt.ttddigital', $karyawanBiodata[0]->karyawan->contract->atasanApprove->email) }}";
            const urlSPT = "{{ route('spt.ttddigital', $karyawan->email) }}";
            setQrCode(urlSPTatasanApprove, 0);
            setQrCode(urlSPT, 1);
        });

        function setQrCode(value, index) {
            const svgQrcode = `https://api.qrserver.com/v1/create-qr-code/?data=${value}`;

            const qrCodeEl = $('.letter-signature-wrapper');
            $(qrCodeEl[index]).find('.qr-code img').attr('src', svgQrcode);
            // $('.letter-signature-wrapper .qr-code img').attr('src', svgQrcode);
        }
    </script>
</body>
</html>
