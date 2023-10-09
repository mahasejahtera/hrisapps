@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                Rencana Kerja
            </h2>
        </div>
    </header>
    <div class="mt-3">
        <div class="container-option">
            <a href="/komisaris/optiondepartment">
                <div class="badge-option">2</div>
                <div class="text-center text-dark">Rencana Kerja Karyawan</div>
            </a>
        </div>
        <div class="container-option">
            <a href="">
                <div class="badge-option">7</div>
                <div class="text-center text-dark">Daftar Permintaan</div>
            </a>
        </div>
    </div>
@endsection
