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
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Cari">
        </div>
        <div class="row justify-content-between">
            @foreach ($pengajuan as $item)
            <div class="col-12">
                <a href="{{ route('hutangoperasional.create') }}" class="menu-item">

                    <p class="menu-item-title">
                        Hutang Operasional
                        <br>
                        {{$item->nomor}}
                        <br>
                        {{ date('d F Y', strtotime($item->created_at)) }}
                    </p>
                </a>
            </div>
            @endforeach
            


        </div>
    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection