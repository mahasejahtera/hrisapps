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
            <h2>CSR</h2>
        </div>
        <form action="{{ route('csr.store') }}" method="POST">
            @csrf
            <input type="hidden" value="15" name="id_pengajuan">
            <div class="form-group">
            <div class="row" style="overflow-x: auto;">
                    <div class="col">
                        {{$nomor}} / CSR .
                        <input type="hidden" id="depan" value="{{$nomor}}/HO.">
                        <input type="hidden" id="nomor_terakhir" name="nomor_terakhir" value="{{$nomor}}">
                        <input type="hidden" id="nomor" name="nomor">
                    </div>
                    <div class="col col-md">
                        <input type="text" name="proyek" id="proyek" class="form-control form-control-sm" value="{{ old('proyek') }}" placeholder="Proyek">
                    </div>
                    <div class="col">
                        /MAHA.{{ session('kode_dept') }}.{{ session('inisial') }}/{{ bulanKeRomawi(date('n')) }}/{{ date('Y') }}
                        <input type="hidden" id="belakang" value="/MAHA.{{ session('kode_dept') }}.{{ session('inisial') }}/{{ bulanKeRomawi(date('n')) }}/{{ date('Y') }}">
                    </div>
                </div>
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
                <input type="text" name="item" class="form-control" placeholder="Item" required>
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
                <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" required>
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