@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Absensi Ditolak
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
                            {{-- <form id="search-form" method="POST" action="/presensi/penolakan/search">
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
                                                <th>Lokasi</th>
                                                <th>Keterangan Tolak</th>
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
                                                        <td>{{ $d->tgl_presensi }}</td>
                                                        <td>{{ $d->jam_in }}</td>
                                                        <td>
                                                            @if (!empty($d->foto_in))
                                                                <img src="{{ asset('storage/uploads/absensi/' . $d->foto_in) }}"
                                                                    alt="" width="100" height="100">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="/presensi/karyawan/map/detail/{{ $d->id }}"
                                                                target="_blank">Lihat
                                                                Disini</a>
                                                        </td>
                                                        <td>{{ $d->ket_in_tolak }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#penerimaanmasuk"
                                                                    class="terimamasuk btn btn-primary me-2"
                                                                    data-id="{{ $d->id }}">Terima</a>
                                                                <form action="/presensi/penolakan/hapus/{{ $d->id }}"
                                                                    method="POST" class="delete-form">
                                                                    @csrf
                                                                    <a class="btn btn-danger delete-confirm">Hapus</a>
                                                                </form>
                                                            </div>
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
                            {{-- <form id="search-form" method="POST" action="/presensi/penolakan/search">
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
                                                <th>Lokasi</th>
                                                <th>Keterangan Tolak</th>
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
                                                        <td>{{ $d->tgl_presensi }}</td>
                                                        <td>{{ $d->jam_out }}</td>
                                                        <td>
                                                            @if (!empty($d->foto_in))
                                                                <img src="{{ asset('storage/uploads/absensi/' . $d->foto_in) }}"
                                                                    alt="" width="100" height="100">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="/presensi/karyawan/map/detail/keluar/{{ $d->id }}"
                                                                target="_blank">Lihat disini</a>
                                                        </td>
                                                        <td>{{ $d->ket_out_tolak }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#penerimaanpulang"
                                                                    class="terimapulang btn btn-primary me-2"
                                                                    data-id="{{ $d->id }}">Terima</a>
                                                                <form
                                                                    action="/presensi/penolakan/hapus/{{ $d->id }}"
                                                                    method="POST" class="delete-form">
                                                                    @csrf
                                                                    <a class="btn btn-danger delete-confirm">Hapus</a>
                                                                </form>
                                                            </div>
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

    <div class="modal" id="penerimaanmasuk" tabindex="-1">
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

    <div class="modal" id="penerimaanpulang" tabindex="-1">
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
    //tolak
    <script>
        document.querySelectorAll('.terimamasuk').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id');
                document.querySelector('#penerimaanmasuk form').action =
                    `/presensi/penolakan/masuk/terima/${id}`;
            });
        });

        document.querySelectorAll('.terimapulang').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id');
                document.querySelector('#penerimaanpulang form').action =
                    `/presensi/penolakan/pulang/terima/${id}`;
            });
        });
    </script>
    <script>
        $(".delete-confirm").click(function(e) {
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin Data Ini Mau Di Hapus ?',
                text: "Jika Ya Maka Data Akan Terhapus Permanent",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Deleted!', 'Data Berhasil Di Hapus', 'success'
                    )
                }
            })
        });

        $(function() {
            $("#submit").click(function() {
                var terlambat = $("#jenisTerlambat").val();
                if (terlambat === "") {
                    showError("Status Terlambat Harus Diisi!");
                    return false;
                }
            });
            $("#submit1").click(function() {
                var pulang = $("#statuspulang").val();
                if (pulang === "") {
                    showError("Status Pulang Harus Diisi!");
                    return false;
                }
            });

            function showError(message) {
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
                    icon: "error",
                    title: message
                });
            }
        });
    </script>
@endpush
