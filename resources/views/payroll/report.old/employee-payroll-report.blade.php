@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Laporan Payroll
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('payroll.employee') }}" id="frmLaporan" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="bulan" id="bulan" class="form-select">
                                                <option value="">Bulan</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ date('m') == $i ? 'selected' : '' }}>{{ $namabulan[$i] }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="tahun" id="tahun" class="form-select">
                                                <option value="">Tahun</option>
                                                @php
                                                    $tahunmulai = 2022;
                                                    $tahunskrg = date('Y');
                                                @endphp
                                                @for ($tahun = $tahunmulai; $tahun <= $tahunskrg; $tahun++)
                                                    <option value="{{ $tahun }}"
                                                        {{ date('Y') == $tahun ? 'selected' : '' }}>{{ $tahun }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="nik" id="nik" class="form-select">
                                                <option value="">Pilih Karyawan</option>
                                                @foreach ($karyawan as $d)
                                                    <option value="{{ $d->nik }}">{{ $d->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-printer" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2">
                                                    </path>
                                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                                    <path
                                                        d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z">
                                                    </path>
                                                </svg>
                                                Cari
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-deck row-cards">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body mx-auto">
                                    <table>
                                        <tr>
                                            <td>Nama Karyawan</td>
                                            <td> : {{ $karyawanPribadi->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td> : {{ $karyawanPribadi->jabatan_kerja->nama_jabatan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Bulan</td>
                                            <td> : {{ bulanIndo($bulan) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tahun</td>
                                            <td> : {{ $tahun }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td> : Karyawan {{ $karyawanGaji->contract_status }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <p>Data Kehadiran</p>
                                    <table>
                                        <tr>
                                            <td>Hari Masuk</td>
                                            <td>: {{ $data }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hari Absen</td>
                                            <td>: {{ $dataabsen }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sakit</td>
                                            <td>: {{ $jumlahsakit }}</td>
                                        </tr>
                                        <tr>
                                            <td>Izin</td>
                                            <td>: {{ $jumlahizin }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cuti</td>
                                            <td>: {{ $jumlahcuti }}</td>
                                        </tr>
                                        <tr>
                                            <td>Terlambat</td>
                                            <td>: {{ $dataterlambat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tidak Absen Pulang</td>
                                            <td>: {{ $totaltidakabsenpulang }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jam Lembur Hari Biasa</td>
                                            <td>: {{ $selisihjambiasa }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jam Lembur Hari Minggu</td>
                                            <td>: {{ $selisihjamminggu }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <p>Pendapatan</p>
                                    <table>
                                        <tr>
                                            <td>Gaji Pokok</td>
                                            <td>: {{ 'Rp ' . number_format($gaji75, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Operasional</td>
                                            <td>: {{ 'Rp ' . number_format($gaji25, 0, ',', '.') }}</td>
                                        </tr>
                                        @if (
                                            $karyawanGaji->contract_status == 'tetap' ||
                                                $karyawanGaji->contract_status == 'pkwt' ||
                                                $karyawanGaji->contract_status == 'percobaan')
                                            <tr>
                                                <td>UMLK</td>
                                                <td>: {{ 'Rp ' . number_format($totalumlk, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Bonus Tahunan</td>
                                                <td>: @if ($tahunan)
                                                        {{ 'Rp ' . number_format($tahunan->jumlah, 0, ',', '.') }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>THR</td>
                                                <td>:
                                                    @if ($thr)
                                                        {{ 'Rp ' . number_format($thr->jumlah, 0, ',', '.') }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>BPJS</td>
                                                <td>: 0</td>
                                            </tr>
                                            <tr>
                                                <td>Lembur</td>
                                                <td>: {{ 'Rp ' . number_format($totalgajilembur, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Bonus</td>
                                            <td>:0</td>
                                        </tr>
                                        <tr>
                                            <td>Total Pendapatan</td>
                                            <td>: {{ 'Rp ' . number_format($totalseluruhgaji, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body" style="height: 10rem">
                                    <p>Potongan</p>
                                    <table>
                                        <tr>
                                            <td> Total Pinjaman</td>
                                            <td>: 0</td>
                                        </tr>
                                        <tr>
                                            <td> Cicilan</td>
                                            <td>:0
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> Absensi</td>
                                            <td>: {{ 'Rp ' . number_format($potonganabsensi, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td> Keterlambatan</td>
                                            <td>: @if ($potonganterlambat)
                                                    {{ 'Rp ' . number_format($potonganterlambat, 0, ',', '.') }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($karyawanGaji->contract_status == 'tetap' || $karyawanGaji->contract_status == 'pkwt')
                                            <tr>
                                                <td> BPJS Kesehatan</td>
                                                <td>: 0</td>
                                            </tr>
                                            <tr>
                                                <td> BPJS Tenaga Kerja</td>
                                                <td>: 0</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Total Potongan</td>
                                            <td>: {{ 'Rp ' . number_format($totalpotongan, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-center">Sisa Cashbon : 0</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-center">Total Gaji
                                        :{{ 'Rp ' . number_format($totalseluruhgaji - $totalpotongan, 0, ',', '.') }}</p>
                                </div>
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
        $(function() {
            $("#frmLaporan").submit(function(e) {
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                var nik = $("#nik").val();
                if (bulan == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Bulan Harus Diplih !',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#bulan").focus();
                    });
                    return false;
                } else if (tahun == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Tahun Harus Dipilih !',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#tahun").focus();
                    });
                    return false;
                } else if (nik == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Karyawan Harus Diisi !',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#nik").focus();
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
