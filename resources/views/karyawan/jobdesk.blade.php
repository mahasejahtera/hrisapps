@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-fluid">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Jobdesk {{ $karyawan->nama_lengkap }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    Jobdesk Karyawan

                    <button type="button" class="btn btn-success ms-3 tambah-jobdesk">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Tambah
                    </button>
                </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                            @endif

                            @if (Session::get('warning'))
                            <div class="alert alert-warning">
                                {{ Session::get('warning')}}
                            </div>
                            @endif

                            @if (Session::get('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr align="middle">
                                        <th>NO</th>
                                        <th>JOBDESK</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobdesk as $item)
                                        <tr>
                                            <td align="middle">{{ $loop->iteration }}</td>
                                            <td>{{ $item->jobdesk }}</td>
                                            <td align="middle">
                                                <button type="button" class="btn btn-primary edit-jobdesk me-2" data-jobdesk="{{ $item->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit m-0" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        <path d="M16 5l3 3"></path>
                                                     </svg>
                                                </button>
                                                <button type="button" class="btn btn-danger delete-jobdesk" data-jobdesk="{{ $item->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash m-0" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 7l16 0"></path>
                                                        <path d="M10 11l0 6"></path>
                                                        <path d="M14 11l0 6"></path>
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                     </svg>
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
    </div>


{{-- modal create jobdesk --}}
<div class="modal modal-blur fade" id="tambahJobdeskModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jobdesk Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.karyawan.jobdeskstore') }}" method="POST">
                    @csrf

                    <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-striped table-hover">     
                                <tr id="jobdesk1">
                                    <th style="vertical-align: middle">Jobdesk</th>
                                    <td>
                                        <textarea name="jobdesk[]" id="jobdesk1" placeholder="cth : Membuat program untuk perusahaan" class="form-control"></textarea>
                                    </td>
                                    <td></td>
                                </tr>
                            </table>

                            <button type="button" class="btn btn-danger add-list-jobdesk">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus m-0" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-success w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- modal edit jobdesk --}}
<div class="modal modal-blur fade" id="editJobdeskModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jobdesk Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.karyawan.jobdeskupdate') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-striped table-hover">     
                                <tr>
                                    <th style="vertical-align: middle">Jobdesk</th>
                                    <td>
                                        <textarea name="jobdesk" id="jobdesk" placeholder="cth : Membuat program untuk perusahaan" class="form-control"></textarea>
                                        <input type="hidden" name="jobdesk_id" id="jobdesk_id">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-warning w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- modal delete jobdesk --}}
<div class="modal modal-blur fade" id="deleteJobdeskModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Jobdesk Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.karyawan.jobdeskdestroy', $karyawan->email) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="row">
                        <p class="m-0">
                            Apakah anda yakin ingin menghapus jobdesk ini ?
                        </p>
                        <input type="hidden" name="jobdesk_id" id="jobdesk_id">
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-danger w-100" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 14l11 -11"></path>
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('myscript')
    <script>
        var baris = 1;

        $('.tambah-jobdesk').on('click', function(e) {
            $('#tambahJobdeskModal').modal('show');
        });

        $('#tambahJobdeskModal .add-list-jobdesk').on('click', function(e) {
            baris++;

            var html = `<tr id="jobdesk${baris}">`;
                html += `<th style="vertical-align: middle">Jobdesk</th>`;
                html += `<td>`;
                html += `<textarea name="jobdesk[]" id="jobdesk${baris}" placeholder="cth : Membuat program untuk perusahaan" class="form-control"></textarea>`;
                html += `</td>`;
                html += `<td>`;
                html += `<button type="button" class="btn btn-warning delete-jobdesk" data-target="#jobdesk${baris}">`;
                html += `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-minus m-0" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            </svg>`;
                html += `</button>`;
                html += `</td>`;
                html += `</tr>`;
            
            $('#tambahJobdeskModal table').append(html);
        });


        $(document).on('click', '#tambahJobdeskModal table .delete-jobdesk', function(e) {
            const $this = $(this);
            const target = $this.attr('data-target');
            
            $('#tambahJobdeskModal table').find(target).remove();
        });

        var jobdeskIdDel;

        $('.delete-jobdesk').on('click', function(e) {
            const $this = $(this);
            const jobdesk = $this.attr('data-jobdesk');

            jobdeskIdDel = jobdesk;
            $('#deleteJobdeskModal').modal('show');
        });

        $('#deleteJobdeskModal').on('show.bs.modal', function(e) {
            const $this = $(this);
            $this.find('#jobdesk_id').val(jobdeskIdDel);
        });


        $('.edit-jobdesk').on('click', function(e) {
            const $this = $(this);
            const jobdesk = $this.attr('data-jobdesk');

            jobdeskIdDel = jobdesk;

            $('#editJobdeskModal').modal('show');
        });

        $('#editJobdeskModal').on('show.bs.modal', function(e) {
            const $this = $(this);
            const urlPost = "{{ route('admin.karyawan.jobdeskget') }}";

            $.ajax({
                url: urlPost,
                type: "post",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    value: jobdeskIdDel,
                },
                success: function(response) {
                    const resJobdesk = response.jobdesk;

                    $this.find('#jobdesk').val(resJobdesk.jobdesk);
                    $this.find('#jobdesk_id').val(resJobdesk.id);
                }
            });
        });
    </script>
@endpush