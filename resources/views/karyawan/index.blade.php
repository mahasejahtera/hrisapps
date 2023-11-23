@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->

                <h2 class="page-title">
                    Data Karyawan
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

                                @if (Session::get('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error')}}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
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
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                            </div>
                        </div>
                        <div class="row mt-3 justify-content-end">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <select id="jenis_kontrak" class="form-select" data-table-target="#karyawan-datatable">
                                        <option value="">-- Pilih Jenis Kontrak --</option>
                                        <option value="tetap">Tetap / PKWTT</option>
                                        <option value="pkwt">PKWT</option>
                                        <option value="project">Project</option>
                                        <option value="harian">Harian</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <select id="kode_dept" class="form-select" data-table-target="#karyawan-datatable">
                                        <option value="">-- Pilih Departemen --</option>
                                        @foreach ($departemen as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama_dept }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group mb-3">
                                    <select id="status_karyawan" class="form-select" data-table-target="#karyawan-datatable">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="0">Verifikasi Register</option>
                                        <option value="1">Pengisian Data</option>
                                        <option value="2">Verifikasi Data</option>
                                        <option value="3">Aktif</option>
                                        <option value="4">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered table-striped table-hover" id="karyawan-datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jabatan</th>
                                            <th>Departemen</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
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

{{-- modal verifikasi register --}}
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
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" id="nik" placeholder="NIK" value="{{ old('nik') }}">
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
                                            <option value="tetap" @selected(old('status_karyawan') == 'tetap')>Karyawan Tetap</option>
                                            <option value="percobaan" @selected(old('status_karyawan') == 'percobaan')>Karyawan Masa Percobaan</option>
                                            <option value="pkwt" @selected(old('status_karyawan') == 'pkwt')>Karyawan PKWT</option>
                                            <option value="project" @selected(old('status_karyawan') == 'project')>Karyawan Per Project</option>
                                            <option value="harian" @selected(old('status_karyawan') == 'harian')>Karyawan Harian</option>
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
                                        <input type="text" class="form-control @error('project') is-invalid @enderror" name="project" id="project" placeholder="cth : Mekanikal Elektrikal Pada Bandara Kualanamu" value="{{ old('project') }}">
                                        @error('project')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="show_contract">
                                    <th style="vertical-align: middle">Tampilkan Kontrak</th>
                                    <td>
                                        <input type="radio" name="kontrak_tampil" id="kontrak_tampil" value="1">
                                        <label for="kontrak_tampil" @selected(old('kontrak_tampil') == 1)>Tampilkan</label>
                                        <input type="radio" class="ms-3" name="kontrak_tampil" id="tampilkan_kontrak1" value="0">
                                        <label for="tampilkan_kontrak1" @selected(old('kontrak_tampil') == 0)>Tidak Tampil</label>
                                        @error('kontrak_tampil')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle">Gaji</th>
                                    <td>
                                        <input type="number" class="form-control @error('salary') is-invalid @enderror" name="salary" id="salary" max="999999999" value="{{ old('salary') }}">
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
                                                <input type="number" class="form-control @error('lama_kontrak_num') is-invalid @enderror" name="lama_kontrak_num" id="lama_kontrak_num" placeholder="Angka" value="{{ old('lama_kontrak_num') }}">
                                                @error('lama_kontrak_num')
                                                    <div class="is-invalid-feedback">
                                                        <small class="text-danger">{{ $message }}</small>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div>
                                                <select name="lama_kontrak_waktu" id="lama_kontrak_waktu" class="form-control @error('lama_kontrak_waktu') is-invalid @enderror">
                                                    <option value="">-- Pilih Waktu --</option>
                                                    <option value="hari" @selected(old('lama_kontrak_waktu') == 'hari')>Hari</option>
                                                    <option value="minggu" @selected(old('lama_kontrak_waktu') == 'minggu')>Minggu</option>
                                                    <option value="bulan" @selected(old('lama_kontrak_waktu') == 'bulan')>Bulan</option>
                                                    <option value="tahun" @selected(old('lama_kontrak_waktu') == 'tahun')>Tahun</option>
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
                                        <input type="date" class="form-control @error('mulai_kontrak') is-invalid @enderror" name="mulai_kontrak" id="mulai_kontrak" value="{{ old('mulai_kontrak') }}">
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
                                        <input type="date" class="form-control @error('akhir_kontrak') is-invalid @enderror" name="akhir_kontrak" id="akhir_kontrak" value="{{ old('akhir_kontrak') }}">
                                        @error('akhir_kontrak')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="jobdesk">
                                    <th style="vertical-align: middle">Jobdesk</th>
                                    <td>
                                        <textarea name="jobdesk_content" class="jobdesk-input" id="jobdeskInput">{{ old('jobdesk_content') }}</textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="hidden" name="karyawan_id" id="employeeId">
                                <button class="btn btn-danger w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                    Verifikasi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal verifikasi data --}}
<div class="modal modal-blur fade" id="verificationDataModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Data Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mt-2">
                    <p class="m-0">Lihat data karyawan :</p>
                    <a href="#" class="btn btn-danger d-inline ms-2 btn-detail">
                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.61,27.65-38.4A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path></svg>
                        Lihat
                    </a>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <form action="{{ route('karyawan.verification.data') }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-bordered table-striped table-hover">
                                            <tr>
                                                <th style="vertical-align: middle">Kode Surat Karyawan</th>
                                                <td>
                                                    <input type="text" class="form-control @error('kode_surat_karyawan') is-invalid @enderror" name="kode_surat_karyawan" id="kode_surat_karyawan" placeholder="Max : 2 Huruf">
                                                    @error('kode_surat_karyawan')
                                                        <div class="is-invalid-feedback">
                                                            <small class="text-danger">{{ $message }}</small>
                                                        </div>
                                                    @enderror
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <input type="hidden" name="karyawan_id" id="employeeId">
                                <button class="btn btn-primary w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                    Verifikasi Data Karyawan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- modal vnonaktifkan karyawan --}}
<div class="modal modal-blur fade" id="nonaktifkanKaryawanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nonaktifkan Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <form action="{{ route('karyawan.nonaktifkan') }}" method="post">
                                @csrf

                                <p>Apakah anda yakin ingin menonaktifkan karyawan ini ?</p>

                                <input type="hidden" name="karyawan_id" id="employeeId">
                                <button class="btn btn-primary w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                    Nonaktifkan Karyawan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


{{-- modal transfer --}}
<div class="modal modal-blur fade" id="transferModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transfer Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('karyawan.transfer.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-striped table-hover">
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td id="employeeNameTransfer"></td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td id="employeeNIKTransfer"></td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td id="employeeJabatanTransfer"></td>
                                </tr>
                                <tr>
                                    <th>Departemen</th>
                                    <td id="employeeDepartemenTransfer"></td>
                                </tr>
                                <tr>
                                    <th>Cabang/Penempatan</th>
                                    <td id="employeeCabangTransfer"></td>
                                </tr>
                                <tr>
                                    <th>Status Karyawan</th>
                                    <td id="employeeStatusTransfer"></td>
                                </tr>
                                <tr>
                                    <th>Gaji</th>
                                    <td id="employeeSalaryTransfer"></td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="text-center">TRANFER</th>
                                </tr>
                                <tr>
                                    <th style="vertical-align: middle">Status Transfer</th>
                                    <td>
                                        <select name="status_transfer" id="status_transfer" class="form-control @error('status_transfer') is-invalid @enderror">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="1" @selected(old('status_transfer') == '1')>Mutasi</option>
                                            <option value="2" @selected(old('status_transfer') == '2')>Promosi</option>
                                            <option value="3" @selected(old('status_transfer') == '3')>Demosi</option>
                                        </select>
                                        @error('status_transfer')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="department-transfer">
                                    <th style="vertical-align: middle">Departemen</th>
                                    <td>
                                        <select name="department_id" id="departmentTransfer" class="form-control @error('department_id') is-invalid @enderror">
                                            <option value="">-- Pilih Departemen --</option>
                                            @foreach ($departemen as $dept)
                                                <option value="{{ $dept->id }}" @selected(old('department_id') == $dept->id)>{{ $dept->nama_dept }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="jabatan-transfer">
                                    <th style="vertical-align: middle">Jabatan</th>
                                    <td>
                                        <select name="jabatan_id" id="jabatanTransfer" class="form-control @error('jabatan_id') is-invalid @enderror">
                                            <option value="">-- Pilih Jabatan --</option>
                                        </select>
                                        @error('jabatan_id')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="cabang-transfer">
                                    <th style="vertical-align: middle">Cabang</th>
                                    <td>
                                        <select name="cabang" id="cabangTransfer" class="form-control @error('cabang') is-invalid @enderror">
                                            <option value="">-- Pilih Cabang --</option>
                                            @foreach ($cabang as $cb)
                                                <option value="{{ $cb->kode_cabang }}" @selected(old('cabang') == $cb->kode_cabang)>{{ $cb->nama_cabang }}</option>
                                            @endforeach
                                        </select>
                                        @error('cabang')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="status-karyawan-transfer">
                                    <th style="vertical-align: middle">Status Karyawan</th>
                                    <td>
                                        <select name="status_karyawan" id="statusKaryawanTransfer" class="form-control @error('status_karyawan') is-invalid @enderror">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="tetap" @selected(old('status_karyawan') == 'tetap')>Karyawan Tetap</option>
                                            <option value="percobaan" @selected(old('status_karyawan') == 'percobaan')>Karyawan Masa Percobaan</option>
                                            <option value="pkwt" @selected(old('status_karyawan') == 'pkwt')>Karyawan PKWT</option>
                                            <option value="project" @selected(old('status_karyawan') == 'project')>Karyawan Per Project</option>
                                            <option value="harian" @selected(old('status_karyawan') == 'harian')>Karyawan Harian</option>
                                        </select>
                                        @error('status_karyawan')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="project-transfer">
                                    <th style="vertical-align: middle">Project</th>
                                    <td>
                                        <input type="text" class="form-control @error('project') is-invalid @enderror" name="project" id="projectTransfer" placeholder="cth : Mekanikal Elektrikal Pada Bandara Kualanamu" value="{{ old('project') }}">
                                        @error('project')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="show-contract-transfer">
                                    <th style="vertical-align: middle">Tampilkan Kontrak</th>
                                    <td>
                                        <input type="radio" name="kontrak_tampil" id="kontrak_tampilTransfer" value="1">
                                        <label for="kontrak_tampil" @selected(old('kontrak_tampil') == 1)>Tampilkan</label>
                                        <input type="radio" class="ms-3" name="kontrak_tampil" id="kontrak_tampilTransfer1" value="0">
                                        <label for="tampilkan_kontrak1" @selected(old('kontrak_tampil') == 0)>Tidak Tampil</label>
                                        @error('kontrak_tampil')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="salary-transfer">
                                    <th style="vertical-align: middle">Gaji</th>
                                    <td>
                                        <input type="number" class="form-control @error('salary') is-invalid @enderror" name="salary" id="salaryTransfer" max="999999999" value="{{ old('salary') }}">
                                        @error('salary')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="lama-kontrak-transfer">
                                    <th style="vertical-align: middle">Lama Kontrak</th>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <input type="number" class="form-control @error('lama_kontrak_num') is-invalid @enderror" name="lama_kontrak_num" id="lama_kontrak_numTransfer" placeholder="Angka" value="{{ old('lama_kontrak_num') }}">
                                                @error('lama_kontrak_num')
                                                    <div class="is-invalid-feedback">
                                                        <small class="text-danger">{{ $message }}</small>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div>
                                                <select name="lama_kontrak_waktu" id="lama_kontrak_waktuTransfer" class="form-control @error('lama_kontrak_waktu') is-invalid @enderror">
                                                    <option value="">-- Pilih Waktu --</option>
                                                    <option value="hari" @selected(old('lama_kontrak_waktu') == 'hari')>Hari</option>
                                                    <option value="minggu" @selected(old('lama_kontrak_waktu') == 'minggu')>Minggu</option>
                                                    <option value="bulan" @selected(old('lama_kontrak_waktu') == 'bulan')>Bulan</option>
                                                    <option value="tahun" @selected(old('lama_kontrak_waktu') == 'tahun')>Tahun</option>
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
                                <tr class="mulai-kontrak-transfer">
                                    <th style="vertical-align: middle">Mulai Kontrak</th>
                                    <td>
                                        <input type="date" class="form-control @error('mulai_kontrak') is-invalid @enderror" name="mulai_kontrak" id="mulai_kontrakTransfer" value="{{ old('mulai_kontrak') }}">
                                        @error('mulai_kontrak')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="akhir-kontrak-transfer">
                                    <th style="vertical-align: middle">Akhir Kontrak</th>
                                    <td>
                                        <input type="date" class="form-control @error('akhir_kontrak') is-invalid @enderror" name="akhir_kontrak" id="akhir_kontrakTransfer" value="{{ old('akhir_kontrak') }}">
                                        @error('akhir_kontrak')
                                            <div class="is-invalid-feedback">
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr class="jobdesk-transfer">
                                    <th style="vertical-align: middle">Jobdesk</th>
                                    <td>
                                        <textarea name="jobdesk_content" class="jobdesk-input @error('jobdesk_content') is-invalid @enderror" id="jobdeskInputTransfer">{{ old('jobdesk_content') }}</textarea>
                                        @error('jobdesk_content')
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
                                <input type="hidden" name="karyawan_id" id="employeeIdTransfer">
                                <button class="btn btn-danger w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                    Transfer
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal aktifkan karyawan --}}
<div class="modal modal-blur fade" id="aktifKaryawanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aktif Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <form action="{{ route('karyawan.aktifkan') }}" method="post">
                                @csrf
                                <p>Apakah anda yakin ingin mengaktifkan karyawan ini ?</p>
                                <input type="hidden" name="karyawan_id" id="employeeId">
                                <button class="btn btn-primary w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path
                                            d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5">
                                        </path>
                                    </svg>
                                    Aktfikan Karyawan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- modal change password --}}
<div class="modal modal-blur fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('karyawan.changepassword') }}" method="POST">
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

                                <tr class="project">
                                    <th style="vertical-align: middle">Password Baru</th>
                                    <td>
                                        <input type="text" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new_password" placeholder="Password Baru" value="{{ old('new_password') }}">
                                        @error('new_password')
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
                                <button class="btn btn-danger w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                    Ubah Password
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
    $('.jobdesk-input').each(function(i,el) {
        ClassicEditor
        .create(el)
        .catch( error => {
            console.error( error );
        } );
    });

    var employeeId = '';
    var employeeEmail = '';

    $(document).ready(function(e) {

        $('#karyawan-datatable').dataTable({
            ordering: true,
            processing: true,
            serverSide: true,
            ajax: {
                'url': "{{ route('admin.karyawan.datatables') }}",
                'data': function (d) {
                    d.jenisKontrak = $('#jenis_kontrak').val();
                    d.department = $('#kode_dept').val();
                    d.status = $('#status_karyawan').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'nik', name: 'nik'},
                {data: 'nama_lengkap', name: 'nama_lengkap'},
                {data: 'contract.jabatan.nama_jabatan', name: 'jabatan_kerja.nama_jabatan'},
                {data: 'department.nama_dept', name: 'department.nama_dept'},
                {data: 'statuslabel', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            'columnDefs': [
                {
                    "targets": 0,
                    "className": "text-center",
                },
                {
                    "targets": 1,
                    "className": "text-center",
                },
                {
                    "targets": 5,
                    "className": "text-center",
                },
                {
                    "targets": 6,
                    "className": "text-center",
                },
            ]
        });

        $('#jenis_kontrak').on('change', function(e) {
            const $this = $(this);
            reloadDatatables($this.attr('data-table-target'));
        });

        $('#kode_dept').on('change', function(e) {
            const $this = $(this);
            reloadDatatables($this.attr('data-table-target'));
        });

        $('#status_karyawan').on('change', function(e) {
            const $this = $(this);
            reloadDatatables($this.attr('data-table-target'));
        });

        // verifivation register
        $('#verificationRegisterModal .project, .lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();

        // transfer
        $('#transferModal .department-transfer, .jabatan-transfer, .cabang-transfer, .status-karyawan-transfer, .project-transfer, .show-contract-transfer, .salary-transfer, .lama-kontrak-transfer, .mulai-kontrak-transfer, .akhir-kontrak-transfer, .jobdesk-transfer').hide();


        const oldJabatan = "{{ old('jabatan_id') }}";

        if(oldJabatan) {
            const valueDept = $('#transferModal #departmentTransfer').val();

            $.ajax({
                url: "{{ route('register.jabatan') }}",
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    value: valueDept,
                    oldJabatan: oldJabatan,
                    isSet: true
                },
                success: function(response) {
                    $('#transferModal #jabatanTransfer').html(response.jabatanOption);
                }
            });
        }
    });

    function reloadDatatables(tbl) {
        var table = $(tbl).DataTable();
        table.cleanData;
        table.ajax.reload();
    }

    /*=======================================================
                    VERIFICATION
    =======================================================*/

    // verifikasi modal
    $(document).on('click', '.btn-verification', function(e) {
        e.preventDefault();

        employeeId = $(this).attr('data-karyawan');
        employeeEmail = $(this).attr('data-email');
        verificationStatus = $(this).attr('data-status');

        if(verificationStatus == 'register') $('#verificationRegisterModal').modal('show');
        if(verificationStatus == 'data') $('#verificationDataModal').modal('show');
        if(verificationStatus == 'aktif') $('#nonaktifkanKaryawanModal').modal('show');
        if (verificationStatus == 'nonaktif') $('#aktifKaryawanModal').modal('show');
    });

    // set verifikasi modal content
    $('#verificationRegisterModal').on('show.bs.modal', function(e) {
        $.ajax({
            type: 'POST'
            , url: "{{ route('karyawan.data.register') }}"
            , data: {
                _token: "{{ csrf_token() }}",
                id: employeeId
            }
            , success: function(respond) {
                $('#verificationRegisterModal #employeeName').text(respond.nama);
                $('#verificationRegisterModal #employeeEmail').text(respond.email);
                $('#verificationRegisterModal #employeeJabatan').text(respond.jabatan);
                $('#verificationRegisterModal #employeeDepartemen').text(respond.departemen);
                $('#verificationRegisterModal #employeeId').val(respond.id);

                $('#verificationRegisterModal .lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();
            }
        });
    });

    // verifikasi data modal on show
    $('#verificationDataModal').on('show.bs.modal', function(e) {
        const $this = $(this);
        const urlDetail = `/karyawan/detail/${employeeEmail}`;

        const employeeIdInput = $this.find('#employeeId');
        const btnDetail = $this.find('.btn-detail');

        $(employeeIdInput).val(employeeId);
        $(btnDetail).attr('href', urlDetail);
    });

    // verifikasi data modal on show
    $('#nonaktifkanKaryawanModal').on('show.bs.modal', function(e) {
        const $this = $(this);

        const employeeIdInput = $this.find('#employeeId');

        $(employeeIdInput).val(employeeId);
    });

    $('#aktifKaryawanModal').on('show.bs.modal', function(e) {
        const $this = $(this);
        const employeeIdInput = $this.find('#employeeId');
        $(employeeIdInput).val(employeeId);
    });


    // status karyawan change
    $('#status_karyawan').on('change', function(e) {
        const value = $(this).val();
        if(value == 'tetap' || value == '') {
            $('#verificationRegisterModal .project, .lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();
        }

        if(value == 'project') {
            $('#verificationRegisterModal .lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();
            $('#verificationRegisterModal .project, .mulai-kontrak').show();
        }

        if(value == 'pkwt' || value == 'percobaan') {
            $('#verificationRegisterModal .project, .lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();
            $('#verificationRegisterModal .lama-kontrak, .mulai-kontrak, .akhir-kontrak').show();
        }

        if(value == 'harian') {
            $('#verificationRegisterModal .project, .lama-kontrak, .mulai-kontrak, .akhir-kontrak').hide();
            $('#verificationRegisterModal .mulai-kontrak').show();
        }
    });

    $('#verificationRegisterModal input[name="kontrak_tampil"]').on('change', function(e){
        const value = $(this).val();

        if(value == 0) {
            $('#verificationRegisterModal .jobdesk').hide();
        } else {
            $('#verificationRegisterModal .jobdesk').show();
        }
    });


    /*=======================================================
                    TRANSFER
    =======================================================*/

    $(document).on('click', '.transfer-action', function(e) {
        const $this = $(this);
        employeeId = $this.attr('data-karyawan');

        $('#transferModal').modal('show');
    });


    $('#transferModal').on('show.bs.modal', function(e) {
        $.ajax({
            type: 'POST'
            , url: "{{ route('karyawan.data') }}"
            , data: {
                _token: "{{ csrf_token() }}",
                id: employeeId
            }
            , success: function(respond) {
                $('#transferModal #employeeNameTransfer').text(respond.nama);
                $('#transferModal #employeeNIKTransfer').text(respond.nik);
                $('#transferModal #employeeJabatanTransfer').text(respond.jabatan);
                $('#transferModal #employeeDepartemenTransfer').text(respond.departemen);
                $('#transferModal #employeeCabangTransfer').text(respond.cabang);
                $('#transferModal #employeeStatusTransfer').text(respond.status);
                $('#transferModal #employeeSalaryTransfer').text(respond.salary);
                $('#transferModal #employeeIdTransfer').val(respond.id);
            }
        });
    });


    // status transfer change
    $('#transferModal #status_transfer').on('change', function(e) {
        const $this = $(this);
        const value = $this.val();

        // mutasi
        if(value == 1) {
            $('#transferModal .department-transfer, .jabatan-transfer, .status-karyawan-transfer, .salary-transfer, .jobdesk-transfer').hide();
            $('#transferModal .cabang-transfer').show();
        } else if(value == 2 || value == 3) {
            $('#transferModal .department-transfer, .jabatan-transfer, .cabang-transfer, .status-karyawan-transfer, .salary-transfer, .jobdesk-transfer').show();
        } else {
            $('#transferModal .department-transfer, .jabatan-transfer, .cabang-transfer, .status-karyawan-transfer, .salary-transfer, .jobdesk-transfer').hide();
        }
    });


    $('#transferModal #departmentTransfer').on('change', function(e) {
        const $this = $(this);
        const deptValue = $this.val();

        if(deptValue != '')
        {
            $.ajax({
                url: "{{ route('register.jabatan') }}",
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    value: deptValue
                },
                success: function(response) {
                    $('#transferModal #jabatanTransfer').html(response.jabatanOption);
                }
            });
        } else {
            $('#transferModal #jabatanTransfer').html("<option value=''>--Pilih Jabatan--</option>");
        }
    });


    // status karyawan change
    $('#transferModal #statusKaryawanTransfer').on('change', function(e) {
        const value = $(this).val();
        if(value == 'tetap' || value == '') {
            $('#transferModal .project-transfer, .lama-kontrak-transfer, .mulai-kontrak-transfer, .akhir-kontrak-transfer').hide();
        }

        if(value == 'project') {
            $('#transferModal .lama-kontrak-transfer, .mulai-kontrak-transfer, .akhir-kontrak-transfer').hide();
            $('#transferModal .project-transfer, .mulai-kontrak-transfer').show();
        }

        if(value == 'pkwt' || value == 'percobaan') {
            $('#transferModal .project-transfer, .lama-kontrak-transfer, .mulai-kontrak-transfer, .akhir-kontrak-transfer').hide();
            $('#transferModal .lama-kontrak-transfer, .mulai-kontrak-transfer, .akhir-kontrak-transfer').show();
        }

        if(value == 'harian') {
            $('#transferModal .project-transfer, .lama-kontrak-transfer, .mulai-kontrak-transfer, .akhir-kontrak-transfer').hide();
            $('#transferModal .mulai-kontrak-transfer').show();
        }
    });


    $(document).on('click', '.btn-change-password', function(e) {
        e.preventDefault();

        employeeId = $(this).attr('data-karyawan');
        $('#changePasswordModal').modal('show');
    });


    // set verifikasi modal content
    $('#changePasswordModal').on('show.bs.modal', function(e) {
        $.ajax({
            type: 'POST'
            , url: "{{ route('karyawan.data.register') }}"
            , data: {
                _token: "{{ csrf_token() }}",
                id: employeeId
            }
            , success: function(respond) {
                $('#changePasswordModal #employeeName').text(respond.nama);
                $('#changePasswordModal #employeeEmail').text(respond.email);
                $('#changePasswordModal #employeeJabatan').text(respond.jabatan);
                $('#changePasswordModal #employeeDepartemen').text(respond.departemen);
                $('#changePasswordModal #employeeId').val(respond.id);
            }
        });
    });

    //================================================


    $(function() {

        $("#nik").mask("00-00");
        $("#no_hp").mask("0000000000000");
        $("#btnTambahkaryawan").click(function() {
            $("#modal-inputkaryawan").modal("show");
        });

        $(".edit").click(function() {
            var nik = $(this).attr('nik');
            $.ajax({
                type: 'POST'
                , url: '/karyawan/edit'
                , cache: false
                , data: {
                    _token: "{{ csrf_token() }}"
                    , nik: nik
                }
                , success: function(respond) {
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-editkaryawan").modal("show");
        });

        $(".delete-confirm").click(function(e) {
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin Data Ini Mau Di Hapus ?'
                , text: "Jika Ya Maka Data Akan Terhapus Permanent"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Ya, Hapus Saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Deleted!'
                        , 'Data Berhasil Di Hapus'
                        , 'success'
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
                    title: 'Warning!'
                    , text: 'Nik Harus Diisi !'
                    , icon: 'warning'
                    , confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#nik").focus();
                });

                return false;
            } else if (nama_lengkap == "") {
                Swal.fire({
                    title: 'Warning!'
                    , text: 'Nama Harus Diisi !'
                    , icon: 'warning'
                    , confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#nama_lengkap").focus();
                });

                return false;
            } else if (jabatan == "") {
                Swal.fire({
                    title: 'Warning!'
                    , text: 'Jabatan Harus Diisi !'
                    , icon: 'warning'
                    , confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#jabatan").focus();
                });

                return false;
            } else if (no_hp == "") {
                Swal.fire({
                    title: 'Warning!'
                    , text: 'No. HP Harus Diisi !'
                    , icon: 'warning'
                    , confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#no_hp").focus();
                });

                return false;
            } else if (kode_dept == "") {
                Swal.fire({
                    title: 'Warning!'
                    , text: 'Departemen Harus Diisi !'
                    , icon: 'warning'
                    , confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#kode_dept").focus();
                });

                return false;
            }
        });
    });

</script>
@endpush
