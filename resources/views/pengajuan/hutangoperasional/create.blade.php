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
            <h2>Hutang Operasional</h2>
        </div>

        <form action="{{ route('hutangoperasional.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" name="nomor" class="form-control" value="{{ old('nomor') }}" placeholder="Nomor" required>
            </div>
            <div class="form-group">
                <input type="text" name="tanggal" class="form-control"  value="{{ old('tanggal') }}" placeholder="Tanggal" required>
            </div>
            <div class="form-group">
                <input type="text" name="due_date" class="form-control"  value="{{ old('due_date') }}" placeholder="Due Date" required>
            </div>
            <div class="form-group">
                <input type="text" name="perihal_pekerjaan" class="form-control"  value="{{ old('perihal_pekerjaan') }}" placeholder="Perihal Pekerjaan" required>
            </div>
            <div class="form-group">
                <input type="text" name="item" class="form-control"  value="{{ old('item') }}" placeholder="Item" required>
            </div>
            <div class="form-group">
                <input type="number" name="qty" class="form-control" value="{{ old('qty') }}" placeholder="Qty" required>
            </div>
            <div class="form-group">
                <input type="number" name="satuan" class="form-control" value="{{ old('satuan') }}" placeholder="Satuan" required>
            </div>
            <div class="form-group">
                <input type="number" name="harga_satuan" class="form-control" value="{{ old('harga_satuan') }}" placeholder="Harga Satuan" required>
            </div>
            <div class="form-group">
                <input type="number" name="jumlah_harga" class="form-control" value="{{ old('jumlah_harga') }}" placeholder="Jumlah Harga" required>
            </div>
            <div class="form-group">
                <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}" placeholder="Keterangan">
            </div>
            <div class="form-group">
                <input type="number" name="total_biaya" class="form-control" value="{{ old('total_biaya') }}" placeholder="Total Biaya" required>
            </div>
            <button type="submit" class="btn btn-danger">Ajukan HO</button>
        </form>


    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection