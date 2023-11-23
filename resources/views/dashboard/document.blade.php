@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Upload Document</p>
    </div>
</header>

<section id="form-bio">
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

    <div class="form-document-wrapper">
        <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formPasPhoto" class="form-document-inner">
                @csrf

            <div class="d-flex justify-content-beetwen align-items-center">
                <div class="input-group">
                    <div class="custom-file mr-3">
                        <input type="file" class="custom-file-input @error('pas_photo') is-invalid @enderror" name="pas_photo" id="pasPhoto" aria-describedby="inputGroupPasPhoto">
                        <label class="custom-file-label {{ (count($karyawanDocument) > 0) ? (!empty($karyawanDocument[0]->pas_photo) ? 'bg-success' : '')  : '' }}" for="pasPhoto">
                            Pas Photo
                        </label>
                    </div> 
                </div>
                <div class="btn-document-form">
                    <button class="btn btn-secondary" type="submit" id="inputGroupPasPhoto">Upload</button>
                    <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->pas_photo) : '#' }}" class="btn btn-primary">Cek FIle</a>
                </div>
            </div>
            @error('pas_photo')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <p><small>Format File : JPG, PNG <br>MAX : 2 MB</small></p>
        </form>

        <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formKTP" class="form-document-inner">
            @csrf

            <div class="d-flex justify-content-beetwen align-items-center">
                <div class="input-group">
                    <div class="custom-file mr-3">
                        <input type="file" class="custom-file-input @error('ktp') is-invalid @enderror" name="ktp" id="ktp" aria-describedby="inputGroupKTP">
                        <label class="custom-file-label {{ (count($karyawanDocument) > 0) ? (!empty($karyawanDocument[0]->ktp) ? 'bg-success' : '')  : '' }}" for="ktp">
                            KTP
                        </label>
                    </div> 
                </div>
                <div class="btn-document-form">
                    <button class="btn btn-secondary" type="submit" id="inputGroupKTP">Upload</button>
                    <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->ktp) : '#' }}" class="btn btn-primary">Cek FIle</a>
                </div>
            </div>
            @error('ktp')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
        </form>

        <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formKK" class="form-document-inner">
            @csrf

            <div class="d-flex justify-content-beetwen align-items-center">
                <div class="input-group">
                    <div class="custom-file mr-3">
                        <input type="file" class="custom-file-input @error('kk') is-invalid @enderror" name="kk" id="kk" aria-describedby="inputGroupKK">
                        <label class="custom-file-label {{ (count($karyawanDocument) > 0) ? (!empty($karyawanDocument[0]->kk) ? 'bg-success' : '')  : '' }}" for="kk">
                            KK
                        </label>
                    </div> 
                </div>
                <div class="btn-document-form">
                    <button class="btn btn-secondary" type="submit" id="inputGroupKK">Upload</button>
                    <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->kk) : '#' }}" class="btn btn-primary">Cek FIle</a>
                </div>
            </div>
            @error('kk')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
        </form>

        <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formIjazah" class="form-document-inner">
            @csrf

            <div class="d-flex justify-content-beetwen align-items-center">
                <div class="input-group">
                    <div class="custom-file mr-3">
                        <input type="file" class="custom-file-input @error('ijazah') is-invalid @enderror" name="ijazah" id="ijazah" aria-describedby="inputGroupIjazah">
                        <label class="custom-file-label {{ (count($karyawanDocument) > 0) ? (!empty($karyawanDocument[0]->ijazah) ? 'bg-success' : '')  : '' }}" for="ijazah">
                            Ijazah
                        </label>
                    </div> 
                </div>
                <div class="btn-document-form">
                    <button class="btn btn-secondary" type="submit" id="inputGroupIjazah">Upload</button>
                    <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->ijazah) : '#' }}" class="btn btn-primary">Cek FIle</a>
                </div>
            </div>
            @error('ijazah')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
        </form>

        <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formBukuRekening" class="form-document-inner">
            @csrf

            <div class="d-flex justify-content-beetwen align-items-center">
                <div class="input-group">
                    <div class="custom-file mr-3">
                        <input type="file" class="custom-file-input @error('buku_rekening') is-invalid @enderror" name="buku_rekening" id="buku_rekening" aria-describedby="inputGroupBukuRekening">
                        <label class="custom-file-label {{ (count($karyawanDocument) > 0) ? (!empty($karyawanDocument[0]->buku_rekening) ? 'bg-success' : '')  : '' }}" for="buku_rekening">
                            Buku Rekening
                        </label>
                    </div>
                </div>
                <div class="btn-document-form"> 
                    <button class="btn btn-secondary" type="submit" id="inputGroupBukuRekening">Upload</button>
                    <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->buku_rekening) : '#' }}" class="btn btn-primary">Cek FIle</a>
                </div>
            </div>
            @error('buku_rekening')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
        </form>

        <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formNPWP" class="form-document-inner">
            @csrf

            <div class="d-flex justify-content-beetwen align-items-center">
                <div class="input-group">
                    <div class="custom-file mr-3">
                        <input type="file" class="custom-file-input @error('npwp') is-invalid @enderror" name="npwp" id="npwp" aria-describedby="inputGroupNPWP">
                        <label class="custom-file-label {{ (count($karyawanDocument) > 0) ? (!empty($karyawanDocument[0]->npwp) ? 'bg-success' : '')  : '' }}" for="npwp">
                            NPWP (Optional)
                        </label>
                    </div>
                </div>
                <div class="btn-document-form"> 
                    <button class="btn btn-secondary" type="submit" id="inputGroupNPWP">Upload</button>
                    <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->npwp) : '#' }}" class="btn btn-primary">Cek FIle</a>
                </div>
            </div>
            @error('npwp')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
        </form>

        <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formBPJSKtn" class="form-document-inner">
            @csrf

            <div class="d-flex justify-content-beetwen align-items-center">
                <div class="input-group">
                    <div class="custom-file mr-3">
                        <input type="file" class="custom-file-input @error('bpjs_ktn') is-invalid @enderror" name="bpjs_ktn" id="bpjs_ktn" aria-describedby="inputGroupBPJSKtn">
                        <label class="custom-file-label {{ (count($karyawanDocument) > 0) ? (!empty($karyawanDocument[0]->bpjs_ktn) ? 'bg-success' : '')  : '' }}" for="bpjs_ktn">
                            BPJS Ketenagakerjaan (Optional)
                        </label>
                    </div>
                </div>
                <div class="btn-document-form"> 
                    <button class="btn btn-secondary" type="submit" id="inputGroupBPJSKtn">Upload</button>
                    <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->bpjs_ktn) : '#' }}" class="btn btn-primary">Cek FIle</a>
                </div>
            </div>
            @error('bpjs_ktn')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
        </form>

        <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formBPJSKes" class="form-document-inner">
            @csrf

            <div class="d-flex justify-content-beetwen align-items-center">
                <div class="input-group">
                    <div class="custom-file mr-3">
                        <input type="file" class="custom-file-input @error('bpjs_kes') is-invalid @enderror" name="bpjs_kes" id="bpjs_kes" aria-describedby="inputGroupBPJSKes">
                        <label class="custom-file-label {{ (count($karyawanDocument) > 0) ? (!empty($karyawanDocument[0]->bpjs_kes) ? 'bg-success' : '')  : '' }}" for="bpjs_kes">
                            BPJS Kesehatan (Optional)
                        </label>
                    </div>
                </div>
                <div class="btn-document-form"> 
                    <button class="btn btn-secondary" type="submit" id="inputGroupBPJSKes">Upload</button>
                    <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->bpjs_kes) : '#' }}" class="btn btn-primary">Cek FIle</a>
                </div>
            </div>
            @error('bpjs_kes')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
        </form>
    </div>

    <button type="button" class="btn primary btn-block mt-2 mb-5" id="btnNext">Lanjut</button>
</section>

@endsection

@section('scriptJS')
    <script>
        const nextStep = function(e) {
            const countData = {{ count($karyawanDocument) }};

            if(countData > 0) {
                const pasPhoto = "{{ (count($karyawanDocument) > 0) ? $karyawanDocument[0]->pas_photo : '' }}";
                const ktp = "{{ (count($karyawanDocument) > 0) ? $karyawanDocument[0]->ktp : '' }}";
                const kk = "{{ (count($karyawanDocument) > 0) ? $karyawanDocument[0]->kk : '' }}";
                const ijazah = "{{ (count($karyawanDocument) > 0) ? $karyawanDocument[0]->ijazah : '' }}";
                const bukuRekening = "{{ (count($karyawanDocument) > 0) ? $karyawanDocument[0]->buku_rekening : '' }}";
                // const npwp = "{{ (count($karyawanDocument) > 0) ? $karyawanDocument[0]->npwp : '' }}";
                // const bpjs_ktn = "{{ (count($karyawanDocument) > 0) ? $karyawanDocument[0]->bpjs_ktn : '' }}";

                if(pasPhoto != '' && ktp != '' && kk != '' && ijazah != '' && bukuRekening != '') {
                    const url = "{{ route('karyawan.signature', $karyawan->email) }}";
                    location.href = url;
                } else {
                    alert('Lengkapi document terlebih dahulu...!!!');
                }

            } else {
                alert('Harap mengupload document...!!!');
            }
        }

        // button next on click
        $('#btnNext').on('click', nextStep);

        // set text file name
        $('input[type="file"]').on('change', function() {
            const $this = $(this);
            const value = $this.val();

            const fileName = value.split('\\');

            $this.siblings().text(fileName[2]);
        });
    </script>
@endsection