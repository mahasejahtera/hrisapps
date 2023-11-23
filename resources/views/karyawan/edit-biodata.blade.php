@extends('layouts.admin.tabler')
@section('content')
    <div class="page-body m-5">
        <div class="container-fluid">
            <section id="form-bio">
                <div class="biodata-confirm-wrapper">
                    <h2 class="page-title">
                        Edit Biodata Karyawan
                    </h2>
                    <div class="card mb-2">
                        <div class="card-header">
                            <h3 class="card-title">Data Karyawan</h3>
                        </div>
                        <form action="{{ route('admin.karyawan.update.biodata', $karyawan->email) }}" id="formBiodata"
                            class="m-3" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $karyawanBiodata[0]->id }}" required />
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama"
                                    value="{{ $karyawanBiodata[0]->fullname }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Panggilan</label>
                                <input type="text" class="form-control" name="panggilan"
                                    value="{{ $karyawanBiodata[0]->nickname }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Induk Kependudukan</label>
                                <input type="number" class="form-control" name="nik"
                                    value="{{ $karyawanBiodata[0]->nik }}" />
                            </div>
                            {{-- <div class="mb-3">
                                <label class="form-label">Provinsi</label>
                                <select name="identity_province" id="identity_province" data-indo="province"
                                    class="form-control indo-input-identity @error('identity_province') is-invalid @enderror">
                                    <option value="">--Pilih Provinsi --</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->identity_province == $province->id ? 'selected' : '') : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kabupaten/Kota</label>
                                <select name="identity_regency" id="identity_regency" data-indo="regency"
                                    class="form-select indo-input-identity @error('identity_regency') is-invalid @enderror">
                                    <option value="">--Pilih Kab/Kota--</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kecamatan</label>
                                <select name="identity_district" id="identity_district" data-indo="district"
                                    class="form-select indo-input-identity @error('identity_district') is-invalid @enderror">
                                    <option value="">--Pilih Kecamatan--</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelurahan/Desa</label>
                                <select name="identity_village" id="identity_village" data-indo="village"
                                    class="form-select indo-input-identity @error('identity_village') is-invalid @enderror">
                                    <option value="">--Pilih Kel/Desa--</option>
                                </select>
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label">Nama Jalan</label>
                                <input type="text" class="form-control" name="nama_jalan"
                                    value="{{ $karyawanBiodata[0]->address_identity }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Tempat Tinggal</label>
                                <select name="status_tinggal" id="address_status" class="form-select">
                                    <option value="kost"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->address_status == 'kost' ? 'selected' : '') : '' }}>
                                        Kost</option>
                                    <option value="rumah_sendiri"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->address_status == 'rumah_sendiri' ? 'selected' : '') : '' }}>
                                        Rumah Sendiri</option>
                                    <option value="rumah_orang_tua"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->address_status == 'rumah_orang_tua' ? 'selected' : '') : '' }}>
                                        Rumah Orang Tua</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. Telepon/HP</label>
                                <input type="number" class="form-control" name="no_hp"
                                    value="{{ $karyawanBiodata[0]->phone }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. Telepon Darurat</label>
                                <input type="number" class="form-control" name="no_hp_darurat"
                                    value="{{ $karyawanBiodata[0]->urgent_phone }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mulai Bekerja</label>
                                <input type="date" class="form-control" name="mulai_bekerja"
                                    value="{{ $karyawanBiodata[0]->start_work }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="jenis_kelamin">
                                    <option value="L" {{ $karyawanBiodata[0]->gender == 'L' ? 'selected' : '' }}>
                                        Laki-Laki</option>
                                    <option value="P" {{ $karyawanBiodata[0]->gender == 'P' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" name="tempat_lahir"
                                    value="{{ $karyawanBiodata[0]->birthplace }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tanggal_lahir"
                                    value="{{ $karyawanBiodata[0]->birthdate }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Agama</label>
                                <select name="agama" id="religion" class="form-control">
                                    <option value="">--Pilih Agama--</option>
                                    <option value="islam"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->religion == 'islam' ? 'selected' : '') : '' }}>
                                        Islam</option>
                                    <option value="kristen"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->religion == 'kristen' ? 'selected' : '') : '' }}>
                                        Kristen</option>
                                    <option value="hindu"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->religion == 'hindu' ? 'selected' : '') : '' }}>
                                        Hindu</option>
                                    <option value="budha"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->religion == 'budha' ? 'selected' : '') : '' }}>
                                        Budha</option>
                                    <option value="konghucu"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->religion == 'konghucu' ? 'selected' : '') : '' }}>
                                        Konghucu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Berat Badan/Kg</label>
                                <input type="number" class="form-control" name="berat"
                                    value="{{ $karyawanBiodata[0]->weight }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tinggi Badan/Cm</label>
                                <input type="number" class="form-control" name="tinggi"
                                    value="{{ $karyawanBiodata[0]->height }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Golongan Darah</label>
                                <select name="gol_darah" id="blood_type" class="form-control ">
                                    <option value="O"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->blood_type == 'O' ? 'selected' : '') : '' }}>
                                        O</option>
                                    <option value="A"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->blood_type == 'A' ? 'selected' : '') : '' }}>
                                        A</option>
                                    <option value="B"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->blood_type == 'B' ? 'selected' : '') : '' }}>
                                        B</option>
                                    <option value="AB"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->blood_type == 'AB' ? 'selected' : '') : '' }}>
                                        AB</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Pernikahan</label>
                                <select name="status_pernikahan" id="marital_status" class="form-control">
                                    <option value="kawin"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->marital_status == 'kawin' ? 'selected' : '') : '' }}>
                                        Kawin</option>
                                    <option value="belum_kawin"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->marital_status == 'belum_kawin' ? 'selected' : '') : '' }}>
                                        Belum Kawin</option>
                                    <option value="janda"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->marital_status == 'janda' ? 'selected' : '') : '' }}>
                                        Janda</option>
                                    <option value="duda"
                                        {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->marital_status == 'duda' ? 'selected' : '') : '' }}>
                                        Duda</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun Pernikahan</label>
                                <input type="number" class="form-control" name="tahun_nikah" id="years_married"
                                    placeholder="Tahun Menikah"
                                    value="{{ !empty($karyawanBiodata[0]) ? $karyawanBiodata[0]->years_married : '' }}">
                            </div>
                            <button type="submit"class="btn btn-primary w-100">Simpan</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('myscript')
@endpush
