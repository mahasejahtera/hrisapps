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
            <a href="/manajer/hrd/optiondepartment">
                <div class="badge-option"></div>
                <div class="text-center text-dark">Rencana Kerja Karyawan</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/manajer/hrd/listrkk">
                <div class="badge-option">{{ $jml }}</div>
                <div class="text-center text-dark">Rencana Kerja Pribadi</div>
            </a>
        </div>
        <div class="container-option">
            <a href="">
                <div class="badge-option">7</div>
                <div class="text-center text-dark">Daftar Tugas</div>
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
