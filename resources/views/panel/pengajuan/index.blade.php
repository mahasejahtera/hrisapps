@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->

                <h2 class="page-title">
                    Data Pengajuan
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
                                @if (Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                                @endif

                                @if (Session::get('warning'))
                                <div class="alert alert-warning">
                                    {{ Session::get('warning')}}
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-12">
                                <a href="#" class="btn btn-primary" id="btnTambahkaryawan">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5l0 14"></path>
                                        <path d="M5 12l14 0"></path>
                                    </svg>
                                    Tambah Data
                                </a>
                            </div>
                        </div> -->
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="/panel/pengajuan" method="GET">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" placeholder="Nama Karyawan" value="{{ Request('nama_karyawan') }}">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select name="kode_pengajuan" id="kode_pengajuan" class="form-select">
                                                    <option value="">Jenis Pengajuan</option>
                                                    @foreach ($pengajuan as $p)
                                                    <option {{ Request('kode_pengajuan')==$p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ $p->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <select name="kode_dept" id="kode_dept" class="form-select">
                                                    <option value="">Departemen</option>
                                                    @foreach ($departemen as $d)
                                                    <option {{ Request('kode_dept')==$d->id ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->nama_dept }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                        <path d="M21 21l-6 -6"></path>
                                                    </svg>
                                                    Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor</th>
                                            <th>Karyawan</th>
                                            <th>Departemen</th>
                                            <th>Tanggal</th>
                                            <th>Due Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($submit_pengajuan as $d)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ $d->nomor }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->nama_dept }}</td>
                                            <td>{{ $d->tanggal }}</td>
                                            <td>{{ $d->due_date }}</td>

                                            <td>
                                                <span class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                                    <div class="dropdown-menu dropdown-menu-end">


                                                        <a class="dropdown-item" href="#">
                                                            Edit
                                                        </a>

                                                        <a class="dropdown-item" href="{{ route('panelpengajuan.destroy', $d->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $d->id }}').submit();">
                                                            Hapus
                                                        </a>
                                                        <form id="delete-form-{{ $d->id }}" action="{{ route('panelpengajuan.destroy', $d->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $submit_pengajuan->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
<div class="modal modal-blur fade" id="modal-inputkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/karyawan/store" method="POST" id="frmKaryawan" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                                        <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                                        <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                                        <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M5 11h1v2h-1z"></path>
                                        <path d="M10 11l0 2"></path>
                                        <path d="M14 11h1v2h-1z"></path>
                                        <path d="M19 11l0 2"></path>
                                    </svg>
                                </span>
                                <input type="text" maxlength="5" value="" id="nik" class="form-control" placeholder="Nik" name="nik">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                </span>
                                <input type="text" id="nama_lengkap" value="" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-analytics" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z"></path>
                                        <path d="M7 20l10 0"></path>
                                        <path d="M9 16l0 4"></path>
                                        <path d="M15 16l0 4"></path>
                                        <path d="M8 12l3 -3l2 2l3 -3"></path>
                                    </svg>
                                </span>
                                <input type="text" id="jabatan" value="" class="form-control" name="jabatan" placeholder="Jabatan">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                    </svg>
                                </span>
                                <input type="text" id="no_hp" value="" class="form-control" name="no_hp" placeholder="No. HP">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <input type="file" name="foto" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <select name="kode_dept" id="kode_dept" class="form-select">
                                <option value="">Departemen</option>
                                @foreach ($departemen as $d)
                                <option value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <select name="kode_cabang" id="kode_cabang" class="form-select">
                                <option value="">Cabang</option>
                                @foreach ($cabang as $d)
                                <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary w-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
{{-- Modal Edit --}}
<div class="modal modal-blur fade" id="modal-editkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="loadeditform">

            </div>

        </div>
    </div>
</div>


<div class="modal modal-blur fade" id="verificationRegisterModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Pendaftaran Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('karyawan.verification.register') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td id="employeeName"></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td id="employeeEmail"></td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td id="employeeJabatan"></td>
                                </tr>
                                <tr>
                                    <th>Departemen</th>
                                    <td id="employeeDepartemen"></td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle">NIK</th>
                                    <td>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" id="nik" placeholder="NIK">
                                        @error('nik')
                                        <div class="is-invalid-feedback">
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle">Status Karyawan</th>
                                    <td>
                                        <select name="status_karyawan" id="status_karyawan" class="form-control @error('status_karyawan') is-invalid @enderror">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="tetap">Karyawan Tetap</option>
                                            <option value="percobaan">Karyawan Masa Percobaan</option>
                                            <option value="pkwt">Karyawan PKWT</option>
                                            <option value="project">Karyawan Per Project</option>
                                            <option value="harian">Karyawan Harian</option>
                                        </select>
                                        @error('status_karyawan')
                                        <div class="is-invalid-feedback">
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>

                                <tr class="project">
                                    <th style="vertical-align: middle">Project</th>
                                    <td>
                                        <input type="text" class="form-control @error('project') is-invalid @enderror" name="project" id="project" placeholder="cth : Mekanikal Elektrikal Pada Bandara Kualanamu">
                                        @error('project')
                                        <div class="is-invalid-feedback">
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle">Gaji</th>
                                    <td>
                                        <input type="number" class="form-control @error('salary') is-invalid @enderror" name="salary" id="salary" max="999999999">
                                        @error('salary')
                                        <div class="is-invalid-feedback">
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="lama-kontrak">
                                    <th style="vertical-align: middle">Lama Kontrak</th>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <input type="number" class="form-control @error('lama_kontrak_num') is-invalid @enderror" name="lama_kontrak_num" id="lama_kontrak_num" placeholder="Angka">
                                                @error('lama_kontrak_num')
                                                <div class="is-invalid-feedback">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                                @enderror
                                            </div>
                                            <div>
                                                <select name="lama_kontrak_waktu" id="lama_kontrak_waktu" class="form-control @error('lama_kontrak_waktu') is-invalid @enderror">
                                                    <option value="">-- Pilih Waktu --</option>
                                                    <option value="hari">Hari</option>
                                                    <option value="minggu">Minggu</option>
                                                    <option value="bulan">Bulan</option>
                                                    <option value="tahun">Tahun</option>
                                                </select>
                                                @error('lama_kontrak_waktu')
                                                <div class="is-invalid-feedback">
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="mulai-kontrak">
                                    <th style="vertical-align: middle">Mulai Kontrak</th>
                                    <td>
                                        <input type="date" class="form-control @error('mulai_kontrak') is-invalid @enderror" name="mulai_kontrak" id="mulai_kontrak">
                                        @error('mulai_kontrak')
                                        <div class="is-invalid-feedback">
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="akhir-kontrak">
                                    <th style="vertical-align: middle">Akhir Kontrak</th>
                                    <td>
                                        <input type="date" class="form-control @error('akhir_kontrak') is-invalid @enderror" name="akhir_kontrak" id="akhir_kontrak">
                                        @error('akhir_kontrak')
                                        <div class="is-invalid-feedback">
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" name="karyawan_id" id="employeeId">
                                <button class="btn btn-primary w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                    Verifikasi Pendaftaran
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });

    var employeeId = '';
    // verifikasi modal
    $('.btn-verification').on('click', function(e) {
        e.preventDefault();

        employeeId = $(this).attr('data-karyawan');
        $('#verificationRegisterModal').modal('show');
    });

    // set verifikasi modal content
    $('#verificationRegisterModal').on('show.bs.modal', function(e) {
        $.ajax({
            type: 'POST',
            url: "{{ route('karyawan.data') }}",
            data: {
                _token: "{{ csrf_token() }}",
                id: employeeId
            },
            success: function(respond) {
                $('#employeeName').text(respond.nama);
                $('#employeeEmail').text(respond.email);
                $('#employeeJabatan').text(respond.jabatan);
                $('#employeeDepartemen').text(respond.departemen);
                $('#employeeId').val(respond.id);

                $('.lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();
            }
        });
    });


    // status karyawan change
    $('#status_karyawan').on('change', function(e) {
        const value = $(this).val();
        if (value == 'tetap' || value == '') {
            $('.project, .lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();
        }

        if (value == 'project') {
            $('.lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();
            $('.project, .mulai-kontrak').show();
        }

        if (value == 'pkwt' || value == 'percobaan') {
            $('.project, .lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();
            $('.lama-kontrak, .mulai-kontrak, .akhir-kontrak').show();
        }

        if (value == 'harian') {
            $('.project, .lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();
            $('.lama-kontrak, .mulai-kontrak, .akhir-kontrak').show();
        }
    });

    $(function() {

        $("#nik").mask("00-00");
        $("#no_hp").mask("0000000000000");
        $("#btnTambahkaryawan").click(function() {
            $("#modal-inputkaryawan").modal("show");
        });

        $(".edit").click(function() {
            var nik = $(this).attr('nik');
            $.ajax({
                type: 'POST',
                url: '/karyawan/edit',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    nik: nik
                },
                success: function(respond) {
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-editkaryawan").modal("show");
        });

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

        $("#frmKaryawan").submit(function() {
            var nik = $("#nik").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var jabatan = $("#jabatan").val();
            var no_hp = $("#no_hp").val();
            var kode_dept = $("frmKaryawan").find("#kode_dept").val();
            if (nik == "") {
                // alert('Nik Harus Diisi');
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nik Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#nik").focus();
                });

                return false;
            } else if (nama_lengkap == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#nama_lengkap").focus();
                });

                return false;
            } else if (jabatan == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jabatan Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#jabatan").focus();
                });

                return false;
            } else if (no_hp == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'No. HP Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#no_hp").focus();
                });

                return false;
            } else if (kode_dept == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Departemen Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#kode_dept").focus();
                });

                return false;
            }
        });
    });
</script>
@endpush