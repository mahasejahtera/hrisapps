@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Form Data Diri</p>
    </div>

    <p class="step-label">Step 1</p>
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

        {{-- SUSUNAN KELUARGa --}}
        <div class="form-group">
            <p class="form-label-section">Susunan Keluarga</p>
        </div>

        <div class="form-group">
            <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" id="father_name" placeholder="Ayah Kandung" data-form="family" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->father_name : '' }}">
            @error('father_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" id="mother_name" placeholder="Ibu Kandung" data-form="family" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->mother_name : '' }}">
            @error('mother_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="number" class="form-control @error('siblings_num') is-invalid @enderror" name="siblings_num" id="siblings_num" placeholder="Jumlah Saudara" data-form="family" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->siblings_num : '' }}">
            @error('siblings_num')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        @if ($karyawanBiodata[0]->marital_status == 'kawin')
            <div class="form-group">
                <input type="text" class="form-control @error('couple_name') is-invalid @enderror" name="couple_name" id="couple_name" placeholder="Suami/Istri" data-form="family" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->couple_name : '' }}">
                @error('couple_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif
        <div class="form-group">
            <input type="number" class="form-control @error('child_to') is-invalid @enderror" name="child_to" id="child_to" placeholder="Anak Ke" data-form="family" value="{{ (!empty($karyawanFamily[0])) ? $karyawanFamily[0]->child_to : '' }}">
            @error('child_to')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- SUSUNAN KELUARGa --}}
        <div class="form-group">
            <p class="form-label-section">Pendidikan</p>
        </div>
        
        <div class="form-group">
            <select name="last_education" id="last_education" class="form-control @error('last_education') is-invalid @enderror" data-form="education">
                <option value="">--Pendidikan Terakhir --</option>
                <option value="sd" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 'sd' ? 'selected' : '') : '' }}>SD</option>
                <option value="smp" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 'smp' ? 'selected' : '') : '' }}>SMP</option>
                <option value="sma" {{ !empty($karyawanEducation[0]) ? ($karyawanEducation[0]->last_education == 'sma' ? 'selected' : '') : '' }}>SMA</option>
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

        <div class="form-group">
            <input type="text" class="form-control @error('primary_school') is-invalid @enderror" name="primary_school" id="primary_school" placeholder="Sekolah Dasar" data-form="education" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->primary_school : '' }}">
            @error('primary_school')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('junior_hight_school') is-invalid @enderror" name="junior_hight_school" id="junior_hight_school" placeholder="Sekolah Menangah Pertama" data-form="education" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->junior_hight_school : '' }}">
            @error('junior_hight_school')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('senior_hight_school') is-invalid @enderror" name="senior_hight_school" id="senior_hight_school" placeholder="Sekolah Menangah Atas" data-form="education" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->senior_hight_school : '' }}">
            @error('senior_hight_school')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" class="form-control @error('university') is-invalid @enderror" name="university" id="university" placeholder="Universitas" data-form="education" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->university : '' }}">
            @error('university')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>  
        <div class="form-group">
            <input type="text" class="form-control @error('major') is-invalid @enderror" name="major" id="major" placeholder="Jurusan" data-form="education" value="{{ (!empty($karyawanEducation[0])) ? $karyawanEducation[0]->major : '' }}">
            @error('major')
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
        $('#formBiodata input,select').on('change', function(e) {
            var $this = $(this);
            var nameAttr = $this.attr('name'); 
            var value = $this.val();
            var formType = $this.attr('data-form');
            var urlPost = "{{ route('karyawan.datadiri.store.next', $karyawan->id) }}";
            
            $.ajax({
                url: urlPost,
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    name: nameAttr,
                    value: value,
                    formType: formType
                }
            });
        });
    </script>
@endsection