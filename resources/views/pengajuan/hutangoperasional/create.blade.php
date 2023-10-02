@extends('layouts.pengajuan')

@section('content')

{{-- START : MAIN --}}
<main id="main-dashboard">

    {{-- START : MENU --}}
    <section id="menu-wrapper">

        <form action="{{ route('hutangoperasional.index') }}" method="GET">

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
            <button type="submit" class="btn btn-danger">Ajukan HO</button>
        </form>


    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection