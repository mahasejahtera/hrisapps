@extends('layouts.pengajuan')

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
        <form action="{{ route('csr.index') }}">

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Perihal Pekerjaan">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Item">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Qty">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Satuan">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Harga Satuan">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Jumlah Harga">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Keterangan">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Total Biaya">
            </div>
            <button type="submit" class="btn btn-danger">Ajukan HO</button>
        </form>


    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection