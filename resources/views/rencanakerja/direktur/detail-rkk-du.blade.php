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
        </table>
        @if ($data->status !== 3)
            <div class="d-flex">
                <form method="POST" action="/direktur/approval" class="ml-auto">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <button type="submit" class="btn btn-success">Terima</button>
                </form>
                <a href="" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Revisi</a>
            </div>
        @endif
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
            </div>
        </div>
    @endif
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keterangan Revisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/direktur/revisi" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            div class="custom-file form-control">
                            <input type="file" class="custom-file-input" id="inputGroupFile04"
                                aria-describedby="inputGroupFileAddon04" name="lampiran">
                            <label class="custom-file-label" for="inputGroupFile04">Lampiran</label>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="message-text" name="keterangan" placeholder="Keterangan" rows="5"></textarea>
                        </div>
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptJS')
    <script>
        $('input[type="file"]').on('change', function(e) {
            var $this = $(this);
            var fileName = e.target.files[0].name;
            $this.siblings().text(fileName);
        });
    </script>
@endsection
