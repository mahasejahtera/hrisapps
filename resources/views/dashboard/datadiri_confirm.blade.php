@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Konfirmasi Data Diri</p>
    </div>
</header>

<section id="form-bio">
    <div class="biodata-confirm-wrapper">
        <p class="biodata-confirm-title">Biodata</p>

        <table class="table">
            <tr>
                <td>Nama Lengkap</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanBiodata[0]->fullname }}</td>
            </tr>
            <tr>
                <td>Nama Panggilan</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanBiodata[0]->nickname }}</td>
            </tr>
            <tr>
                <td>Nomor Induk Keluarga</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanBiodata[0]->nik }}</td>
            </tr>
            <tr>
                <td>Alamat Sesuai KTP</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    {{ $karyawanBiodata[0]->address_identity }}, Kel. {{ Str::title($karyawanBiodata[0]->identityVillage->name) }}, Kec. {{ Str::title($karyawanBiodata[0]->identityDistrict->name) }}, {{ Str::title($karyawanBiodata[0]->identityRegency->name) }}, {{ Str::title($karyawanBiodata[0]->identityProvince->name) }}
                </td>
            </tr>
            <tr>
                <td>Alamat Sekarang</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    {{ $karyawanBiodata[0]->current_address }}, Kel. {{ Str::title($karyawanBiodata[0]->currentVillage->name) }}, Kec. {{ Str::title($karyawanBiodata[0]->currentDistrict->name) }}, {{ Str::title($karyawanBiodata[0]->currentRegency->name) }}, {{ Str::title($karyawanBiodata[0]->currentProvince->name) }}
                </td>
            </tr>
            <tr>
                <td>Status Tempat Tinggal</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    @php
                        if ($karyawanBiodata[0]->address_status == 'kost') {
                            echo 'Kost';
                        } else if($karyawanBiodata[0]->address_status == 'rumah_sendiri') {
                            echo 'Rumah Sendiri';
                        } else if($karyawanBiodata[0]->address_status == 'rumah_orang_tua') {
                            echo 'Rumah Orang Tua';
                        } else if($karyawanBiodata[0]->address_status == 'otder') {
                            echo 'Lainnya';
                        }
                    @endphp
                </td>
            </tr>
            <tr>
                <td>No. Telepon/HP</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanBiodata[0]->phone }}</td>
            </tr>
            <tr>
                <td>No. Telepon Darurat</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanBiodata[0]->urgent_phone }}</td>
            </tr>
            <tr>
                <td>Mulai Bekerja</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ tanggalBulanIndo($karyawanBiodata[0]->start_work) }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanBiodata[0]->email }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ ($karyawanBiodata[0]->gender == 'L') ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Tempat Tanggal Lahir</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanBiodata[0]->birthplace . ', ' . tanggalBulanIndo($karyawanBiodata[0]->birthdate) }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ ucfirst($karyawanBiodata[0]->religion) }}</td>
            </tr>
            <tr>
                <td>Berat Badan</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanBiodata[0]->weight }} Kg</td>
            </tr>
            <tr>
                <td>Tinggi Badan</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanBiodata[0]->height }} Cm</td>
            </tr>
            <tr>
                <td>Golongan Darah</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanBiodata[0]->blood_type }}</td>
            </tr>
            <tr>
                <td>Status Perkawinan</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    @php
                        if($karyawanBiodata[0]->marital_status == 'kawin') {
                            echo 'Kawin';
                        } else if($karyawanBiodata[0]->marital_status == 'belum_kawin') {
                            echo 'Belum Kawin';
                        } else if($karyawanBiodata[0]->marital_status == 'janda') {
                            echo 'Janda';
                        } else if($karyawanBiodata[0]->marital_status == 'duda') {
                            echo 'Duda';
                        }
                    @endphp
                </td>
            </tr>

            @if ($karyawanBiodata[0]->marital_status == 'kawin')
                <tr>
                    <td>Tahun Menikah</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ $karyawanBiodata[0]->years_married }}</td>
                </tr>
            @endif
        </table>
    </div>

    <div class="biodata-confirm-wrapper mt-3">
        <p class="biodata-confirm-title">Riwayat Pendidikan</p>

        <table class="table">
            <tr>
                <td>Pendidikan Terakhir</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ strtoupper($karyawanEducation[0]->last_education) }}</td>
            </tr>
            @if ($karyawanEducation[0]->last_education == 'sd' || $karyawanEducation[0]->last_education == 'smp' || $karyawanEducation[0]->last_education == 'sd' || $karyawanEducation[0]->last_education == 'sma' || $karyawanEducation[0]->last_education == 'd i' || $karyawanEducation[0]->last_education == 'd ii' || $karyawanEducation[0]->last_education == 'd iii' || $karyawanEducation[0]->last_education == 's1' || $karyawanEducation[0]->last_education == 's2' || $karyawanEducation[0]->last_education == 's3')

                <tr>
                    <td colspan="3" align="middle"><p class="m-0 h3"><strong>SD</strong></p></td>
                </tr>

                <tr>
                    <td>Nama SD</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->primary_school) }}</td>
                </tr>
                <tr>
                    <td>Tahun Masuk</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->sd_start_year) }}</td>
                </tr>
                <tr>
                    <td>Tahun Selesai</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->sd_end_year) }}</td>
                </tr>
                <tr>
                    <td>Berijazah</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ ($karyawanEducation[0]->sd_ijazah == 'y') ? 'Ya' : 'Tidak' }}</td>
                </tr>
            @endif

            @if ($karyawanEducation[0]->last_education == 'smp' || $karyawanEducation[0]->last_education == 'sma' || $karyawanEducation[0]->last_education == 'd i' || $karyawanEducation[0]->last_education == 'd ii' || $karyawanEducation[0]->last_education == 'd iii' || $karyawanEducation[0]->last_education == 's1' || $karyawanEducation[0]->last_education == 's2' || $karyawanEducation[0]->last_education == 's3')
                <tr>
                    <td colspan="3" align="middle"><p class="m-0 h3"><strong>SMP</strong></p></td>
                </tr>

                <tr>
                    <td>Nama SMP</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->junior_hight_school) }}</td>
                </tr>
                <tr>
                    <td>Tahun Masuk</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->smp_start_year) }}</td>
                </tr>
                <tr>
                    <td>Tahun Selesai</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->smp_end_year) }}</td>
                </tr>
                <tr>
                    <td>Berijazah</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ ($karyawanEducation[0]->smp_ijazah == 'y') ? 'Ya' : 'Tidak' }}</td>
                </tr>
            @endif

            @if ($karyawanEducation[0]->last_education == 'sma' || $karyawanEducation[0]->last_education == 'd i' || $karyawanEducation[0]->last_education == 'd ii' || $karyawanEducation[0]->last_education == 'd iii' || $karyawanEducation[0]->last_education == 's1' || $karyawanEducation[0]->last_education == 's2' || $karyawanEducation[0]->last_education == 's3')
                <tr>
                    <td colspan="3" align="middle"><p class="m-0 h3"><strong>SMA</strong></p></td>
                </tr>

                <tr>
                    <td>Nama SMA</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->senior_hight_school) }}</td>
                </tr>
                <tr>
                    <td>Tahun Masuk</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->sma_start_year) }}</td>
                </tr>
                <tr>
                    <td>Tahun Selesai</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->sma_end_year) }}</td>
                </tr>
                <tr>
                    <td>Berijazah</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ ($karyawanEducation[0]->sma_ijazah == 'y') ? 'Ya' : 'Tidak' }}</td>
                </tr>
            @endif

            @if ($karyawanEducation[0]->last_education == 'd i' || $karyawanEducation[0]->last_education == 'd ii' || $karyawanEducation[0]->last_education == 'd iii' || $karyawanEducation[0]->last_education == 's1' || $karyawanEducation[0]->last_education == 's2' || $karyawanEducation[0]->last_education == 's3')
                <tr>
                    <td colspan="3" align="middle"><p class="m-0 h3"><strong>Sarjana</strong></p></td>
                </tr>

                <tr>
                    <td>Universitas</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->bachelor_university) }}</td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->bachelor_major) }}</td>
                </tr>
                <tr>
                    <td>Tahun Masuk</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->bachelor_start_year) }}</td>
                </tr>
                <tr>
                    <td>Tahun Selesai</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->bachelor_end_year) }}</td>
                </tr>
                <tr>
                    <td>Berijazah</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ ($karyawanEducation[0]->bachelor_ijazah == 'y') ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td>IPK</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->bachelor_gpa) }}</td>
                </tr>
                <tr>
                    <td>Gelar</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->bachelor_degree) }}</td>
                </tr>
            @endif

            @if ($karyawanEducation[0]->last_education == 's2' || $karyawanEducation[0]->last_education == 's3')
                <tr>
                    <td colspan="3" align="middle"><p class="m-0 h3"><strong>Magister</strong></p></td>
                </tr>

                <tr>
                    <td>Universitas</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->master_university) }}</td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->master_major) }}</td>
                </tr>
                <tr>
                    <td>Tahun Masuk</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->master_start_year) }}</td>
                </tr>
                <tr>
                    <td>Tahun Selesai</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->master_end_year) }}</td>
                </tr>
                <tr>
                    <td>Berijazah</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ ($karyawanEducation[0]->master_ijazah == 'y') ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td>IPK</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->master_gpa) }}</td>
                </tr>
                <tr>
                    <td>Gelar</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->master_degree) }}</td>
                </tr>
            @endif

            @if ($karyawanEducation[0]->last_education == 's3')
                <tr>
                    <td colspan="3" align="middle"><p class="m-0 h3"><strong>Doctor</strong></p></td>
                </tr>

                <tr>
                    <td>Universitas</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->doctor_university) }}</td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->doctor_major) }}</td>
                </tr>
                <tr>
                    <td>Tahun Masuk</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->doctor_start_year) }}</td>
                </tr>
                <tr>
                    <td>Tahun Selesai</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->doctor_end_year) }}</td>
                </tr>
                <tr>
                    <td>Berijazah</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ ($karyawanEducation[0]->doctor_ijazah == 'y') ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td>IPK</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->doctor_gpa) }}</td>
                </tr>
                <tr>
                    <td>Gelar</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanEducation[0]->doctor_degree) }}</td>
                </tr>
            @endif
        </table>
    </div>

    <div class="biodata-confirm-wrapper mt-3">
        <p class="biodata-confirm-title">Susunan Keluarga</p>

        <table class="table">

            @if ($karyawanBiodata[0]->marital_status == 'kawin')
                <tr>
                    <td colspan="3" align="middle"><p class="m-0 h3"><strong>{{ $karyawanBiodata[0]->gender == 'L' ? 'ISTRI' : 'SUAMI' }}</strong></p></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ $karyawanFamily[0]->couple_name }}</td>
                </tr>
                <tr>
                    <td>Usia</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ $karyawanFamily[0]->couple_age }} Tahun</td>
                </tr>
                <tr>
                    <td>Pendidiakan Terakhir</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ strtoupper($karyawanFamily[0]->couple_last_education) }}</td>
                </tr>
                <tr>
                    <td>Jabatan Pekerjaan Terakhir</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ ucFirst($karyawanFamily[0]->couple_last_job_position) }}</td>
                </tr>
                <tr>
                    <td>Perusahaan Pekerjaan Terakhir</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ ucFirst($karyawanFamily[0]->couple_last_job_company) }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="3" align="middle"><p class="m-0 h3"><strong>AYAH</strong></p></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanFamily[0]->father_name }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ ($karyawanFamily[0]->father_status == 1) ? 'Hidup' : 'Meninggal' }}</td>
            </tr>

            @if ($karyawanFamily[0]->father_status == 1)
                <tr>
                    <td>Usia</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ $karyawanFamily[0]->father_age }} Tahun</td>
                </tr>
            @endif
            <tr>
                <td>Pendidiakan Terakhir</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ strtoupper($karyawanFamily[0]->father_last_education) }}</td>
            </tr>
            <tr>
                <td>Jabatan Pekerjaan Terakhir</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ ucFirst($karyawanFamily[0]->father_last_job_position) }}</td>
            </tr>
            <tr>
                <td>Perusahaan Pekerjaan Terakhir</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ ucFirst($karyawanFamily[0]->father_last_job_company) }}</td>
            </tr>

            <tr>
                <td colspan="3" align="middle"><p class="m-0 h3"><strong>IBU</strong></p></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ $karyawanFamily[0]->mother_name }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ ($karyawanFamily[0]->mother_status == 1) ? 'Hidup' : 'Meninggal' }}</td>
            </tr>

            @if ($karyawanFamily[0]->mother_status == 1)
                <tr>
                    <td>Usia</td>
                    <td><span class="mx-3">:</span></td>
                    <td>{{ $karyawanFamily[0]->mother_age }} Tahun</td>
                </tr>
            @endif
            <tr>
                <td>Pendidiakan Terakhir</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ strtoupper($karyawanFamily[0]->mother_last_education) }}</td>
            </tr>
            <tr>
                <td>Jabatan Pekerjaan Terakhir</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ ucFirst($karyawanFamily[0]->mother_last_job_position) }}</td>
            </tr>
            <tr>
                <td>Perusahaan Pekerjaan Terakhir</td>
                <td><span class="mx-3">:</span></td>
                <td>{{ ucFirst($karyawanFamily[0]->mother_last_job_company) }}</td>
            </tr>
        </table>
    </div>

    @if (count($karyawanSibling) > 0)
        <div class="biodata-confirm-wrapper mt-3">
            <p class="biodata-confirm-title">Saudara</p>

            <table class="table">
                @foreach ($karyawanSibling as $item)
                    <tr>
                        <td colspan="3" align="middle"><p class="m-0 h3"><strong>Saudara ke-{{ $loop->iteration }}</strong></p></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td><span class="mx-3">:</span></td>
                        <td>{{ $item->siblings_name }}</td>
                    </tr>
                    <tr>
                        <td>Usia</td>
                        <td><span class="mx-3">:</span></td>
                        <td>{{ $item->siblings_age }} Tahun</td>
                    </tr>
                    <tr>
                        <td>Pendidiakan Terakhir</td>
                        <td><span class="mx-3">:</span></td>
                        <td>{{ strtoupper($item->siblings_last_education) }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan Pekerjaan Terakhir</td>
                        <td><span class="mx-3">:</span></td>
                        <td>{{ ucFirst($item->siblings_last_job_position) }}</td>
                    </tr>
                    <tr>
                        <td>Perusahaan Pekerjaan Terakhir</td>
                        <td><span class="mx-3">:</span></td>
                        <td>{{ ucFirst($item->siblings_last_job_company) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    @if (count($karyawanChildren) > 0)
        <div class="biodata-confirm-wrapper mt-3">
            <p class="biodata-confirm-title">Anak</p>

            <table class="table">
                @foreach ($karyawanChildren as $kc)
                    <tr>
                        <td colspan="3" align="middle"><p class="m-0 h3"><strong>Anak ke-{{ $loop->iteration }}</strong></p></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td><span class="mx-3">:</span></td>
                        <td>{{ $kc->children_name }}</td>
                    </tr>
                    <tr>
                        <td>Usia</td>
                        <td><span class="mx-3">:</span></td>
                        <td>{{ $kc->children_age }} Tahun</td>
                    </tr>
                    <tr>
                        <td>Pendidiakan Terakhir</td>
                        <td><span class="mx-3">:</span></td>
                        <td>{{ strtoupper($kc->children_last_education) }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan Pekerjaan Terakhir</td>
                        <td><span class="mx-3">:</span></td>
                        <td>{{ ucFirst($kc->children_last_job_position) }}</td>
                    </tr>
                    <tr>
                        <td>Perusahaan Pekerjaan Terakhir</td>
                        <td><span class="mx-3">:</span></td>
                        <td>{{ ucFirst($kc->children_last_job_company) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    {{-- <div class="biodata-confirm-wrapper mt-3">
        <p class="biodata-confirm-title">Dokumen</p>

        <table class="table">
            <tr>
                <td>Pas Photo</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    <a href="{{ asset('storage/'. $karyawanDocument[0]->pas_photo) }}" target="_blank" class="text-decoration-none"><strong>Lihat disini</strong></a>
                </td>
            </tr>
            <tr>
                <td>KTP</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    <a href="{{ asset('storage/'. $karyawanDocument[0]->ktp) }}" target="_blank" class="text-decoration-none"><strong>Lihat disini</strong></a>
                </td>
            </tr>
            <tr>
                <td>KK</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    <a href="{{ asset('storage/'. $karyawanDocument[0]->kk) }}" target="_blank" class="text-decoration-none"><strong>Lihat disini</strong></a>
                </td>
            </tr>
            <tr>
                <td>Ijazah</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    <a href="{{ asset('storage/'. $karyawanDocument[0]->ijazah) }}" target="_blank" class="text-decoration-none"><strong>Lihat disini</strong></a>
                </td>
            </tr>
            <tr>
                <td>Buku Rekening</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    <a href="{{ asset('storage/'. $karyawanDocument[0]->buku_rekening) }}" target="_blank" class="text-decoration-none"><strong>Lihat disini</strong></a>
                </td>
            </tr>
            <tr>
                <td>NPWP</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    @if ($karyawanDocument[0]->npwp)
                        <a href="{{ asset('storage/'. $karyawanDocument[0]->npwp) }}" target="_blank" class="text-decoration-none"><strong>Lihat disini</strong></a>
                    @endif
                </td>
            </tr>
            <tr>
                <td>BPJS Ketenagakerjaan</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    @if ($karyawanDocument[0]->bpjs_ktn)
                        <a href="{{ asset('storage/'. $karyawanDocument[0]->bpjs_ktn) }}" target="_blank" class="text-decoration-none"><strong>Lihat disini</strong></a>
                    @endif
                </td>
            </tr>
            <tr>
                <td>BPJS Kesehatan</td>
                <td><span class="mx-3">:</span></td>
                <td>
                    @if ($karyawanDocument[0]->bpjs_kes)
                        <a href="{{ asset('storage/'. $karyawanDocument[0]->bpjs_kes) }}" target="_blank" class="text-decoration-none"><strong>Lihat disini</strong></a>
                    @endif
                </td>
            </tr>
        </table>

    </div> --}}
    <div class="d-flex justify-content-end mb-5 mt-3">
        <a href="{{ route('karyawan.datadiri', $karyawanBiodata[0]->karyawan->email) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('karyawan.datadiri.storeconfirm', $karyawanBiodata[0]->karyawan->email) }}" class="btn primary ml-2">Konfirmasi</a>
    </div>


</section>

@endsection

@section('scriptJS')
@endsection
