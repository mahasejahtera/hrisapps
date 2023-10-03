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
        <form>

            <div class="form-group">
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Perihal Pekerjaan">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Item">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Qty">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Satuan">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Harga Satuan">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Jumlah Harga">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Keterangan">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Total Biaya">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection