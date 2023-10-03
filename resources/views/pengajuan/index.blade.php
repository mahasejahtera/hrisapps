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
            <div class="col-12">
                <a href="{{ route('pelatihankaryawan.create') }}" class="menu-item">
                    <p class="menu-item-title">Pengajuan Pelatihan Karyawan</p>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('csr.create') }}" class="menu-item">

                    <p class="menu-item-title">Pengajuan CSR</p>
                </a>
            </div>

        </div>
    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection