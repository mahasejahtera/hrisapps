@extends('layouts.main')

@section('content')

<header class="huader-main">
    <div class="header-main-title">
        <p>Upload Document</p>
    </div>

    <p class="step-label">Step 2</p>
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

    <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formPasPhoto">
        @csrf

        <div class="input-group">
            <div class="custom-file mr-3">
                <input type="file" class="custom-file-input @error('pas_photo') is-invalid @enderror" name="pas_photo" id="pasPhoto" aria-describedby="inputGroupPasPhoto">
                <label class="custom-file-label" for="pasPhoto">Pas Photo</label>
            </div> 
            <button class="btn btn-secondary mr-3" type="submit" id="inputGroupPasPhoto">Upload</button>
            <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->pas_photo) : '#' }}" class="btn btn-primary">Cek FIle</a>
        </div>
        @error('pas_photo')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <p><small>Format File : JPG, PNG <br>MAX : 2 MB</small></p>
    </form>

    <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formKTP">
        @csrf

        <div class="input-group">
            <div class="custom-file mr-3">
                <input type="file" class="custom-file-input @error('ktp') is-invalid @enderror" name="ktp" id="ktp" aria-describedby="inputGroupKTP">
                <label class="custom-file-label" for="ktp">Kartu Tanda Penduduk</label>
            </div> 
            <button class="btn btn-secondary mr-3" type="submit" id="inputGroupKTP">Upload</button>
            <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->ktp) : '#' }}" class="btn btn-primary">Cek FIle</a>
            
        </div>
        @error('ktp')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
    </form>

    <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formKK">
        @csrf

        <div class="input-group">
            <div class="custom-file mr-3">
                <input type="file" class="custom-file-input @error('kk') is-invalid @enderror" name="kk" id="kk" aria-describedby="inputGroupKK">
                <label class="custom-file-label" for="kk">Kartu Keluarga</label>
            </div> 
            <button class="btn btn-secondary mr-3" type="submit" id="inputGroupKK">Upload</button>
            <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->kk) : '#' }}" class="btn btn-primary">Cek FIle</a>
            
        </div>
        @error('kk')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
    </form>

    <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formIjazah">
        @csrf

        <div class="input-group">
            <div class="custom-file mr-3">
                <input type="file" class="custom-file-input @error('ijazah') is-invalid @enderror" name="ijazah" id="ijazah" aria-describedby="inputGroupIjazah">
                <label class="custom-file-label" for="ijazah">Ijazah</label>
            </div> 
            <button class="btn btn-secondary mr-3" type="submit" id="inputGroupIjazah">Upload</button>
            <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->ijazah) : '#' }}" class="btn btn-primary">Cek FIle</a>
            
        </div>
        @error('ijazah')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
    </form>

    <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formBukuRekening">
        @csrf

        <div class="input-group">
            <div class="custom-file mr-3">
                <input type="file" class="custom-file-input @error('buku_rekening') is-invalid @enderror" name="buku_rekening" id="buku_rekening" aria-describedby="inputGroupBukuRekening">
                <label class="custom-file-label" for="buku_rekening">Buku Rekening</label>
            </div> 
            <button class="btn btn-secondary mr-3" type="submit" id="inputGroupBukuRekening">Upload</button>
            <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->buku_rekening) : '#' }}" class="btn btn-primary">Cek FIle</a>
            
        </div>
        @error('buku_rekening')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
    </form>

    <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formNPWP">
        @csrf

        <div class="input-group">
            <div class="custom-file mr-3">
                <input type="file" class="custom-file-input @error('npwp') is-invalid @enderror" name="npwp" id="npwp" aria-describedby="inputGroupNPWP">
                <label class="custom-file-label" for="npwp">NPWP</label>
            </div> 
            <button class="btn btn-secondary mr-3" type="submit" id="inputGroupNPWP">Upload</button>
            <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->npwp) : '#' }}" class="btn btn-primary">Cek FIle</a>
            
        </div>
        @error('npwp')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
    </form>

    <form action="{{ route('karyawan.datadiri.document.store', $karyawan->email) }}" method="post" enctype="multipart/form-data" id="formBPJS">
        @csrf

        <div class="input-group">
            <div class="custom-file mr-3">
                <input type="file" class="custom-file-input @error('bpjs') is-invalid @enderror" name="bpjs" id="bpjs" aria-describedby="inputGroupBPJS">
                <label class="custom-file-label" for="bpjs">BPJS</label>
            </div> 
            <button class="btn btn-secondary mr-3" type="submit" id="inputGroupBPJS">Upload</button>
            <a target="_blank" href="{{ (count($karyawanDocument) > 0) ? asset('storage/'.$karyawanDocument[0]->bpjs) : '#' }}" class="btn btn-primary">Cek FIle</a>
            
        </div>
        @error('bpjs')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
        <p><small>Format File : PDF <br>MAX : 2 MB</small></p>
    </form>

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
                const npwp = "{{ (count($karyawanDocument) > 0) ? $karyawanDocument[0]->npwp : '' }}";
                const bpjs = "{{ (count($karyawanDocument) > 0) ? $karyawanDocument[0]->bpjs : '' }}";

                if(pasPhoto != '' && ktp != '' && kk != '' && ijazah != '' && bukuRekening != '' && npwp != '' && bpjs != '') {
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