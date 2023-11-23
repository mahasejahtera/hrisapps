@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Monitoring Presensi
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-icon mb-3">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <form id="search-form" method="POST" action="/getpresensi">
                                        @csrf
                                        <div class="form-group">
                                            <input type="date" id="tanggal" name="tanggal" class="form-control"
                                                placeholder="Tanggal Presensi" autocomplete="off"
                                                value="{{ session('selectedDate', date('Y-m-d')) }}">
                                        </div>
                                </div>
                                <div class="col-6 d-flex justify-content-between ">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    <div class="m-2">
                                    </div>
                                    <select id="pilihanPersetujuan" class="form-select ">
                                        <option value="default">Lihat Persetujuan</option>
                                        <option value="/presensi/persetujuan">Persetujuan Absensi</option>
                                        <option value="/presensi/penolakan">Absen Ditolak</option>
                                    </select>
                                </div>
                                </form>
                            </div>
                            <style>
                                #map {
                                    height: 500px;
                                }
                            </style>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped table-hover w-100 table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nik</th>
                                                <th>Nama</th>
                                                <th>Tanggal Presensi</th>
                                                <th>Status Presensi</th>
                                                <th>Jam Masuk</th>
                                                <th>Jam Keluar</th>
                                                <th>Foto Masuk</th>
                                                <th>Foto Pulang</th>
                                                <th>Lokasi Masuk</th>
                                                <th>Lokasi Keluar</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data->isEmpty())
                                                <tr>
                                                    <td colspan="12" class="text-center">Tidak ada data dalam tanggal ini
                                                        !!</td>
                                                </tr>
                                            @else
                                                @foreach ($data as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->nik }}</td>
                                                        <td>{{ $d->karyawan->nama_lengkap }}</td>
                                                        <td>{{ $d->tgl_presensi }}</td>
                                                        <td>
                                                            @if ($d->status == 1)
                                                                Absen dalam kantor/proyek
                                                            @elseif($d->status == 2 || $d->status == 3)
                                                                Absen diluar kantor/proyek
                                                            @endif
                                                        </td>
                                                        <td>{{ $d->jam_in }}</td>
                                                        <td>{{ $d->jam_out }}</td>
                                                        <td>
                                                            @if (!empty($d->jam_in))
                                                                @if ($d->absen_masuk_type == 2)
                                                                    Finger
                                                                @else
                                                                    <img src="{{ asset('storage/uploads/absensi/' . $d->foto_in) }}"
                                                                        alt="" width="100" height="100">
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (!empty($d->jam_out))
                                                                @if ($d->absen_pulang_type == 2)
                                                                    Finger
                                                                @else
                                                                    <img src="{{ asset('storage/uploads/absensi/' . $d->foto_out) }}"
                                                                        alt="" width="100" height="100">
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (!empty($d->jam_in))
                                                                @if ($d->absen_masuk_type == 2)
                                                                    -
                                                                @else
                                                                    <a href="/presensi/karyawan/map/detail/{{ $d->id }}"
                                                                        target="_blank">Lihat
                                                                        Disini</a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (!empty($d->jam_out))
                                                                @if ($d->absen_pulang_type == 2)
                                                                    -
                                                                @else
                                                                    <a href="/presensi/karyawan/map/detail/keluar/{{ $d->id }}"
                                                                        target="_blank">Lihat disini</a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{ $data->links('vendor.pagination.bootstrap-5') }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
@push('myscript')
    <script>
        function showMap(latitude, longitude) {
            var map = L.map('map').setView([latitude, longitude], 18);
            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);
            var marker = L.marker([latitude, longitude]).addTo(map);
        }
        var lokasi_kantor = "3.5674615,98.6571604";
        var lok = lokasi_kantor.split(",");
        var lat_kantor = parseFloat(lok[0]);
        var long_kantor = parseFloat(lok[1]);
        showMap(lat_kantor, long_kantor);
    </script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        var dropdown = document.getElementById("pilihanPersetujuan");
        dropdown.addEventListener("change", function() {
            var selectedOption = dropdown.value;
            if (selectedOption !== "default") {
                window.location.href = selectedOption;
            }
        });
    </script>
@endpush
