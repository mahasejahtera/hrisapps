@include('template.header')

<body>
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
                <a href="{{ route('detail-rkk', ['id' => $d->id]) }}">

                    <div class="container-task m-2">
                        <div class="icon-task text-warning">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                        <div class="text-task text-dark">
                            <div>{{ $d->perihal }}</div>
                            <div class="job-title">{{ $d->waktu }}</div>
                        </div>
                        @if ($d->status === 3)
                            <div class="badge-status-revisi">Revisi</div>
                        @endif
                    </div>
                </a>
            @endforeach
        @endif
        <a href="/karyawan/add-rkk" class="btn bg-prima floating-button-rkk text-sec">
            +
        </a>
    </div>
</body>
@include('template.bottomNav')
@include('template.footer')
@if (session('success'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        });
    </script>
@endif

</html>
