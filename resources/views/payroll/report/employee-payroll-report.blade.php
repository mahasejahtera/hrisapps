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
                                            <td>Total Hadir</td>
                                            <td>: {{ $jmlMasuk }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Mangkir </td>
                                            <td>: 0</td>
                                        </tr>
                                        <tr>
                                            <td>Sakit</td>
                                            <td>: 0</td>
                                        </tr>
                                        <tr>
                                            <td>Izin</td>
                                            <td>: 0</td>
                                        </tr>
                                        <tr>
                                            <td>Cuti</td>
                                            <td>: 0</td>
                                        </tr>
                                        <tr>
                                            <td>Terlambat</td>
                                            <td>: {{ $dataTerlambat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tidak Absen Pulang</td>
                                            <td>: {{ $jmlTidakAbsenPulang }}</td>
                                        </tr>
                                        <tr>
                                            <td>Lembur Hari Biasa</td>
                                            <td>: {{ $jamLemburHariBiasa }} Jam</td>
                                        </tr>
                                        <tr>
                                            <td>Lembur Hari Libur</td>
                                            <td>: {{ $jamLemburHariLibur }} Jam</td>
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
                                            <td>: {{ 'Rp ' . number_format($gajiPokok, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Operasional</td>
                                            <td>: {{ 'Rp ' . number_format($gajiOperasional, 0, ',', '.') }}</td>
                                        </tr>
                                        {{-- @if (
                                            $karyawanGaji->contract_status == 'tetap' ||
                                                $karyawanGaji->contract_status == 'pkwt' ||
                                                $karyawanGaji->contract_status == 'percobaan') --}}
                                            <tr>
                                                <td>UMLK</td>
                                                <td>: {{ 'Rp ' . number_format($totalUMLK, 0, ',', '.') }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <td>Bonus Tahunan</td>
                                                <td>: @if (true)
                                                        {{ 'Rp ' . number_format(0, 0, ',', '.') }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                            </tr> --}}
                                            {{-- <tr>
                                                <td>THR</td>
                                                <td>:
                                                    @if (true)
                                                        {{ 'Rp ' . number_format(0, 0, ',', '.') }}
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                            </tr> --}}
                                            {{-- <tr>
                                                <td>BPJS</td>
                                                <td>: 0</td>
                                            </tr> --}}
                                            <tr>
                                                <td>Lembur</td>
                                                <td>: {{ 'Rp ' . number_format($totalGajiLembur, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        {{-- @endif --}}
                                        {{-- <tr>
                                            <td>Bonus</td>
                                            <td>:0</td>
                                        </tr> --}}
                                        @foreach ($karyawanBonus as $item)
                                            <tr>
                                                <td>{{ $item->jenis_bonus->nama_bonus }}</td>
                                                <td>: Rp {{ number_format($item->jumlah_bonus,0,',','.') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>Total Pendapatan</td>
                                            <td>: {{ 'Rp ' . number_format($totalPendapatan, 0, ',', '.') }}</td>
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
                                            <td> Total Cashbon</td>
                                            <td>: Rp {{ number_format($totalPinjaman,0,',','.') }}</td>
                                        </tr>
                                        <tr>
                                            <td> Cashbon</td>
                                            <td>: Rp {{ number_format($nominalCicilan,0,',','.') }}</td>
                                        </tr>
                                        <tr>
                                            <td> Mangkir</td>
                                            <td>: {{ 'Rp ' . number_format(0, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td> Keterlambatan</td>
                                            <td>:
                                                    {{ 'Rp ' . number_format($jumlahPotonganTerlambat, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        {{-- @if ($karyawanGaji->contract_status == 'tetap' || $karyawanGaji->contract_status == 'pkwt')
                                            <tr>
                                                <td> BPJS Kesehatan</td>
                                                <td>: 0</td>
                                            </tr>
                                            <tr>
                                                <td> BPJS Tenaga Kerja</td>
                                                <td>: 0</td>
                                            </tr>
                                        @endif --}}
                                        @foreach ($karyawanPotongan as $item)
                                            <tr>
                                                <td>{{ $item->jenis_potongan->nama_potongan }}</td>
                                                <td>: Rp {{ number_format($item->jml_potongan,0,',','.') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>Total Potongan</td>
                                            <td>: {{ 'Rp ' . number_format($totalPotongan, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                    
                                    <table class="border-top mt-2">
                                        <tr>
                                            <td>Sisa Cashbon : Rp {{ number_format($sisaPinjaman,0,',','.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-12">-->
                        <!--    <div class="card">-->
                        <!--        <div class="card-body">-->
                        <!--            <p class="text-center">Sisa Cashbon : Rp {{ number_format($sisaPinjaman,0,',','.') }}</p>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-center">Total Gaji
                                        :{{ 'Rp ' . number_format($totalGaji, 0, ',', '.') }}
                                    </p>
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
