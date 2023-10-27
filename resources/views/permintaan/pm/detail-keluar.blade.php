@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Detail Permintaan Keluar
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
                <td>: <a href="{{ asset('images/permintaan/' . $data->lampiran_pengirim) }}" target="_blank"
                        class="text-danger">Klik
                        disini</a></td>
            </tr>
            <tr>
                <td>
                    <h3>Status</h3>
                </td>
                <td>:<a href="{{ route('pm-track-permintaan', ['id' => $data->id]) }}" class="text-danger">
                        Lihat Status Permintaan
                    </a></td>
            </tr>
        </table>
    </div>
    @if ($data->status == 3)
        <div class="card m-2">
            <div class="card-body">
                <h5 class="card-title text-danger">Ditolak</h5>
                <table>
                    <tr>
                        <td>Keterangan</td>
                        <td>: {{ $data->keterangan_tolak }}</td>
                    </tr>
                </table>
                {{-- <div class="text-right"><a href="{{ route('hrd-revisi', ['id' => $data->id]) }}"
                        class="btn btn-warning">Perbaharui</a></div> --}}
            </div>
        </div>
    @endif
    @if ($data->status == 4)
        <div class="card m-2">
            <div class="card-body">
                <h5 class="card-title text-success">Diterima</h5>
                <table>
                    <tr>
                        <td>Keterangan</td>
                        <td>: {{ $data->keterangan_penerima }}</td>
                    </tr>
                    <tr>
                        <td>Lampiran</td>
                        <td>: <a href="{{ asset('images/permintaan/' . $data->lampiran_penerima) }}" target="_blank"
                                class="text-danger">Klik
                                disini</a></td>
                    </tr>
                </table>

            </div>
        </div>
    @endif
@endsection
