@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                List Permintaan Masuk
            </h2>
        </div>
    </header>
    <div class="container-add-rkk">
        @if (count($data) === 0)
            <img src="{{ asset('images/per.png') }}" alt="">
        @else
            @foreach ($data as $d)
                <a href="{{ route('detail-permintaan-masuk-pm', ['id' => $d->id]) }}">
                    <div class="container-task m-2">
                        <div class="icon-task text-warning">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                        <div class="text-task text-dark">
                            <div>{{ $d->perihal }}</div>
                            <div class="job-title">{{ $d->waktu }}</div>
                        </div>
                        @if ($d->status === 1)
                            <div class="badge-status-new">Baru</div>
                        @elseif ($d->status === 2)
                            <div class="badge-status-read">Dibaca</div>
                        @elseif ($d->status === 3)
                            <div class="badge-status-revisi">Ditolak</div>
                        @elseif ($d->status === 4)
                            <div class="badge-status-new">Diterima</div>
                        @endif
                    </div>
                </a>
            @endforeach
        @endif
    </div>
@endsection

