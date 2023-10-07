@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Detail Tugas
            </h2>
        </div>
    </header>
    <div class="container-detail-task ml-2 mb-2 mr-2">
        <table>
            <tr>
                <td>Perihal </td>
                <td>: </td>
            </tr>
            <tr>
                <td>Lokasi </td>
                <td>: </td>
            </tr>
            <tr>
                <td>Waktu Pelaksanaan</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Jatuh Tempo</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Prioritas</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>: <a href="" target="_blank" class="text-danger">Klik
                        disini</a></td>
            </tr>
    </div>
    </table>
    <div class="container ">
        <div class="row">
            <div class="text-right">
                <a href="" class="btn btn-success">Accept</a>
                <a href="" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Revisi</a>
            </div>
        </div>
    </div>
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
                    <form>
                        @csrf
                        <div class="input-group form-group">
                            <div class="custom-file form-control">
                                <input type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="message-text" placeholder="Keterangan" rows="5"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </div>
    </div>
@endsection
