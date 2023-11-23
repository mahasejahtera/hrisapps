@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Data Izin/Cuti/Sakit
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="/presensi/izin/karyawan/search" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="jenisizin" id="bulan" class="form-select">
                                                <option value="">Pilih Jenis</option>
                                                <option value="i">Izin</option>
                                                <option value="c">Cuti</option>
                                                <option value="s">Sakit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
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
                        </div>
                        <div class="row mt-2">
                            <div class="">
                                <div class="form-group">
                                    <button type="submit" name="cetak" class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
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
                <div class="col-6 h-auto">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-center text-bold">
                                @if ($jenisizin == 'i')
                                    Izin
                                @elseif($jenisizin == 'c')
                                    Cuti
                                @elseif($jenisizin == 's')
                                    Sakit
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">
                                @php
                                    $jenisIzinLabel = '';
                                    if($jenisizin == 'i') $jenisIzinLabel = 'Izin';
                                    if($jenisizin == 'c') $jenisIzinLabel = 'Cuti';
                                    if($jenisizin == 's') $jenisIzinLabel = 'Sakit';
                                @endphp
                                Dafter {{ $jenisIzinLabel }}
                            </h3>

                            @if ($jenisizin == 's')
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahIzinModal">Tambah Data Sakit</button>
                            @endif
                        </div>
                        <div class="cardi-body">
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered table-striped table-hover w-100 table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nik</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai </th>
                                                {{-- <th>Status</th> --}}
                                                <th>Keterangan</th>
                                                <th>Lampiran</th>
                                                <th>Bulan Pertama</th>
                                                <th>Bulan Kedua</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!$data)
                                                <tr>
                                                    <td colspan="12" class="text-center">Tidak ada data dalam tanggal ini
                                                        !!</td>
                                                </tr>
                                            @else
                                                @foreach ($data as $d)
                                                    <tr>
                                                        <td align="middle">{{ $loop->iteration }}</td>
                                                        <td>{{ $d->karyawan->nama_lengkap }}</td>
                                                        <td>{{ tanggalBulanIndo($d->tgl_mulai_izin) }}</td>
                                                        <td>{{ tanggalBulanIndo($d->tgl_akhir_izin) }}</td>
                                                        {{-- <td>{{ $d->status }}</td> --}}
                                                        <td>{{ $d->keterangan }}</td>
                                                        <td align="middle">
                                                            @if ($d->lampiran)
                                                                <a href="{{ asset('/storage/' . $d->lampiran) }}" target="_blank">Lampiran</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td align="middle">
                                                            {{ $d->bulan_pertama }}
                                                        </td>
                                                        <td align="middle">
                                                            {{ $d->bulan_kedua }}
                                                        </td>
                                                        <td align="middle">
                                                            <button type="button" class="btn btn-warning ms-0 ms-md-3 mt-2 mt-md-0" data-action="edit" data-bs-target="#editIzinModal" data-izin="{{ $d->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM51.31,160,136,75.31,152.69,92,68,176.68ZM48,179.31,76.69,208H48Zm48,25.38L79.31,188,164,103.31,180.69,120Zm96-96L147.31,64l24-24L216,84.68Z"></path></svg>
                                                            </button>
                                                            <button type="button" class="btn btn-danger ms-0 ms-md-3 mt-2 mt-md-0" data-action="delete" data-bs-target="#deleteIzinModal" data-izin="{{ $d->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path></svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal" id="tambahIzinModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data {{ $jenisIzinLabel }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.izin.create') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="nik" class="form-label">Karyawan</label>
                            <select name="nik" id="nik" class="form-control" required>
                                <option value="">--Pilih Karyawan--</option>
                                @foreach ($karyawan as $kry)
                                    <option value="{{ $kry->nik }}">{{ $kry->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tgl_mulai_izin" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai_izin" id="tgl_mulai_izin" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tgl_akhir_izin" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir_izin" id="tgl_akhir_izin" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" required></textarea>
                        </div>

                        <div class="form-group mb-3 bulan-pertama">
                            <label for="bulan_pertama" class="form-label">Jumlah Hari Kerja Bulan Pertama</label>
                            <input type="number" name="bulan_pertama" id="bulan_pertama" class="form-control" value="0" required>
                        </div>

                        <div class="form-group mb-3 bulan-kedua">
                            <label for="bulan_kedua" class="form-label">Jumlah Hari Kerja Bulan Kedua</label>
                            <input type="number" name="bulan_kedua" id="bulan_kedua" class="form-control" value="0" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="formFile" class="form-label">Lampiran</label>
                            <input class="form-control" name="lampiran" id="lampiran" type="file" id="formFile" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="status" id="status" value="{{ $jenisizin }}">

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

    {{-- Modal Edit --}}
    <div class="modal" id="editIzinModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data {{ $jenisIzinLabel }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.izin.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="" class="form-label">Karyawan</label>
                            <input type="text" class="form-control" id="nama_karyawan" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tgl_mulai_izin" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai_izin" id="tgl_mulai_izin" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tgl_akhir_izin" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir_izin" id="tgl_akhir_izin" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" required></textarea>
                        </div>

                        <div class="form-group mb-3 bulan-pertama">
                            <label for="bulan_pertama" class="form-label">Jumlah Hari Kerja Bulan Pertama</label>
                            <input type="number" name="bulan_pertama" id="bulan_pertama" class="form-control" value="0" required>
                        </div>

                        <div class="form-group mb-3 bulan-kedua">
                            <label for="bulan_kedua" class="form-label">Jumlah Hari Kerja Bulan Kedua</label>
                            <input type="number" name="bulan_kedua" id="bulan_kedua" class="form-control" value="0" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="" class="form-label">Lampiran Lama</label>
                            <a href="#" target="_blank" id="lampiran_lama">Lihat Disini</a>
                        </div>

                        <div class="form-group mb-3">
                            <label for="formFile" class="form-label">Lampiran</label>
                            <input class="form-control" name="lampiran" id="lampiran" type="file" id="formFile">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="izin_id" id="izin_id">

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

    {{-- Modal Delete --}}
    <div class="modal" id="deleteIzinModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data {{ $jenisIzinLabel }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.izin.delete') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus izin ?</p>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="izin_id" id="izin_id">

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
        var idIzin;

        $(document).ready(function(e) {
            $('#tambahIzinModal .bulan-kedua').hide();
        });

        $('#tambahIzinModal #tgl_akhir_izin').on('change', function(e) {
            const $this = $(this);
            const tglAkhir = $this.val();
            const tglAwal = $('#tambahIzinModal #tgl_mulai_izin').val();

            if(tglAwal) {
                const tglAwalSplit = tglAwal.split('-');
                const tglAkhirSplit = tglAkhir.split('-');

                // date parse
                const tglAwalParse = new Date();
                tglAwalParse.setFullYear(tglAwalSplit[0], tglAwalSplit[1], tglAwalSplit[2]);

                const tglAkhirParse = new Date();
                tglAkhirParse.setFullYear(tglAkhirSplit[0], tglAkhirSplit[1], tglAkhirSplit[2]);

                const akhirPerioda = new Date();
                akhirPerioda.setFullYear(tglAwalSplit[0], tglAwalSplit[1], 28);

                if(tglAwalParse > akhirPerioda) {
                    $('#tambahIzinModal .bulan-pertama').hide();
                } else {
                    $('#tambahIzinModal .bulan-pertama').show();
                }

                if(tglAkhirParse > akhirPerioda) {
                    $('#tambahIzinModal .bulan-kedua').show();
                } else {
                    $('#tambahIzinModal .bulan-kedua').hide();
                }
            }
        });

        $('#tambahIzinModal #tgl_mulai_izin').on('change', function(e) {
            const $this = $(this);
            const tglAwal = $this.val();
            const tglAkhir = $('#tambahIzinModal #tgl_akhir_izin').val();

            if(tglAkhir) {
                const tglAwalSplit = tglAwal.split('-');
                const tglAkhirSplit = tglAkhir.split('-');

                // date parse
                const tglAwalParse = new Date();
                tglAwalParse.setFullYear(tglAwalSplit[0], tglAwalSplit[1], tglAwalSplit[2]);

                const tglAkhirParse = new Date();
                tglAkhirParse.setFullYear(tglAkhirSplit[0], tglAkhirSplit[1], tglAkhirSplit[2]);

                const akhirPerioda = new Date();
                akhirPerioda.setFullYear(tglAwalSplit[0], tglAwalSplit[1], 28);

                if(tglAwalParse > akhirPerioda) {
                    $('#tambahIzinModal .bulan-pertama').hide();
                } else {
                    $('#tambahIzinModal .bulan-pertama').show();
                }

                if(tglAkhirParse > akhirPerioda) {
                    $('#tambahIzinModal .bulan-kedua').show();
                } else {
                    $('#tambahIzinModal .bulan-kedua').hide();
                }
            }
        });


        $('[data-action]').on('click', function(e) {
            const $this =$(this);
            const target = $this.attr('data-bs-target');
            const izin = $this.attr('data-izin');

            idIzin = izin;
            $(target).modal('show');
        });

        $('#deleteIzinModal').on('show.bs.modal', function(e) {
            const $this = $(this);
            $this.find('#izin_id').val(idIzin);
        });

        $('#editIzinModal').on('show.bs.modal', function(e) {
            const $this = $(this);

            $.ajax({
                url: "{{ route('admin.izin.get-edit') }}",
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    izinId: idIzin
                },
                success: function(response) {
                    if(response.error == false) {
                        const dataIzin = response.dataIzin;

                        $this.find('#izin_id').val(dataIzin.id);
                        $this.find('#nama_karyawan').val(dataIzin.karyawan.nama_lengkap);
                        $this.find('#tgl_mulai_izin').val(dataIzin.tgl_mulai_izin);
                        $this.find('#tgl_akhir_izin').val(dataIzin.tgl_akhir_izin);
                        $this.find('#keterangan').val(dataIzin.keterangan);
                        $this.find('#bulan_pertama').val(dataIzin.bulan_pertama);
                        $this.find('#bulan_kedua').val(dataIzin.bulan_kedua);

                        const baseAsset = "{{asset('storage/')}}";
                        const lampiran = dataIzin.lampiran;
                        const lampiranUrl = baseAsset +'/'+ lampiran;
                        $this.find('#lampiran_lama').attr('href', lampiranUrl);
                    }
                }
            });
        });

        // var idIzin = null;

        // $('[data-action]').on('click', function(e) {
        //     const $this = $(this);
        //     const target = $this.attr('data-bs-target');
        //     const action = $this.attr('data-action');

        //     if(action == 'tambah') {
        //         idIzin = null;
        //         $(target).modal('show');
        //     }
        // });

        // $('#izinModal').on('show.bs.modal', function(e) {
        //     const $this = $(this);

        //     if(idIzin) {

        //     } else {
        //         $this.find('.modal-title').text("Tambah {{ $jenisIzinLabel }}");
        //     }
        // });
    </script>
@endpush
