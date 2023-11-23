@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Hari Libur
                    </h2>
                </div>
            </div>
        </div>
    </div>


    <div class="page-body">
        <div class="container">
            <div class="row">
                <div class="card">
                    <div class="card-header d-flex justify-content-end align-items-center m-2">
                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                            data-bs-target="#ambilharilibur">Ambil Data Hari Libur</button>
                        <button type="button" class="btn btn-primary ms-3" data-bs-toggle="modal"
                            data-bs-target="#harilibur">Tambah Hari Libur</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Tanggal Libur</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @if ($data->isEmpty())
                                        <tr>
                                            <td colspan="12" class="text-center">Tidak ada data dalam tanggal ini
                                                !!</td>
                                        </tr>
                                    @else
                                        @foreach ($data as $d)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $d->holidays_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($d->holidays_date)->isoFormat('D MMMM Y') }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="#" class="edit btn btn-info btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#editharilibur"
                                                            data-id = "{{ $d->id }}"
                                                            data-nama="{{ $d->holidays_name }}"
                                                            data-tanggal="{{ $d->holidays_date }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-edit" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path
                                                                    d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                                </path>
                                                                <path
                                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                                </path>
                                                                <path d="M16 5l3 3"></path>
                                                            </svg>
                                                        </a>
                                                        <form action="/presensi/hari/libur/delete/{{ $d->id }}"
                                                            method="POST" style="margin-left:5px">
                                                            @csrf
                                                            <a class="btn btn-danger btn-sm delete-confirm">
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
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif --}}
                                </tbody>
                            </table>
                            {{-- {{ $data->links('vendor.pagination.bootstrap-5') }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="harilibur" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Hari Libur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/presensi/hari/libur/proses" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" id="nama" class="form-control" name="nama" placeholder=""
                                required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Libur</label>
                            <input type="date" id="tanggal" class="form-control" name="tanggal" placeholder=""
                                required />
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

    <div class="modal" id="ambilharilibur" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Dapatkan Hari Libur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/presensi/get-holidays" method="post" enctype="multipart/form-data" id="formGetHoliday">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="number" id="tahun-libur" class="form-control" name="tahun"
                                placeholder="Contoh: 2023" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal"
                            id="submitAmbilharilibur">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
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

    <div class="modal" id="editharilibur" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Hari Libur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" id="namaa" class="form-control" name="nama" placeholder=""
                                value="" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Libur</label>
                            <input type="date" id="tanggall" class="form-control" name="tanggal" placeholder=""
                                value="" required />
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

        $(document).ready(function(e) {
            $('.table').dataTable({
                ordering: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('harilibur.datatables') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'holidays_name', name: 'holidays_name'},
                    {data: 'holidays_date', name: 'holidays_date'},
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

        $(document).on('click', '.edit', function(e) {
            const $this = $(this);
            const id = $this.attr('data-id');
            const nama = $this.attr('data-nama');
            const tanggal = $this.attr('data-tanggal');

            $('#namaa').val(nama);
            $('#tanggall').val(tanggal);
            $('#editharilibur form').attr('action', `/presensi/hari/libur/update/${id}`);
        });

        // $("#submitAmbilharilibur").click(function() {
        //     var tahun = $("#tahun-libur").val();
        //     if (tahun === "") {
        //         showError("Tahun harus Diisi!");
        //         return false;
        //     } else if (tahun.length !== 4) {
        //         showError("Tahun harus 4 digit contoh: 2023 !");
        //         return false;
        //     }
        // });

        $("#formGetHoliday").submit(function() {
            var tahun = $("#tahun-libur").val();
            if (tahun === "") {
                showError("Tahun harus Diisi!");
                return false;
            } else if (tahun.length !== 4) {
                showError("Tahun harus 4 digit contoh: 2023 !");
                return false;
            }
        });

        // document.querySelectorAll('.edit').forEach(function(button) {
        //     button.addEventListener('click', function() {
        //         var id = button.getAttribute('data-id');
        //         var nama = button.getAttribute('data-nama');
        //         var tanggal = button.getAttribute('data-tanggal');
        //         document.getElementById('namaa').value = nama;
        //         document.getElementById('tanggall').value = tanggal;
        //         document.querySelector('#editharilibur form').action = `/presensi/hari/libur/update/${id}`;
        //     });
        // });
    </script>

    <script>
        $(document).on('click', '.delete-confirm', function(e) {
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
                    Swal.fire(
                        'Deleted!', 'Data Berhasil Di Hapus', 'success'
                    )
                }
            })
        });

        $(function() {
            $("#submit").click(function() {
                var nama = $("#nama").val();
                var tanggal = $("#tanggal").val();
                if (nama === "") {
                    showError("Nama Libur harus Diisi!");
                    return false;
                } else if (tanggal === "") {
                    showError("Tanggal Libur Harus Diisi!");
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
