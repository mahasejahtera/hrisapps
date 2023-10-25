@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Permintaan
            </h2>
        </div>
    </header>

    <div class="container-add-rkk" style="margin-top: 120px;">
        <form action="/manajer/permintaan/add/proses" method="post" enctype="multipart/form-data" required>
            @csrf
            <div class="form-group">
                <input type="text" name="perihal" class="form-control" placeholder="Perihal" required>
            </div>
            <div class="form-group">
                <input type="text" name="lokasi" class="form-control" placeholder="Lokasi" required>
            </div>
            <div class="form-group">
                <input type="text" name="waktu" class="form-control" placeholder="Waktu Pelaksanaan"
                    onfocus="(this.type='date')" onblur="(this.type='text')" required>
            </div>
            <div class="form-group">
                <input type="text" name="jatuh_tempo" class="form-control" placeholder="Jatuh Tempo" required
                    onfocus="(this.type='date')" onblur="(this.type='text')">
            </div>
            <div class="form-group">
                <textarea class="form-control" name="keterangan_pengirim" id="exampleFormControlTextarea1" rows="5"
                    placeholder="Keterangan" required></textarea>
            </div>
            <div class="input-group form-group">
                <div class="custom-file form-control">
                    <input type="file" class="custom-file-input" id="inputGroupFile04"
                        aria-describedby="inputGroupFileAddon04" name="lampiran_pengirim" required>
                    <label class="custom-file-label" for="inputGroupFile04">Lampiran</label>
                </div>
            </div>
            <div class="form-group">
                <select name="prioritas" class="form-control form-select" required>
                    <option selected>--Pilih Prioritas--</option>
                    <option value="Penting">Penting</option>
                    <option value="Normal">Normal</option>
                    <option value="Mendesak">Mendesak</option>
                </select>
            </div>
            <div class="form-group">
                <select name="penerima" class="form-control form-select" required>
                    <option selected>--Pilih Penerima--</option>
                    @foreach ($Allkaryawan as $ky)
                        @if ($ky->id != $idk)
                            <option value="{{ $ky->id }}">{{ $ky->nama }} || Departemen ||
                                {{ $ky->kode_dept }} || {{ $ky->role_id }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group ">
                <button type="submit" class="btn btn-block bg-prima text-sec">Submit</button>
            </div>
        </form>
    </div>
</body>
@include('template.bottomNav')
@include('template.footer')
@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'File harus berupa pdf',
        });
    </script>
@endif
<script>
    $('input[type="file"]').on('change', function(e) {
        var $this = $(this);
        var fileName = e.target.files[0].name;
        $this.siblings().text(fileName);
    });
</script>

</html>
