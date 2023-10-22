@extends('layouts.pengajuan')

@push('styles')
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<style>
    @media screen and (max-width: 720px) {
        .item {
            width: 200px;
        }

        .qty {
            width: 100px;
        }

        .satuan {
            width: 150px;
        }

        .harga-satuan {
            width: 120px;
        }

        .jumlah-harga {
            width: 200px;
        }

        .keterangan {
            width: 200px;
        }
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
        <div class="text-center">
            <h2>Operasional Kantor</h2>
        </div>
        <form action="{{ route('operasionalkantor.store') }}" method="POST">
            @csrf
            <input type="hidden" value="31" name="id_pengajuan">
            <div class="form-group">
                <input type="text" name="nomor" class="form-control" placeholder="Nomor" required>
            </div>
            <div class="form-group">
                <input type="text" name="tanggal" class="form-control calendar" value="{{ old('tanggal')??date('Y-m-d') }}" placeholder="Tanggal" required>
            </div>
            <div class="form-group">
                <input type="text" name="due_date" class="form-control calendar" value="{{ old('due_date')??date('Y-m-d') }}" placeholder="Due Date" required>
            </div>
            <div class="form-group">
                <input type="text" name="perihal_pekerjaan" class="form-control" placeholder="Perihal Pekerjaan" required>
            </div>

            <table class="table table-responsive-lg" id="item-table">
                <thead>
                    <tr>
                        <th>Jenis Pengeluaran/Merk/Spesifikasi</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah Harga</th>
                        <th>Keterangan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="item[]" class="form-control item"></td>
                        <td><input type="number" name="qty[]" class="form-control qty"></td>
                        <td><input type="text" name="satuan[]" class="form-control satuan"></td>
                        <td><input type="number" name="harga_satuan[]" class="form-control harga-satuan"></td>
                        <td><input type="number" name="jumlah_harga[]" class="form-control jumlah-harga"></td>
                        <td><input type="text" name="keterangan[]" class="form-control keterangan"></td>
                    </tr>
                </tbody>
            </table>

            <div class="form-group">
                <input type="number" name="total_biaya" class="form-control" placeholder="Total Biaya" required>
            </div>
            <button type="submit" class="btn btn-danger">Ajukan OPK</button>
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
                <td><input type="text" name="item[]" class="form-control item"></td>
                <td><input type="number" name="qty[]" class="form-control qty"></td>
                <td><input type="text" name="satuan[]" class="form-control satuan"></td>
                <td><input type="number" name="harga_satuan[]" class="form-control harga-satuan"></td>
                <td><input type="number" name="jumlah_harga[]" class="form-control jumlah-harga"></td>
                <td><input type="text" name="keterangan[]" class="form-control keterangan"></td>
                <td><button class="btn btn-danger remove-item">Remove</button></td>
            </tr>
        `);
    });

    // Menambahkan event handler untuk menghapus baris
    $('#item-table').on('click', '.remove-item', function() {
        $(this).closest('tr').remove();
    });
</script>
@endpush