@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Data Kakak/Adik</p>
    </div>
</header>

<section id="form-bio">
    <form action="{{ route('karyawan.datadiri.saudarastore', $karyawan->email) }}" method="post" id="formBiodata">
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

        <div class="siblings-form-wrapper">
            @if (count($karyawanSibling) > 0)
                @foreach ($karyawanSibling as $item)
                    <div id="formSiblings{{ $loop->iteration }}">
                        {{--SAUDARA --}}
                        <div class="d-flex align-items-center form-group">
                            <p class="form-label-section m-0">Kakak/Adik Kandung</p>
                            <button type="button" data-toggle="modal" data-target="#deleteModal" data-sibling="{{ $item->id }}" class="btn btn-danger ml-2 btn-delete" data-el-target="#formSiblings{{ $loop->iteration }}">-</button>
                        </div>

                        <input type="hidden" name="siblings_id[]" value="{{ $item->id }}">

                        <div class="form-group">
                            <input type="text" class="form-control @error('siblings_name') is-invalid @enderror" name="siblings_name[]" id="siblings_name" placeholder="Nama Kakak/Adik Kandung" value="{{ $item->siblings_name }}" required>
                            @error('siblings_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select name="siblings_gender[]" id="siblings_gender" class="form-control @error('siblings_gender') is-invalid @enderror" required>
                                <option value="">--Jenis Kelamin Kakak/Adik Kandung--</option>
                                <option value="L" @selected($item->siblings_gender == 'L')>Laki-Laki</option>
                                <option value="P" @selected($item->siblings_gender == 'P')>Perempuan</option>
                            </select>
                            @error('siblings_gender')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="number" class="form-control @error('siblings_age') is-invalid @enderror" name="siblings_age[]" id="siblings_age" min="0" max="999" placeholder="Usia Kakak/Adik Kandung" value="{{ $item->siblings_age }}" required>
                            @error('siblings_age')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select name="siblings_last_education[]" id="siblings_last_education" class="form-control @error('siblings_last_education') is-invalid @enderror" required>
                                <option value="">--Pendidikan Terakhir Kakak/Adik Kandung--</option>
                                <option value="sd" @selected($item->siblings_last_education == 'sd')>SD</option>
                                <option value="smp" @selected($item->siblings_last_education == 'smp')>SMP</option>
                                <option value="sma" @selected($item->siblings_last_education == 'sma')>SMA</option>
                                <option value="d i" @selected($item->siblings_last_education == 'd i')>D I</option>
                                <option value="d ii" @selected($item->siblings_last_education == 'd ii')>D II</option>
                                <option value="d iii" @selected($item->siblings_last_education == 'd iii')>D III</option>
                                <option value="s1" @selected($item->siblings_last_education == 's1')>S1 / D IV</option>
                                <option value="s2" @selected($item->siblings_last_education == 's2')>S2</option>
                                <option value="s3" @selected($item->siblings_last_education == 's3')>S3</option>
                            </select>
                            @error('siblings_last_education')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <p class="form-label-section">Pekerjaan Terakhir Kakak/Adik Kandung</p>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control @error('siblings_last_job_position') is-invalid @enderror" name="siblings_last_job_position[]" id="siblings_last_job_position" placeholder="Jabatan (Optional)" value="{{ $item->siblings_last_job_position }}">
                            @error('siblings_last_job_position')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control @error('siblings_last_job_company') is-invalid @enderror" name="siblings_last_job_company[]" id="siblings_last_job_company" placeholder="Perusahaan (Optional)" value="{{ $item->siblings_last_job_company }}">
                            @error('siblings_last_job_company')
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
            <button type="button" class="btn btn-info mr-2" id="addSiblingsForm">+</button>
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
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Kakak/Adik Kandung</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('karyawan.saudara.destroy') }}" method="post">
                        @csrf
                        @method("DELETE")

                        <input type="hidden" name="siblings">
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
        let baris = {{ count($karyawanSibling) }};

        $('#addSiblingsForm').on('click', function(e) {
            baris++;

            var html = `<div id="formSiblings${baris}">`;
            html += `<div class="d-flex align-items-center form-group">
                        <p class="form-label-section m-0">Kakak/Adik Kandung</p>
                        <button type="button" class="btn btn-danger ml-2 remove-siblings-form" data-el-target="#formSiblings${baris}">-</button>
                    </div>`;
            html += `<input type="hidden" name="siblings_id[]">`;
            html += `<div class="form-group">
                        <input type="text" class="form-control @error('siblings_name') is-invalid @enderror" name="siblings_name[]" id="siblings_name${baris}" placeholder="Nama Kakak/Adik Kandung" required>
                        @error('siblings_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>`;
            html += `<div class="form-group">
                        <select name="siblings_gender[]" id="siblings_gender" class="form-control @error('siblings_gender') is-invalid @enderror" required>
                            <option value="">--Jenis Kelamin Kakak/Adik Kandung--</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('siblings_gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>`;
            html += `<div class="form-group">
                        <input type="number" class="form-control @error('siblings_age') is-invalid @enderror" name="siblings_age[]" id="siblings_age${baris}" min="0" max="999" placeholder="Usia Kakak/Adik Kandung" required>
                        @error('siblings_age')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>`;
            html += `<div class="form-group">
                        <select name="siblings_last_education[]" id="siblings_last_education${baris}" class="form-control @error('siblings_last_education') is-invalid @enderror"  required>
                            <option value="">--Pendidikan Terakhir Kakak/Adik Kandung--</option>
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
                        @error('siblings_last_education')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>`;
            html += `<div class="form-group">
                        <p class="form-label-section">Pekerjaan Terakhir Kakak/Adik Kandung</p>
                    </div>`;
            html += `<div class="form-group">
                        <input type="text" class="form-control @error('siblings_last_job_position') is-invalid @enderror" name="siblings_last_job_position[]" id="siblings_last_job_position${baris}" placeholder="Jabatan (Optional)">
                        @error('siblings_last_job_position')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>`;
            html += `<div class="form-group">
                        <input type="text" class="form-control @error('siblings_last_job_company') is-invalid @enderror" name="siblings_last_job_company[]" id="siblings_last_job_company${baris}" placeholder="Perusahaan (Optional)">
                        @error('siblings_last_job_company')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>`;
            html += `</div>`;

            $('.siblings-form-wrapper').append(html);
        });


        $(document).on('click', '.remove-siblings-form', function(e) {
            const $this = $(this);
            const target = $this.attr('data-el-target');

            $(target).remove();
        });

        $('.btn-delete').on('click', function(e) {
            const $this = $(this);
            const sibling = $this.attr('data-sibling');

            $('#deleteModal input[name="siblings"]').val(sibling);
        });
    </script>
@endsection
