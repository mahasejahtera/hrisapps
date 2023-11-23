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
                            <h3 class="card-title">Data Susunan Keluarga</h3>
                        </div>
                        <form action="{{ route('admin.karyawan.update.susunan', $karyawan->email) }}" class="m-3" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $karyawanFamily[0]->id }}" required />
                            <div class="mb-3">
                                <label class="form-label">Anak Ke-</label>
                                <input type="number" class="form-control" name="anakke"
                                    value="{{ $karyawanFamily[0]->child_to }}" />
                            </div>
                            @if ($karyawanBiodata[0]->marital_status == 'kawin')
                                <div class="mb-3">
                                    <div class="text-center">
                                        <p class="m-0 h3">
                                            <strong>{{ $karyawanBiodata[0]->gender == 'L' ? 'ISTRI' : 'SUAMI' }}</strong>
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Pasangan</label>
                                    <input type="text" class="form-control"  name="nama_pasangan"
                                        value="{{ $karyawanFamily[0]->couple_name }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Usia</label>
                                    <input type="number" class="form-control" name="usia_pasangan"
                                        value="{{ $karyawanFamily[0]->couple_age }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pendidikan Terakhir</label>
                                    <select name="pasangan_last_education" class="form-select" id="couple_last_education"
                                        class="form-control @error('couple_last_education') is-invalid @enderror">
                                        <option value="sd"
                                            {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'sd' ? 'selected' : '') : '' }}>
                                            SD</option>
                                        <option value="smp"
                                            {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'smp' ? 'selected' : '') : '' }}>
                                            SMP</option>
                                        <option value="sma"
                                            {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'sma' ? 'selected' : '') : '' }}>
                                            SMA</option>
                                        <option value="d i"
                                            {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'd i' ? 'selected' : '') : '' }}>
                                            D I</option>
                                        <option value="d ii"
                                            {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'd ii' ? 'selected' : '') : '' }}>
                                            D II</option>
                                        <option value="d iii"
                                            {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'd iii' ? 'selected' : '') : '' }}>
                                            D III</option>
                                        <option value="s1"
                                            {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 's1' ? 'selected' : '') : '' }}>
                                            S1 / D IV</option>
                                        <option value="s2"
                                            {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 's2' ? 'selected' : '') : '' }}>
                                            S2</option>
                                        <option value="s3"
                                            {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 's3' ? 'selected' : '') : '' }}>
                                            S3</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jabatan Pekerjaan Terakhir</label>
                                    <input type="text" class="form-control" name="jabatan_terakhir_pasangan"
                                        value="{{ strtoupper($karyawanFamily[0]->couple_last_job_position) }}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Perusahaan Pekerjaan Terakhir</label>
                                    <input type="text" class="form-control" name="perusahaan_terakhir_pasangan"
                                        value="{{ strtoupper($karyawanFamily[0]->couple_last_job_company) }}" />
                                </div>
                            @endif

                            <div class="mb-3">
                                <div class="text-center">
                                    <p class="m-0 h3">
                                        <strong>AYAH</strong>
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama_ayah"
                                    value="{{ $karyawanFamily[0]->father_name }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Usia</label>
                                <input type="number" class="form-control" name="usia_ayah"
                                    value="{{ $karyawanFamily[0]->father_age }}" />
                            </div>
                            <label class="form-label">Pendidikan Terakhir</label>
                            <div class="mb-3">
                                <select name="ayah_last_education" class="form-select" id="father_last_education"
                                    class="form-control @error('father_last_education') is-invalid @enderror">
                                    <option value="sd"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'sd' ? 'selected' : '') : '' }}>
                                        SD</option>
                                    <option value="smp"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'smp' ? 'selected' : '') : '' }}>
                                        SMP</option>
                                    <option value="sma"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'sma' ? 'selected' : '') : '' }}>
                                        SMA</option>
                                    <option value="d i"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'd i' ? 'selected' : '') : '' }}>
                                        D I</option>
                                    <option value="d ii"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'd ii' ? 'selected' : '') : '' }}>
                                        D II</option>
                                    <option value="d iii"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'd iii' ? 'selected' : '') : '' }}>
                                        D III</option>
                                    <option value="s1"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 's1' ? 'selected' : '') : '' }}>
                                        S1 / D IV</option>
                                    <option value="s2"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 's2' ? 'selected' : '') : '' }}>
                                        S2</option>
                                    <option value="s3"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 's3' ? 'selected' : '') : '' }}>
                                        S3</option>
                                </select>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan Pekerjaan Terakhir</label>
                                <input type="text" class="form-control" name="jabatan_terakhir_ayah"
                                    value="{{ $karyawanFamily[0]->father_last_job_position }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Perusahaan Pekerjaan Terakhir</label>
                                <input type="text" class="form-control" name="perusahaan_terakhir_ayah"
                                    value="{{ $karyawanFamily[0]->father_last_job_company }}" />
                            </div>
                            <div class="mb-3">
                                <div class="text-center">
                                    <p class="m-0 h3">
                                        <strong>IBU</strong>
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama_ibu"
                                    value="{{ $karyawanFamily[0]->mother_name }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Usia</label>
                                <input type="number" class="form-control" name="usia_ibu"
                                    value="{{ $karyawanFamily[0]->mother_age }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pendidikan Terakhir</label>
                                <select name="ibu_last_education" class="form-select" id="mother_last_education"
                                    class="form-control @error('mother_last_education') is-invalid @enderror">
                                    <option value="sd"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'sd' ? 'selected' : '') : '' }}>
                                        SD</option>
                                    <option value="smp"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'smp' ? 'selected' : '') : '' }}>
                                        SMP</option>
                                    <option value="sma"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'sma' ? 'selected' : '') : '' }}>
                                        SMA</option>
                                    <option value="d i"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'd i' ? 'selected' : '') : '' }}>
                                        D I</option>
                                    <option value="d ii"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'd ii' ? 'selected' : '') : '' }}>
                                        D II</option>
                                    <option value="d iii"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'd iii' ? 'selected' : '') : '' }}>
                                        D III</option>
                                    <option value="s1"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 's1' ? 'selected' : '') : '' }}>
                                        S1 / D IV</option>
                                    <option value="s2"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 's2' ? 'selected' : '') : '' }}>
                                        S2</option>
                                    <option value="s3"
                                        {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 's3' ? 'selected' : '') : '' }}>
                                        S3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan Pekerjaan Terakhir</label>
                                <input type="text" class="form-control" name="jabatan_terakhir_ibu"
                                    value="{{ $karyawanFamily[0]->mother_last_job_position }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Perusahaan Pekerjaan Terakhir</label>
                                <input type="text" class="form-control" name="perusahaan_terakhir_ibu"
                                    value="{{ $karyawanFamily[0]->mother_last_job_company }}" />
                            </div>
                            <button type="submit"class="btn btn-primary w-100">Simpan</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
