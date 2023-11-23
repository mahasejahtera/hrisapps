@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Pendidikan</p>
    </div>
</header>

<section id="form-bio">
    <form action="{{ route('karyawan.education.store', $karyawan->email) }}" method="post" id="formBiodata">
        @csrf

        @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <div class="form-group">
            <select name="last_education" id="last_education" class="form-control @error('last_education') is-invalid @enderror">
                <option value="">--Pendidikan Terakhir --</option>
                <option value="sd" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 'sd' ? 'selected' : '') : '' }}>SD</option>
                <option value="smp" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 'smp' ? 'selected' : '') : '' }}>SMP</option>
                <option value="sma" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 'sma' ? 'selected' : '') : '' }}>SMA</option>
                <option value="d i" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 'd i' ? 'selected' : '') : '' }}>D I</option>
                <option value="d ii" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 'd ii' ? 'selected' : '') : '' }}>D II</option>
                <option value="d iii" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 'd iii' ? 'selected' : '') : '' }}>D III</option>
                <option value="s1" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 's1' ? 'selected' : '') : '' }}>S1 / D IV</option>
                <option value="s2" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 's2' ? 'selected' : '') : '' }}>S2</option>
                <option value="s3" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 's3' ? 'selected' : '') : '' }}>S3</option>
            </select>
            @error('last_education')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <div id="sd-wrapper">
            {{-- SD --}}
            <div class="form-group">
                <p class="form-label-section">SD</p>
            </div>

            <div class="form-group">
                <input type="text" class="form-control @error('primary_school') is-invalid @enderror" name="primary_school" id="primary_school" placeholder="Nama SD" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->primary_school : '' }}">
                @error('primary_school')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" class="form-control @error('sd_start_year') is-invalid @enderror" name="sd_start_year" id="sd_start_year" placeholder="Tahun Masuk SD" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->sd_start_year : '' }}">
                @error('sd_start_year')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" class="form-control @error('sd_end_year') is-invalid @enderror" name="sd_end_year" id="sd_end_year" placeholder="Tahun Selesai SD" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->sd_end_year : '' }}">
                @error('sd_end_year')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group pl-3">
                <label for=""><strong>Berijazah</strong></label>
                <div class="d-flex">
                    <div class="">
                        <input type="radio" name="sd_ijazah" id="sd_ijazahY" value="y" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->sd_ijazah == 'y' ? 'checked' : '') : '' }}>
                        <label for="sd_ijazahY">Ya</label>
                    </div>
                    <div class="ml-2">
                        <input type="radio" name="sd_ijazah" id="sd_ijazahN" value="n"{{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->sd_ijazah == 'n' ? 'checked' : '') : '' }}>
                        <label for="sd_ijazahN">Tidak</label>
                    </div>
                </div>
                @error('sd_ijazah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div id="smp-wrapper">
            {{-- SMP --}}
            <div class="form-group">
                <p class="form-label-section">SMP</p>
            </div>

            <div class="form-group">
                <input type="text" class="form-control @error('junior_hight_school') is-invalid @enderror" name="junior_hight_school" id="junior_hight_school" placeholder="Nama SMP" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->junior_hight_school : '' }}">
                @error('junior_hight_school')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" class="form-control @error('smp_start_year') is-invalid @enderror" name="smp_start_year" id="smp_start_year" placeholder="Tahun Masuk SMP" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->smp_start_year : '' }}">
                @error('smp_start_year')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" class="form-control @error('smp_end_year') is-invalid @enderror" name="smp_end_year" id="smp_end_year" placeholder="Tahun Selesai SMP" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->smp_end_year : '' }}">
                @error('smp_end_year')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group pl-3">
                <label for=""><strong>Berijazah</strong></label>
                <div class="d-flex">
                    <div class="">
                        <input type="radio" name="smp_ijazah" id="smp_ijazahY" value="y" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->smp_ijazah == 'y' ? 'checked' : '') : '' }}>
                        <label for="smp_ijazahY">Ya</label>
                    </div>
                    <div class="ml-2">
                        <input type="radio" name="smp_ijazah" id="smp_ijazahN" value="n"{{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->smp_ijazah == 'n' ? 'checked' : '') : '' }}>
                        <label for="smp_ijazahN">Tidak</label>
                    </div>
                </div>
                @error('smp_ijazah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div id="sma-wrapper">
            {{-- SMA --}}
            <div class="form-group">
                <p class="form-label-section">SMA</p>
            </div>

            <div class="form-group">
                <input type="text" class="form-control @error('senior_hight_school') is-invalid @enderror" name="senior_hight_school" id="senior_hight_school" placeholder="Nama SMA" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->senior_hight_school : '' }}">
                @error('senior_hight_school')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" class="form-control @error('sma_start_year') is-invalid @enderror" name="sma_start_year" id="sma_start_year" placeholder="Tahun Masuk SMA" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->sma_start_year : '' }}">
                @error('sma_start_year')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" class="form-control @error('sma_end_year') is-invalid @enderror" name="sma_end_year" id="sma_end_year" placeholder="Tahun Selesai SMA" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->sma_end_year : '' }}">
                @error('sma_end_year')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group pl-3">
                <label for=""><strong>Berijazah</strong></label>
                <div class="d-flex">
                    <div class="">
                        <input type="radio" name="sma_ijazah" id="sma_ijazahY" value="y" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->sma_ijazah == 'y' ? 'checked' : '') : '' }}>
                        <label for="sma_ijazahY">Ya</label>
                    </div>
                    <div class="ml-2">
                        <input type="radio" name="sma_ijazah" id="sma_ijazahN" value="n"{{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->sma_ijazah == 'n' ? 'checked' : '') : '' }}>
                        <label for="sma_ijazahN">Tidak</label>
                    </div>
                </div>
                @error('sma_ijazah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>


        <div id="bachelor-wrapper">
            {{-- S! --}}
            <div class="form-group">
                <p class="form-label-section">Diploma / Sarjana</p>
            </div>

            <div class="form-group">
                <input type="text" class="form-control @error('bachelor_university') is-invalid @enderror" name="bachelor_university" id="bachelor_university" placeholder="Universitas" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->bachelor_university : '' }}">
                @error('bachelor_university')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" class="form-control @error('bachelor_major') is-invalid @enderror" name="bachelor_major" id="bachelor_major" placeholder="Jurusan" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->bachelor_major : '' }}">
                @error('bachelor_major')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="number" class="form-control @error('bachelor_start_year') is-invalid @enderror" name="bachelor_start_year" id="bachelor_start_year" placeholder="Tahun Masuk" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->bachelor_start_year : '' }}">
                @error('bachelor_start_year')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="number" class="form-control @error('bachelor_end_year') is-invalid @enderror" name="bachelor_end_year" id="bachelor_end_year" placeholder="Tahun Selesai" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->bachelor_end_year : '' }}">
                @error('bachelor_end_year')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group pl-3">
                <label for=""><strong>Berijazah</strong></label>
                <div class="d-flex">
                    <div class="">
                        <input type="radio" name="bachelor_ijazah" id="bachelor_ijazahY" value="y" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->bachelor_ijazah == 'y' ? 'checked' : '') : '' }}>
                        <label for="bachelor_ijazahY">Ya</label>
                    </div>
                    <div class="ml-2">
                        <input type="radio" name="bachelor_ijazah" id="bachelor_ijazahN" value="n"{{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->bachelor_ijazah == 'n' ? 'checked' : '') : '' }}>
                        <label for="bachelor_ijazahN">Tidak</label>
                    </div>
                </div>
                @error('bachelor_ijazah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" class="form-control @error('bachelor_gpa') is-invalid @enderror" name="bachelor_gpa" id="bachelor_gpa" placeholder="IPK (cth: 4.00)" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->bachelor_gpa : '' }}">
                @error('bachelor_gpa')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" class="form-control @error('bachelor_degree') is-invalid @enderror" name="bachelor_degree" id="bachelor_degree" placeholder="Gelar (cth:S.Kom)" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->bachelor_degree : '' }}">
                @error('bachelor_degree')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>


        <div id="master-wrapper">
            {{-- S! --}}
            <div class="form-group">
                <p class="form-label-section">Magister</p>
            </div>

            <div class="form-group">
                <input type="text" class="form-control @error('master_university') is-invalid @enderror" name="master_university" id="master_university" placeholder="Universitas" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->master_university : '' }}">
                @error('master_university')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" class="form-control @error('master_major') is-invalid @enderror" name="master_major" id="master_major" placeholder="Jurusan" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->master_major : '' }}">
                @error('master_major')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="number" class="form-control @error('master_start_year') is-invalid @enderror" name="master_start_year" id="master_start_year" placeholder="Tahun Masuk" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->master_start_year : '' }}">
                @error('master_start_year')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="number" class="form-control @error('master_end_year') is-invalid @enderror" name="master_end_year" id="master_end_year" placeholder="Tahun Selesai" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->master_end_year : '' }}">
                @error('master_end_year')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group pl-3">
                <label for=""><strong>Berijazah</strong></label>
                <div class="d-flex">
                    <div class="">
                        <input type="radio" name="master_ijazah" id="master_ijazahY" value="y" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->master_ijazah == 'y' ? 'checked' : '') : '' }}>
                        <label for="master_ijazahY">Ya</label>
                    </div>
                    <div class="ml-2">
                        <input type="radio" name="master_ijazah" id="master_ijazahN" value="n"{{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->master_ijazah == 'n' ? 'checked' : '') : '' }}>
                        <label for="master_ijazahN">Tidak</label>
                    </div>
                </div>
                @error('master_ijazah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" class="form-control @error('master_gpa') is-invalid @enderror" name="master_gpa" id="master_gpa" placeholder="IPK (cth: 4.00)" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->master_gpa : '' }}">
                @error('master_gpa')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" class="form-control @error('master_degree') is-invalid @enderror" name="master_degree" id="master_degree" placeholder="Gelar (cth:S.Kom)" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->master_degree : '' }}">
                @error('master_degree')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>


        <div id="doctor-wrapper">
            {{-- S! --}}
            <div class="form-group">
                <p class="form-label-section">Doctor</p>
            </div>

            <div class="form-group">
                <input type="text" class="form-control @error('doctor_university') is-invalid @enderror" name="doctor_university" id="doctor_university" placeholder="Universitas" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->doctor_university : '' }}">
                @error('doctor_university')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" class="form-control @error('doctor_major') is-invalid @enderror" name="doctor_major" id="doctor_major" placeholder="Jurusan" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->doctor_major : '' }}">
                @error('doctor_major')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="number" class="form-control @error('doctor_start_year') is-invalid @enderror" name="doctor_start_year" id="doctor_start_year" placeholder="Tahun Masuk" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->doctor_start_year : '' }}">
                @error('doctor_start_year')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="number" class="form-control @error('doctor_end_year') is-invalid @enderror" name="doctor_end_year" id="doctor_end_year" placeholder="Tahun Selesai" min="1945" max="{{ date('Y') }}" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->doctor_end_year : '' }}">
                @error('doctor_end_year')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group pl-3">
                <label for=""><strong>Berijazah</strong></label>
                <div class="d-flex">
                    <div class="">
                        <input type="radio" name="doctor_ijazah" id="doctor_ijazahY" value="y" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->doctor_ijazah == 'y' ? 'checked' : '') : '' }}>
                        <label for="doctor_ijazahY">Ya</label>
                    </div>
                    <div class="ml-2">
                        <input type="radio" name="doctor_ijazah" id="doctor_ijazahN" value="n"{{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->doctor_ijazah == 'n' ? 'checked' : '') : '' }}>
                        <label for="doctor_ijazahN">Tidak</label>
                    </div>
                </div>
                @error('doctor_ijazah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" class="form-control @error('doctor_gpa') is-invalid @enderror" name="doctor_gpa" id="doctor_gpa" placeholder="IPK (cth: 4.00)" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->doctor_gpa : '' }}">
                @error('doctor_gpa')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" class="form-control @error('doctor_degree') is-invalid @enderror" name="doctor_degree" id="doctor_degree" placeholder="Gelar (cth:S.Kom)" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->doctor_degree : '' }}">
                @error('doctor_degree')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn primary btn-block mt-2 mb-5">Lanjut</button>
    </form>
</section>

@endsection

@section('scriptJS')
    <script>
        $(document).ready(function() {
            $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper, #doctor-wrapper').hide();
            const lastEducation = "{{ (!empty($karyawanEducation[0]) ? $karyawanEducation[0]->last_education : '') }}";

            if(lastEducation =='sd') {
                $('#sd-wrapper').show();
            } else if(lastEducation == 'smp') {
                $('#sd-wrapper, #smp-wrapper').show();
            } else if(lastEducation == 'sma') {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper').show();
            } else if(lastEducation == 'd i' || lastEducation == 'd ii' || lastEducation == 'd iii' || lastEducation == 's1') {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper').show();
            } else if(lastEducation == 's2') {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper').show();
            } else if(lastEducation == 's3') {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper, #doctor-wrapper').show();
            }
        });

        $('#formBiodata input,select').on('change', function(e) {
            var $this = $(this);
            var nameAttr = $this.attr('name');
            var value = $this.val();
            var urlPost = "{{ route('karyawan.education.store', $karyawan->email) }}";

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


        $('#last_education').on('change', function(e) {
            const $this = $(this);
            const value = $this.val();

            if(value =='sd') {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper, #doctor-wrapper').hide();
                $('#sd-wrapper').show();
            } else if(value == 'smp') {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper, #doctor-wrapper').hide();
                $('#sd-wrapper, #smp-wrapper').show();
            } else if(value == 'sma') {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper, #doctor-wrapper').hide();
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper').show();
            } else if(value == 'd i' || value == 'd ii' || value == 'd iii' || value == 's1') {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper, #doctor-wrapper').hide();
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper').show();
            } else if(value == 's2') {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper, #doctor-wrapper').hide();
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper').show();
            } else if(value == 's3') {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper, #doctor-wrapper').hide();
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper, #doctor-wrapper').show();
            } else {
                $('#sd-wrapper, #smp-wrapper, #sma-wrapper, #bachelor-wrapper, #master-wrapper, #doctor-wrapper').hide();
            }
        });
    </script>
@endsection
