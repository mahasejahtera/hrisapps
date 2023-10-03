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
                <select name="kode_dept" class="form-control form-select">
                    <option selected>--Pilih Departemen--</option>
                    <option value="KM">Komisaris</option>
                    <option value="DU">Direktur Utama</option>
                    <option value="DR">Direktur Keuangan</option>
                    <option value="GM">General Manager</option>
                    <option value="IT">Information Technology</option>
                    <option value="PN">Pemasaran</option>
                    <option value="PN">Produksi</option>
                    <option value="HR">Human Resource Development</option>
                    <option value="SC">SCM</option>
                    <option value="KU">Keuangan</option>
                </select>
            </div>
            <div class="form-group">
                <select name="role_id" class="form-control form-select">
                    <option selected>--Pilih Role--</option>
                    <option value="1">Karyawan</option>
                    <option value="2">Manager</option>
                    <option value="3">General Manager</option>
                    <option value="4">Direktur</option>
                    <option value="5">Komisaris</option>
                </select>
            </div>
            <button class="form-control btn-danger">Start</button>
        </form>
</body>
@include('template.footer')
</html>
