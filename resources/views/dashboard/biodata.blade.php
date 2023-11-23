@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Form Data Diri</p>
    </div>
</header>

<section id="form-bio">
    <form action="{{ route('karyawan.datadiri.store', $karyawan->id) }}" method="post" id="formBiodata">
        @csrf

        <div class="form-group">
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="fullname" id="fullname" placeholder="Nama Lengkap" value="{{ (!empty($karyawanBiodata[0])) ? (!empty($karyawanBiodata[0]->fullname) ? $karyawanBiodata[0]->fullname : $karyawan->nama_lengkap) : $karyawan->nama_lengkap }}" required>
            @error('fullname')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" id="nickname" placeholder="Nama Panggilan" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->nickname : '' }}" required>
            @error('nickname')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="number" class="form-control @error('nik') is-invalid @enderror" name="nik" id="nik" placeholder="Nomor Induk Kependudukan (NIK)" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->nik : '' }}" required>
            @error('nik')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex align-items-center form-group">
            <p class="form-label-section m-0">Alamat Sesuai KTP</p>
        </div>

        <div class="form-group">
            <select name="identity_province" id="identity_province" data-indo="province" class="form-control indo-input-identity @error('identity_province') is-invalid @enderror" required>
                <option value="">--Pilih Provinsi --</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->identity_province == $province->id ? 'selected' : '') : '' }}>{{ $province->name }}</option>
                @endforeach
            </select>
            @error('identity_province')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <select name="identity_regency" id="identity_regency" data-indo="regency" class="form-control indo-input-identity @error('identity_regency') is-invalid @enderror" required>
                <option value="">--Pilih Kab/Kota--</option>
            </select>
            @error('identity_regency')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <select name="identity_district" id="identity_district" data-indo="district" class="form-control indo-input-identity @error('identity_district') is-invalid @enderror" required>
                <option value="">--Pilih Kecamatan--</option>
            </select>
            @error('identity_district')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <select name="identity_village" id="identity_village" data-indo="village" class="form-control indo-input-identity @error('identity_village') is-invalid @enderror" required>
                <option value="">--Pilih Kel/Desa--</option>
            </select>
            @error('identity_village')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="number" class="form-control @error('identity_postal_code') is-invalid @enderror" name="identity_postal_code" id="identity_postal_code" placeholder="Kode Pos" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->identity_postal_code : '' }}" required>
            @error('identity_postal_code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="text" class="form-control @error('address_identity') is-invalid @enderror" name="address_identity" id="address_identity" placeholder="Nama Jalan" value="{{ (!empty($karyawanBiodata[0])) ? (!empty($karyawanBiodata[0]->address_identity) ? $karyawanBiodata[0]->address_identity : 'Jl. ') : 'Jl. ' }}" required>
            @error('address_identity')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <div class="d-flex align-items-center form-group">
            <p class="form-label-section m-0">Alamat Saat Ini</p>
        </div>

        <div class="form-group">
            <select name="current_province" id="current_province" data-indo="province" class="form-control indo-input-current @error('current_province') is-invalid @enderror" required>
                <option value="">--Pilih Provinsi --</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->current_province == $province->id ? 'selected' : '') : '' }}>{{ $province->name }}</option>
                @endforeach
            </select>
            @error('current_province')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <select name="current_regency" id="current_regency" data-indo="regency" class="form-control indo-input-current @error('current_regency') is-invalid @enderror" required>
                <option value="">--Pilih Kab/Kota--</option>
            </select>
            @error('current_regency')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <select name="current_district" id="current_district" data-indo="district" class="form-control indo-input-current @error('current_district') is-invalid @enderror" required>
                <option value="">--Pilih Kecamatan--</option>
            </select>
            @error('current_district')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <select name="current_village" id="current_village" data-indo="village" class="form-control indo-input-current @error('current_village') is-invalid @enderror" required>
                <option value="">--Pilih Kel/Desa--</option>
            </select>
            @error('current_village')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="number" class="form-control @error('current_postal_code') is-invalid @enderror" name="current_postal_code" id="current_postal_code" placeholder="Kode Pos" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->current_postal_code : '' }}" required>
            @error('current_postal_code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="text" class="form-control @error('current_address') is-invalid @enderror" name="current_address" id="current_address" placeholder="Nama Jalan" value="{{ (!empty($karyawanBiodata[0])) ? (!empty($karyawanBiodata[0]->current_address) ? $karyawanBiodata[0]->current_address : 'Jl. ') : 'Jl. ' }}" required>
            @error('current_address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <div class="d-flex align-items-center form-group">
            <p class="form-label-section m-0">General</p>
        </div>

        <div class="form-group">
            <select name="address_status" id="address_status" class="form-control @error('address_status') is-invalid @enderror" required>
                <option value="">--Pilih Status Tempat Tinggal --</option>
                <option value="kost" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->address_status == 'kost' ? 'selected' : '') : '' }}>Kost</option>
                <option value="rumah_kontrakan" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->address_status == 'rumah_kontrakan' ? 'selected' : '') : '' }}>Rumah Kontrakan</option>
                <option value="rumah_sendiri" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->address_status == 'rumah_sendiri' ? 'selected' : '') : '' }}>Rumah Sendiri</option>
                <option value="rumah_orang_tua" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->address_status == 'rumah_orang_tua' ? 'selected' : '') : '' }}>Rumah Orang Tua</option>
            </select>
            @error('address_status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Nomor Handphone" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->phone : '' }}" required>
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('urgent_phone') is-invalid @enderror" name="urgent_phone" id="urgent_phone" placeholder="Nomor HP Darurat" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->urgent_phone : '' }}" required>
            @error('urgent_phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('start_work') is-invalid @enderror" name="start_work" placeholder="Tanggal Mulai Bekerja" onfocus="(this.type='date')" onblur="(this.type='text')" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->start_work : '' }}" required>
            @error('start_work')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ (!empty($karyawanBiodata[0])) ? (!empty($karyawanBiodata[0]->email) ? $karyawanBiodata[0]->email : $karyawan->email) : $karyawan->email }}" required>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
                <option value="">--Pilih Jenis Kelamin--</option>
                <option value="L" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->gender == 'L' ? 'selected' : '') : '' }}>Laki-Laki</option>
                <option value="P" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->gender == 'P' ? 'selected' : '') : '' }}>Perempuan</option>
            </select>
            @error('gender')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="d-flex">
            <div class="form-group">
                <input type="text" class="form-control @error('birthplace') is-invalid @enderror" name="birthplace" id="birthplace" placeholder="Tempat Lahir" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->birthplace : '' }}" required>
                @error('birthplace')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group ml-3">
                <input type="text" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" placeholder="Tanggal Lahir" onfocus="(this.type='date')" onblur="(this.type='text')" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->birthdate : '' }}" required>
                @error('birthdate')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <select name="religion" id="religion" class="form-control @error('religion') is-invalid @enderror" required>
                <option value="">--Pilih Agama--</option>
                <option value="islam" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->religion == 'islam' ? 'selected' : '') : '' }}>Islam</option>
                <option value="kristen" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->religion == 'kristen' ? 'selected' : '') : '' }}>Kristen</option>
                <option value="hindu" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->religion == 'hindu' ? 'selected' : '') : '' }}>Hindu</option>
                <option value="budha" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->religion == 'budha' ? 'selected' : '') : '' }}>Budha</option>
                <option value="konghucu" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->religion == 'konghucu' ? 'selected' : '') : '' }}>Konghucu</option>
            </select>
            @error('religion')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="d-flex mb-2">
            <div class="input-group">
                <input type="number" class="form-control @error('weight') is-invalid @enderror" name="weight" id="weight" placeholder="Berat Badan" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->weight : '' }}" required>
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Kg</span>
                </div>
                @error('weight')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="input-group ml-3">
                <input type="number" class="form-control @error('height') is-invalid @enderror" name="height" id="height" placeholder="Tinggi Badan" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->height : '' }}" required>
                <div class="input-group-prepend">
                    <span class="input-group-text">Cm</span>
                </div>
                @error('height')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <select name="blood_type" id="blood_type" class="form-control @error('blood_type') is-invalid @enderror" required>
                <option value="">--Pilih Golongan Darah--</option>
                <option value="O" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->blood_type == 'O' ? 'selected' : '') : '' }}>O</option>
                <option value="A" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->blood_type == 'A' ? 'selected' : '') : '' }}>A</option>
                <option value="B" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->blood_type == 'B' ? 'selected' : '') : '' }}>B</option>
                <option value="AB" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->blood_type == 'AB' ? 'selected' : '') : '' }}>AB</option>
            </select>
            @error('blood_type')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <select name="marital_status" id="marital_status" class="form-control @error('marital_status') is-invalid @enderror" required>
                <option value="">--Status Perkawinan--</option>
                <option value="kawin" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->marital_status == 'kawin' ? 'selected' : '') : '' }}>Kawin</option>
                <option value="belum_kawin" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->marital_status == 'belum_kawin' ? 'selected' : '') : '' }}>Belum Kawin</option>
                <option value="janda" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->marital_status == 'janda' ? 'selected' : '') : '' }}>Janda</option>
                <option value="duda" {{ !empty($karyawanBiodata[0]) ? ($karyawanBiodata[0]->marital_status == 'duda' ? 'selected' : '') : '' }}>Duda</option>
            </select>
            @error('marital_status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="number" class="form-control @error('years_married') is-invalid @enderror" name="years_married" id="years_married" placeholder="Tahun Menikah" value="{{ (!empty($karyawanBiodata[0])) ? $karyawanBiodata[0]->years_married : '' }}">
            @error('years_married')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn primary btn-block mt-2 mb-5">Lanjut</button>
    </form>
</section>

@endsection

@section('scriptJS')
    <script>
        $(document).ready(function() {
            // get value marriage
            const marriedStatus = $('#marital_status').val();

            // kalau statusnya kawin munculkan tahun kawin
            if(marriedStatus == 'kawin') {
                $('#years_married').attr('required', 'required');
                $('#years_married').show();
            } else {
                $('#years_married').attr('required', false);
                $('#years_married').hide();
            }


            //  SET INDONESIA Wilayah
            const identityProvinceValue = $('#identity_province').val()
            const currentProvinceValue = $('#current_province').val()

            const urlPost = "{{ route('indonesiadata.set', $karyawan->email) }}";

            $.ajax({
                url: urlPost,
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    identityProvince: identityProvinceValue,
                    currentProvince: currentProvinceValue
                },
                success: function(response) {
                    // IDENTITY
                    const identity_regency = response.identityRegency;
                    const identity_district = response.identityDistrict;
                    const identity_village = response.identityVillage;

                    if(identity_regency != '') {
                        $('#identity_regency').html(identity_regency);
                    }

                    if(identity_district != '') {
                        $('#identity_district').html(identity_district);
                    }

                    if(identity_village != '') {
                        $('#identity_village').html(identity_village);
                    }


                    // CURRNET
                    const current_regency = response.currentRegency;
                    const current_district = response.currentDistrict;
                    const current_village = response.currentVillage;

                    if(current_regency != '') {
                        $('#current_regency').html(current_regency);
                    }

                    if(current_district != '') {
                        $('#current_district').html(current_district);
                    }

                    if(current_village != '') {
                        $('#current_village').html(current_village);
                    }
                }
            });
        });

        // status kawin di ubah
        $('#marital_status').on('change', function(e) {
            const marriedStatus = $(this).val();

            // kalau statusnya kawin munculkan tahun kawin
            if(marriedStatus == 'kawin') {
                $('#years_married').attr('required', 'required');
                $('#years_married').show();
            } else {
                $('#years_married').attr('required', false);
                $('#years_married').hide();
            }
        });

        $('#formBiodata input,select').on('change', function(e) {
            var $this = $(this);
            var nameAttr = $this.attr('name');
            var value = $this.val();
            var urlPost = "{{ route('karyawan.datadiri.store', $karyawan->id) }}";

            $.ajax({
                url: urlPost,
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    name: nameAttr,
                    value: value
                }
            });
        });

        $('#formBiodata input').on('keyup', function() {
            var $this = $(this);
            var value = $this.val();

            if(value) {
                $this.removeClass('is-invalid');
            } else {
                $this.addClass('is-invalid');
            }
        });

        $('#formBiodata .indo-input-identity').on('change', function(e) {
            const $this = $(this);
            const value = $this.val();
            const indoType = $this.attr('data-indo');
            const urlPost = "{{ route('indonesiadata') }}";

            $.ajax({
                url: urlPost,
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    value: value,
                    type: indoType
                },
                success: function(response) {
                    const status = response.type;

                    if(status == 'regency') {
                        $('#identity_regency').html(response.regencyOptions);
                    }

                    if(status == 'district') {
                        $('#identity_district').html(response.districtOptions);
                    }

                    if(status == 'village') {
                        $('#identity_village').html(response.villageOptions);
                    }
                }
            });
        });

        $('#formBiodata .indo-input-current').on('change', function(e) {
            const $this = $(this);
            const value = $this.val();
            const indoType = $this.attr('data-indo');
            const urlPost = "{{ route('indonesiadata') }}";

            $.ajax({
                url: urlPost,
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    value: value,
                    type: indoType
                },
                success: function(response) {
                    const status = response.type;

                    if(status == 'regency') {
                        $('#current_regency').html(response.regencyOptions);
                    }

                    if(status == 'district') {
                        $('#current_district').html(response.districtOptions);
                    }

                    if(status == 'village') {
                        $('#current_village').html(response.villageOptions);
                    }
                }
            });
        });

    </script>
@endsection
