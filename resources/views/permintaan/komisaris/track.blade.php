@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Tracking Rencana Kerja
            </h2>
        </div>
    </header>
    @if ($data->karyawanPenerima->role_id == 2)
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
                                <div class="tl-dot b-warning"></div>
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
                            <div class="tl-item @if (
                                $data->manajer_approval == 1 &&
                                    $data->pm_approval == 1 &&
                                    $data->hrd_approval == 1 &&
                                    $data->direktur_approval == 1 &&
                                    $data->komisaris_approval == 1) actived @endif">
                                <div class="tl-dot b-warning"></div>
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
    @endif
@endsection
