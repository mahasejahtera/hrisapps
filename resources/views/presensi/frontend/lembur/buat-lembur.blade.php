@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal {
        max-height: 430px !important;
    }

    .datepicker-date-display {
        background-color: #0f3a7e !important;
    }
</style>
<!-- App Header -->
<div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Lembur</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        @php
        $messagesuccess = Session::get('success');
        $messageerror = Session::get('error');
        @endphp
        @if (Session::get('success'))
        <div class="alert alert-success">
            {{ $messagesuccess }}
        </div>
        @endif
        @if (Session::get('error'))
        <div class="alert alert-danger">
            {{ $messageerror }}
        </div>
        @endif
    </div>
</div>
<div class="row px-2 form-lembur-wrapper">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('presensi.lembur.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="tgl_lembur">Tanggal Lembur</label>
                        <input type="text" class="form-control datepicker @error('tgl_lembur') is-invalid @enderror" name="tgl_lembur" id="tgl_lembur">
                        @error('tgl_lembur')
                            <div class="is-invalid-feedback text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai</label>
                        <select name="jam_mulai" id="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror">
                            <option value="">--Pilih Jam Mulai--</option>
                            @for ($i = 0; $i <= 24; $i++)
                                @if ($i != 18 && $i != 19)
                                    <option value="{{ sprintf('%02s', $i) }}:00">{{ sprintf('%02s', $i) }}:00</option>
                                @endif
                            @endfor
                        </select>
                        @error('jam_mulai')
                            <div class="is-invalid-feedback text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jam_selesai">Jam Selesai</label>
                        <select name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror">
                            <option value="">--Pilih Jam Selesai--</option>
                            @for ($i = 0; $i <= 24; $i++)
                                @if ($i != 18 && $i != 19)
                                    <option value="{{ sprintf('%02s', $i) }}:00">{{ sprintf('%02s', $i) }}:00</option>
                                @endif
                            @endfor
                        </select>
                        @error('jam_selesai')
                            <div class="is-invalid-feedback text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="perihal">Perihal</label>
                        <input type="text" name="perihal" id="perihal" class="form-control @error('perihal') is-invalid @enderror">
                        @error('perihal')
                            <div class="is-invalid-feedback text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="5"></textarea>
                        @error('keterangan')
                            <div class="is-invalid-feedback text-danger">
                                <small>{{ $message }}</small>
                            </div>
                        @enderror
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function(e) {
            // datepicker
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd",
                minDate: new Date()
            });
        });
    </script>
@endpush
