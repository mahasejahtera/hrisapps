@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Data Anak</p>
    </div>
</header>

<section id="form-bio">
    <form action="{{ route('karyawan.datadiri.anakstore', $karyawan->email) }}" method="post" id="formBiodata">
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

        <div class="children-form-wrapper">
            @if (count($karyawanChildren) > 0)
                @foreach ($karyawanChildren as $item)
                    <div id="formChildren{{ $loop->iteration }}">
                        {{--ANAK --}}
                        <div class="d-flex align-items-center form-group">
                            <p class="form-label-section m-0">ANAK</p>
                            <button type="button" data-toggle="modal" data-target="#deleteModal" data-children="{{ $item->id }}" class="btn btn-danger ml-2 btn-delete" data-el-target="#formChildren{{ $loop->iteration }}">-</button>
                        </div>

                        <input type="hidden" name="children_id[]" value="{{ $item->id }}">

                        <div class="form-group">
                            <input type="text" class="form-control @error('children_name') is-invalid @enderror" name="children_name[]" id="children_name" placeholder="Nama Anak" value="{{ $item->children_name }}" required>
                            @error('children_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select name="children_gender[]" id="children_gender" class="form-control @error('children_gender') is-invalid @enderror" required>
                                <option value="">--Jenis Kelamin Anak --</option>
                                <option value="L" @selected($item->children_gender == 'L')>Laki-Laki</option>
                                <option value="P" @selected($item->children_gender == 'P')>Perempuan</option>
                            </select>
                            @error('children_gender')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="number" class="form-control @error('children_age') is-invalid @enderror" name="children_age[]" id="children_age" min="0" max="999" placeholder="Usia Anak" value="{{ $item->children_age }}" required>
                            @error('children_age')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select name="children_last_education[]" id="children_last_education" class="form-control @error('children_last_education') is-invalid @enderror" required>
                                <option value="">--Pendidikan Terakhir --</option>
                                <option value="belum sekolah" @selected($item->children_last_education == 'belum sekolah')>Belum Sekolah</option>
                                <option value="sd" @selected($item->children_last_education == 'sd')>SD</option>
                                <option value="smp" @selected($item->children_last_education == 'smp')>SMP</option>
                                <option value="sma" @selected($item->children_last_education == 'sma')>SMA</option>
                                <option value="d i" @selected($item->children_last_education == 'd i')>D I</option>
                                <option value="d ii" @selected($item->children_last_education == 'd ii')>D II</option>
                                <option value="d iii" @selected($item->children_last_education == 'd iii')>D III</option>
                                <option value="s1" @selected($item->children_last_education == 's1')>S1 / D IV</option>
                                <option value="s2" @selected($item->children_last_education == 's2')>S2</option>
                                <option value="s3" @selected($item->children_last_education == 's3')>S3</option>
                            </select>
                            @error('children_last_education')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <p class="form-label-section">Pekerjaan Terakhir</p>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control @error('children_last_job_position') is-invalid @enderror" name="children_last_job_position[]" id="children_last_job_position" placeholder="Jabatan (Optional)" value="{{ $item->children_last_job_position }}">
                            @error('children_last_job_position')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control @error('children_last_job_company') is-invalid @enderror" name="children_last_job_company[]" id="children_last_job_company" placeholder="Perusahaan (Optional)" value="{{ $item->children_last_job_company }}">
                            @error('children_last_job_company')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="d-flex mt-2 mb-5">
            <button type="button" class="btn btn-info mr-2" id="addChildrenForm">+</button>
            <button type="submit" class="btn primary">Lanjut</button>
        </div>
    </form>

    <!-- Modal -->
    <button type="button" class="d-none btn btn-primary btn-modal-alert" data-toggle="modal" data-target="#alertModal">
        Launch demo modal
    </button>

    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    {{-- modal delete --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Anak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('karyawan.anak.destroy') }}" method="post">
                        @csrf
                        @method("DELETE")

                        <input type="hidden" name="children">
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scriptJS')
    <script>
        let baris = {{ count($karyawanChildren) }};

        $('#addChildrenForm').on('click', function(e) {
            baris++;

            var html = `<div id="formChildren${baris}">`;
            html += `<div class="d-flex align-items-center form-group">
                        <p class="form-label-section m-0">ANAK</p>
                        <button type="button" class="btn btn-danger ml-2 remove-children-form" data-el-target="#formChildren${baris}">-</button>
                    </div>`;
            html += `<input type="hidden" name="children_id[]">`;
            html += `<div class="form-group">
                        <input type="text" class="form-control @error('children_name') is-invalid @enderror" name="children_name[]" id="children_name${baris}" placeholder="Nama Anak" required>
                        @error('children_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>`;
            html += `<div class="form-group">
                        <select name="children_gender[]" id="children_gender" class="form-control @error('children_gender') is-invalid @enderror" required>
                            <option value="">--Jenis Kelamin Anak--</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('children_gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>`;
            html += `<div class="form-group">
                        <input type="number" class="form-control @error('children_age') is-invalid @enderror" name="children_age[]" id="children_age${baris}" min="0" max="999" placeholder="Usia Anak" required>
                        @error('children_age')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>`;
            html += `<div class="form-group">
                        <select name="children_last_education[]" id="children_last_education${baris}" class="form-control @error('children_last_education') is-invalid @enderror"  required>
                            <option value="">--Pendidikan Terakhir Anak--</option>
                            <option value="belum sekolah">Belum Sekolah</option>
                            <option value="sd">SD</option>
                            <option value="smp">SMP</option>
                            <option value="sma">SMA</option>
                            <option value="d i">D I</option>
                            <option value="d ii">D II</option>
                            <option value="d iii">D III</option>
                            <option value="s1">S1 / D IV</option>
                            <option value="s2">S2</option>
                            <option value="s3">S3</option>
                        </select>
                        @error('children_last_education')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>`;
            html += `<div class="form-group">
                        <p class="form-label-section">Pekerjaan Terakhir Anak</p>
                    </div>`;
            html += `<div class="form-group">
                        <input type="text" class="form-control @error('children_last_job_position') is-invalid @enderror" name="children_last_job_position[]" id="children_last_job_position${baris}" placeholder="Jabatan (Optional)">
                        @error('children_last_job_position')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>`;
            html += `<div class="form-group">
                        <input type="text" class="form-control @error('children_last_job_company') is-invalid @enderror" name="children_last_job_company[]" id="children_last_job_company${baris}" placeholder="Perusahaan (Optional)">
                        @error('children_last_job_company')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>`;
            html += `</div>`;

            $('.children-form-wrapper').append(html);
        });


        $(document).on('click', '.remove-children-form', function(e) {
            const $this = $(this);
            const target = $this.attr('data-el-target');

            $(target).remove();
        });

        $('.btn-delete').on('click', function(e) {
            const $this = $(this);
            const children = $this.attr('data-children');

            $('#deleteModal input[name="children"]').val(children);
        });
    </script>
@endsection
