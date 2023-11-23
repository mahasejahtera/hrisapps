@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Persetujuan Absensi Masuk
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                    </div>
                                </div>
                            </div>
                            <form id="search-form" method="POST" action="/presensi/persetujuan/search">
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
                            </form>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped table-hover w-100 table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nik</th>
                                                <th>Nama</th>
                                                <th>Tanggal Presensi</th>
                                                <th>Jam Masuk</th>
                                                <th>Foto Masuk</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data->isEmpty())
                                                <tr>
                                                    <td colspan="12" class="text-center">Tidak ada data dalam tanggal ini
                                                        !!</td>
                                                </tr>
                                            @else
                                                @foreach ($data as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->nik }}</td>
                                                        <td>{{ $d->karyawan->nama_lengkap }}</td>
                                                        <td>{{ $d->tgl_presensi }}</td>
                                                        <td>{{ $d->jam_in }}</td>
                                                        <td>
                                                            @if (!empty($d->foto_in))
                                                                <img src="{{ asset('storage/uploads/absensi/' . $d->foto_in) }}"
                                                                    alt="" width="100" height="100">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            Absen Diluar Radius
                                                        </td>
                                                        <td>
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#penerimaan" class="terima btn btn-primary"
                                                                data-id = "{{ $d->id }}">Terima</a>

                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#penolakan" data-id = "{{ $d->id }}"
                                                                data-keterangan = "{{ $d->keterangan_tolak }}"
                                                                class="tolak btn btn-danger">Tolak</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{ $data->links('vendor.pagination.bootstrap-5') }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="penolakan" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penolakan Absensi</h5>
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
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
    <div class="modal" id="penerimaan" tabindex="-1">
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
                            <select class="form-select" id="jenisTerlambat" name="terlambat">
                                <option value="" selected>Pilih Status Terlambat</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
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
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="submit">
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
                icon: "info",
                title: "{{ session('message') }}"
            });
        </script>
    @endif
    //tolak
    <script>
        document.querySelectorAll('.tolak').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id');
                document.querySelector('#penolakan form').action = `/presensi/persetujuan/tolak/${id}`;
            });
        });

        document.querySelectorAll('.terima').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id');
                document.querySelector('#penerimaan form').action = `/presensi/persetujuan/terima/${id}`;
            });
        });
    </script>
    <script>
        $(function() {
            $("#submit").click(function() {
                var terlambat = $("#jenisTerlambat").val();
                var uangmakan = $("#terimaUangMakan").val();
                if (terlambat === "") {
                    showError("Status Terlambat Harus Diisi!");
                    return false;
                } else if (uangmakan === "") {
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

            function showError(message) {
                Swal.fire({
                    title: 'Warning!',
                    text: message,
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                });
            }
        });
    </script>
@endpush
