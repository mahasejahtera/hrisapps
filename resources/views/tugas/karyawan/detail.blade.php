@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Detail Tugas Masuk
            </h2>
        </div>
    </header>
    <div class="container-detail-tugas">
        <div class="container-detail-task ml-2 mb-2 mr-2">
            <table>
                <tr>
                    <td>Perihal </td>
                    <td>: {{ $data->perihal }}</td>
                </tr>
                <tr>
                    <td>Lokasi </td>
                    <td>: {{ $data->lokasi }}</td>
                </tr>
                <tr>
                    <td>Waktu Pelaksanaan</td>
                    <td>: {{ $data->waktu }}</td>
                </tr>
                <tr>
                    <td>Jatuh Tempo</td>
                    <td>: {{ $data->jatuh_tempo }}</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: {{ $data->keterangan_pengirim }}</td>
                </tr>
                <tr>
                    <td>Prioritas</td>
                    <td>: {{ $data->prioritas }}</td>
                </tr>
                <tr>
                    <td>Pengirim</td>
                    <td>: {{ $data->karyawanPengirim->nama }}</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>: <a href="{{ asset('images/tugas/' . $data->lampiran_pengirim) }}" target="_blank"
                            class="text-danger">Klik disini</a></td>
                </tr>
            </table>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container-tugas-proses ml-2 mb-2 mr-2">
            <h3 class="text-center">Foto Laporan Proses Pekerjaan</h3>
            <form action="/karyawan/tugas/update" enctype="multipart/form-data" method="post">
                @csrf
                <input type="hidden" value="{{ $data->id }}" name="id">
                @if ($data->progress1 != null)
                    <div class="">
                        <a href="{{ asset('images/tugas/' . $data->progress1) }}" target="_blank"
                            class="text-success">File berhasil diupload lihat lampiran 1</a>
                    </div>
                @endif
                <div class="input-group form-group">
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" name="lampiran1">
                        <label class="custom-file-label" for="inputGroupFile04">Lampiran 1</label>
                    </div>
                </div>
                @if ($data->progress2 != null)
                    <div class="">
                        <a href="{{ asset('images/tugas/' . $data->progress2) }}" target="_blank"
                            class="text-success">File berhasil diupload lihat lampiran 2</a>
                    </div>
                @endif
                <div class="input-group form-group">
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" name="lampiran2">
                        <label class="custom-file-label" for="inputGroupFile04">Lampiran 2</label>
                    </div>
                </div>
                @if ($data->progress3 != null)
                    <div class="">
                        <a href="{{ asset('images/tugas/' . $data->progress3) }}" target="_blank"
                            class="text-success">File berhasil diupload lihat lampiran 3</a>
                    </div>
                @endif
                <div class="input-group form-group">
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" name="lampiran3">
                        <label class="custom-file-label" for="inputGroupFile04">Lampiran 3</label>
                    </div>
                </div>
                @if ($data->progress4 != null)
                    <div class="">
                        <a href="{{ asset('images/tugas/' . $data->progress4) }}" target="_blank"
                            class="text-success">File berhasil diupload lihat lampiran 4</a>
                    </div>
                @endif
                <div class="input-group form-group">
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" name="lampiran4">
                        <label class="custom-file-label" for="inputGroupFile04">Lampiran 4</label>
                    </div>
                </div>
                @if ($data->progress5 != null)
                    <div class="">
                        <a href="{{ asset('images/tugas/' . $data->progress5) }}" target="_blank"
                            class="text-success">File berhasil diupload lihat lampiran 5</a>
                    </div>
                @endif
                <div class="input-group form-group">
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" name="lampiran5">
                        <label class="custom-file-label" for="inputGroupFile04">Lampiran 5</label>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="keterangan" id="exampleFormControlTextarea1" rows="5"
                        placeholder="Keterangan">
@if ($data->keterangan_progress != null)
{{ $data->keterangan_progress }}
@endif
</textarea>
                </div>
                <div class="form-group ">
                    <button type="submit" class="btn btn-block bg-prima text-sec">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
@include('template.bottomNav')
@include('template.footer')
<script>
    $('input[type="file"]').on('change', function(e) {
        var $this = $(this);
        var fileName = e.target.files[0].name;

        $this.siblings().text(fileName);
    });
</script>

</html>
