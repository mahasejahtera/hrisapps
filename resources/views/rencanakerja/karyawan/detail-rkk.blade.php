@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                Detail Tugas
            </h2>
        </div>
    </header>
    <div class="container-detail-task m-2">
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
                <td>: {{ $data->target_penyelesaian }}</td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>: {{ $data->keterangan }}</td>
            </tr>
            <tr>
                <td>Prioritas</td>
                <td>: {{ $data->prioritas }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>: <a href="{{ asset('images/rencanakerja/' . $data->lampiran) }}" target="_blank"
                        class="text-danger">Klik disini</a></td>
            </tr>

    </div>
    </table>
    <div class="text-right"><a href="" class="btn btn-success">Proses</a></div>
    </div>

</body>

@include('template.bottomNav')
@include('template.footer')

</html>
