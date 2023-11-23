@extends('layouts.admin.tabler')
@section('content')
    <div class="page-body m-5">
        <div class="container-fluid">
            @error('foto_karyawan')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <section id="form-bio">
                <div class="biodata-confirm-wrapper">
                    <h2 class="page-title">
                        Edit Karyawan
                    </h2>
                    <div class="card mb-2">
                        <div class="card-header">
                            <h3 class="card-title">Data Karyawan</h3>
                        </div>
                        <form action="{{ route('admin.karyawan.update', $karyawan->email) }}" class="m-3" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $karyawan->id }}" required />
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama"
                                    value="{{ $karyawan->nama_lengkap }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $karyawan->email }}"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <select class="form-select" name="jabatan" required>
                                    @php
                                        $selectedJobId = $karyawan->jabatan_kerja->id;
                                    @endphp
                                    @foreach ($jabatan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $selectedJobId ? 'selected' : '' }}>
                                            {{ $item->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Departemen</label>
                                <select class="form-select" name="departemen" required>
                                    @php
                                        $selectedDepartmentId = $karyawan->department->id;
                                    @endphp
                                    @foreach ($departemen as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $selectedDepartmentId ? 'selected' : '' }}>
                                            {{ $item->nama_dept }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cabang</label>
                                <select class="form-select" name="cabang" required>
                                    @php
                                        $selectedBranchId = $karyawan->cabang->id;
                                    @endphp
                                    @foreach ($cabang as $item)
                                        <option value="{{ $item->kode_cabang }}"
                                            {{ $item->id == $selectedBranchId ? 'selected' : '' }}>
                                            {{ $item->nama_cabang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto</label>
                                @if ($karyawan->foto)
                                    <a href="{{ asset('storage/' . $karyawan->foto) }}">Lihat Disini</a>
                                @endif
                                <input type="file" class="form-control" name="foto_karyawan" />
                            </div>

                            <button type="submit"class="btn btn-primary w-100">Simpan</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
