@extends('layouts.pengajuan')

@push('styles')
<style>
    .circle-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .circle-button {
        width: 50px;
        height: 50px;
        background-color: #f00;
        /* Warna latar belakang */
        border-radius: 50%;
        /* Membuat lingkaran dengan border-radius setengah dari lebar atau tinggi */
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        /* Warna teks */
        font-size: 24px;
        text-decoration: none;
        border: none;
        /* Menghilangkan garis pinggir */
        cursor: pointer;
    }
</style>
@endpush
@section('content')
{{-- START : MAIN --}}
<main id="main-dashboard">

    {{-- START : MENU --}}
    <section id="menu-wrapper">
        <div class="col-sm-12 col-lg-3">
            <div style="width: 100%; height: 100%; background: #FF0000; border-top-right-radius: 10px" class="p-2 mb-3">
                <div style="width: 100%; height: 100%; color: white; font-size: 28px; font-family: Poppins; font-weight: 700; word-wrap: break-word">Form Pengajuan</div>
            </div>
        </div>

        <div class="row justify-content-between">

            <img style="width: 100%; height: 100%; " src="{{ asset('assets/img/add.png') }}" />

        </div>
        <div class="circle-container">
            <a href="{{ route($id.'.create') }}" class="circle-button">+</a>
        </div>

    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection