@extends('template.main')
@section('content')

    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Tracking Rencana Kerja
            </h2>
        </div>
    </header>
    @if (
        ($karyawan->kode_dept == 'TK' && $karyawan->role_id == 2) ||
            ($karyawan->kode_dept == 'PR' && $karyawan->role_id == 2))
        <div class="page-content page-container mt-7" id="page-content">
            <div class="padding">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="timeline p-4 block mb-4">
                            <p><strong>{{ $data->perihal }}</strong></p>
                            <div class="tl-item @if ($data->manajer_approval == 1 && $data->pm_approval == 0) active @endif ">
                                <div class="tl-dot @if ($data->pm_approval == 1) b-success @endif"></div>
                                <div class="tl-content">
                                    <div class="">Diperiksa Oleh PM</div>
                                </div>
                            </div>
                            <div class="tl-item @if ($data->manajer_approval == 1 && $data->pm_approval == 1 && $data->hrd_approval == 0) active @endif">
                                <div class="tl-dot @if ($data->hrd_approval == 1) b-success @endif"></div>
                                <div class="tl-content">
                                    <div class="">Diperiksa oleh HRD
                                    </div>
                                </div>
                            </div>
                            <div class="tl-item @if (
                                $data->manajer_approval == 1 &&
                                    $data->pm_approval == 1 &&
                                    $data->hrd_approval == 1 &&
                                    $data->direktur_approval == 0) active @endif">
                                <div class="tl-dot @if ($data->direktur_approval == 1) b-success @endif"></div>
                                <div class="tl-content">
                                    <div class="">Diperiksa oleh Direktur</div>
                                </div>
                            </div>
                            <div class="tl-item  @if (
                                $data->manajer_approval == 1 &&
                                    $data->pm_approval == 1 &&
                                    $data->hrd_approval == 1 &&
                                    $data->direktur_approval == 1 &&
                                    $data->komisaris_approval == 0) active @endif ">
                                <div class="tl-dot @if ($data->komisaris_approval == 1) b-success @endif"></div>
                                <div class="tl-content">
                                    <div class="">Diperiksa oleh Komisaris</div>
                                </div>
                            </div>
                            <div class="tl-item @if (
                                $data->manajer_approval == 1 &&
                                    $data->pm_approval == 1 &&
                                    $data->hrd_approval == 1 &&
                                    $data->direktur_approval == 1 &&
                                    $data->komisaris_approval == 1) actived @endif">
                                <div class="tl-dot b-warning"></div>
                                <div class="tl-content b-success">
                                    <div class="text-green"><strong>Disetujui</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (
        ($karyawan->kode_dept == 'SC' && $karyawan->role_id == 2) ||
            ($karyawan->kode_dept == 'KU' && $karyawan->role_id == 2) ||
            ($karyawan->kode_dept == 'PN' && $karyawan->role_id == 2) ||
            ($karyawan->kode_dept == 'IT' && $karyawan->role_id == 2))
        <div class="page-content page-container mt-7" id="page-content">
            <div class="padding">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="timeline p-4 block mb-4">
                            <p><strong>{{ $data->perihal }}</strong></p>
                            <div class="tl-item @if ($data->manajer_approval == 1 && $data->pm_approval == 1 && $data->hrd_approval == 0) active @endif">
                                <div class="tl-dot @if ($data->hrd_approval == 1) b-success @endif"></div>
                                <div class="tl-content">
                                    <div class="">Diperiksa oleh HRD
                                    </div>
                                </div>
                            </div>
                            <div class="tl-item @if (
                                $data->manajer_approval == 1 &&
                                    $data->pm_approval == 1 &&
                                    $data->hrd_approval == 1 &&
                                    $data->direktur_approval == 0) active @endif">
                                <div class="tl-dot @if ($data->direktur_approval == 1) b-success @endif"></div>
                                <div class="tl-content">
                                    <div class="">Diperiksa oleh Direktur</div>
                                </div>
                            </div>
                            <div class="tl-item  @if (
                                $data->manajer_approval == 1 &&
                                    $data->pm_approval == 1 &&
                                    $data->hrd_approval == 1 &&
                                    $data->direktur_approval == 1 &&
                                    $data->komisaris_approval == 0) active @endif ">
                                <div class="tl-dot @if ($data->komisaris_approval == 1) b-success @endif"></div>
                                <div class="tl-content">
                                    <div class="">Diperiksa oleh Komisaris</div>
                                </div>
                            </div>
                            <div class="tl-item @if (
                                $data->manajer_approval == 1 &&
                                    $data->pm_approval == 1 &&
                                    $data->hrd_approval == 1 &&
                                    $data->direktur_approval == 1 &&
                                    $data->komisaris_approval == 1) actived @endif">
                                <div class="tl-dot b-war"></div>
                                <div class="tl-content b-success">
                                    <div class="text-green"><strong>Disetujui</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
