@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Bonus
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container">
            <div class="ro">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Jenis Bonus</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#jenisbonus">Tambah
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-vcenter" id="bonus-datatables">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Bonus</th>
                                        <th>Tipe Bonus</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($bonusJenis->isEmpty())
                                        <tr>
                                            <td colspan="12" class="text-center">Tidak ada data jenis bonus !!
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($bonusJenis as $d)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $d->nama_bonus }}</td>
                                                <td>{{ $d->tipe_bonus == 1 ? 'Tetap' : 'Lain-lain' }}</td>
                                                <td align="middle">
                                                    <div class="btn-group">
                                                        <a href="#" class="edit btn btn-warning" data-bs-toggle="modal"
                                                            data-bs-target="#editjenisbonus" data-id = "{{ $d->id }}"
                                                            data-namabonus ="{{ $d->nama_bonus }}"
                                                            data-jenisbonus ="{{ $d->tipe_bonus }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,120v88a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h88a8,8,0,0,1,0,16H48V208H208V120a8,8,0,0,1,16,0Zm5.66-50.34-96,96A8,8,0,0,1,128,168H96a8,8,0,0,1-8-8V128a8,8,0,0,1,2.34-5.66l96-96a8,8,0,0,1,11.32,0l32,32A8,8,0,0,1,229.66,69.66Zm-17-5.66L192,43.31,179.31,56,200,76.69Z"></path></svg>
                                                        </a>
                                                        {{-- <form action="{{ route('payroll.bonus.delete', ['id' => $d->id]) }}"
                                                            method="POST" class="ms-3">
                                                            @csrf
                                                            <a class="btn btn-danger delete-confirm">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-trash-filled"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                    </path>
                                                                    <path
                                                                        d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z"
                                                                        stroke-width="0" fill="currentColor"></path>
                                                                    <path
                                                                        d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z"
                                                                        stroke-width="0" fill="currentColor"></path>
                                                                </svg>
                                                            </a>
                                                        </form> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $bonusJenis->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container">
            <div class="ro">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Bonus </h3>
                        <div class="d-flex justify-content-between">
                            <form action="{{ route('payroll.bonus.karyawan.search') }}" method="post">
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
                                data-bs-target="#tambahbonuskaryawan">Tambah
                            </button>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-vcenter">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Karyawan</th>
                                        <th>Jenis Bonus</th>
                                        <th>Jumlah Bonus</th>
                                        <th>Tanggal Dikeluarkan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($bonus->isEmpty())
                                        <tr>
                                            <td colspan="12" class="text-center">Tidak ada data bonus !!
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($bonus as $d)
                                            <tr>
                                                <td align="middle">{{ $loop->iteration }}</td>
                                                <td>{{ $d->karyawan->nama_lengkap }}</td>
                                                <td>{{ $d->jenis_bonus->nama_bonus }}

                                                </td>
                                                <td>{{ $d->jumlah_bonus }}</td>
                                                <td>{{ BulanIndo($d->bulan_bonus) }} {{ $d->tahun_bonus }}</td>
                                                <td align="middle">
                                                    <div class="btn-group">
                                                        <a href="#" class="editbonus btn btn-warning"
                                                            data-bs-toggle="modal" data-bs-target="#editbonuskaryawan"
                                                            data-id-test = "{{ $d->id }}"
                                                            data-karyawan ="{{ $d->karyawan->nama_lengkap }}"
                                                            data-jenisbonus ="{{ $d->jenis_bonus_id }}"
                                                            data-jumlahbonus ="{{ $d->jumlah_bonus }}"
                                                            data-bulanbonus ="{{ $d->bulan_bonus }}"
                                                            data-tahunbonus ="{{ $d->tahun_bonus }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,120v88a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h88a8,8,0,0,1,0,16H48V208H208V120a8,8,0,0,1,16,0Zm5.66-50.34-96,96A8,8,0,0,1,128,168H96a8,8,0,0,1-8-8V128a8,8,0,0,1,2.34-5.66l96-96a8,8,0,0,1,11.32,0l32,32A8,8,0,0,1,229.66,69.66Zm-17-5.66L192,43.31,179.31,56,200,76.69Z"></path></svg>
                                                        </a>
                                                        <form
                                                            action="{{ route('payroll.bonus.karyawan.delete', ['id' => $d->id]) }}"
                                                            method="POST" class="ms-3">
                                                            @csrf
                                                            <a class="btn btn-danger delete-confirm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,56a8,8,0,0,1-8,8h-8V208a16,16,0,0,1-16,16H64a16,16,0,0,1-16-16V64H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,56ZM88,32h80a8,8,0,0,0,0-16H88a8,8,0,0,0,0,16Z"></path></svg>
                                                            </a>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $bonus->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="tambahbonuskaryawan" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Bonus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payroll.bonus.karyawan.add') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Karyawan</label>
                            <select name="karyawann" id="karyawan" class="form-select" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Bonus</label>
                            <select name="jenis_bonus_id" id="jenis_bonus_id" class="form-select" required>
                                <option value="">Pilih Jenis</option>
                                @foreach ($bonusJenis as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_bonus }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Bonus</label>
                            <input type="number" id="jumlahbonus" class="form-control" name="jumlah_bonus" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bulan</label>
                            <select name="bulan_bonus" id="bulan_bonus" class="form-select" required>
                                <option value="">Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                                        {{ $namabulan[$i] }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tahun</label>
                            <select name="tahun_bonus" id="tahun_bonus" class="form-select" required>
                                @php
                                    $tahunmulai = date('Y');
                                    $tahunskrg = date('Y') + 1;
                                @endphp
                                @for ($tahun = $tahunmulai; $tahun <= $tahunskrg; $tahun++)
                                    <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal"
                            id="submitTambah">
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

    <div class="modal" id="editbonuskaryawan" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Bonus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Karyawan</label>
                            <input type="text" class="form-control" id="karyawan1" value="" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Bonus</label>
                            <select name="jenis_bonus_id" id="jenisbonus1" class="form-select" required>
                                @foreach ($bonusJenis as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_bonus }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Bonus</label>
                            <input type="number" id="jumlahbonus1" class="form-control" name="jumlah_bonus" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bulan</label>
                            <select name="bulan_bonus" id="bulan_bonus1" class="form-select" required>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                                        {{ $namabulan[$i] }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tahun</label>
                            <select name="tahun_bonus" id="tahun_bonus1" class="form-select" required>
                                @php
                                    $tahunmulai = date('Y');
                                    $tahunskrg = date('Y') + 1;
                                @endphp
                                @for ($tahun = $tahunmulai; $tahun <= $tahunskrg; $tahun++)
                                    <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal"
                            id="submitEditBonus">
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

    <div class="modal" id="jenisbonus" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jenis Bonus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payroll.bonus.add') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Bonus</label>
                            <input type="text" id="namabonus" class="form-control" name="nama_bonus" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Bonus</label>
                            <select name="jenis_bonus" id="jenisbonuss" class="form-select">
                                <option value="">Pilih Jenis</option>
                                <option value="1">Tetap</option>
                                <option value="2">Lain-lain</option>
                            </select>
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
    <div class="modal" id="editjenisbonus" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jenis Bonus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Bonus</label>
                            <input type="text" id="editnamabonus" class="form-control" name="nama_bonus" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Bonus</label>
                            <select name="jenis_bonus" id="editjenisbonusselect" class="form-select">
                                <option value="">Pilih Jenis</option>
                                <option value="1">Tetap</option>
                                <option value="2">Lain-lain</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-warning ms-auto" data-bs-dismiss="modal" id="submitEdit">
                            Edit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function(e) {
            $('#bonus-datatables').dataTable({
                ordering: true,
                processing: true,
                serverSide: true,
                ajax: {
                    'url': "{{ route('payroll.bonus.datatables-type') }}",
                    'data': function (d) {
                        d.tipe = $('#deduction-type').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'nama_bonus', name: 'nama_bonus'},
                    {data: 'tipe_bonus', name: 'tipe_bonus'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                'columnDefs': [
                    {
                        "targets": 0,
                        "className": "text-center",
                    },
                    {
                        "targets": 2,
                        "className": "text-center",
                    },
                    {
                        "targets": 3,
                        "className": "text-center",
                    },
                ]
            });
        });

        document.querySelectorAll('.editbonus').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = button.getAttribute('data-id-test');
                var karyawan = button.getAttribute('data-karyawan');
                var jenisbonus = button.getAttribute('data-jenisbonus');
                var jumlahbonus = button.getAttribute('data-jumlahbonus');
                var bulanbonus = button.getAttribute('data-bulanbonus');
                var tahunbonus = button.getAttribute('data-tahunbonus');

                document.getElementById('karyawan1').value = karyawan;
                document.getElementById('jumlahbonus1').value = jumlahbonus;
                selectJenisBonus = document.getElementById('jenisbonus1');
                for (var i = 0; i < selectJenisBonus.options.length; i++) {
                    var option = selectJenisBonus.options[i];
                    if (option.value === jenisbonus) {
                        option.selected = true;
                        break;
                    }
                }
                selectBulanBonus = document.getElementById('bulan_bonus1');
                for (var i = 0; i < selectBulanBonus.options.length; i++) {
                    var option = selectBulanBonus.options[i];
                    if (option.value === bulanbonus) {
                        option.selected = true;
                        break;
                    }
                }

                selectTahunBonus = document.getElementById('tahun_bonus1');
                for (var i = 0; i < selectTahunBonus.options.length; i++) {
                    var option = selectTahunBonus.options[i];
                    if (option.value === tahunbonus) {
                        option.selected = true;
                        break;
                    }
                }
                document.querySelector('#editbonuskaryawan form').action =
                    `/payroll/bonus/karyawan/edit/${id}`;
            });
        });
    </script>

    <script>
        $(document).on('click', '.edit', function(e) {
            const $this = $(this);
            const id = $this.attr('data-id');
            const namabonus = $this.attr('data-namabonus');
            const jenisbonus = $this.attr('data-jenisbonus');

            $('#editnamabonus').val(namabonus);

            const select = $('#editjenisbonusselect')[0];

            for (var i = 0; i < select.options.length; i++) {
                var option = select.options[i];
                if (option.value === jenisbonus) {
                    option.selected = true;
                    break;
                }
            }

            $('#editjenisbonus form').attr('action', `/payroll/bonus/edit/${id}`)
        });

        // document.querySelectorAll('.edit').forEach(function(button) {
        //     button.addEventListener('click', function() {
        //         var id = button.getAttribute('data-id');
        //         var namabonus = button.getAttribute('data-namabonus');
        //         var jenisbonus = button.getAttribute('data-jenisbonus');
        //         document.getElementById('editnamabonus').value = namabonus;
        //         var select = document.getElementById('editjenisbonusselect');
        //         for (var i = 0; i < select.options.length; i++) {
        //             var option = select.options[i];
        //             if (option.value === jenisbonus) {
        //                 option.selected = true;
        //                 break;
        //             }
        //         }
        //         document.querySelector('#editjenisbonus form').action = `/payroll/bonus/edit/${id}`;
        //     });
        // });

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
                icon: "success",
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
                text: "Jika Ya Maka Data Akan Terhapus Permanen",
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
                var namabonus = $("#namabonus").val();
                var jenisbonus = $("#jenisbonuss").val();
                if (namabonus === "") {
                    showError("Nama Bonus Harus Diisi !");
                    return false;
                } else if (jenisbonus === "") {
                    showError("Jenis Bonus Harus Dipilih !");
                    return false;
                }
            });

            $("#submitEdit").click(function() {
                var editnamabonus = $("#editnamabonus").val();
                var editjenisbonus = $("#editjenisbonusselect").val();
                if (editnamabonus === "") {
                    showError("Nama Bonus Harus Diisi !");
                    return false;
                } else if (editjenisbonus === "") {
                    showError("Jenis Bonus Harus Dipilih !");
                    return false;
                }
            });

            $("#submitTambah").click(function() {
                var karyawan = $("#karyawan").val();
                var jenisbonus = $("#jenis_bonus_id").val();
                var jumlahbonus = $("#jumlahbonus").val();
                var bulanbonus = $("#bulan_bonus").val();
                var tahunbonus = $("#tahun_bonus").val();
                if (karyawan === "") {
                    showError("Karyawan Harus Dipilih !");
                    return false;
                } else if (jenisbonus === "") {
                    showError("Jenis Bonus Harus Dipilih !");
                    return false;
                } else if (jumlahbonus === "") {
                    showError("Jumlah Bonus Harus Diisi !");
                    return false;
                } else if (bulanbonus === "") {
                    showError("Bulan Bonus Harus Dipilih !");
                    return false;
                } else if (tahunbonus === "") {
                    showError("Tahun Bonus Harus Dipilih !");
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
                    icon: "error",
                    title: message,
                });
            }
        });
    </script>
@endpush
