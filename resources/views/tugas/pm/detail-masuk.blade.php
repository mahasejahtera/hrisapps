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
        <div class="container-tugas-proses ml-2 mb-2 mr-2">
            <h3 class="text-center">Laporan Proses Pekerjaan</h3>
            <form action="">
                @csrf
                <div class="input-group form-group">
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" name="lampiran_pengirim" required>
                        <label class="custom-file-label" for="inputGroupFile04">Lampiran 1</label>
                    </div>
                </div>
                <div class="input-group form-group">
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" name="lampiran_pengirim" required>
                        <label class="custom-file-label" for="inputGroupFile04">Lampiran 2</label>
                    </div>
                </div>
                <div class="input-group form-group">
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" name="lampiran_pengirim" required>
                        <label class="custom-file-label" for="inputGroupFile04">Lampiran 3</label>
                    </div>
                </div>
                <div class="input-group form-group">
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" name="lampiran_pengirim" required>
                        <label class="custom-file-label" for="inputGroupFile04">Lampiran 4</label>
                    </div>
                </div>
                <div class="input-group form-group">
                    <div class="custom-file form-control">
                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" name="lampiran_pengirim" required>
                        <label class="custom-file-label" for="inputGroupFile04">Lampiran 5</label>
                    </div>
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

</html>
