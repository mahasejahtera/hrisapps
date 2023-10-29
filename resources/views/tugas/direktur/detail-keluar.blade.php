@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Detail Tugas Keluar
            </h2>
        </div>
    </header>
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
                <td>Penerima</td>
                <td>: {{ $data->karyawanPenerima->nama }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>: <a href="{{ asset('images/tugas/' . $data->lampiran_pengirim) }}" target="_blank"
                        class="text-danger">Klik disini</a></td>
            </tr>
        </table>
    </div>
    <div class="card m-2">
        <div class="card-body">
            <h5 class="card-title text-warning">Proses Tugas</h5>
            <table>
                <tr>
                    <td>Lampiran 1</td>
                    <td>:
                        @if ($data->progress1 != null)
                            <a href="{{ asset('images/tugas/' . $data->progress1) }}" target="_blank"
                                class="text-danger">Klik disini</a>
                        @else
                            <span class="text-warning">Tugas belum di update</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Lampiran 2</td>
                    <td>: @if ($data->progress2 != null)
                            <a href="{{ asset('images/tugas/' . $data->progress2) }}" target="_blank"
                                class="text-danger">Klik disini</a>
                        @else
                            <span class="text-warning">Tugas belum di update</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Lampiran 3</td>
                    <td>: @if ($data->progress3 != null)
                            <a href="{{ asset('images/tugas/' . $data->progress3) }}" target="_blank"
                                class="text-danger">Klik disini</a>
                        @else
                            <span class="text-warning">Tugas belum di update</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Lampiran 4</td>
                    <td>: @if ($data->progress4 != null)
                            <a href="{{ asset('images/tugas/' . $data->progress4) }}" target="_blank"
                                class="text-danger">Klik disini</a>
                        @else
                            <span class="text-warning">Tugas belum di update</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Lampiran 5</td>
                    <td>: @if ($data->progress5 != null)
                            <a href="{{ asset('images/tugas/' . $data->progress5) }}" target="_blank"
                                class="text-danger">Klik disini</a>
                        @else
                            <span class="text-warning">Tugas belum di update</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: {{ $data->keterangan_progress }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
@include('template.bottomNav')
@include('template.footer')

</html>
