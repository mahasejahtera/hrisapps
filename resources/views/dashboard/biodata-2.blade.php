@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Susuna Keluarga</p>
    </div>
</header>

<section id="form-bio">
    <form action="{{ route('karyawan.datadiri.store.next', $karyawan->id) }}" method="post" id="formBiodata">
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

        @if ($karyawanBiodata[0]->marital_status == 'kawin')

            <div class="form-group">
                <p class="form-label-section">{{ $karyawanBiodata[0]->gender == 'L' ? 'Istri' : 'Suami' }}</p>
            </div>

            <div class="form-group">
                <input type="text" class="form-control @error('couple_name') is-invalid @enderror" name="couple_name" id="couple_name" placeholder="Nama {{ $karyawanBiodata[0]->gender == 'L' ? 'Istri' : 'Suami' }}" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->couple_name : '' }}" required>
                @error('couple_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" class="form-control @error('couple_age') is-invalid @enderror" name="couple_age" id="couple_age" placeholder="Usia {{ $karyawanBiodata[0]->gender == 'L' ? 'Istri' : 'Suami' }}" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->couple_age : '' }}" required>
                @error('couple_age')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <select name="couple_last_education" id="couple_last_education" class="form-control @error('couple_last_education') is-invalid @enderror" required>
                    <option value="">--Pendidikan Terakhir {{ $karyawanBiodata[0]->gender == 'L' ? 'Istri' : 'Suami' }} --</option>
                    <option value="sd" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'sd' ? 'selected' : '') : '' }}>SD</option>
                    <option value="smp" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'smp' ? 'selected' : '') : '' }}>SMP</option>
                    <option value="sma" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'sma' ? 'selected' : '') : '' }}>SMA</option>
                    <option value="d i" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'd i' ? 'selected' : '') : '' }}>D I</option>
                    <option value="d ii" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'd ii' ? 'selected' : '') : '' }}>D II</option>
                    <option value="d iii" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 'd iii' ? 'selected' : '') : '' }}>D III</option>
                    <option value="s1" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 's1' ? 'selected' : '') : '' }}>S1 / D IV</option>
                    <option value="s2" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 's2' ? 'selected' : '') : '' }}>S2</option>
                    <option value="s3" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->couple_last_education == 's3' ? 'selected' : '') : '' }}>S3</option>
                </select>
                @error('couple_last_education')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <p class="form-label-section">Pekerjaan Terakhir {{ $karyawanBiodata[0]->gender == 'L' ? 'Istri' : 'Suami' }}</p>
            </div>

            <div class="form-group">
                <input type="text" class="form-control @error('couple_last_job_position') is-invalid @enderror" name="couple_last_job_position" id="couple_last_job_position" placeholder="Jabatan (Optional)" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->couple_last_job_position : '' }}">
                @error('couple_last_job_position')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="text" class="form-control @error('couple_last_job_company') is-invalid @enderror" name="couple_last_job_company" id="couple_last_job_company" placeholder="Perusahaan (Optional)" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->couple_last_job_company : '' }}">
                @error('couple_last_job_company')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        @endif


        {{--AYAH --}}
        <div class="form-group">
            <p class="form-label-section">AYAH</p>
        </div>


        <div class="form-group">
            <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" id="father_name" placeholder="Nama Ayah Kandung" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->father_name : '' }}" required>
            @error('father_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group pl-3">
            <label for=""><strong>Status Ayah</strong></label>
            <div class="d-flex">
                <div class="">
                    <input type="radio" name="father_status" id="father_status" value="1" {{ (!empty($karyawanFamily[0])) ? ($karyawanFamily[0]->father_status == 1 ? 'checked' : '') : '' }} required>
                    <label for="father_status">Hidup</label>
                </div>
                <div class="ml-2">
                    <input type="radio" name="father_status" id="father_status1" value="2" {{ (!empty($karyawanFamily[0])) ? ($karyawanFamily[0]->father_status == 2 ? 'checked' : '') : '' }} required>
                    <label for="father_status1">Meninggal</label>
                </div>
            </div>
            @error('father_status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="number" class="form-control @error('father_age') is-invalid @enderror" name="father_age" id="father_age" placeholder="Usia Ayah" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->father_age : '' }}">
            @error('father_age')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <select name="father_last_education" id="father_last_education" class="form-control @error('father_last_education') is-invalid @enderror" required>
                <option value="">--Pendidikan Terakhir Ayah --</option>
                <option value="sd" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'sd' ? 'selected' : '') : '' }}>SD</option>
                <option value="smp" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'smp' ? 'selected' : '') : '' }}>SMP</option>
                <option value="sma" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'sma' ? 'selected' : '') : '' }}>SMA</option>
                <option value="d i" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'd i' ? 'selected' : '') : '' }}>D I</option>
                <option value="d ii" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'd ii' ? 'selected' : '') : '' }}>D II</option>
                <option value="d iii" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 'd iii' ? 'selected' : '') : '' }}>D III</option>
                <option value="s1" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 's1' ? 'selected' : '') : '' }}>S1 / D IV</option>
                <option value="s2" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 's2' ? 'selected' : '') : '' }}>S2</option>
                <option value="s3" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->father_last_education == 's3' ? 'selected' : '') : '' }}>S3</option>
            </select>
            @error('father_last_education')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <p class="form-label-section">Pekerjaan Terakhir Ayah</p>
        </div>

        <div class="form-group">
            <input type="text" class="form-control @error('father_last_job_position') is-invalid @enderror" name="father_last_job_position" id="father_last_job_position" placeholder="Jabatan (Optional)" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->father_last_job_position : '' }}">
            @error('father_last_job_position')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="text" class="form-control @error('father_last_job_company') is-invalid @enderror" name="father_last_job_company" id="father_last_job_company" placeholder="Perusahaan (Optional)" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->father_last_job_company : '' }}">
            @error('father_last_job_company')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>


        {{--AYAH --}}
        <div class="form-group">
            <p class="form-label-section">IBU</p>
        </div>


        <div class="form-group">
            <input type="text" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" id="mother_name" placeholder="Nama Ibu Kandung" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->mother_name : '' }}" required>
            @error('mother_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group pl-3">
            <label for=""><strong>Status Ibu</strong></label>
            <div class="d-flex">
                <div class="">
                    <input type="radio" name="mother_status" id="mother_status" value="1" {{ (!empty($karyawanFamily[0])) ? ($karyawanFamily[0]->mother_status == 1 ? 'checked' : '') : '' }} required>
                    <label for="mother_status">Hidup</label>
                </div>
                <div class="ml-2">
                    <input type="radio" name="mother_status" id="mother_status1" value="2" {{ (!empty($karyawanFamily[0])) ? ($karyawanFamily[0]->mother_status == 2 ? 'checked' : '') : '' }} required>
                    <label for="mother_status1">Meninggal</label>
                </div>
            </div>
            @error('mother_status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="number" class="form-control @error('mother_age') is-invalid @enderror" name="mother_age" id="mother_age" placeholder="Usia Ibu" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->mother_age : '' }}">
            @error('mother_age')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <select name="mother_last_education" id="mother_last_education" class="form-control @error('mother_last_education') is-invalid @enderror" required>
                <option value="">--Pendidikan Terakhir Ibu --</option>
                <option value="sd" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'sd' ? 'selected' : '') : '' }}>SD</option>
                <option value="smp" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'smp' ? 'selected' : '') : '' }}>SMP</option>
                <option value="sma" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'sma' ? 'selected' : '') : '' }}>SMA</option>
                <option value="d i" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'd i' ? 'selected' : '') : '' }}>D I</option>
                <option value="d ii" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'd ii' ? 'selected' : '') : '' }}>D II</option>
                <option value="d iii" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 'd iii' ? 'selected' : '') : '' }}>D III</option>
                <option value="s1" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 's1' ? 'selected' : '') : '' }}>S1 / D IV</option>
                <option value="s2" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 's2' ? 'selected' : '') : '' }}>S2</option>
                <option value="s3" {{ !empty($karyawanFamily[0]) ? ($karyawanFamily[0]->mother_last_education == 's3' ? 'selected' : '') : '' }}>S3</option>
            </select>
            @error('mother_last_education')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <p class="form-label-section">Pekerjaan Terakhir Ibu</p>
        </div>

        <div class="form-group">
            <input type="text" class="form-control @error('mother_last_job_position') is-invalid @enderror" name="mother_last_job_position" id="mother_last_job_position" placeholder="Jabatan (Optional)" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->mother_last_job_position : '' }}">
            @error('mother_last_job_position')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="text" class="form-control @error('mother_last_job_company') is-invalid @enderror" name="mother_last_job_company" id="mother_last_job_company" placeholder="Perusahaan (Optional)" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->mother_last_job_company : '' }}">
            @error('mother_last_job_company')
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
        $(document).ready(function(e) {
            const fatherStatus = {{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->father_status : 1 }};
            const motherStatus = {{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->mother_status : 1 }};

            if(fatherStatus == 2) {
                $('#formBiodata #father_age').attr('required', '');
                $('#formBiodata #father_age').hide();
            } else {
                $('#formBiodata #father_age').attr('required', 'required');
                $('#formBiodata #father_age').show();
            }

            if(motherStatus == 2) {
                $('#formBiodata #mother_age').attr('required', '');
                $('#formBiodata #mother_age').hide();
            } else {
                $('#formBiodata #mother_age').attr('required', 'required');
                $('#formBiodata #mother_age').show();
            }
        });

        $('#formBiodata input,select').on('change', function(e) {
            var $this = $(this);
            var nameAttr = $this.attr('name');
            var value = $this.val();
            // var formType = $this.attr('data-form');
            var urlPost = "{{ route('karyawan.datadiri.store.next', $karyawan->id) }}";

            $.ajax({
                url: urlPost,
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    name: nameAttr,
                    value: value,
                    // formType: formType
                }
            });
        });

        $('#formBiodata input[name="father_status"]').on('change', function(e) {
            const $this = $(this);
            const value = $this.val();

            if(value == 1) {
                $('#formBiodata #father_age').attr('required', 'required');
                $('#formBiodata #father_age').show();
            } else {
                $('#formBiodata #father_age').attr('required', '');
                $('#formBiodata #father_age').hide();
            }
        });

        $('#formBiodata input[name="mother_status"]').on('change', function(e) {
            const $this = $(this);
            const value = $this.val();

            if(value == 1) {
                $('#formBiodata #mother_age').attr('required', 'required');
                $('#formBiodata #mother_age').show();
            } else {
                $('#formBiodata #mother_age').attr('required', '');
                $('#formBiodata #mother_age').hide();
            }
        });
    </script>
@endsection
