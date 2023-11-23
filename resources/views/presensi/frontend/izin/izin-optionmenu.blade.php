@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-danger text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Menu Izin</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="menu-list-wrapper">
        <a href="{{ route('presensi.izinkaryawan') }}" class="menu-list-item">
            <p>Izin Karyawan</p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path></svg>
        </a>

        <a href="{{ route('presensi.izinpribadi') }}" class="menu-list-item">
            <p>Izin Pribadi</p>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path></svg>
        </a>
    </div>
@endsection
