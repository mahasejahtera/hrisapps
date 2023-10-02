@extends('layouts.pengajuan')

@section('content')
    
    {{-- START : MAIN --}}
    <main id="main-dashboard">

        {{-- START : MENU --}}
        <section id="menu-wrapper">
           
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