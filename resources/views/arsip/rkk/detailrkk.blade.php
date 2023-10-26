@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Detail Arsip Rencana Kerja
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
        </table>
    </div>
</body>

@include('template.bottomNav')
@include('template.footer')

</html>
