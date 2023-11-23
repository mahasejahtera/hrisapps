@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Detail Izin Karyawan</div>
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
                <div class="alert alert-warning">
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
                        <div class="card-title">Data Izin</div>
                    </div>
                    <div class="card-body">
                        <table>
                            <tr>
                                <th>Kategori</th>
                                <th><span class="mx-3">:</span></th>
                                <td>
                                    @if ($dataIzin->status == 'i')
                                        Izin
                                    @elseif ($dataIzin->status == 's')
                                        Sakit
                                    @elseif ($dataIzin->status == 'c')
                                        Cuti
                                    @else
                                        Izin
                                    @endif
                                </td>
                            </tr>
                            @if ($dataIzin->status == 'c')
                                <tr>
                                    <th>Jenis Cuti</th>
                                    <th><span class="mx-3">:</span></th>
                                    <td>
                                        {{ $dataIzin->jenisizin->nama }}
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th>Tanggal Awal</th>
                                <th><span class="mx-3">:</span></th>
                                <td>{{ tanggalBulanIndo($dataIzin->tgl_mulai_izin) }}</td>
                            </tr>
                            @if (!empty($dataIzin->tgl_akhir_izin))
                                <tr>
                                    <th>Tanggal Akhir</th>
                                    <th><span class="mx-3">:</span></th>
                                    <td>{{ tanggalBulanIndo($dataIzin->tgl_akhir_izin) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Jumlah Hari</th>
                                <th><span class="mx-3">:</span></th>
                                <td>
                                    @if (empty($dataIzin->tgl_akhir_izin))
                                        1 Hari
                                    @else
                                        {{ hitungJumlahhari($dataIzin->tgl_mulai_izin, $dataIzin->tgl_akhir_izin) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <th><span class="mx-3">:</span></th>
                                <td>{{ $dataIzin->keterangan }}</td>
                            </tr>
                            <tr>
                                <th>Lampiran</th>
                                <th><span class="mx-3">:</span></th>
                                <td>
                                    @if (!empty($dataIzin->lampiran))
                                        <b><a href="{{ asset('storage/' . $dataIzin->lampiran) }}" target="_blank">Lihat</a></b>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if (auth()->guard('karyawan')->user()->role_id > 1)
                    @if ($dataIzin->status_approved == $kodeStatusApproved)
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <a href="{{ route('presensi.izin.terima', $dataIzin->id) }}" class="btn btn-success mr-2" onclick="return confirm('Anda yakin ingin terima ?')">Terima</a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectIzinModal">
                                Tolak
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        @if (count($trackingIzin) > 0)
            <div class="row px-2 mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Tracking Izin</div>
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
                                        @foreach ($trackingIzin as $item)
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
  <div class="modal fade" id="rejectIzinModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Keterangan Ditolak</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
             <form action="{{route('presensi.izin.tolak', $dataIzin->id)}}" method="post">
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
