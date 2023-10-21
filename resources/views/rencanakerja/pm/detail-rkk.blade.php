@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Detail Rencana Kerja
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
                <td>: <a href="{{ asset('images/rencanakerja/' . $data->lampiran) }}" target="_blank" class="text-danger">Klik
                        disini</a></td>
            </tr>
            <tr>
                <td>
                    <h3>Status</h3>
                </td>
                <td>:<a href="{{ route('pm-track', ['id' => $data->id]) }}" class="text-danger">
                        @if($data->manajer_approval == 1 && $data->pm_approval == 1 && $data->hrd_approval == 0)
                            Diperiksa oleh HRD
                        @elseif(
                            $data->manajer_approval == 1 &&
                                $data->pm_approval == 1 &&
                                $data->hrd_approval == 1 &&
                                $data->direktur_approval == 0)
                            Diperiksa oleh Direktur
                        @elseif(
                            $data->manajer_approval == 1 &&
                                $data->pm_approval == 1 &&
                                $data->hrd_approval == 1 &&
                                $data->direktur_approval == 1 &&
                                $data->komisaris_approval == 0)
                            Diperiksa oleh Komisaris
                        @else
                            Disetujui
                        @endif
                    </a>
                </td>
            </tr>
        </table>
    </div>
    @if ($data->status == 3)
        <div class="card m-2">
            <div class="card-body">
                <h5 class="card-title text-danger">Revisi</h5>
                <table>
                    <tr>
                        <td>Lampiran</td>
                        <td>: <a href="{{ asset('images/rencanakerja/revisi/' . $data->lampiran_revisi) }}" target="_blank"
                                class="text-danger">Klik disini</a></td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>: {{ $data->ket_revisi }}</td>
                    </tr>
                </table>
                <div class="text-right"><a href="{{ route('pm-revisi', ['id' => $data->id]) }}"
                        class="btn btn-warning">Perbaharui</a></div>
            </div>
        </div>
    @endif
@endsection
