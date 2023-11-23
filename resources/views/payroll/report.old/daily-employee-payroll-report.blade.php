<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Karyawan Harian</title>

    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
    <main id="employee-report__page">
        <div class="page-header d-print-none mb-3">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="">
                        <img src="{{ asset('assets/img/header-surat.png') }}" alt="" width="100%">
                    </div>
                    <h3 class="center line">Surat Pengajuan Gaji</h3>
                    <p class="center">Rev. 011/SPG/MAHA.HR.ER/X/2023</p>
                    <div class="ml">
                        @php
                            $totalEmployees = count($result);
                        @endphp
                        <div class="f1">
                            <table>
                                <tr>
                                    <td>Periode</td>
                                    <td>: {{ \Carbon\Carbon::parse($dari)->isoFormat('D MMMM Y') }} -
                                        {{ \Carbon\Carbon::parse($sampai)->isoFormat('D MMMM Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Karyawan</td>
                                    <td>: {{ $totalEmployees }} </td>
                                </tr>
                                <tr>
                                    <td>Jenis Kontrak</td>
                                    <td>: Karyawan Harian</td>
                                </tr>
                            </table>
                            <div class="print-button">
                                <button onclick="printDocument()">Cetak Payroll</button>
                            </div>
                        </div>
                    </div>
                    @foreach ($result as $nik => $result)
                        <div class="card ">
                            <div class="card-body">
                                <div class="row">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-center">
                                                <th colspan="2">Karyawan</th>
                                                <th colspan="2">Data Kehadiran</th>
                                                <th colspan="2">Pendapatan</th>
                                                <th colspan="2">Potongan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Nama</td>
                                                <td class="fw-bold">: {{ $result['karyawanPribadi']->nama_lengkap }}</td>
                                                </td>
                                                <td>Hari Masuk</td>
                                                <td>: {{ $result['daftarhadir'] }}</td>
                                                <td>Gaji Pokok</td>
                                                <td>: {{ 'Rp ' . number_format($result['gaji75'], 0, ',', '.') }}</td>
                                                <td> Total Pinjaman</td>
                                                <td>: 0</td>
                                            </tr>
                                            <tr>
                                                <td>Awal Masuk Kerja
                                                </td>
                                                <td>:
                                                    {{ \Carbon\Carbon::parse($result['karyawanBiodata']->start_work)->format('d F Y') }}
                                                </td>
                                                <td>Tidak Hadir</td>
                                                <td>: {{ $result['daftartidakhadir'] }}</td>
                                                <td>Gaji Operasional</td>
                                                <td>: {{ 'Rp ' . number_format($result['gaji25'], 0, ',', '.') }}</td>
                                                <td> Cicilan</td>
                                                <td>: 0</td>
                                            </tr>
                                            <tr>
                                                <td>Bulan </td>
                                                <td>: 0</td>
                                                <td>Sakit</td>
                                                <td>: 0</td>
                                                <td>Lembur</td>
                                                <td>: 0
                                                </td>
                                                <td>Tidak Hadir</td>
                                                <td>: {{ 'Rp ' . number_format($result['potonganabsensi'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tahun</td>
                                                <td> : 0</td>
                                                <td>Cuti</td>
                                                <td>: 0</td>
                                                <td>Bonus</td>
                                                <td>: 0

                                                </td>
                                                <td>Keterlambatan</td>
                                                <td> : {{ 'Rp ' . number_format($result['potonganterlambat'], 0, ',', '.') }}</td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Izin</td>
                                                <td>: 0</td>
                                                <td>UMLK</td>
                                                <td>: 0
                                                </td>
                                                <td>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Terlambat </td>
                                                <td>: 0</td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Tidak Absen Pulang</td>
                                                <td>: 0</td>
                                                <td></td>
                                                <td>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Jam Lembur Hari Biasa</td>
                                                <td>: 0</td>
                                                <td>Total Pendapatan</td>
                                                <td>:0
                                                </td>
                                                <td> Total Potongan</td>
                                                <td>:0
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Jam Lembur Hari Minggu</td>
                                                <td>: 0</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-12">
                                        <h3 class="text-center">Sisa Cashbon : 0</h3>
                                    </div>
                                    <div class="col-12 mb-5">
                                        <h3 class="text-center">Total Gaji
                                            :0
                                        </h3>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                    <div class="signatures">
                        <table class="signature-table">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Medan, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} </td>
                            </tr>
                            <tr>
                                <td>Diajukan Oleh</td>
                                <td>Diperiksa Oleh</td>
                                <td>Disetujui Oleh</td>
                                <td>Diketahui Oleh</td>
                            </tr>
                            <tr>
                                <td>Admin Payroll</td>
                                <td>Supervisi HRD</td>
                                <td>Direktur</td>
                                <td>Komisaris</td>
                            </tr>
                            <tr class="space-row">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>{{ $adminpayroll->nama_lengkap }}</h4>
                                </td>
                                <td>
                                    <h4>{{ $hrdsvp->nama_lengkap }}</h4>
                                </td>
                                <td>
                                    <h4>{{ $direktur->nama_lengkap }}</h4>
                                </td>
                                <td>
                                    <h4>{{ $komisaris->nama_lengkap }}</h4>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<script>
    function printDocument() {
        window.print();
    }
</script>

</html>
