@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Potongan
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h3 class="card-title">Jenis Potongan</h3>

                        <div class="d-md-flex align-items-center">
                            <form action="{{ route('payroll.deductions.type.search') }}" method="post">
                                @csrf

                                <div class="d-flex align-items-center">
                                    <div class="form-group" style="width: 175px;">
                                        <select name="tipe" class="form-control">
                                            <option value="">--Filter Tipe--</option>
                                            <option value="1">Tetap</option>
                                            <option value="2">Lain-Lain</option>
                                        </select>
                                    </div>

                                    <div class="input-group ms-2">
                                        <input type="text" class="form-control" placeholder="Cari..." name="keyword">
                                        <button type="submit" class="btn btn-outline-primary" type="button">Cari</button>
                                    </div>
                                </div>
                            </form>

                            <button type="button" class="btn btn-primary ms-3 mt-2 mt-md-0" data-action-jenis="tambah" data-bs-target="#jenisPotonganModal">
                                Tambah Jenis Potongan
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped table-hover table-deductions-type">
                            <thead>
                                <tr align="middle">
                                    <th>No</th>
                                    <th>Nama Potongan</th>
                                    <th>Tipe</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            </thead>
                            <tbody>
                                {{-- @foreach ($deductionsType as $item)
                                    <tr>
                                        <td align="middle">{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_potongan }}</td>
                                        <td align="middle">
                                            @if ($item->tipe == 1)
                                                Tetap
                                            @else
                                                Lain-Lain
                                            @endif
                                        </td>
                                        <td align="middle">
                                            <button type="button" class="btn btn-warning" data-action-jenis="edit" data-jenis="{{ $item->id }}" data-bs-target="#jenisPotonganModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM51.31,160,136,75.31,152.69,92,68,176.68ZM48,179.31,76.69,208H48Zm48,25.38L79.31,188,164,103.31,180.69,120Zm96-96L147.31,64l24-24L216,84.68Z"></path></svg>
                                            </button>
                                            <button type="button" class="btn btn-danger ms-0 ms-md-3 mt-2 mt-md-0" data-action-jenis="delete" data-bs-target="#hapusJenisPotonganModal" data-jenis="{{ $item->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Potongan Karyawan</h3>

                        <div class="d-md-flex align-items-center">
                            <form action="#" method="post">
                                @csrf

                                <div class="input-group ms-2">
                                    <input type="text" class="form-control" placeholder="Cari..." name="keyword">
                                    <button type="submit" class="btn btn-outline-primary" type="button">Cari</button>
                                </div>
                            </form>

                            <button type="button" class="btn btn-primary ms-3 mt-2 mt-md-0"  data-bs-toggle="modal" data-bs-target="#potonganModal">
                                Tambah Potongan
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped table-hover table-deductions">
                            <thead>
                                <tr align="middle">
                                    <th>NO</th>
                                    <th>NAMA KARYAWAN</th>
                                    <th>JENIS POTONGAN</th>
                                    <th>JUMLAH POTONGAN</th>
                                    <th>KATEGORI</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deductions as $deduction)
                                    <tr>
                                        <td align="middle">{{ $loop->iteration }}</td>
                                        <td>{{ $deduction->karyawan->nama_lengkap }}</td>
                                        <td>{{ $deduction->jenis_potongan->nama_potongan }}</td>
                                        <td align="middle">Rp. {{ number_format($deduction->jml_potongan,0,',','.') }}</td>
                                        <td align="middle">
                                            @if ($deduction->jenis_potongan->tipe == 1)
                                                Tetap
                                            @else
                                                Lain-Lain
                                            @endif
                                        </td>
                                        <td align="middle">
                                            <button type="button" class="btn btn-success detail-potongan" data-potongan="{{ $deduction->id }}" data-bs-target="#detailPotonganModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.61,27.65-38.4A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path></svg>
                                            </button>
                                            <button type="button" class="btn btn-warning edit-potongan ms-0 ms-md-3 mt-2 mt-md-0" data-potongan="{{ $deduction->id }}" data-bs-target="#editPotonganModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM51.31,160,136,75.31,152.69,92,68,176.68ZM48,179.31,76.69,208H48Zm48,25.38L79.31,188,164,103.31,180.69,120Zm96-96L147.31,64l24-24L216,84.68Z"></path></svg>
                                            </button>
                                            <button type="button" class="btn btn-danger delete-potongan ms-0 ms-md-3 mt-2 mt-md-0" data-bs-target="#hapusPotonganModal" data-potongan="{{ $deduction->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Jenis --}}
    <div class="modal" id="jenisPotonganModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post">
                    @csrf
                    @method('post')

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nama_potongan" class="form-label">Nama Potongan</label>
                            <input type="text" class="form-control" name="nama_potongan" id="nama_potongan" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tipe" class="form-label">Tipe Potongan</label>
                            <select name="tipe" id="tipe" class="form-control" required>

                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="type_id" id="type_id">

                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            Tambah
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Modal Hapus Jenis --}}
    <div class="modal" id="hapusJenisPotonganModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Jenis Potongan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payroll.deductions.type.delete') }}" method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="type_id" id="type_id">

                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-danger ms-auto">
                            Hapus
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    {{-- Modal Tambah Potongan --}}
    <div class="modal" id="potonganModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Potongan Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payroll.deductions.create') }}" method="post">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="karyawan_id" class="form-label">Karyawan</label>
                            <select name="karyawan_id" id="karyawan_id" class="form-control" required>
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jenis_potongan_id" class="form-label">Jenis Potongan</label>
                            <select name="jenis_potongan_id" id="jenis_potongan_id" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                @foreach ($deductionsTypeList as $deduction)
                                    <option value="{{ $deduction->id }}">{{ $deduction->nama_potongan }} | {{ ($deduction->tipe == 1) ? 'Tetap' : 'Lain-Lain' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jml_potongan" class="form-label">Nominal Potongan</label>
                            <input type="number" class="form-control" name="jml_potongan" id="jml_potongan" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="total_potongan" class="form-label">Total Potongan <span class="text-danger">(Optional)</span></label>
                            <input type="number" class="form-control" name="total_potongan" id="total_potongan">
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="form-group">
                                <label for="bulan_mulai" class="form-label">Bulan Mulai</label>
                                <select name="bulan_mulai" id="bulan_mulai" class="form-control">
                                    <option value="">-- Pilih Bulan --</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ bulanIndo("0$i") }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group ms-3">
                                <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                                <select name="tahun_mulai" id="tahun_mulai" class="form-control">
                                    <option value="">-- Pilih Tahun --</option>
                                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                    <option value="{{ date('Y', strtotime('+1year', strtotime(date('Y')))) }}">{{ date('Y', strtotime('+1year', strtotime(date('Y')))) }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="lama_potongan" class="form-label">Lama Potongan Dalam Bulan <span class="text-danger">(Optional)</span></label>
                            <input type="number" class="form-control" name="lama_potongan" id="lama_potongan">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            Tambah
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Potongan --}}
    <div class="modal" id="editPotonganModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Potongan Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payroll.deductions.update') }}" method="post">
                    @csrf
                    @method('put')

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nama_karyawan" class="form-label">Karyawan</label>
                            <input type="text" id="nama_karyawan" class="form-control" disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jenis_potongan_id" class="form-label">Jenis Potongan</label>
                            <select name="jenis_potongan_id" id="jenis_potongan_id" class="form-control" required>

                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="jml_potongan" class="form-label">Nominal Potongan</label>
                            <input type="number" class="form-control" name="jml_potongan" id="jml_potongan" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="total_potongan" class="form-label">Total Potongan <span class="text-danger">(Optional)</span></label>
                            <input type="number" class="form-control" name="total_potongan" id="total_potongan">
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="form-group">
                                <label for="bulan_mulai" class="form-label">Bulan Mulai</label>
                                <select name="bulan_mulai" id="bulan_mulai" class="form-control">

                                </select>
                            </div>
                            <div class="form-group ms-3">
                                <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                                <select name="tahun_mulai" id="tahun_mulai" class="form-control">

                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="lama_potongan" class="form-label">Lama Potongan Dalam Bulan <span class="text-danger">(Optional)</span></label>
                            <input type="number" class="form-control" name="lama_potongan" id="lama_potongan">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="potongan_id" id="potongan_id">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-warning ms-auto">
                            Edit
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Modal Detail Potongan --}}
    <div class="modal" id="detailPotonganModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Potongan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Karyawan</th>
                            <th>:</th>
                            <td id="nama_karyawan"></td>
                        </tr>
                        <tr>
                            <th>Jenis Potongan</th>
                            <th>:</th>
                            <td id="jenis_potongan"></td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <th>:</th>
                            <td id="kategori_potongan"></td>
                        </tr>
                        <tr>
                            <th>Nominal Potongan</th>
                            <th>:</th>
                            <td id="jml_potongan"></td>
                        </tr>
                        <tr>
                            <th>Total Potongan</th>
                            <th>:</th>
                            <td id="total_potongan"></td>
                        </tr>
                        <tr>
                            <th>Lama Potongan</th>
                            <th>:</th>
                            <td id="lama_potongan"></td>
                        </tr>
                        <tr>
                            <th>Sisa Waktu Potongan</th>
                            <th>:</th>
                            <td id="sisa_bulan_potongan"></td>
                        </tr>
                        <tr>
                            <th>Waktu Mulai Potongan</th>
                            <th>:</th>
                            <td id="waktu_mulai"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Hapus Potongan --}}
    <div class="modal" id="hapusPotonganModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Potongan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payroll.deductions.delete') }}" method="post">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus potongan ini ?</p>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="potongan_id" id="potongan_id">

                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-danger ms-auto">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    @if (session('success'))
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
                title: "{{ session('success') }}"
            });
        </script>
    @endif

    @if (session('error'))
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
                icon: "error",
                title: "{{ session('error') }}"
            });
        </script>
    @endif

    <script>

        var idJenis;
        var idPotongan;

        $(document).ready(function(e) {
            $('.table-deductions-type').dataTable({
                ordering: true,
                serverSide: true,
                processing: true,
                ajax: {
                    'url': "{{ route('payroll.deductions.datatables-type') }}",
                },
                column: [
                    { data: 'DT_RowIndex', name: 'no', orderable: false, searchable: false},
                    { data: 'nama_potongan', name: 'nama_potongan'},
                    { data: 'tipe', name: 'tipe'}
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            // $('.table-deductions').dataTable();
        });

        // JENIS POTONGAN
        $('[data-action-jenis]').on('click', function(e) {
            const $this = $(this);
            const action = $this.attr('data-action-jenis');
            const target = $this.attr('data-bs-target');

            //tambah
            if(action == 'tambah') {
                $(target).find('#nama_potongan').val('');
                $(target).find('#tipe').val('');

                idJenis = null;
                $(target).modal('show');
            }

            // edit
            if(action == 'edit') {
                const jenis = $this.attr('data-jenis');
                idJenis = jenis;
                $(target).modal('show');
            }

            // hapus
            if(action == 'delete') {
                const jenis = $this.attr('data-jenis');
                idJenis = jenis;
                $(target).modal('show');
            }
        });


        $('#jenisPotonganModal').on('show.bs.modal', function(e) {
            const $this = $(this);

            if(idJenis) {

                $this.find('button[type="submit"]').text('Edit');
                $this.find('button[type="submit"]').removeClass('btn-primary');
                $this.find('button[type="submit"]').addClass('btn-warning');

                $.ajax({
                    url: "{{ route('payroll.deductions.type.getbyid') }}",
                    type: "post",
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        typeId: idJenis
                    },
                    success: function(response) {
                        if(response.error == false) {
                            const deductionsType = response.deductionsType;
                            const type = deductionsType.tipe;

                            $this.find('.modal-title').text('Edit Jenis Potongan');
                            $this.find('#nama_potongan').val(deductionsType.nama_potongan);
                            $this.find('#type_id').val(deductionsType.id);
                            $this.find('form').attr('action', "{{ route('payroll.deductions.type.update') }}");
                            $this.find('[name="_method"]').val('put');

                            var htmlType = '<option value="">--Pilih Tipe--</option>';

                                if(type == 1) {
                                    htmlType += '<option value="1" selected>Potongan Tetap</option>';
                                } else {
                                    htmlType += '<option value="1">Potongan Tetap</option>';
                                }

                                if(type == 2) {
                                    htmlType += '<option value="2" selected>Potongan Lain-Lain</option>';
                                } else {
                                    htmlType += '<option value="2">Potongan Lain-Lain</option>';
                                }

                                $this.find('#tipe').html(htmlType);
                        }
                    }
                });
            } else {
                $this.find('.modal-title').text('Tambah Jenis Potongan');
                $this.find('[name="_method"]').val('post');
                $this.find('form').attr('action', "{{ route('payroll.deductions.type.create') }}");
                $this.find('button[type="submit"]').text('Tambah');
                $this.find('button[type="submit"]').removeClass('btn-warning');
                $this.find('button[type="submit"]').addClass('btn-primary');

                var htmlType = '<option value="">--Pilih Tipe--</option>';
                    htmlType += '<option value="1">Potongan Tetap</option>';
                    htmlType += '<option value="2">Potongan Lain-Lain</option>';

                $this.find('#tipe').html(htmlType);
            }

        });


        $('#hapusJenisPotonganModal').on('show.bs.modal', function(e) {
            const $this = $(this);

            if(idJenis) {
                $.ajax({
                    url: "{{ route('payroll.deductions.type.getbyid') }}",
                    type: "post",
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        typeId: idJenis
                    },
                    success: function(response) {
                        if(response.error == false) {
                            const deductionsType = response.deductionsType;
                            const name = deductionsType.nama_potongan;
                            const type = deductionsType.tipe;
                            console.log(response);

                            $this.find('.modal-body').html(`<p>Anda yakin ingin menghapus ${name} ?</p>`);
                            $this.find('#type_id').val(deductionsType.id);
                        }
                    }
                });
            }
        });

        // POTONGAN
        $('.edit-potongan').on('click', function(e) {
            const $this = $(this);
            const target = $this.attr('data-bs-target');
            const potongan = $this.attr('data-potongan');

            idPotongan = potongan;
            $(target).modal('show');
        });

        $('#editPotonganModal').on('show.bs.modal', function(e) {
            const $this = $(this);

            $.ajax({
                url: "{{ route('payroll.deductions.getbyid') }}",
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    potonganId: idPotongan
                },
                success: function(response) {
                    if(response.error == false) {
                        const deductions = response.deductions;

                        $this.find('#nama_karyawan').val(deductions.karyawan.nama_lengkap);
                        $this.find('#jenis_potongan_id').html(response.deductionsTypeOption);
                        $this.find('#jml_potongan').val(deductions.jml_potongan);
                        $this.find('#total_potongan').val(deductions.total_potongan);
                        $this.find('#lama_potongan').val(deductions.lama_potongan);
                        $this.find('#bulan_mulai').html(response.month);
                        $this.find('#tahun_mulai').html(response.year);
                        $this.find('#potongan_id').val(deductions.id);
                    }
                }
            });
        });

        $('.detail-potongan').on('click', function(e) {
            const $this = $(this);
            const target = $this.attr('data-bs-target');
            const potongan = $this.attr('data-potongan');

            idPotongan = potongan;
            $(target).modal('show');
        });

        $('#detailPotonganModal').on('show.bs.modal', function(e) {
            const $this = $(this);

            $.ajax({
                url: "{{ route('payroll.deductions.detail-json') }}",
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    potonganId: idPotongan
                },
                success: function(response) {
                    if(response.error == false) {
                        const deductions = response.deductions;

                        $this.find('#nama_karyawan').text(deductions.employeeName);
                        $this.find('#jenis_potongan').text(deductions.deductionsType);
                        $this.find('#kategori_potongan').text(deductions.deductionsTypeCtg);
                        $this.find('#jml_potongan').text(deductions.deductionsAmount);
                        $this.find('#total_potongan').text(deductions.deductionsTotal);
                        $this.find('#lama_potongan').text(deductions.deductionsLength);
                        $this.find('#sisa_bulan_potongan').text(deductions.deductionsRemaining);
                        $this.find('#waktu_mulai').text(deductions.deductionsStart);
                    }
                }
            });
        });

        $('.delete-potongan').on('click', function(e) {
            const $this = $(this);
            const target = $this.attr('data-bs-target');
            const potongan = $this.attr('data-potongan');

            idPotongan = potongan;
            $(target).modal('show');
        });

        $('#hapusPotonganModal').on('show.bs.modal', function(e) {
            const $this = $(this);
            $this.find('#potongan_id').val(idPotongan);
        });
    </script>
@endpush
