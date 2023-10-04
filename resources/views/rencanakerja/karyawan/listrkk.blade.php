@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                List Rencana Kerja
            </h2>
        </div>
    </header>
    <div class="">

        @if (!$data)
            <img src="{{ asset('assets/img/iconrkk.png') }}" alt="">
        @else
            @foreach ($data as $d)
                <a href="{{ route('detail-rkk', ['id' => $d->id]) }}">

                    <div class="container-task m-2">
                        <div class="icon-task text-warning">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                        <div class="text-task text-dark">
                            <div>{{ $d->perihal }}</div>
                            <div class="job-title">{{ $d->waktu }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        @endif
        <button class="btn bg-prima floating-button-rkk text-sec">
            <a href="/karyawan/add-rkk" class="text-sec">+</a>
        </button>
    </div>
</body>
@include('template.bottomNav')
@include('template.footer')

</html>