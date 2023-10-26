@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                Permintaan
            </h2>
        </div>
    </header>
    <div class="mt-3">
        <a href="/manajer/permintaan/masuk" class="text-dark">
            <div class="container-option">
                <div class="float-left">Permintaan Masuk</div>
                <div class="float-right">
                    <img src="{{ asset('images/out.png') }}" alt="Logo" class="logo">
                </div>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
    <div class="mt-3">
        <a href="/manajer/permintaan/keluar" class="text-dark">
            <div class="container-option">
                <div class="float-left">Permintaan Keluar</div>
                <div class="float-right">
                    <img src="{{ asset('images/upload.png') }}" alt="Logo" class="logo">
                </div>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
    <div class="mt-3">
        <a href="/manajer/permintaan/persetujuan" class="text-dark">
            <div class="container-option">
                <div class="float-left">Persetejuan Permintaan Karyawan</div>
                <div class="float-right">
                    <img src="{{ asset('images/upload.png') }}" alt="Logo" class="logo">
                </div>
                <div class="clearfix"></div>
            </div>
        </a>
    </div>
@endsection
