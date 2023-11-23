@extends('layouts.admin.tabler')
@section('content')
    <div class="page-body m-5">
        <div class="container-fluid">
            <section id="form-bio">
                <div class="biodata-confirm-wrapper">
                    <h2 class="page-title">
                        Edit Karyawan
                    </h2>
                    <div class="card mb-2">
                        <div class="card-header">
                            <h3 class="card-title">Data Riwayat Pendidikan</h3>
                        </div>
                        <form action="{{ route('admin.karyawan.update.pendidikan', $karyawan->email) }}" class="m-3"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $karyawanEducation[0]->id }}" required />
                            @if (
                                $karyawanEducation[0]->last_education == 'sd' ||
                                    $karyawanEducation[0]->last_education == 'smp' ||
                                    $karyawanEducation[0]->last_education == 'sd' ||
                                    $karyawanEducation[0]->last_education == 'sma' ||
                                    $karyawanEducation[0]->last_education == 'd i' ||
                                    $karyawanEducation[0]->last_education == 'd ii' ||
                                    $karyawanEducation[0]->last_education == 'd iii' ||
                                    $karyawanEducation[0]->last_education == 's1' ||
                                    $karyawanEducation[0]->last_education == 's2' ||
                                    $karyawanEducation[0]->last_education == 's3')
                                <div class="mb-3">
                                    <div class="text-center">
                                        <p class="m-0 h3">
                                            <strong>SD</strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama SD</label>
                                    <input type="text" class="form-control" name="nama_sd"
                                        value="{{ strtoupper($karyawanEducation[0]->primary_school) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Masuk</label>
                                    <input type="number" class="form-control" name="masuk_sd"
                                        value="{{ strtoupper($karyawanEducation[0]->sd_start_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Selesai</label>
                                    <input type="number" class="form-control" name="selesai_sd"
                                        value="{{ strtoupper($karyawanEducation[0]->sd_end_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Berijazah</label>
                                    <select class="form-select" name="sd_ijazah">
                                        <option value="y"
                                            {{ $karyawanEducation[0]->sd_ijazah == 'y' ? 'selected' : '' }}>Ya</option>
                                        <option value="n"
                                            {{ $karyawanEducation[0]->sd_ijazah == 'n' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                            @endif
                            @if (
                                $karyawanEducation[0]->last_education == 'smp' ||
                                    $karyawanEducation[0]->last_education == 'sd' ||
                                    $karyawanEducation[0]->last_education == 'sma' ||
                                    $karyawanEducation[0]->last_education == 'd i' ||
                                    $karyawanEducation[0]->last_education == 'd ii' ||
                                    $karyawanEducation[0]->last_education == 'd iii' ||
                                    $karyawanEducation[0]->last_education == 's1' ||
                                    $karyawanEducation[0]->last_education == 's2' ||
                                    $karyawanEducation[0]->last_education == 's3')
                                <div class="mb-3">
                                    <div class="text-center">
                                        <p class="m-0 h3">
                                            <strong>SMP</strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama SMP</label>
                                    <input type="text" class="form-control" name="nama_smp"
                                        value="{{ strtoupper($karyawanEducation[0]->junior_hight_school) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Masuk</label>
                                    <input type="number" class="form-control" name="masuk_smp"
                                        value="{{ strtoupper($karyawanEducation[0]->smp_start_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Selesai</label>
                                    <input type="number" class="form-control" name="selesai_smp"
                                        value="{{ strtoupper($karyawanEducation[0]->smp_end_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Berijazah</label>
                                    <select class="form-select" name="smp_ijazah">
                                        <option value="y"
                                            {{ $karyawanEducation[0]->smp_ijazah == 'y' ? 'selected' : '' }}>Ya</option>
                                        <option value="n"
                                            {{ $karyawanEducation[0]->smp_ijazah == 'n' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                            @endif
                            @if (
                                $karyawanEducation[0]->last_education == 'sma' ||
                                    $karyawanEducation[0]->last_education == 'd i' ||
                                    $karyawanEducation[0]->last_education == 'd ii' ||
                                    $karyawanEducation[0]->last_education == 'd iii' ||
                                    $karyawanEducation[0]->last_education == 's1' ||
                                    $karyawanEducation[0]->last_education == 's2' ||
                                    $karyawanEducation[0]->last_education == 's3')
                                <div class="mb-3">
                                    <div class="text-center">
                                        <p class="m-0 h3">
                                            <strong>SMA</strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama SMA</label>
                                    <input type="text" class="form-control" name="nama_sma"
                                        value="{{ strtoupper($karyawanEducation[0]->senior_hight_school) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Masuk</label>
                                    <input type="number" class="form-control" name="masuk_sma"
                                        value="{{ strtoupper($karyawanEducation[0]->sma_start_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Selesai</label>
                                    <input type="number" class="form-control" name="selesai_sma"
                                        value="{{ strtoupper($karyawanEducation[0]->sma_end_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Berijazah</label>
                                    <select class="form-select" name="sma_ijazah">
                                        <option value="y"
                                            {{ $karyawanEducation[0]->sma_ijazah == 'y' ? 'selected' : '' }}>Ya</option>
                                        <option value="n"
                                            {{ $karyawanEducation[0]->sma_ijazah == 'n' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                            @endif
                            @if (
                                $karyawanEducation[0]->last_education == 'd i' ||
                                    $karyawanEducation[0]->last_education == 'd ii' ||
                                    $karyawanEducation[0]->last_education == 'd iii' ||
                                    $karyawanEducation[0]->last_education == 's1' ||
                                    $karyawanEducation[0]->last_education == 's2' ||
                                    $karyawanEducation[0]->last_education == 's3')
                                <div class="mb-3">
                                    <div class="text-center">
                                        <p class="m-0 h3">
                                            <strong>Sarjana</strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Universitas</label>
                                    <input type="text" class="form-control" name="nama_univ"
                                        value="{{ strtoupper($karyawanEducation[0]->bachelor_university) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" name="jurusan_univ"
                                        value="{{ strtoupper($karyawanEducation[0]->bachelor_major) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Masuk</label>
                                    <input type="number" class="form-control" name="masuk_univ"
                                        value="{{ strtoupper($karyawanEducation[0]->bachelor_start_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Lulus</label>
                                    <input type="number" class="form-control" name="selesai_univ"
                                        value="{{ strtoupper($karyawanEducation[0]->bachelor_end_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Berijazah</label>
                                    <select class="form-select" name="univ_ijazah">
                                        <option value="y"
                                            {{ $karyawanEducation[0]->bachelor_ijazah == 'y' ? 'selected' : '' }}>Ya
                                        </option>
                                        <option value="n"
                                            {{ $karyawanEducation[0]->bachelor_ijazah == 'n' ? 'selected' : '' }}>Tidak
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">IPK</label>
                                    <input type="text" class="form-control" name="ipk_univ"
                                        value="{{ strtoupper($karyawanEducation[0]->bachelor_gpa) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gelar</label>
                                    <input type="text" class="form-control" name="gelar_univ"
                                        value="{{ strtoupper($karyawanEducation[0]->bachelor_degree) }}" />
                                </div>
                            @endif
                            @if ($karyawanEducation[0]->last_education == 's2' || $karyawanEducation[0]->last_education == 's3')
                                <div class="mb-3">
                                    <div class="text-center">
                                        <p class="m-0 h3">
                                            <strong>Magister</strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Universitas</label>
                                    <input type="text" class="form-control" name="nama_master"
                                        value="{{ strtoupper($karyawanEducation[0]->master_university) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" name="jurusan_master"
                                        value="{{ strtoupper($karyawanEducation[0]->master_major) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Masuk</label>
                                    <input type="number" class="form-control" name="masuk_master"
                                        value="{{ strtoupper($karyawanEducation[0]->master_start_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Lulus</label>
                                    <input type="number" class="form-control" name="selesai_master"
                                        value="{{ strtoupper($karyawanEducation[0]->master_end_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Berijazah</label>
                                    <select class="form-select" name="master_ijazah">
                                        <option value="y"
                                            {{ $karyawanEducation[0]->master_ijazah == 'y' ? 'selected' : '' }}>Ya</option>
                                        <option value="n"
                                            {{ $karyawanEducation[0]->master_ijazah == 'n' ? 'selected' : '' }}>Tidak
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">IPK</label>
                                    <input type="text" class="form-control" name="ipk_master"
                                        value="{{ strtoupper($karyawanEducation[0]->master_gpa) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gelar</label>
                                    <input type="text" class="form-control" name="gelar_master"
                                        value="{{ strtoupper($karyawanEducation[0]->master_degree) }}" />
                                </div>
                            @endif
                            @if ($karyawanEducation[0]->last_education == 's3')
                                <div class="mb-3">
                                    <div class="text-center">
                                        <p class="m-0 h3">
                                            <strong>Doctor</strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Universitas</label>
                                    <input type="text" class="form-control" name="nama_doctor"
                                        value="{{ strtoupper($karyawanEducation[0]->doctor_university) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" name="jurusan_doctor"
                                        value="{{ strtoupper($karyawanEducation[0]->doctor_major) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Masuk</label>
                                    <input type="number" class="form-control" name="masuk_doctor"
                                        value="{{ strtoupper($karyawanEducation[0]->doctor_start_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun Lulus</label>
                                    <input type="number" class="form-control" name="selesai_doctor"
                                        value="{{ strtoupper($karyawanEducation[0]->doctor_end_year) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Berijazah</label>
                                    <select class="form-select" name="doctor_ijazah">
                                        <option value="y"
                                            {{ $karyawanEducation[0]->doctor_ijazah == 'y' ? 'selected' : '' }}>Ya</option>
                                        <option value="n"
                                            {{ $karyawanEducation[0]->doctor_ijazah == 'n' ? 'selected' : '' }}>Tidak
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">IPK</label>
                                    <input type="text" class="form-control" name="ipk_doctor"
                                        value="{{ strtoupper($karyawanEducation[0]->doctor_gpa) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gelar</label>
                                    <input type="text" class="form-control" name="gelar_doctor"
                                        value="{{ strtoupper($karyawanEducation[0]->doctor_degree) }}" />
                                </div>
                            @endif
                            <button type="submit"class="btn btn-primary w-100">Simpan</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
