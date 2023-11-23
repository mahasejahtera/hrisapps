@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">{{ $labelStatusLembur }}</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
<style>
    .webcam-capture,
    .webcam-capture video {
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;

    }

    #map {
        height: 200px;
    }

    .jam-digital-malasngoding {

        background-color: #27272783;
        position: absolute;
        top: 65px;
        right: 10px;
        z-index: 9999;
        width: 150px;
        border-radius: 10px;
        padding: 5px;
    }



    .jam-digital-malasngoding p {
        color: #fff;
        font-size: 16px;
        text-align: left;
        margin-top: 0;
        margin-bottom: 0;
    }

</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
@endsection
@section('content')
<div class="row" style="margin-top: 60px">
    <div class="col">
        <input type="hidden" id="lokasi">
        <input type="hidden" id="foto_status" value="{{ $status }}">
        <input type="hidden" id="lembur_id" value="{{ $lembur->id }}">
        <div class="webcam-capture"></div>
    </div>
    <div class="jam-digital-malasngoding">
        <p>{{ date("d-m-Y") }}</p>
        <p id="jam"></p>
    </div>
</div>
<div class="row">
    <div class="col">
        <button id="takeabsen" class="btn btn-danger btn-block">
            <ion-icon name="camera-outline"></ion-icon>
            {{ $labelStatusLembur }}
        </button>
    </div>
</div>
<div class="row mt-2">
    <div class="col">
        <div id="map"></div>
    </div>
</div>

<audio id="notifikasi_in">
    <source src="{{ asset('assets/sound/notifikasi_in.mp3') }}" type="audio/mpeg">
</audio>
<audio id="notifikasi_out">
    <source src="{{ asset('assets/sound/notifikasi_out.mp3') }}" type="audio/mpeg">
</audio>
<audio id="radius_sound">
    <source src="{{ asset('assets/sound/radius.mp3') }}" type="audio/mpeg">
</audio>
@endsection

@push('myscript')
<script type="text/javascript">
    window.onload = function() {
        jam();
    }

    function jam() {
        var e = document.getElementById('jam')
            , d = new Date()
            , h, m, s;
        h = d.getHours();
        m = set(d.getMinutes());
        s = set(d.getSeconds());

        e.innerHTML = h + ':' + m + ':' + s;

        setTimeout('jam()', 1000);
    }

    function set(e) {
        e = e < 10 ? '0' + e : e;
        return e;
    }

</script>
<script>
    var notifikasi_in = document.getElementById('notifikasi_in');
    var notifikasi_out = document.getElementById('notifikasi_out');
    var radius_sound = document.getElementById('radius_sound');
    Webcam.set({
        height: 480
        , width: 640
        , image_format: 'jpeg'
        , jpeg_quality: 80
    });

    Webcam.attach('.webcam-capture');

    var lokasi = document.getElementById('lokasi');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position) {
        lokasi.value = position.coords.latitude + "," + position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
        var lokasi_kantor = "{{ $lok_kantor->lokasi_cabang }}";
        var lok = lokasi_kantor.split(",");
        var lat_kantor = lok[0];
        var long_kantor = lok[1];
        var radius = "{{ $lok_kantor->radius_cabang }}";
        L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20
            , subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
    }

    function errorCallback() {

    }

    $("#takeabsen").click(function(e) {
        Webcam.snap(function(uri) {
            image = uri;
        });
        var lokasi = $("#lokasi").val();
        var status = $('#foto_status').val();
        var lembur = $('#lembur_id').val();
        $.ajax({
            type: 'POST'
            , url: "{{ route('presensi.lembur.foto.store') }}"
            , data: {
                _token: "{{ csrf_token() }}"
                , image: image
                , lokasi: lokasi
                , status: status
                , lembur: lembur
            }
            , cache: false
            , success: function(respond) {
                var status = respond.split("|");
                if (status[0] == "success") {
                    notifikasi_in.play();

                    Swal.fire({
                        title: 'Berhasil !'
                        , text: status[1]
                        , icon: 'success'
                    })
                    setTimeout("location.href='/presensi/lembur'", 3000);
                } else {
                    Swal.fire({
                        title: 'Error !'
                        , text: status[1]
                        , icon: 'error'
                    })
                }
            }
        });

    });

</script>
@endpush
