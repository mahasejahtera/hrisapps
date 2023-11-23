@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Kontrak Kerja</p>
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

    @if ($karyawanBiodata[0]->karyawan->contract->contract_status == 'pkwt')
        @include('dashboard.template.kontrak_pkwt')
    @endif

    @if ($karyawanBiodata[0]->karyawan->contract->contract_status == 'percobaan')
        @include('dashboard.template.kontrak_percobaan')
    @endif

    @if ($karyawanBiodata[0]->karyawan->contract->contract_status == 'tetap')
        @include('dashboard.template.kontrak_tetap')
    @endif

    @if ($karyawanBiodata[0]->karyawan->contract->contract_status == 'project')
        @include('dashboard.template.kontrak_project')
    @endif

    @if ($karyawanBiodata[0]->karyawan->contract->contract_status == 'harian')
        @include('dashboard.template.kontrak_harian')
    @endif
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
                    url: "{{ route('karyawan.kontrakkerja.store', $karyawanBiodata[0]->karyawan->email) }}",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    method: "POST",
                    success: function (response) {
                        location.href = "{{ route('karyawan.datadiri.confirm', $karyawanBiodata[0]->karyawan->email) }}";
                    }
                })
            }
        });
    </script>
@endsection
