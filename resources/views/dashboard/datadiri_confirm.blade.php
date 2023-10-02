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
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->fullname }}</td>
            </tr>
            <tr>
                <td>Nama Panggilan</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->nickname }}</td>
            </tr>
            <tr>
                <td>Nomor Induk Keluarga</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->nik }}</td>
            </tr>
            <tr>
                <td>Alamat Sesuai KTP</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->address_identity }}</td>
            </tr>
            <tr>
                <td>Alamat Sekarang</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->current_address }}</td>
            </tr>
            <tr>
                <td>Status Tempat Tinggal</td>
                <td><span class="mx-4">:</span></td>
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
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->phone }}</td>
            </tr>
            <tr>
                <td>No. Telepon Darurat</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->urgent_phone }}</td>
            </tr>
            <tr>
                <td>Mulai Bekerja</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ tanggalIndo($karyawanBiodata[0]->start_work) }}</td>
            </tr>
            <tr>
                <td>Posisi Saat Ini</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->current_position }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->email }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ ($karyawanBiodata[0]->gender == 'L') ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Tempat Tanggal Lahir</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->birthplace . ', ' . tanggalIndo($karyawanBiodata[0]->birthdate) }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->religion }}</td>
            </tr>
            <tr>
                <td>Berat Badan</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->weight }} Kg</td>
            </tr>
            <tr>
                <td>Tinggi Badan</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->height }} Cm</td>
            </tr>
            <tr>
                <td>Golongan Darah</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->blood_type }}</td>
            </tr>
            <tr>
                <td>Status Perkawinan</td>
                <td><span class="mx-4">:</span></td>
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
                    <td><span class="mx-4">:</span></td>
                    <td>{{ $karyawanBiodata[0]->years_married }}</td>
                </tr>
            @endif

            <tr>
                <td>Jumlah Tanggungan</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanBiodata[0]->dependents_num }}</td>
            </tr>
        </table>
    </div>

    <div class="biodata-confirm-wrapper mt-3">
        <p class="biodata-confirm-title">Susunan Keluarga</p>

        <table class="table">
            <tr>
                <td>Nama Ayah</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanFamily[0]->father_name }}</td>
            </tr>
            <tr>
                <td>Nama Ibu</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanFamily[0]->mother_name }}</td>
            </tr>
            <tr>
                <td>Jumlah Saudara</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanFamily[0]->siblings_num }}</td>
            </tr>

            @if ($karyawanBiodata[0]->marital_status == 'kawin')
                <tr>
                    <td>Nama Suami/Istri</td>
                    <td><span class="mx-4">:</span></td>
                    <td>{{ $karyawanFamily[0]->couple_name }}</td>
                </tr>
            @endif
            
            <tr>
                <td>Anak Ke</td>
                <td><span class="mx-4">:</span></td>
                <td>{{ $karyawanFamily[0]->child_to }}</td>
            </tr>
        </table>
    </div>
</section>

@endsection

@section('scriptJS')
@endsection