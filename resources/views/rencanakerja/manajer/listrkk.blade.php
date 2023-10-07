@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                List Rencana Kerja
            </h2>
        </div>
    </header>
    <div class="container-add-rkk">
        {{-- @if (!$data) --}}
        <img src="{{ asset('assets/img/iconrkk.png') }}" alt="">
        {{-- @else
            @foreach ($data as $d)
                <a href="{{ route('detail-rkk', ['id' => $d->id]) }}">

                    <div class="container-task m-2">
                        <div class="icon-task text-warning">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                        <div class="text-task text-dark">
                            <div></div>
                            <div class="job-title"></div>
                        </div>
                    </div>
                </a>
            @endforeach
        @endif --}}
        <a href="/karyawan/add-rkk" class="btn bg-prima floating-button-rkk text-sec">
            +
        </a>
    </div>
@endsection
