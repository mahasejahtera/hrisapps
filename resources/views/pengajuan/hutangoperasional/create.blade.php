@extends('layouts.pengajuan')

@push('styles')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
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
        <div class="text-center">
            <h2>Hutang Operasional</h2>
        </div>

        <form action="{{ route('hutangoperasional.store') }}" method="POST">
            @csrf
            <input type="hidden" value="1" name="id_pengajuan">
            <div class="form-group">
                <input type="text" name="nomor" class="form-control" value="{{ old('nomor') }}" placeholder="Nomor" required>
            </div>
            <div class="form-group">
                <input type="text" name="tanggal" class="form-control calendar" value="{{ old('tanggal')??date('Y-m-d') }}" placeholder="Tanggal" autocomplete="off" required>
            </div>
            <div class="form-group">
                <input type="text" name="due_date" class="form-control calendar" value="{{ old('due_date')??date('Y-m-d') }}" placeholder="Due Date" autocomplete="off" required>
            </div>
            <div class="form-group">
                <input type="text" name="perihal_pekerjaan" class="form-control" value="{{ old('perihal_pekerjaan') }}" placeholder="Perihal Pekerjaan" required>
            </div>
            <!-- Input multi-baris untuk item -->
            <table class="table table-responsive" id="item-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah Harga</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="item[]" class="form-control"></td>
                        <td><input type="number" name="qty[]" class="form-control"></td>
                        <td><input type="text" name="satuan[]" class="form-control"></td>
                        <td><input type="number" name="harga_satuan[]" class="form-control"></td>
                        <td><input type="number" name="jumlah_harga[]" class="form-control"></td>
                        <td><input type="text" name="keterangan[]" class="form-control"></td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <button type="button" class="btn btn-primary" id="add-item">Tambah Item</button>
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

@push('myscript')

<!-- Bootstrap-datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function() {
        $('.calendar').datepicker({
            format: 'yyyy-mm-dd', // Format tanggal yang diinginkan
            autoclose: true, // Menutup kalender setelah memilih tanggal
        });
    });
    // Script untuk menambahkan baris input item secara dinamis
    $('#add-item').click(function() {
        $('#item-table tbody').append(`
            <tr>
                <td><input type="text" name="item[]" class="form-control"></td>
                <td><input type="number" name="qty[]" class="form-control"></td>
                <td><input type="text" name="satuan[]" class="form-control"></td>
                <td><input type="number" name="harga_satuan[]" class="form-control"></td>
                <td><input type="number" name="jumlah_harga[]" class="form-control"></td>
                <td><input type="text" name="keterangan[]" class="form-control"></td>
            </tr>
        `);
    });
</script>
@endpush