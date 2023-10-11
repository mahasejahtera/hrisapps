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
        @if (count($data) === 0)
            <img src="{{ asset('assets/img/iconrkk.png') }}" alt="">
        @else
            @foreach ($data as $d)
                <a href="{{ route('detail-rkk-du-from-komisaris', ['id' => $d->id]) }}">
                    <div class="container-task m-2">
                        <div class="icon-task text-warning">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                        <div class="text-task text-dark">
                            <div>{{ $d->perihal }}</div>
                            <div class="job-title">{{ $d->waktu }}</div>
                        </div>
                        @if ($d->status === 0)
                            <div class="badge-status-new">Baru</div>
                        @else
                            <div class="badge-status-read">Dibaca</div>
                        @endif
                    </div>
                </a>
            @endforeach
        @endif

    </div>
@endsection
