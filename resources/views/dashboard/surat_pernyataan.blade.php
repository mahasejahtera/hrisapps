@extends('layouts.main')

@section('content')

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
                            Bahwa saya tidak akan melakukan praktik Korupsi, Kolusi dan Nepotisme (KKN) dengan siapapun dan pihak manapun;
                        </li>
                        <li>
                            Bahwa saya tidak akan meminta atau menerima pemberian secara langsung atau tidak langsung berupa suap, hadiah, bantuan atau pemberian dalam bentuk lainnya yang tidak sesuai dengan ketentuan perusahaan PT. Maha Akbar Sejahtera;
                        </li>
                        <li>
                            Bahwa saya akan bersikap transparan, jujur, objektif dan akuntabel dalam melaksanakan tugas.
                        </li>
                        <li>
                            Bahwa saya tidak akan melakukan perbuatan yang melanggar norma agama, norma kesusilaan, norma sosial dan norma hukum serta sanggup mentaati segala peraturan lainnya yang berlaku dilingkungan PT. Maha Akbar Sejahtera;
                        </li>
                        <li>
                            Bahwa saya akan menggunakan dan menjaga fasilitas / peralatan kerja milik perusahaan PT. Maha Akbar Sejahtera yang saya gunakan saat bekerja dengan sebaik-baiknya karena apabila terjadi kerusakan / kehilangan peralatan kerja yang menimbulkan kerugian perusahaan maka akan dikenakan sanksi administrasi berupa pemotongan upah atas kerusakan/kehilangan peralatan milik perusahaan;
                        </li>
                        <li>
                            Bahwa saya tidak akan melakukan pemalsuan data/transaksi atau manipulasi data/transaksi dan/atau pemalsuan jumlah data/transaksi yang saya peroleh/ketahui atau melalui perantara saya dari konsumen kepada Perusahaan PT. Maha Akbar Sejahtera;
                        </li>
                        <li>
                            Bahwa saya akan menjaga seluruh kerahasiaan PT. Maha Akbar Sejahtera dan tidak akan menyalahgunakan setiap informasi atau data perusahaan dalam arti yang seluas-luasnya yang saya peroleh/ ketahui.
                        </li>
                        <li>
                            Bahwa saya tidak akan memberikan, mendiskusikan, membahas dan membocorkan dengan cara atau metode apapun informasi-informasi dan data tersebut baik secara sengaja maupun tidak sengaja dengan orang-orang atau perusahaan lainnya.
                        </li>
                        <li>
                            Jika dikemudian hari saya mengundurkan diri / PHK oleh Perusahaan, maka saya tidak akan mengajak atau membawa Konsumen PT. Maha Akbar Sejahtera ketempat saya akan bekerja nantinya.
                        </li>
                    </ol>

                    <p class="mt-3">
                        &emsp;&emsp;&emsp;Demikian surat pernyataan ini dibuat dengan sebenarnya secara sadar tanpa ada paksaan dari pihak manapun serta akan melaksanakannya dengan penuh rasa tanggungjawab. Apabila saya melakukan perbuatan-perbuatan yang bertentangan dengan Pernyataan saya di atas, maka saya bersedia dituntut sesuai dengan Peraturan Perundang-undangan yang berlaku.
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" id="agreeCheckbox">
                                <label for="agreeCheckbox" class="ml-1 mb-0">Agree</label>
                            </div>

                            <button type="button" class="btn primary mt-3" id="btnAgree">Setuju</button>
                        </div>

                        <div class="letter-signature-wrapper">
                            <p>Medan, {{ tanggalBulanIndo(date('Y-m-d')) }}</p>
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

@endsection

@section('scriptJS')
    <script>
        $(document).ready(function() {
            $('#btnAgree').prop('disabled', true);

            const urlSPT = "{{ route('spt.ttddigital', $karyawan->email) }}";
            setQrCode(urlSPT);
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
                    url: "{{ route('karyawan.suratpernyataan.store', $karyawanBiodata[0]->karyawan->email) }}",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    method: "POST",
                    success: function (response) {
                        const kontrakTampil = {{ $karyawan->kontrak_tampil }};

                        if(kontrakTampil == 1) {
                            location.href = "{{ route('karyawan.kontrakkerja', $karyawanBiodata[0]->karyawan->email) }}";
                        } else {
                            location.href = "{{ route('karyawan.datadiri.confirm', $karyawanBiodata[0]->karyawan->email) }}";
                        }
                    }
                })
            }
        });
    </script>
@endsection
