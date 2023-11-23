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
                        <div class="card-header d-flex justify-content-between">
                            <h3>Karyawan Detail</h3>
                            <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                                data-bs-target="#bonus">Tambah Bonus</button>
                        </div>
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


    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h3>Karyawan Bulanan</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payroll.all-employee') }}" id="frmLaporan" method="POST"
                                target="_blank">
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
                                            <select name="status" id="status" class="form-select" required>
                                                <option value="">Pilih Status Karyawan</option>
                                                <option value="tetap">Tetap || PKWT || Percobaan</option>
                                                <option value="project">Projek</option>
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
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="">
                    <div class="card">
                        <div class="card-header">
                            <h3>Karyawan Mingguan</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payroll.daily-employee') }}" id="frmLaporan" method="POST"
                                target="_blank">
                                @csrf
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" name="dari" onfocus="(this.type='date')"
                                                onblur="(this.type = 'text')" placeholder="Dari Tanggal"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" name="sampai" onfocus="(this.type='date')"
                                                onblur="(this.type = 'text')" placeholder="Sampai Tanggal"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="status" id="status" class="form-select">
                                                <option value="">Pilih Status Karyawan</option>
                                                <option value="hariandl">Harian Dalam Kota</option>
                                                <option value="harianlk">Harian Luar Kota</option>
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

    <div class="modal" id="bonus" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Bonus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payroll.bonus.add') }}" method="post" id="bonuss"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <select class="form-select mb-3" id="karyawan" name="karyawan">
                                <option value="" selected>Pilih Karyawan</option>
                                @foreach ($karyawan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_lengkap }}</option>
                                @endforeach
                                <option value="tahunan">Bonus Tahunan</option>
                            </select>
                            <select class="form-select mb-3" id="bulan1" name="bulan">
                                <option value="" selected>Pilih Bulan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                            <select class="form-select mb-3" id="tahun1" name="tahun">
                                <option value="" selected>Pilih Tahun</option>
                                @php
                                    $currentYear = date('Y');
                                    $startYear = 2022;
                                @endphp
                                @for ($year = $currentYear; $year >= $startYear; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                            <select class="form-select" id="jenis" name="jenis">
                                <option value="" selected>Pilih Jenis Bonus</option>
                                <option value="thr">THR</option>
                                <option value="tahunan">Bonus Tahunan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" id="jumlah" class="form-control" name="jumlah" placeholder="" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal"
                            id="submitBonusForm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    @if (session('message'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "info",
                title: "{{ session('message') }}"
            });
        </script>
    @endif
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

        $(function() {
            $("#submitBonusForm").click(function() {
                var bulan = $("#bulan1").val();
                var tahun = $("#tahun1").val();
                var jenis = $("#jenis").val();
                var jumlah = $("#jumlah").val();
                var karyawan = $("#karyawan").val();
                if (karyawan === "") {
                    showError("Karyawan harus dipilih!");
                    return false;
                } else if (bulan === "") {
                    showError("Bulan harus dipilih!");
                    return false;
                } else if (tahun === "") {
                    showError("Tahun harus dipilih!");
                    return false;
                } else if (jenis === "") {
                    showError("Jenis Bonus harus diisi!");
                    return false;
                } else if (jumlah === "") {
                    showError("Jumlah harus diisi!");
                    return false;
                }
            });

            $("#submitPotongan").click(function() {
                var bulan = $("#bulan2").val();
                var tahun = $("#tahun2").val();
                var jumlah = $("#jumlah1").val();
                var karyawan = $("#karyawan1").val();
                if (karyawan === "") {
                    showError("Karyawan harus dipilih!");
                    return false;
                } else if (bulan === "") {
                    showError("Bulan harus dipilih!");
                    return false;
                } else if (tahun === "") {
                    showError("Tahun harus dipilih!");
                    return false;
                } else if (jumlah === "") {
                    showError("Jumlah harus diisi!");
                    return false;
                }
            });

            function showError(message) {
                Swal.fire({
                    title: 'Warning!',
                    text: message,
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                });
            }
        });
    </script>
@endpush
