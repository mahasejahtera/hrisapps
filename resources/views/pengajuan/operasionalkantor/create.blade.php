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
        <div class="text-center">
            <h2>Operasional Kantor</h2>
        </div>
        <form action="{{ route('operasionalkantor.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="nomor" class="form-control" placeholder="Nomor" required>
            </div>
            <div class="form-group">
                <input type="text" name="tanggal" class="form-control" placeholder="Tanggal" required>
            </div>
            <div class="form-group">
                <input type="text" name="due_date" class="form-control" placeholder="Due Date" required>
            </div>
            <div class="form-group">
                <input type="text" name="perihal_pekerjaan" class="form-control" placeholder="Perihal Pekerjaan" required>
            </div>

            <div class="form-group">
                <input type="text" name="jenis_pengeluaran" class="form-control" placeholder="Jenis Pengeluaran/Merk/Spesifikasi" required>
            </div>
            <div class="form-group">
                <input type="number" name="qty" class="form-control" placeholder="Qty" required>
            </div>
            <div class="form-group">
                <input type="number" name="satuan" class="form-control" placeholder="Satuan" required>
            </div>
            <div class="form-group">
                <input type="number" name="harga_satuan" class="form-control" placeholder="Harga Satuan" required>
            </div>
            <div class="form-group">
                <input type="number" name="jumlah_harga" class="form-control" placeholder="Jumlah Harga" required>
            </div>
            <div class="form-group">
                <input type="number" name="keterangan" class="form-control" placeholder="Keterangan" required>
            </div>
            <div class="form-group">
                <input type="number" name="total_biaya" class="form-control" placeholder="Total Biaya" required>
            </div>
            <button type="submit" class="btn btn-danger">Ajukan HO</button>
        </form>


    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection