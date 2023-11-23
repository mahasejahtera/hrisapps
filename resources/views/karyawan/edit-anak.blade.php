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
                            <h3 class="card-title">Data Anak</h3>
                        </div>
                        <form action="{{ route('admin.karyawan.update.anak') }}" class="m-3" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $karyawanChildren->id }}" required />
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama"
                                    value="{{ $karyawanChildren->children_name }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="jenis_kelamin">
                                    <option value="L" {{ $karyawanChildren->gender == 'L' ? 'selected' : '' }}>
                                        Laki-Laki</option>
                                    <option value="P" {{ $karyawanChildren->gender == 'P' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Usia</label>
                                <input type="number" class="form-control" name="usia"
                                    value="{{ $karyawanChildren->children_age }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir" id="last_education"
                                    class="form-control">
                                    <option value="sd"
                                        {{ !empty($karyawanChildren) ? ($karyawanChildren->children_last_education == 'sd' ? 'selected' : '') : '' }}>
                                        SD</option>
                                    <option value="smp"
                                        {{ !empty($karyawanChildren) ? ($karyawanChildren->children_last_education == 'smp' ? 'selected' : '') : '' }}>
                                        SMP</option>
                                    <option value="sma"
                                        {{ !empty($karyawanChildren) ? ($karyawanChildren->children_last_education == 'sma' ? 'selected' : '') : '' }}>
                                        SMA</option>
                                    <option value="d i"
                                        {{ !empty($karyawanChildren) ? ($karyawanChildren->children_last_education == 'd i' ? 'selected' : '') : '' }}>
                                        D I</option>
                                    <option value="d ii"
                                        {{ !empty($karyawanChildren) ? ($karyawanChildren->children_last_education == 'd ii' ? 'selected' : '') : '' }}>
                                        D II</option>
                                    <option value="d iii"
                                        {{ !empty($karyawanChildren) ? ($karyawanChildren->children_last_education == 'd iii' ? 'selected' : '') : '' }}>
                                        D III</option>
                                    <option value="s1"
                                        {{ !empty($karyawanChildren) ? ($karyawanChildren->children_last_education == 's1' ? 'selected' : '') : '' }}>
                                        S1 / D IV</option>
                                    <option value="s2"
                                        {{ !empty($karyawanChildren) ? ($karyawanChildren->children_last_education == 's2' ? 'selected' : '') : '' }}>
                                        S2</option>
                                    <option value="s3"
                                        {{ !empty($karyawanChildren) ? ($karyawanChildren->children_last_education == 's3' ? 'selected' : '') : '' }}>
                                        S3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan Posisi Terakhir</label>
                                <input type="text" class="form-control" name="jabatan_terakhir"
                                    value="{{ $karyawanChildren->children_last_job_position }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Perusahaan Pekerjaan Terakhir</label>
                                <input type="text" class="form-control" name="perusahaan_terakhir"
                                    value="{{ $karyawanChildren->children_last_job_company }}" />
                            </div>
                            <button type="submit"class="btn btn-primary w-100">Simpan</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
