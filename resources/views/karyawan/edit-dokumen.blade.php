@extends('layouts.admin.tabler')
@section('content')
    <div class="page-body m-5">
        <div class="container-fluid">
            <section id="form-bio">
                <div class="biodata-confirm-wrapper">
                    <div class="row">
                        <div class="col-12">
                            @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                            @endif

                            @if (Session::get('warning'))
                            <div class="alert alert-warning">
                                {{ Session::get('warning')}}
                            </div>
                            @endif

                            @if (Session::get('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <h2 class="page-title">
                        Edit Karyawan
                    </h2>
                    <div class="card mb-2">
                        <div class="card-header">
                            <h3 class="card-title">Data Dokumen</h3>
                        </div>
                        <form action="{{ route('admin.karyawan.update.dokumen', $karyawan->email) }}" class="m-3" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $karyawanDocument[0]->id }}" required />
                            <input type="hidden" name="karyawan_id" value="{{ $karyawanDocument[0]->karyawan_id }}" required />
                            <div class="mb-3">
                                <label class="form-label">Pas Photo</label>

                                @if ($karyawanDocument[0]->pas_photo)
                                    <a href="{{ asset('storage/' . $karyawanDocument[0]->pas_photo) }}">Lihat Disini</a>
                                @endif

                                <input type="file" class="form-control" name="pas_photo" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">KTP</label>

                                @if ($karyawanDocument[0]->ktp)
                                    <a href="{{ asset('storage/' . $karyawanDocument[0]->ktp) }}">Lihat Disini</a>
                                @endif

                                <input type="file" class="form-control" name="ktp" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">KK</label>
                                @if ($karyawanDocument[0]->kk)
                                    <a href="{{ asset('storage/' . $karyawanDocument[0]->kk) }}">Lihat Disini</a>
                                @endif

                                <input type="file" class="form-control" name="kk" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ijazah</label>

                                @if ($karyawanDocument[0]->ijazah)
                                    <a href="{{ asset('storage/' . $karyawanDocument[0]->ijazah) }}">Lihat Disini</a>
                                @endif

                                <input type="file" class="form-control" name="ijazah" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Buku Rekening</label>

                                @if ($karyawanDocument[0]->buku_rekening)
                                    <a href="{{ asset('storage/' . $karyawanDocument[0]->buku_rekening) }}">Lihat Disini</a>
                                @endif

                                <input type="file" class="form-control" name="buku_rekening" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NPWP</label>

                                @if ($karyawanDocument[0]->npwp)
                                    <a href="{{ asset('storage/' . $karyawanDocument[0]->npwp) }}">Lihat Disini</a>
                                @endif

                                <input type="file" class="form-control" name="npwp" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">BPJS Ketenagakerjaan</label>

                                @if ($karyawanDocument[0]->bpjs_ktn)
                                    <a href="{{ asset('storage/' . $karyawanDocument[0]->bpjs_ktn) }}">Lihat Disini</a>
                                @endif

                                <input type="file" class="form-control" name="bpjs_ktn" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">BPJS Kesehatan</label>

                                @if ($karyawanDocument[0]->bpjs_kes)
                                    <a href="{{ asset('storage/' . $karyawanDocument[0]->bpjs_kes) }}">Lihat Disini</a>
                                @endif

                                <input type="file" class="form-control" name="bpjs_kes" />
                            </div>
                            <button type="submit"class="btn btn-primary w-100">Simpan</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
