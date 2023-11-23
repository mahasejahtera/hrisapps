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

<header class="huader-main">
    <div class="header-main-title">
        <p>Surat Pernyataan</p>
    </div>
</header>

<section id="pakta-integritas-section">
    @if (Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="letter-wrapper">
        <div class="letter-inner">
            <div class="letter-header-footer">
                <img src="{{ asset('assets/img/Header-surat.png') }}" alt="">
            </div>
            <div class="letter-body">
                <p class="letter-title">
                    SURAT PERNYATAAN
                </p>
                <p class="letter-number">
                    Nomor: {{ $karyawanBiodata[0]->karyawan->no_surat_pakta_integritas }}
                </p>

                <div class="letter-content">
                    <p>Saya yang bertanda tangan di bawah ini :</p>

                    <table>
                        <tr>
                            <td>Nama</td>
                            <td><span class="ml-5 mr-3">:</span></td>
                            <td>{{ $karyawanBiodata[0]->fullname }}</td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td><span class="ml-5 mr-3">:</span></td>
                            <td>{{ $karyawanBiodata[0]->karyawan->nik }}</td>
                        </tr>
                        <tr>
                            <td>Tempat & Tanggal Lahir</td>
                            <td><span class="ml-5 mr-3">:</span></td>
                            <td>{{ $karyawanBiodata[0]->birthplace .  ', ' . tanggalBulanIndo($karyawanBiodata[0]->birthdate) }}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td><span class="ml-5 mr-3">:</span></td>
                            <td>{{ $karyawanBiodata[0]->karyawan->jabatan_kerja->nama_jabatan }}</td>
                        </tr>
                    </table>

                    <p class="mt-3">
                        Dengan ini menyatakan :
                    </p>

                    <ol>
                        <li>
                            Bahwa saya benar telah membuat, memberikan dan menyetujui tanda tangan saya untuk digunakan sebagai tanda tangan digital pada aplikasi perusahaan PT. Maha Akbar Sejahtera;
                        </li>
                        <li>
                            Bahwa saya benar menjamin tanda tangan yang terdapat dalam Aplikasi perusahaan PT. Maha Akbar Sejahtera tersebut merupakan tanda tangan yang sah dan asli sebagaimana tanda tangan cap basah saya;
                        </li>
                        <li>
                            Bahwa saya bertanggung jawab secara penuh terhadap setiap penggunaan tanda tangan digital saya pada aplikasi perusahaan PT. Maha Akbar Sejahtera.
                        </li>
                    </ol>

                    <p class="mt-3">
                        &emsp;&emsp;&emsp;Demikian pernyataan ini saya buat dengan sebenarnya dalam keadaan sehat secara sadar dan tanpa ada paksaan dari pihak manapun agar dapat dipergunakan sebagaimana mestinya.
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="letter-signature-wrapper">
                            <p>Medan, {{ tanggalBulanIndo($karyawanBiodata[0]->karyawan->pakta_integritas_check_date) }}</p>
                            <p>Yang Menyatakan</p>
                            <div class="letter-signature-inner">
                                <img src="{{ asset("signature/".$karyawanBiodata[0]->karyawan->signature) }}" alt="">
                                <div class="qr-code">
                                    <img src="" alt="">
                                </div>
                            </div>
                            <p class="letter-signature-name">({{ $karyawanBiodata[0]->fullname }})</p>
                            <p class="letter-signature-jabatan">{{ $karyawanBiodata[0]->karyawan->jabatan_kerja->nama_jabatan }}</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="letter-header-footer mt-5">
                <img src="{{ asset('assets/img/footer-surat.png') }}" alt="">
            </div>
        </div>
    </div>
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
        $('#btnAgree').prop('disabled', true);
        setQrCode('https://hrisapps.mahasejahtera.com');
    });

    function setQrCode(value) {
        const svgQrcode = `https://api.qrserver.com/v1/create-qr-code/?data=${value}`;
        $('.letter-signature-wrapper .qr-code img').attr('src', svgQrcode);
    }

    // checkbox agree change
    $('#agreeCheckbox').on('change', function(e) {
        const $this = $(this);

        if($this.is(':checked')) {
            $('#btnAgree').prop('disabled', false);
        } else {
            $('#btnAgree').prop('disabled', true);
        }
    });

    // button setuju di klik
    $('#btnAgree').on('click', function(e) {
        // cek checkbox di xhexk atau tida
        const agreeCheckbox = $('#agreeCheckbox').is(':checkbox');

        if(agreeCheckbox) {
            $.ajax({
                url: "{{ route('karyawan.paktaintegritas.store', $karyawanBiodata[0]->karyawan->email) }}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                method: "POST",
                success: function (response) {
                    location.href = "{{ route('karyawan.suratpernyataan', $karyawanBiodata[0]->karyawan->email) }}";
                }
            })
        }
    });
</script>

</body>
</html>
