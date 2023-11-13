@extends('layouts.pengajuan')

@push('styles')
<!-- Bootstrap CSS -->
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
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
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Cari">
        </div>
        <div class="row justify-content-between">
            @foreach ($pengajuan as $item)
            <div class="col-12">
                <a href="{{ route('hutangoperasional.create') }}" class="menu-item">
                    <div>
                    <p class="menu-item-title">
                        {{$item->nama}}
                        <br>
                        {{$item->nomor}}
                        <br>
                        {{ date('d F Y', strtotime($item->created_at)) }}
                        
                    </p>
                    </div>
                    <span class="badge badge-success">Baru</span>
                    <button class="btn btn-sm btn-primary text-sm" style="font-size:12px">View Tracking</button>
                </a>
                
            </div>
            @endforeach



        </div>
    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection