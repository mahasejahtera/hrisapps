@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Persetujuan Absensi
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Absen Masuk</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                    </div>
                                </div>
                            </div>
                            {{-- <form id="search-form" method="POST" action="/presensi/persetujuan/search">
                                @csrf
                                <div class="row">
                                    <div class="col-6 d-flex justify-content-between">
                                        <div class="form-group col-6">
                                            <input type="text" id="tanggalmulai" name="tanggalmulai"
                                                onfocus="(this.type='date')" onblur="(this.type='text')"
                                                placeholder="Tanggal Mulai" class="form-control" autocomplete="off" required
                                                value="{{ $tanggalMulai }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <input type="text" id="tanggalselesai" name="tanggalselesai"
                                                class="form-control" required autocomplete="off"
                                                placeholder="Tanggal Selesai" value="{{ $tanggalSelesai }}"
                                                onfocus="(this.type='date')" onblur="(this.type='text')" />
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex justify-content-between ">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </form> --}}
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped table-hover w-100 table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Tanggal Presensi</th>
                                                <th>Jam Masuk</th>
                                                <th>Foto Masuk</th>
                                                <th>Status</th>
                                                <th>Lokasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($datamasuk->isEmpty())
                                                <tr>
                                                    <td colspan="12" class="text-center">Tidak ada data dalam tanggal ini
                                                        !!</td>
                                                </tr>
                                            @else
                                                @foreach ($datamasuk as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->karyawan->nama_lengkap }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($d->tgl_presensi)->isoFormat('D MMMM Y') }}
                                                        </td>
                                                        <td>{{ $d->jam_in }}</td>
                                                        <td>
                                                            @if (!empty($d->foto_in))
                                                                <img src="{{ asset('storage/uploads/absensi/' . $d->foto_in) }}"
                                                                    alt="" width="100" height="100">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            Absen Diluar Kantor
                                                        </td>
                                                        <td><a href="/presensi/karyawan/map/detail/{{ $d->id }}"
                                                                target="_blank">Lihat
                                                                Disini</a>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#penerimaanmasuk"
                                                                class="terimamasuk btn btn-primary"
                                                                data-id = "{{ $d->id }}">Terima</a>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#penolakanmasuk"
                                                                data-id = "{{ $d->id }}"
                                                                data-keterangan = "{{ $d->keterangan_tolak }}"
                                                                class="tolakmasuk btn btn-danger">Tolak</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{ $datamasuk->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Absen Pulang</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                    </div>
                                </div>
                            </div>
                            {{-- <form id="search-form" method="POST" action="/presensi/persetujuan/search">
                                @csrf
                                <div class="row">
                                    <div class="col-6 d-flex justify-content-between">
                                        <div class="form-group col-6">
                                            <input type="text" id="tanggalmulai" name="tanggalmulai"
                                                onfocus="(this.type='date')" onblur="(this.type='text')"
                                                placeholder="Tanggal Mulai" class="form-control" autocomplete="off" required
                                                value="{{ $tanggalMulai }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <input type="text" id="tanggalselesai" name="tanggalselesai"
                                                class="form-control" required autocomplete="off"
                                                placeholder="Tanggal Selesai" value="{{ $tanggalSelesai }}"
                                                onfocus="(this.type='date')" onblur="(this.type='text')" />
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex justify-content-between ">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </form> --}}
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped table-hover w-100 table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Tanggal Presensi</th>
                                                <th>Jam Pulang</th>
                                                <th>Foto Pulang</th>
                                                <th>Status</th>
                                                <th>Lokasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($datakeluar->isEmpty())
                                                <tr>
                                                    <td colspan="12" class="text-center">Tidak ada data dalam tanggal ini
                                                        !!</td>
                                                </tr>
                                            @else
                                                @foreach ($datakeluar as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->karyawan->nama_lengkap }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($d->tgl_presensi)->isoFormat('D MMMM Y') }}
                                                        </td>
                                                        <td>{{ $d->jam_out }}</td>
                                                        <td>
                                                            @if (!empty($d->foto_in))
                                                                <img src="{{ asset('storage/uploads/absensi/' . $d->foto_out) }}"
                                                                    alt="" width="100" height="100">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            Absen Diluar Kantor
                                                        </td>
                                                        <td><a href="/presensi/karyawan/map/detail/keluar/{{ $d->id }}"
                                                                target="_blank">Lihat disini</a>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#penerimaankeluar"
                                                                class="terimakeluar btn btn-primary"
                                                                data-id = "{{ $d->id }}">Terima</a>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#penolakankeluar"
                                                                data-id = "{{ $d->id }}"
                                                                data-keterangan = "{{ $d->keterangan_tolak }}"
                                                                class="tolakpulang btn btn-danger">Tolak</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{ $datakeluar->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Uang Makan Luar Kota</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                    </div>
                                </div>
                            </div>
                            {{-- <form id="search-form" method="POST" class="mb-3" action="/presensi/persetujuan/search">
                                @csrf
                                <div class="row">
                                    <div class="col-6 d-flex justify-content-between">
                                        <div class="form-group col-6">
                                            <input type="text" id="tanggalmulai" name="tanggalmulai"
                                                onfocus="(this.type='date')" onblur="(this.type='text')"
                                                placeholder="Tanggal Mulai" class="form-control" autocomplete="off" required
                                                value="{{ $tanggalMulai }}">
                                        </div>
                                        <div class="form-group col-6">
                                            <input type="text" id="tanggalselesai" name="tanggalselesai"
                                                class="form-control" required autocomplete="off"
                                                placeholder="Tanggal Selesai" value="{{ $tanggalSelesai }}"
                                                onfocus="(this.type='date')" onblur="(this.type='text')" />
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex justify-content-between ">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </form> --}}
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped table-hover w-100 table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nik</th>
                                                <th>Nama</th>
                                                <th>Tanggal Presensi</th>
                                                <th>Lokasi Masuk</th>
                                                <th>Lokasi Keluar</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($dataumlk->isEmpty())
                                                <tr>
                                                    <td colspan="12" class="text-center">Tidak ada data dalam tanggal
                                                        ini
                                                        !!</td>
                                                </tr>
                                            @else
                                                @foreach ($dataumlk as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->nik }}</td>
                                                        <td>{{ $d->karyawan->nama_lengkap }}</td>
                                                        <td> {{ \Carbon\Carbon::parse($d->tgl_presensi)->isoFormat('D MMMM Y') }}
                                                        </td>
                                                        <td> <a href="/presensi/karyawan/map/detail/{{ $d->id }}"
                                                                target="_blank">Lihat
                                                                Disini</a>
                                                        </td>
                                                        <td> <a href="/presensi/karyawan/map/detail/keluar/{{ $d->id }}"
                                                                target="_blank">Lihat disini</a></td>
                                                        <td>
                                                            @if ($d->absen_in_status == 3 && $d->absen_out_status == 3)
                                                                Absen Masuk dan Pulang Diluar Deli Serdang
                                                            @elseif($d->absen_in_status == 3)
                                                                Absen Masuk Diluar Deli Serdang
                                                            @elseif($d->absen_out_status == 3)
                                                                Absen Pulang Diluar Deli Serdang
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#penerimaanumlk"
                                                                class="terimaumlk btn btn-primary"
                                                                data-id = "{{ $d->id }}">Terima</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{ $dataumlk->links('vendor.pagination.bootstrap-5') }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="penolakankeluar" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penolakan Absensi Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="submitTolak">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="penerimaankeluar" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Persetujuan Absensi Pulang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <select class="form-select" id="statuspulang" name="pulangcepat">
                                <option value="" selected>Pilih Status Pulang</option>
                                <option value="0">Pulang Tepat Waktu</option>
                                <option value="1">Pulang Cepat</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Terima
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="penolakanmasuk" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penolakan Absensi Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="submitTolak1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="penerimaanmasuk" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Persetujuan Absensi Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <select class="form-select" id="jenisTerlambat" name="terlambat">
                                <option value="" selected>Pilih Status Terlambat</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="submit1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Terima
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="penerimaanumlk" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Persetujuan Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <select class="form-select" id="terimaUangMakan" name="uang_makan">
                                <option value="" selected>Pilih Terima Uang Makan</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="mb-3" id="teksTerimaUangMakan" style="display: none;">
                            <label class="form-label">Total Makan Sehari</label>
                            <input type="number" id="alasanTerimaUangMakan" name="jumlah" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="submitumlk">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Terima
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
@push('myscript')
    <script>
        $(document).ready(function() {
            $('#terimaUangMakan').change(function() {
                if ($(this).val() === '1') {
                    $('#teksTerimaUangMakan').show();
                } else {
                    $('#teksTerimaUangMakan').hide();
                }
            });
        });
    </script>
    @if (session('message'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "{{ session('message') }}"
            });
        </script>
    @endif

    <script>
        document.querySelectorAll('.tolakmasuk').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id');
                document.querySelector('#penolakanmasuk form').action =
                    `/presensi/persetujuan/masuk/tolak/${id}`;
            });
        });

        document.querySelectorAll('.terimamasuk').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id');
                document.querySelector('#penerimaanmasuk form').action =
                    `/presensi/persetujuan/masuk/terima/${id}`;
            });
        });

        document.querySelectorAll('.tolakpulang').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id');
                document.querySelector('#penolakankeluar form').action =
                    `/presensi/persetujuan/pulang/tolak/${id}`;
            });
        });

        document.querySelectorAll('.terimakeluar').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id');
                document.querySelector('#penerimaankeluar form').action =
                    `/presensi/persetujuan/pulang/terima/${id}`;
            });
        });

        document.querySelectorAll('.terimaumlk').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id');
                document.querySelector('#penerimaanumlk form').action =
                    `/presensi/persetujuan/umlk/${id}`;
            });
        });
    </script>

    <script>
        $(function() {
            $("#submit").click(function() {
                var pulang = $("#statuspulang").val();
                if (pulang === "") {
                    showError("Status Pulang Harus Diisi!");
                    return false;
                }
            });

            $("#submit1").click(function() {
                var terlambat = $("#jenisTerlambat").val();
                if (terlambat === "") {
                    showError("Status Terlambat Harus Diisi!");
                    return false;
                }
            });

            $("#submitumlk").click(function() {
                var uangmakan = $("#terimaUangMakan").val();
                if (uangmakan === "") {
                    showError("Uang Makan Harus Diisi!");
                    return false;
                } else if (uangmakan === "1") {
                    var jumlah = $("#alasanTerimaUangMakan").val();
                    if (jumlah === "") {
                        showError("Jumlah Makan Sehari Harus Diisi!");
                        return false;
                    }
                }
            });

            $("#submitTolak").click(function() {
                var keterangan = $("#keterangan").val();
                if (keterangan === "") {
                    showError("Keterangan Harus Diisi!");
                    return false;
                }
            });
            $("#submitTolak1").click(function() {
                var keterangan = $("#keterangan").val();
                if (keterangan === "") {
                    showError("Keterangan Harus Diisi!");
                    return false;
                }
            });

            function showError(message) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: message
                });
            }
        });
    </script>
@endpush
