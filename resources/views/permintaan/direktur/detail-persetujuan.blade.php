@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Detail Permintaan Masuk
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
                <td>Pengirim</td>
                <td>: {{ $data->karyawanPengirim->nama }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>: <a href="{{ asset('images/permintaan/' . $data->lampiran_pengirim) }}" target="_blank"
                        class="text-danger">Klik
                        disini</a></td>
            </tr>
        </table>
        @if ($data->status != 3 && $data->status != 4)
            <div class="d-flex">
                <a href="" class="btn btn-success ml-auto" data-toggle="modal"
                    data-target="#exampleModalTerima">Terima</a>
                <a href="" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Tolak</a>
            </div>
        @endif

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Keterangan Menolak</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/direktur/permintaan/tolak/persetujuan" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control" id="message-text" name="keterangan_tolak" placeholder="Keterangan" rows="5"></textarea>
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
        <div class="modal fade" id="exampleModalTerima" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Keterangan Menerima</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/direktur/permintaan/terima/persetujuan" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <p>Apakah Anda Yakin Ingin Menerima Permintaan?</p>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Terima</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($data->status == 3)
        <div class="card m-2">
            <div class="card-body">
                <h5 class="card-title text-danger">Ditolak</h5>
                <table>
                    <tr>
                        <td>Keterangan Menolak</td>
                        <td>: {{ $data->keterangan_tolak }}</td>
                    </tr>
                </table>
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
@section('scriptJS')
    <script>
        $('input[type="file"]').on('change', function(e) {
            var $this = $(this);
            var fileName = e.target.files[0].name;
            $this.siblings().text(fileName);
        });
    </script>
@endsection
