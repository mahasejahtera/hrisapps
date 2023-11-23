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
    <div class="pageTitle">Form Izin</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<div class="row mx-3" style="margin-top:70px">
    <div class="col">

        <div class="form-group">
            <select id="statusIzin" class="form-control">
                <option value="">-- Jenis Izin --</option>
                <option value="i" @selected(old('status') == 'i')>Izin</option>
                <option value="s" @selected(old('status') == 's')>Sakit</option>
                <option value="c" @selected(old('status') == 'c')>Cuti</option>
            </select>
        </div>

        <form method="POST" action="/presensi/storeizin" id="frmIzin" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="status">

            <div class="form-group jenis-izin">
                <select id="jenis_izin_id" name="jenis_izin_id" class="form-control">
                    <option value="">-- Pilih Jenis --</option>
                </select>
            </div>

            <div class="form-group tgl-mulai">
                <input type="text" id="tgl_mulai_izin" name="tgl_mulai_izin" class="form-control datepicker @error('tgl_mulai_izin') is-invalid @enderror" placeholder="Tanggal Awal" value="{{ old('tgl_mulai_izin') }}">
                @error('tgl_mulai_izin')
                    <div class="is-invalid-feedback text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="form-group tgl-akhir">
                <input type="text" id="tgl_akhir_izin" name="tgl_akhir_izin" class="form-control datepicker @error('tgl_akhir_izin') is-invalid @enderror" placeholder="Tanggal Akhir" value="{{ old('tgl_akhir_izin') }}">
                @error('tgl_akhir_izin')
                    <div class="is-invalid-feedback text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="form-group jam-mulai">
                <input type="text" id="jam_mulai" name="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" placeholder="Jam Awal" onfocus="(this.type='time')" onblur="(this.type='text')" value="{{ old('jam_mulai') }}">
                @error('jam_mulai')
                    <div class="is-invalid-feedback text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="form-group jam-akhir">
                <input type="text" id="jam_akhir" name="jam_akhir" class="form-control @error('jam_akhir') is-invalid @enderror" placeholder="Jam Akhir" onfocus="(this.type='time')" onblur="(this.type='text')" value="{{ old('jam_akhir') }}">
                @error('jam_akhir')
                    <div class="is-invalid-feedback text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>

            <div class="form-group keterangan">
                <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control @error('status') is-invalid @enderror" placeholder="Keterangan">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="is-invalid-feedback text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            {{-- <div class="form-group bulan-pertama">
                <input type="number" name="bulan_pertama" id="bulan_pertama" placeholder="Jumlah Hari Kerja Bulan Pertama" class="form-control">
            </div>
            <div class="form-group bulan-kedua">
                <input type="number" name="bulan_kedua" id="bulan_kedua" placeholder="Jumlah Hari Kerja Bulan Kedua" class="form-control">
            </div> --}}
            <div class="form-group lampiran">
                <div class="input-group">
                    <div class="custom-file mr-3">
                        <input type="file" class="custom-file-input @error('lampiran') is-invalid @enderror" name="lampiran" id="lampiran" aria-describedby="inputGroupLampiran">
                        <label class="custom-file-label" for="lampiran">Lampiran</label>
                    </div>
                </div>
                @error('lampiran')
                    <div class="is-invalid-feedback text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-danger w-100">Ajukan</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();
    // set date picker 14 hari
    const minDateCuti = new Date(new Date().getTime() + (13 * 24 * 60 * 60 * 1000));

    $(document).ready(function() {

        // old form
        const oldStatus = "{{ old('status') }}";

        if(oldStatus != '') {
            if(oldStatus == 'i' || oldStatus == 's') {
                if(oldStatus == 's') {
                    $('#frmIzin .lampiran label').text('Lampiran');
                } else {
                    $('#frmIzin .lampiran label').text('Lampiran (Optional)');
                }

                $('#frmIzin').show();
            }
        } else {
            // hide form
            $('#frmIzin .lampiran label').text('Lampiran (Optional)');
            $('#frmIzin').hide();
        }

        $(".datepicker").datepicker({
            format: "yyyy-mm-dd",
            minDate: new Date()
        });

        $("#tgl_izin").change(function(e) {
            var tgl_izin = $(this).val();
            $.ajax({
                type: 'POST'
                , url: '/presensi/cekpengajuanizin'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , tgl_izin: tgl_izin
                }
                , cache: false
                , success: function(respond) {
                    if (respond == 1) {
                        Swal.fire({
                            title: 'Oops !'
                            , text: 'Anda Sudah Melakukan Input Pengjuan Izin Pada Tanggal Tersebut !'
                            , icon: 'warning'
                        }).then((result) => {
                            $("#tgl_izin").val("");
                        });
                    }
                }
            });
        });

        // $("#frmIzin").submit(function() {
        //     var tgl_izin = $("#tgl_izin").val();
        //     var status = $("#status").val();
        //     var keterangan = $("#keterangan").val();
        //     if (tgl_izin == "") {
        //         Swal.fire({
        //             title: 'Oops !'
        //             , text: 'Tanggal Harus Diisi'
        //             , icon: 'warning'
        //         });
        //         return false;
        //     } else if (status == "") {
        //         Swal.fire({
        //             title: 'Oops !'
        //             , text: 'Status Harus Diisi'
        //             , icon: 'warning'
        //         });
        //         return false;
        //     } else if (keterangan == "") {
        //         Swal.fire({
        //             title: 'Oops !'
        //             , text: 'Ketereangan Harus Diisi'
        //             , icon: 'warning'
        //         });
        //         return false;
        //     }
        // });
    });

    $('#frmIzin').on('submit', function(e)
    {
        const $this = $(this);
        const statusIzin = $('#statusIzin').val();

        if(statusIzin == 'i') {
            const jenisIZin = $this.find('#jenis_izin_id').val();

            // kalau izin meninggalkan jam kerja max 4 jam
            if(jenisIZin == 10) {
                const jamMulai = $this.find('#jam_mulai').val();
                const jamAkhir = $this.find('#jam_akhir').val();

                var jamMulaiSplit = jamMulai.split(':');
                var jamAkhirSplit = jamAkhir.split(':');

                var selisihJam = jamAkhirSplit[0] - jamMulaiSplit[0];
                var selisihMenit = Number(jamAkhirSplit[1]) + Number(jamMulaiSplit[1]);
                var selisihMenitKeJam = selisihMenit / 60;
                var selisih = selisihJam + selisihMenitKeJam;

                if(selisih > 4) {
                    Swal.fire({
                        title: 'Warning !'
                        , text: 'Izin tidak boleh lebih dari 4 jam!!!'
                        , icon: 'warning'
                    });
                    return false;
                } else {
                    $this.find('button[type=submit]').trigger('click');
                }
            }
        } else {
        }

    });


    // status izin change
    $('#statusIzin').on('change', function(e) {
        const $this = $(this);
        const value = $this.val();

        $('#frmIzin .tgl-mulai input').attr('placeholder', 'Tanggal Awal');

        if(value != '') {
            if(value == 'c') {
                $('#frmIzin .lampiran label').text('Lampiran (Optional)');

                $.ajax({
                    type: "POST",
                    url: "{{ route('presensi.izin.getjenis') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        jenis: value
                    },
                    success: function (response) {
                        const jenis = response.optJenis;
                        $('#frmIzin #jenis_izin_id').html(jenis);
                        // show form
                        $('#frmIzin input[name="status"]').val(value);
                        $('#frmIzin').show();
                        $('#frmIzin .jenis-izin').show();
                        $('#frmIzin .tgl-mulai, .tgl-akhir, .jam-mulai, .jam-akhir, .keterangan, .lampiran').hide();
                    }
                });
            } else if(value == 'i') {
                $('#frmIzin .lampiran label').text('Lampiran (Optional)');

                $.ajax({
                    type: "POST",
                    url: "{{ route('presensi.izin.getjenis') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        jenis: value
                    },
                    success: function (response) {
                        const jenis = response.optJenis;
                        $('#frmIzin #jenis_izin_id').html(jenis);
                        // show form
                        $('#frmIzin input[name="status"]').val(value);
                        $('#frmIzin').show();
                        $('#frmIzin .jenis-izin').show();
                        $('#frmIzin .tgl-mulai, .tgl-akhir, .jam-mulai, .jam-akhir, .keterangan, .lampiran').hide();
                    }
                });

                // $('#frmIzin input[name="status"]').val(value);
                // $('#frmIzin').show();
                // $('#frmIzin .jam-mulai, .jam-akhir, .jenis-izin').show();
                // $('#frmIzin .jenis-izin, .tgl-mulai, .tgl-akhir').hide();
            } else {
                $('#frmIzin .lampiran label').text('Lampiran');

                $(".datepicker").datepicker({
                    format: "yyyy-mm-dd"
                });

                // show form
                $('#frmIzin input[name="status"]').val(value);
                $('#frmIzin').show();
                $('#frmIzin .jenis-izin, .jam-mulai, .jam-akhir').hide();
                $('#frmIzin .tgl-mulai, .tgl-akhir, .keterangan, .lampiran').show();
            }
        } else {
            // hide form
            // $('#frmIzin').hide();
        }
    })

    // jenis change
    $('#jenis_izin_id').on('change', function(e) {
        const $this = $(this);
        const value = $this.val();

        if(value != 1) {
            if(value == 10) {
                $('#frmIzin .tgl-mulai, .tgl-akhir').hide();
                $('#frmIzin .jam-mulai, .jam-akhir, .keterangan, .lampiran').show();
            } else {
                if(value == 11) {
                    $('#frmIzin .tgl-mulai input').attr('placeholder', 'Tanggal Izin');
                } else {
                    $('#frmIzin .tgl-mulai input').attr('placeholder', 'Tanggal Awal');
                }

                $('#frmIzin .tgl-akhir, .jam-mulai, .jam-akhir').hide();
                $('#frmIzin .tgl-mulai, .keterangan, .lampiran').show();

                // cuti haji
                if(value == 9) {
                    // set date picker 30 hari
                    const minDateCutiHaji = new Date(new Date().getTime() + (29 * 24 * 60 * 60 * 1000));

                    $(".datepicker").datepicker({
                        format: "yyyy-mm-dd",
                        minDate: minDateCutiHaji
                    });
                } else {
                    $(".datepicker").datepicker({
                        format: "yyyy-mm-dd",
                        minDate: new Date()
                    });
                }
            }

        } else {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd",
                minDate: minDateCuti
            });

            $('#frmIzin .jam-mulai, .jam-akhir').hide();
            $('#frmIzin .tgl-mulai, .tgl-akhir, .keterangan, .lampiran').show();

            $('#tgl_mulai_izin').on('change', function(e){
                const $this = $(this);
                const value = $this.val();

                const maxDateCuti = new Date(new Date(value).getTime() + (1 * 24 * 60 * 60 * 1000));

                $("#tgl_akhir_izin").datepicker({
                    format: "yyyy-mm-dd",
                    minDate: new Date(value),
                    maxDate: maxDateCuti
                });
            });
        }
    });

    // set text file name
    $('input[type="file"]').on('change', function() {
        const $this = $(this);
        const value = $this.val();

        const fileName = value.split('\\');

        $this.siblings().text(fileName[2]);
    });

</script>
@endpush
