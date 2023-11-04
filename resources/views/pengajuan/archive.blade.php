@extends('layouts.pengajuan')

@section('content')

{{-- START : MAIN --}}
<main id="main-dashboard">

    {{-- START : MENU --}}
    <section id="menu-wrapper">
        <div class="col-sm-12 col-lg-3">
            <div style="width: 100%; height: 100%; background: #FF0000; border-top-right-radius: 10px" class="p-2 mb-3">
                <div style="width: 100%; height: 100%; color: white; font-size: 28px; font-family: Poppins; font-weight: 700; word-wrap: break-word">Arsip Pengajuan</div>
            </div>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Cari">
        </div>
        <input type="text" class="form-control" placeholder="Bulan"> 
        <input type="text" class="form-control" placeholder="Tahun"> 
        <input type="text" class="form-control" placeholder="Karyawan"> 
        <div class="row justify-content-between">
        <table class="table table-responsive-lg" id="item-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Perihal</th>
                        <th>Pengirim</th>
                        <th>Penerima</th>
                        <th>Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection