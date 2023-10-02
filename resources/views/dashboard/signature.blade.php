@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Tanda Tangan</p>
    </div>
</header>

<section id="">
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

    <div class="signature-wrapper">
        <!-- canvas tanda tangan  -->
        <canvas id="signature-pad" class="signature-pad"></canvas>
        @if ($karyawan->signature)
            <div class="qrcode-signature">
                <div class="signature-image">
                    <img src="{{ asset("signature/$karyawan->signature") }}" alt="">
                </div>
                {!! QrCode::generate(asset("signature/$karyawan->signature")) !!}
            </div>
        @endif
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
                    location.reload();
                    alert('Tanda Tangan Berhasil Disimpan');
                }

            })
        })


        // next button
        $('#btnNext').on('click', function(e) {
            const signature = "{{ $karyawan->signature }}";
            
            if(signature) {
                location.href = "{{ route('karyawan.paktaintegritas', $karyawan->email) }}";
            } else {
                alert('Harap tanda tangan terlebih dahulu...!!!');
            }
        });
    </script>
@endsection