@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Tracking Rencana Kerja
            </h2>
        </div>
    </header>
    @if ($data->karyawanPengirim->kode_dept == 'TK' || $data->karyawanPengirim->kode_dept == 'PR')
        @if ($data->karyawanPenerima->role_id == 2 && $data->karyawanPenerima->kode_dept != 'HR')
            <div class="page-content page-container mt-7" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="timeline p-4 block mb-4">
                                <p><strong>{{ $data->perihal }}</strong></p>
                                <div class="tl-item @if (
                                    $data->manajer_approval == 1 &&
                                        $data->pm_approval == 1 &&
                                        $data->hrd_approval == 1 &&
                                        $data->direktur_approval == 1 &&
                                        $data->komisaris_approval == 1) actived @endif">
                                    <div class="tl-dot b-warning"></div>
                                    <div class="tl-content b-success">
                                        <div class="text-green"><strong>Permintaan Telah Tersampaikan ke Manajer Departemen
                                                {{ $data->karyawanPenerima->nama }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($data->karyawanPenerima->role_id == 2 && $data->karyawanPenerima->kode_dept == 'HR')
            <div class="page-content page-container mt-7" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="timeline p-4 block mb-4">
                                <p><strong>{{ $data->perihal }}</strong></p>
                                <div class="tl-item @if ($data->manajer_approval == 1 && $data->pm_approval == 0) active @endif">
                                    <div class="tl-dot @if ($data->pm_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Projek Manajer</div>
                                    </div>
                                </div>
                                <div class="tl-item @if (
                                    $data->manajer_approval == 1 &&
                                        $data->pm_approval == 1 &&
                                        $data->hrd_approval == 1 &&
                                        $data->direktur_approval == 1 &&
                                        $data->komisaris_approval == 1) actived @endif">
                                    <div class="tl-dot"></div>
                                    <div class="tl-content b-success">
                                        <div class="text-green"><strong>Permintaan Telah Tersampaikan ke Manajer HRD
                                                {{ $data->karyawanPenerima->nama }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($data->karyawanPenerima->role_id == 3)
            <div class="page-content page-container mt-7" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="timeline p-4 block mb-4">
                                <p><strong>{{ $data->perihal }}</strong></p>
                                <div class="tl-item @if (
                                    $data->manajer_approval == 1 &&
                                        $data->pm_approval == 1 &&
                                        $data->hrd_approval == 1 &&
                                        $data->direktur_approval == 1 &&
                                        $data->komisaris_approval == 1) actived @endif">
                                    <div class="tl-dot"></div>
                                    <div class="tl-content b-success">
                                        <div class="text-green"><strong>Permintaan Telah Tersampaikan ke Projek Manajer
                                                {{ $data->karyawanPenerima->nama }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($data->karyawanPenerima->role_id == 4)
            <div class="page-content page-container mt-7" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="timeline p-4 block mb-4">
                                <p><strong>{{ $data->perihal }}</strong></p>
                                <div class="tl-item @if ($data->pm_approval == 0 && $data->manajer_approval == 1) active @endif">
                                    <div class="tl-dot @if ($data->pm_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Projek Manajer</div>
                                    </div>
                                </div>
                                <div class="tl-item @if ($data->hrd_approval == 0 && $data->pm_approval == 1) active @endif">
                                    <div class="tl-dot @if ($data->hrd_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Manajer HRD</div>
                                    </div>
                                </div>
                                <div class="tl-item @if (
                                    $data->manajer_approval == 1 &&
                                        $data->pm_approval == 1 &&
                                        $data->hrd_approval == 1 &&
                                        $data->direktur_approval == 1 &&
                                        $data->komisaris_approval == 1) actived @endif">
                                    <div class="tl-dot"></div>
                                    <div class="tl-content b-success">
                                        <div class="text-green"><strong>Permintaan Telah Tersampaikan ke Direktur
                                                {{ $data->karyawanPenerima->nama }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($data->karyawanPenerima->role_id == 5)
            <div class="page-content page-container mt-7" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="timeline p-4 block mb-4">
                                <p><strong>{{ $data->perihal }}</strong></p>
                                <div class="tl-item @if ($data->pm_approval == 0 && $data->manajer_approval == 1) active @endif">
                                    <div class="tl-dot @if ($data->pm_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Projek Manajer</div>
                                    </div>
                                </div>
                                <div class="tl-item @if ($data->hrd_approval == 0 && $data->pm_approval == 1) active @endif">
                                    <div class="tl-dot @if ($data->hrd_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Manajer HRD</div>
                                    </div>
                                </div>
                                <div class="tl-item @if ($data->direktur_approval == 0 && $data->hrd_approval == 1) active @endif">
                                    <div class="tl-dot @if ($data->direktur_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Direktur</div>
                                    </div>
                                </div>
                                <div class="tl-item @if (
                                    $data->manajer_approval == 1 &&
                                        $data->pm_approval == 1 &&
                                        $data->hrd_approval == 1 &&
                                        $data->direktur_approval == 1 &&
                                        $data->komisaris_approval == 1) actived @endif">
                                    <div class="tl-dot"></div>
                                    <div class="tl-content b-success">
                                        <div class="text-green"><strong>Permintaan Telah Tersampaikan ke Komisaris
                                                {{ $data->karyawanPenerima->nama }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    @if (
        $data->karyawanPengirim->role_id == 1 &&
            ($data->karyawanPengirim->kode_dept != 'TK' ||
                $data->karyawanPengirim->kode_dept != 'PR' ||
                $data->karyawanPengirim->kode_dept != 'HR'))
        @if ($data->karyawanPenerima->role_id == 1)
            <div class="page-content page-container mt-7" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="timeline p-4 block mb-4">
                                <p><strong>{{ $data->perihal }}</strong></p>
                                <div class="tl-item @if (
                                    $data->manajer_approval == 1 &&
                                        $data->pm_approval == 1 &&
                                        $data->hrd_approval == 1 &&
                                        $data->direktur_approval == 1 &&
                                        $data->komisaris_approval == 1) actived @endif">
                                    <div class="tl-dot b-warning"></div>
                                    <div class="tl-content b-success">
                                        <div class="text-green"><strong>Permintaan Telah Tersampaikan ke Karyawan
                                                {{ $data->karyawanPenerima->nama }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($data->karyawanPenerima->role_id == 2 && $data->karyawanPenerima->kode_dept == 'HR')
            <div class="page-content page-container mt-7" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="timeline p-4 block mb-4">
                                <p><strong>{{ $data->perihal }}</strong></p>
                                <div class="tl-item @if ($data->manajer_approval == 0) active @endif">
                                    <div class="tl-dot @if ($data->manajer_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Manajer Departemen</div>
                                    </div>
                                </div>
                                <div class="tl-item @if (
                                    $data->manajer_approval == 1 &&
                                        $data->pm_approval == 1 &&
                                        $data->hrd_approval == 1 &&
                                        $data->direktur_approval == 1 &&
                                        $data->komisaris_approval == 1) actived @endif">
                                    <div class="tl-dot"></div>
                                    <div class="tl-content b-success">
                                        <div class="text-green"><strong>Permintaan Telah Tersampaikan ke Manajer HRD
                                                {{ $data->karyawanPenerima->nama }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($data->karyawanPenerima->role_id == 2 && $data->karyawanPenerima->kode_dept != 'HR')
            <div class="page-content page-container mt-7" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="timeline p-4 block mb-4">
                                <p><strong>{{ $data->perihal }}</strong></p>
                                <div class="tl-item @if (
                                    $data->manajer_approval == 1 &&
                                        $data->pm_approval == 1 &&
                                        $data->hrd_approval == 1 &&
                                        $data->direktur_approval == 1 &&
                                        $data->komisaris_approval == 1) actived @endif">
                                    <div class="tl-dot"></div>
                                    <div class="tl-content b-success">
                                        <div class="text-green"><strong>Permintaan Telah Tersampaikan ke Manajer Departemen
                                                {{ $data->karyawanPenerima->nama }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($data->karyawanPenerima->role_id == 4)
            <div class="page-content page-container mt-7" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="timeline p-4 block mb-4">
                                <p><strong>{{ $data->perihal }}</strong></p>
                                <div class="tl-item @if ($data->manajer_approval == 0) active @endif">
                                    <div class="tl-dot @if ($data->manajer_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Manajer Departemen</div>
                                    </div>
                                </div>
                                <div class="tl-item @if ($data->hrd_approval == 0 && $data->manajer_approval == 1) active @endif">
                                    <div class="tl-dot @if ($data->hrd_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Manajer HRD</div>
                                    </div>
                                </div>
                                <div class="tl-item @if (
                                    $data->manajer_approval == 1 &&
                                        $data->pm_approval == 1 &&
                                        $data->hrd_approval == 1 &&
                                        $data->direktur_approval == 1 &&
                                        $data->komisaris_approval == 1) actived @endif">
                                    <div class="tl-dot"></div>
                                    <div class="tl-content b-success">
                                        <div class="text-green"><strong>Permintaan Telah Tersampaikan ke Direktur
                                                {{ $data->karyawanPenerima->nama }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($data->karyawanPenerima->role_id == 5)
            <div class="page-content page-container mt-7" id="page-content">
                <div class="padding">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="timeline p-4 block mb-4">
                                <p><strong>{{ $data->perihal }}</strong></p>
                                <div class="tl-item @if ($data->manajer_approval == 0) active @endif">
                                    <div class="tl-dot @if ($data->manajer_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Manajer Departemen</div>
                                    </div>
                                </div>
                                <div class="tl-item @if ($data->hrd_approval == 0 && $data->manajer_approval == 1) active @endif">
                                    <div class="tl-dot @if ($data->hrd_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Manajer HRD</div>
                                    </div>
                                </div>
                                <div class="tl-item @if ($data->direktur_approval == 0 && $data->hrd_approval == 1) active @endif">
                                    <div class="tl-dot @if ($data->direktur_approval == 1) b-success @endif"></div>
                                    <div class="tl-content">
                                        <div class="">Diperiksa oleh Direktur</div>
                                    </div>
                                </div>
                                <div class="tl-item @if (
                                    $data->manajer_approval == 1 &&
                                        $data->pm_approval == 1 &&
                                        $data->hrd_approval == 1 &&
                                        $data->direktur_approval == 1 &&
                                        $data->komisaris_approval == 1) actived @endif">
                                    <div class="tl-dot"></div>
                                    <div class="tl-content b-success">
                                        <div class="text-green"><strong>Permintaan Telah Tersampaikan ke Komisaris
                                                {{ $data->karyawanPenerima->nama }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
