@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Tanda Tangan</p>
    </div>
</header>

<section id="">

    <div class="signature-wrapper">
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

        <!-- canvas tanda tangan  -->
        <canvas id="signature-pad" class="signature-pad"></canvas>
        {{-- @if ($karyawan->signature) --}}
            <div class="qrcode-signature">
                <div class="signature-image">
                    <img src="{{ asset("signature/$karyawan->signature") }}" alt="">
                </div>
                {{-- {!! QrCode::generate(asset("signature/$karyawan->signature")) !!} --}}
                <div class="qr-code">
                    <img src="" alt="">
                </div>
            </div>
        {{-- @endif --}}
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-info" id="submitSignature">Simpan</button>
            <button type="button" class="btn btn-secondary" id="clearSignature">Hapus</button>
        </div>
    </div>


    <button type="button" class="btn primary btn-block mt-2 mb-5" id="btnNext">Lanjut</button>
</section>

@endsection

@section('scriptJS')
    <script>
        var signatureOld = '{{ $karyawan->signature }}';

        $(document).ready(function(e) {
            if(signatureOld) {
                setQrCode('https://hrisapps.mahasejahtera.com');
            } else {
                $('.signature-wrapper .qr-code img').hide();
            }
        });

        function setQrCode(value) {
            const svgQrcode = `https://api.qrserver.com/v1/create-qr-code/?data=${value}`;
            $('.signature-wrapper .qr-code img').show();
            $('.signature-wrapper .qr-code img').attr('src', svgQrcode);
        }

        // script di dalam ini akan dijalankan pertama kali saat dokumen dimuat
        document.addEventListener('DOMContentLoaded', function () {
            resizeCanvas();
        })

        var canvas = document.getElementById('signature-pad');
        //script ini berfungsi untuk menyesuaikan tanda tangan dengan ukuran canvas
        function resizeCanvas() {
            var ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        //warna dasar signaturepad
        var signaturePad = new SignaturePad(canvas, {
            // backgroundColor: 'rgb(255, 255, 255)'
        });

        //saat tombol clear diklik maka akan menghilangkan seluruh tanda tangan
        document.getElementById('clearSignature').addEventListener('click', function () {
            signaturePad.clear();

            $('.qrcode-signature').hide();
        });

        //fungsi untuk menyimpan tanda tangan dengan metode ajax
        $(document).on('click', '#submitSignature', function () {
            var signature = signaturePad.toDataURL();

            $.ajax({
                url: "{{ route('karyawan.signature.store', $karyawan->email) }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    foto: signature
                },
                method: "POST",
                success: function (response) {
                    signatureOld = response.signature;
                    $('.signature-wrapper .signature-image img').attr('src', `{{ asset('signature') }}${signatureOld}`);
                    $('.qrcode-signature').show();
                    setQrCode('https://hrisapps.mahasejahtera.com');
                    alert('Tanda Tangan Berhasil Disimpan');
                }

            })
        })


        // next button
        $('#btnNext').on('click', function(e) {

            if(signatureOld) {
                location.href = "{{ route('karyawan.paktaintegritas', $karyawan->email) }}";
            } else {
                alert('Harap tanda tangan terlebih dahulu...!!!');
            }
        });
    </script>
@endsection
