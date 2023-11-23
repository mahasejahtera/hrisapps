@extends('layouts.main')

@section('content')

<header class="huader-profile-wrapper">
    <a href="{{ route('profil', auth()->guard('karyawan')->user()->email) }}" class="header-profile-inner">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256"><path d="M224,128a8,8,0,0,1-8,8H120v64a8,8,0,0,1-13.66,5.66l-72-72a8,8,0,0,1,0-11.32l72-72A8,8,0,0,1,120,56v64h96A8,8,0,0,1,224,128Z"></path></svg>

        <p>Kontrak Kerja</p>
    </a>

    <div class="menu-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256"><path d="M224,120v16a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V120a8,8,0,0,1,8-8H216A8,8,0,0,1,224,120Zm-8,56H40a8,8,0,0,0-8,8v16a8,8,0,0,0,8,8H216a8,8,0,0,0,8-8V184A8,8,0,0,0,216,176Zm0-128H40a8,8,0,0,0-8,8V72a8,8,0,0,0,8,8H216a8,8,0,0,0,8-8V56A8,8,0,0,0,216,48Z"></path></svg>
    </div>
</header>

@include('frontend.template.menu-item')

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

@endsection

@section('scriptJS')
    @include('frontend.template.menu-item-script')

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
@endsection
