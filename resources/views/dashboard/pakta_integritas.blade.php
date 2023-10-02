@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Pakta Integritas</p>
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
    
                <div class="letter-content">
                    <p>Yang bertanda tangan di bawah ini :</p>
    
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
                                {!! QrCode::generate(asset("signature/".$karyawanBiodata[0]->karyawan->signature)) !!}
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
        });
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
                        location.href = "{{ route('karyawan.kontrakkerja', $karyawanBiodata[0]->karyawan->email) }}";
                    }
                })
            }
        });
    </script>
@endsection