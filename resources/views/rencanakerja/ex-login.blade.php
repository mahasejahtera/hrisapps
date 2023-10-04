@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                Example Login
            </h2>
        </div>
    </header>
    <div class="mt-3">
        <form action="/exlogin" method="post">
            @csrf
            <div class="form-group">
                <select name="id_karyawan" class="form-control form-select">
                    <option selected>--Pilih Departemen--</option>
                    @foreach ($kary as $k)
                        <option value="{{ $k->id }}">Kode Departemen|{{ $k->kode_dept }} | Role |
                            {{ $k->role_id }}</option>
                    @endforeach
                </select>
            </div>
            <button class="form-control btn-danger">Start</button>
        </form>
</body>
@include('template.footer')

</html>
