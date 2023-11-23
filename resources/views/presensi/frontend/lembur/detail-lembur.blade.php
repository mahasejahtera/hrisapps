@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Detail Lembur Karyawan</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
    <div class="data-izin-wrapper">
        <div class="row" style="margin-top:70px">
            <div class="col">
                @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
                @endphp
                @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ $messagesuccess }}
                </div>
                @endif
                @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ $messageerror }}
                </div>
                @endif
            </div>
        </div>
        @if (auth()->guard('karyawan')->user()->role_id > 1)
            <div class="row px-2">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Data Karyawan</div>
                        </div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <th>Nama</th>
                                    <th><span class="mx-3">:</span></th>
                                    <td>{{ $karyawan[0]->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <th><span class="mx-3">:</span></th>
                                    <td>{{ $karyawan[0]->nik }}</td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <th><span class="mx-3">:</span></th>
                                    <td>{{ $karyawan[0]->jabatan_kerja->nama_jabatan }}</td>
                                </tr>
                                <tr>
                                    <th>Departemen</th>
                                    <th><span class="mx-3">:</span></th>
                                    <td>{{ $karyawan[0]->department->nama_dept }}</td>
                                </tr>
                                <tr>
                                    <th>Cabang</th>
                                    <th><span class="mx-3">:</span></th>
                                    <td>{{ $karyawan[0]->cabang->nama_cabang }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row px-2 mt-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Data Lembur</div>
                    </div>
                    <div class="card-body">
                        <table>
                            <tr>
                                <th>Tanggal Lembur</th>
                                <th><span class="mx-3">:</span></th>
                                <td>{{ tanggalBulanIndo($dataLembur->tgl_lembur) }}</td>
                            </tr>
                            <tr>
                                <th>Jam Mulai</th>
                                <th><span class="mx-3">:</span></th>
                                <td>{{ $dataLembur->jam_mulai }}</td>
                            </tr>
                            <tr>
                                <th>Jam Selesai</th>
                                <th><span class="mx-3">:</span></th>
                                <td>{{ $dataLembur->jam_selesai }}</td>
                            </tr>
                            <tr>
                                <th>Perihal</th>
                                <th><span class="mx-3">:</span></th>
                                <td>{{ $dataLembur->perihal }}</td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <th><span class="mx-3">:</span></th>
                                <td>{{ $dataLembur->keterangan }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-2 mt-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Foto Lembur</div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr align="middle">
                                <th colspan="3">Foto Mulai</th>
                            </tr>
                            @foreach ($fotoMulai as $fm)
                            <tr>
                                <th>Foto</th>
                                <th><span class="mx-3">:</span></th>
                                <td><a href="{{ asset("storage/$fm->foto_lembur") }}" target="_blank" class="">Lihat disini</a></td>
                            </tr>
                            @endforeach
                            @if (count($fotoMulai) < 1)
                                @if ($dataLembur->status_approved == 11)
                                    <tr>
                                        <td>
                                            <a href="{{ route('presensi.lembur.foto', [1, $dataLembur->id]) }}" class="btn btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                            <tr align="middle">
                                <th colspan="3">Foto Berlangsung <span class="text-danger">(min. 3)</span></th>
                            </tr>
                            @foreach ($fotoBerlangsung as $fb)
                            <tr>
                                <th>Foto {{ $loop->iteration }}</th>
                                <th><span class="mx-3">:</span></th>
                                <td><a href="{{ asset("storage/$fb->foto_lembur") }}" target="_blank" class="">Lihat disini</a></td>
                            </tr>
                            @endforeach

                            @if ($dataLembur->status_approved == 11)
                                <tr>
                                    <td>
                                        <a href="{{ route('presensi.lembur.foto', [2, $dataLembur->id]) }}" class="btn btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                            <tr align="middle">
                                <th colspan="3">Foto Selesai</th>
                            </tr>
                            @foreach ($fotoSelesai as $fs)
                            <tr>
                                <th>Foto</th>
                                <th><span class="mx-3">:</span></th>
                                <td><a href="{{ asset("storage/$fs->foto_lembur") }}" target="_blank" class="">Lihat disini</a></td>
                            </tr>
                            @endforeach
                            @if (count($fotoSelesai) < 1)
                                @if ($dataLembur->status_approved == 11)
                                    <tr>
                                        <td>
                                            <a href="{{ route('presensi.lembur.foto', [3, $dataLembur->id]) }}" class="btn btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        </table>
                    </div>
                </div>

                @if (auth()->guard('karyawan')->user()->role_id > 1)
                    @if ($dataLembur->status_approved == $kodeStatusApproved)
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <a href="{{ route('presensi.lembur.terima', $dataLembur->id) }}" class="btn btn-success mr-2" onclick="return confirm('Anda yakin ingin terima ?')">Terima</a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectLemburModal">
                                Tolak
                            </button>
                        </div>
                    @endif
                @endif

                @if (auth()->guard('karyawan')->user()->role_id == 1)
                    @if ($dataLembur->status_approved == 11)
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <a href="{{ route('presensi.lembur.ajukan', $dataLembur->id) }}" class="btn btn-success mr-2 btn-ajukan">Ajukan</a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        @if (count($trackingLembur) > 0)
            <div class="row px-2 mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Tracking Lembur</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr align="middle">
                                            <th>TANGGAL</th>
                                            <th>STATUS</th>
                                            <th>KETERANGAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trackingLembur as $item)
                                            <tr>
                                                <td align="middle">
                                                    {{ tanggalBulanIndo(date('Y-m-d', strtotime($item->created_at))) . ' / ' . date('H:i', strtotime($item->created_at)) }}
                                                </td>
                                                <td align="middle">{{ $item->keterangan }}</td>
                                                <td>
                                                    {{ (!empty($item->keterangan_tolak)) ? $item->keterangan_tolak : '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>


  <!-- Modal Reject Izin -->
  <div class="modal fade" id="rejectLemburModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Keterangan Ditolak</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
             <form action="{{route('presensi.lembur.tolak', $dataLembur->id)}}" method="post">
                @csrf

                <div class="form-group">
                    <label for="keterangan_tolak">Keterangan</label>
                    <textarea name="keterangan_tolak" id="keterangan_tolak" cols="1" rows="3" class="form-control"></textarea>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Tolak</button>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function(e) {
            if({{ count($fotoMulai) }} < 1 || {{ count($fotoBerlangsung) }} < 3 || {{ count($fotoSelesai) }} < 1) {

                $('.btn-ajukan').prop('disabled', true);
                $('.btn-ajukan').css('cursor', 'not-allowed');
                $('.btn-ajukan').removeClass('btn-success');;
                $('.btn-ajukan').addClass('btn-secondary');;

                $('.btn-ajukan').on('click', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Gagal !'
                        , text: 'Foto belum lengkap'
                        , icon: 'error'
                    });
                });
            } else {
                $('.btn-ajukan').on('click', function(e) {
                    return confirm('Anda yakin ingin mengajukan ?');
                });
            }
        });
    </script>
@endpush
