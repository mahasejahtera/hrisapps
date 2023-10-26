@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                List Arsip Permintaan
            </h2>
        </div>
    </header>

    <div class="container-add-rkk">
        <form action="/arsip/permintaan/search" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <input type="text" name="dari" class="form-control" value="{{ $dari }}"
                            placeholder="Dari" onfocus="(this.type='date')" onblur="(this.type='text')" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <input type="text" name="sampai" value="{{ $sampai }}" class="form-control"
                            placeholder="Sampai" onfocus="(this.type='date')" onblur="(this.type='text')" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </form>
        @if (count($data) === 0)
            <img src="{{ asset('assets/img/iconrkk.png') }}" alt="">
        @else

            @foreach ($data as $d)
                <a href="{{ route('arsip-detail-permintaan', ['id' => $d->id]) }}">
                    <div class="container-task m-2">
                        <div class="icon-task text-warning">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                        <div class="text-task text-dark">
                            <div>{{ $d->perihal }}</div>
                            <div class="job-title">{{ $d->waktu }}</div>
                        </div>
                        <div class="badge-status-new">Selesai</div>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
</body>
@include('template.bottomNav')
@include('template.footer')

</html>
