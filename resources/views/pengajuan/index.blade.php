@extends('layouts.pengajuan')

@section('content')

{{-- START : MAIN --}}
<main id="main-dashboard">

    {{-- START : MENU --}}
    <section id="menu-wrapper">
        <div class="col-sm-12 col-lg-3">
            <div style="width: 100%; height: 100%; background: #FF0000; border-top-right-radius: 10px" class="p-2 mb-3">
                <div style="width: 100%; height: 100%; color: white; font-size: 28px; font-family: Poppins; font-weight: 700; word-wrap: break-word">Pengajuan</div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-12">
                <a href="{{ route('hutangoperasional.create') }}" class="menu-item">

                    <p class="menu-item-title">Pengajuan Hutang Operasional</p>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('operasionalkantor.create') }}" class="menu-item">

                    <p class="menu-item-title">Pengajuan Operasional Kantor</p>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('reimbursement.create') }}" class="menu-item">

                    <p class="menu-item-title">Pengajuan Reimbursement</p>
                </a>
            </div>
            @if(session('role_id')==4)
            <div class="col-12">
                <a href="{{ route('reimbursement.create') }}" class="menu-item">

                    <p class="menu-item-title">Pengajuan Inventaris Kantor</p>
                </a>
            </div>
            @endif
            @if(session('role_id')==2 || session('role_id')==4)
            <div class="col-12">
                <a href="{{ route('reimbursement.create') }}" class="menu-item">

                    <p class="menu-item-title">Pengajuan Rekrutmen Karyawan</p>
                </a>
            </div>
            @endif
            <div class="col-12">
                <a href="{{ route('pelatihankaryawan.create') }}" class="menu-item">
                    <p class="menu-item-title">Pengajuan Pelatihan Karyawan</p>
                </a>
            </div>
            @if(session('role_id')==2 || session('role_id')==4)
            <div class="col-12">
                <a href="{{ route('reimbursement.create') }}" class="menu-item">

                    <p class="menu-item-title">Pengajuan Kegiatan/Acara</p>
                </a>
            </div>
            @endif
            <div class="col-12">
                <a href="{{ route('csr.create') }}" class="menu-item">

                    <p class="menu-item-title">Pengajuan CSR</p>
                </a>
            </div>
            @if(session('role_id')==4)
            <div class="col-12">
                <a href="{{ route('reimbursement.create') }}" class="menu-item">

                    <p class="menu-item-title">Pengajuan Entertainment</p>
                </a>
            </div>
            @endif
            @if(session('role_id')==2 || session('role_id')==4)
            <div class="col-12">
                <a href="{{ route('reimbursement.create') }}" class="menu-item">

                    <p class="menu-item-title">Pengajuan Kenaikan Gaji</p>
                </a>
            </div>
            @endif
        </div>
    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection