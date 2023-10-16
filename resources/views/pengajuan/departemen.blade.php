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
                <a href="{{ route('pengajuan.pribadi') }}" class="menu-item">

                    <p class="menu-item-title">DU Department</p>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('operasionalkantor.create') }}" class="menu-item">

                    <p class="menu-item-title">Engineering Department</p>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('operasionalkantor.create') }}" class="menu-item">

                    <p class="menu-item-title">Production Department</p>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('operasionalkantor.create') }}" class="menu-item">

                    <p class="menu-item-title">IT Department</p>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('operasionalkantor.create') }}" class="menu-item">

                    <p class="menu-item-title">Marketing Department</p>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('operasionalkantor.create') }}" class="menu-item">

                    <p class="menu-item-title">HRD Department</p>
                </a>
            </div>
            <div class="col-12">
                <a href="{{ route('operasionalkantor.create') }}" class="menu-item">

                    <p class="menu-item-title">Finance Department</p>
                </a>
            </div>

        </div>
    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection