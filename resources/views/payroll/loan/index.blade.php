@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Pinjaman
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="ro">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Pinjaman</h3>
                        <div class="d-flex align-items-center">
                            <form action="{{ route('payroll.loan.search') }}" method="post">
                                @csrf
                                <div class="d-flex align-items-center">
                                    <div class="form-group">
                                        <select name="nama_karyawan" style="width:180px;" class="form-control">
                                            <option value="">--Daftar Karyawan--</option>
                                            @foreach ($karyawan as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group ms-2 me-2">
                                        <button type="submit" class="btn btn-outline-primary" type="button">Cari</button>
                                    </div>
                                </div>
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#loan">Tambah
                                Pinjaman</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-vcenter">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Jumlah Pinjam</th>
                                        <th>Jumlah Cicilan</th>
                                        <th>Lama Cicilan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($loan->isEmpty())
                                        <tr>
                                            <td colspan="12" class="text-center">Tidak ada data loan tanggal ini
                                                !!</td>
                                        </tr>
                                    @else
                                        @foreach ($loan as $d)
                                            <tr>
                                                <td align="middle">{{ $loop->iteration }}</td>
                                                <td>{{ $d->karyawan->nama_lengkap }}</td>
                                                <td>{{ BulanIndo($d->bulan_pinjam) }} {{ $d->tahun_pinjam }}</td>
                                                <td>{{ 'Rp ' . number_format($d->jumlah_pinjam, 0, ',', '.') }}</td>
                                                <td>{{ 'Rp ' . number_format($d->jumlah_cicilan, 0, ',', '.') }}</td>
                                                <td align="middle">{{ $d->lama_cicilan }} Bulan</td>
                                                <td align="middle">
                                                    <a href="#" class="detail btn btn-cyan"
                                                        data-bs-toggle="modal" data-bs-target="#detail"
                                                        data-jumlahpinjam ="{{ $d->jumlah_pinjam }}"
                                                        data-jumlahcicilan ="{{ $d->jumlah_cicilan }}"
                                                        data-lamacicilan = "{{ $d->lama_cicilan }}"
                                                        data-nama = "{{ $d->karyawan->nama_lengkap }}"
                                                        data-bulan = "{{ $d->bulan_pinjam }}"
                                                        data-tahun = "{{ $d->tahun_pinjam }}"
                                                        data-lunas = "{{ $d->is_lunas }}"
                                                        data-totaldibayar = "{{ $d->total_dibayar }}"
                                                        data-bulandibayar = "{{ $d->bulan_dibayar }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.61,27.65-38.4A8,8,0,0,0,247.31,124.76ZM128,168a40,40,0,1,1,40-40A40,40,0,0,1,128,168Z"></path></svg>
                                                    </a>
                                                    <a href="#" class="editt btn btn-info ms-1" data-bs-toggle="modal"
                                                        data-bs-target="#editpinjaman" data-id = "{{ $d->id }}"
                                                        data-jumlahpinjam ="{{ $d->jumlah_pinjam }}"
                                                        data-jumlahcicilan ="{{ $d->jumlah_cicilan }}"
                                                        data-lamacicilan = "{{ $d->lama_cicilan }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,120v88a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h88a8,8,0,0,1,0,16H48V208H208V120a8,8,0,0,1,16,0Zm5.66-50.34-96,96A8,8,0,0,1,128,168H96a8,8,0,0,1-8-8V128a8,8,0,0,1,2.34-5.66l96-96a8,8,0,0,1,11.32,0l32,32A8,8,0,0,1,229.66,69.66Zm-17-5.66L192,43.31,179.31,56,200,76.69Z"></path></svg>
                                                    </a>
                                                    <form action="{{ route('payroll.loan.delete', ['id' => $d->id]) }}"
                                                        method="POST" class="ms-1 d-inline">
                                                        @csrf
                                                        <a class="btn btn-danger delete-confirm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,56a8,8,0,0,1-8,8h-8V208a16,16,0,0,1-16,16H64a16,16,0,0,1-16-16V64H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,56ZM88,32h80a8,8,0,0,0,0-16H88a8,8,0,0,0,0,16Z"></path></svg>
                                                        </a>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $loan->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="loan" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payroll.loan.add') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Karyawan</label>
                            <select name="karyawan" id="karyawan" class="form-select">
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawan as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Pinjaman</label>
                            <input type="number" id="pinjaman" class="form-control" name="jumlah_pinjaman"
                                placeholder="Contoh: 1000000" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Cicilan Setiap Bulan</label>
                            <input type="number" id="cicilan" class="form-control" name="jumlah_cicilan"
                                placeholder="Contoh: 10000" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lama Bulan Cicilan</label>
                            <input type="number" id="bulan" class="form-control" name="bulan_cicilan"
                                placeholder="Contoh: 5" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bulan Mulai</label>
                            <input type="text" class="form-control" id="bulan1" name="bulan"
                                value="{{ date('F') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tahun Mulai</label>
                            <input type="text" class="form-control" id="tahun1" name="tahun"
                                value="{{ date('Y') }}" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="submit">
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

    <div class="modal modal-sm" id="detail" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pinjaman</h5>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td>Nama</td>
                            <td id="nama-karyawan"></td>
                        </tr>
                        <tr>
                            <td>Jumlah Pinjam</td>
                            <td id="jumlah-pinjam"></td>
                        </tr>
                        <tr>
                            <td>Jumlah Cicilan</td>
                            <td id="jumlah-cicilan"></td>
                        </tr>
                        <tr>
                            <td>Bulan Cicilan</td>
                            <td id="bulan-cicilan"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Mulai</td>
                            <td id="tanggal-mulai"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="editpinjaman" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Jumlah Pinjaman</label>
                            <input type="number" id="pinjaman_uang" class="form-control" name="jumlah_pinjaman"
                                placeholder="Contoh: 1000000" value="" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Cicilan Setiap Bulan</label>
                            <input type="number" id="cicilan_uang" class="form-control" name="jumlah_cicilan"
                                placeholder="Contoh: 10000" value="" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lama Bulan Cicilan</label>
                            <input type="number" id="bulan_uang" class="form-control" name="bulan_cicilan"
                                value="" placeholder="Contoh: 5" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="">
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
    <script>
        document.querySelectorAll('.editt').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id');
                var jumlahpinjam = button.getAttribute('data-jumlahpinjam');
                var jumlahcicilan = button.getAttribute('data-jumlahcicilan');
                var lamacicilan = button.getAttribute('data-lamacicilan');
                document.getElementById('pinjaman_uang').value = jumlahpinjam;
                document.getElementById('cicilan_uang').value = jumlahcicilan;
                document.getElementById('bulan_uang').value = lamacicilan;
                document.querySelector('#editpinjaman form').action = `/payroll/loan/edit/${id}`;
            });
        });

        document.querySelectorAll('.detail').forEach(function(button) {
            button.addEventListener('click', function() {
                var nama = button.getAttribute('data-nama');
                var jumlahpinjam = button.getAttribute('data-jumlahpinjam');
                var jumlahcicilan = button.getAttribute('data-jumlahcicilan');
                var lamacicilan = button.getAttribute('data-lamacicilan');
                var bulan = button.getAttribute('data-bulan');
                var tahun = button.getAttribute('data-tahun');
                var monthNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                var bulanName = monthNames[parseInt(bulan) - 1];
                document.getElementById('nama-karyawan').innerText = ": " + nama;
                document.getElementById('jumlah-pinjam').innerText = ": " + jumlahpinjam;
                document.getElementById('jumlah-cicilan').innerText = ": " + jumlahcicilan;
                document.getElementById('bulan-cicilan').innerText = ": " + lamacicilan + " Bulan";
                document.getElementById('tanggal-mulai').innerText = ": " + bulanName + " " + tahun;
            });
        });
    </script>

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
        $(".delete-confirm").click(function(e) {
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin Data Ini Mau Di Hapus ?',
                text: "Jika Ya Maka Data Akan Terhapus Permanent",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Saja!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });

        $(function() {
            $("#submit").click(function() {
                var karyawan = $("#karyawan").val();
                var pinjaman = $("#pinjaman").val();
                var cicilan = $("#cicilan").val();
                var bulan = $("#bulan").val();
                if (karyawan === "") {
                    showError("Karyawan Harus Dipilih !");
                    return false;
                } else if (pinjaman === "") {
                    showError("Jumlah Pinjaman Harus Diisi!");
                    return false;
                } else if (cicilan === "") {
                    showError("Jumlah Cicilan Harus Diisi!");
                    return false;
                } else if (bulan === "") {
                    showError("Lama Bulan Cicilan Harus Diisi!");
                    return false;
                }
            });

            function showError(message) {
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
                    title: message,
                });
            }
        });
    </script>
@endpush
