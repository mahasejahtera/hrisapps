@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                Rencana Kerja
            </h2>
        </div>
    </header>

    <div class="container-add-rkk mt-2">
        <form action="/karyawan/addrkk/proses" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" name="perihal" class="form-control" placeholder="Perihal">
            </div>
            <div class="form-group">
                <input type="text" name="lokasi" class="form-control" placeholder="Lokasi">
            </div>
            <div class="form-group">
                <input type="text" name="waktu" class="form-control" placeholder="Waktu Pelaksanaan"
                    onfocus="(this.type='date')" onblur="(this.type='text')">
            </div>
            <div class="form-group">
                <input type="text" name="target" class="form-control" placeholder="Target Penyelesaian"
                    onfocus="(this.type='date')" onblur="(this.type='text')">
            </div>
            <div class="form-group">
                <textarea class="form-control" name="keterangan" id="exampleFormControlTextarea1" rows="5"
                    placeholder="Keterangan"></textarea>
            </div>
            <div class="form-group">
                <label for="fileInput" class="d-flex align-items-center">
                    <input type="file" class="form-control pt-1" name="lampiran">
                </label>
            </div>
            <div class="form-group">
                <select name="prioritas" class="form-control form-select">
                    <option selected>--Pilih Prioritas--</option>
                    <option value="Penting">Penting</option>
                    <option value="Normal">Normal</option>
                    <option value="Mendesak">Mendesak</option>
                </select>
            </div>
            <div class="form-group ">
                <button class="btn btn-block bg-prima text-sec">Submit</button>
            </div>
        </form>
    </div>
</body>
@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'File harus berupa pdf',
        });
    </script>
@endif
@include('template.bottomNav')
@include('template.footer')

</html>
