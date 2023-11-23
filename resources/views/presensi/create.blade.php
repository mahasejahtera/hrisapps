@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-danger text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
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
            <div class="webcam-capture"></div>
        </div>
    </div>
    <div class="jam-digital-malasngoding">
        <p>{{ date('d-m-Y') }}</p>
        <p id="jam"></p>
        <p>{{ $jamkerja->nama_jam_kerja }}</p>
        <p>Mulai : {{ date('H:i', strtotime($jamkerja->awal_jam_masuk)) }}</p>
        <p>Masuk : {{ date('H:i', strtotime($jamkerja->jam_masuk)) }}</p>
        <p>Akhir : {{ date('H:i', strtotime($jamkerja->akhir_jam_masuk)) }}</p>
        <p>Pulang : {{ date('H:i', strtotime($jamkerja->jam_pulang)) }}</p>
    </div>
    <div class="row">
        <div class="col">
            @if ($cek > 0)
                <button id="takeabsen" class="btn btn-danger btn-block">
                    <ion-icon name="camera-outline"></ion-icon>
                    Absen Pulang
                </button>
            @else
                <button id="takeabsen" class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline"></ion-icon>
                    Absen Masuk
                </button>
            @endif

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
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
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

        var lattitudeKaryawan;
        var longitudeKaryawan;

        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80
        });

        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lattitudeKaryawan = position.coords.latitude;
            longitudeKaryawan = position.coords.longitude;

            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
            var lokasi_kantor = "{{ $lok_kantor->lokasi_cabang }}";
            var lok = lokasi_kantor.split(",");
            var lat_kantor = lok[0];
            var long_kantor = lok[1];
            var radius = "{{ $lok_kantor->radius_cabang }}";
            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([lat_kantor, long_kantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
        }

        function errorCallback() {

        }

        $("#takeabsen").click(function(e) {
            const cekAbsenLokasi = cekAbsenZona(longitudeKaryawan, lattitudeKaryawan);

            Webcam.snap(function(uri) {
                image = uri;
            });
            var lokasi = $("#lokasi").val();
            $.ajax({
                type: 'POST',
                url: '/presensi/store',
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi,
                    inZone: cekAbsenLokasi,
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split("|");
                    if (status[0] == "success") {
                        if (status[2] == "in") {
                            notifikasi_in.play();
                        } else {
                            notifikasi_out.play();
                        }
                        Swal.fire({
                            title: 'Berhasil !',
                            text: status[1],
                            icon: 'success'
                        })
                        setTimeout("location.href='/presensi'", 3000);
                    } else if (status[0] == "warning") {
                        Swal.fire({
                            title: 'Warning !',
                            text: status[1],
                            icon: 'warning'
                        })

                        $('.swal2-confirm').on('click', function(e) {
                            location.href = '/presensi';
                        });

                    } else {
                        if (status[2] == "radius") {
                            radius_sound.play();
                        }
                        Swal.fire({
                            title: 'Error !',
                            text: status[1],
                            icon: 'error'
                        })
                    }
                }
            });

        });


        function cekAbsenZona(long, lat) {
            var yourGeoJSONdata = {
                "type": "FeatureCollection",
                "features": [{
                    "type": "Feature",
                    "properties": {},
                    "geometry": {
                        "type": "Polygon",
                        "coordinates": [
                            [
                                [98.67110546031267, 3.909657043813212],
                                [98.58034971825464, 3.8088517763317498],
                                [98.50892839971843, 3.7205169445431707],
                                [98.4964945994072, 3.6594437778965094],
                                [98.52344278427933, 3.614258845616277],
                                [98.51682486054975, 3.571376335920789],
                                [98.4820355206856, 3.532993722236725],
                                [98.48019656691321, 3.237785812262686],
                                [98.58500217102042, 3.239903342369397],
                                [98.58041557109566, 3.059238129003976],
                                [98.73364788650477, 3.0480624636664526],
                                [98.78199834866066, 3.226903893202227],
                                [98.83077718110829, 3.397642738846061],
                                [98.95730069149876, 3.55267274419354],
                                [98.96730387704062, 3.6607852091844872],
                                [98.95487545381907, 3.677607315342679],
                                [98.90970667044218, 3.6770638639066817],
                                [98.81302073739158, 3.715540496376832],
                                [98.76890173033507, 3.7367240450422656],
                                [98.7611617169324, 3.7560141363800312],
                                [98.7505503419473, 3.7620251678395675],
                                [98.73189095532132, 3.7650913912767123],
                                [98.71948763254011, 3.7719862167950424],
                                [98.72625179738682, 3.8001973409623275],
                                [98.70977979911896, 3.805944622453282],
                                [98.69969938163877, 3.850926979118114],
                                [98.69420069733002, 3.890317581872644],
                                [98.67100477239148, 3.909706084664066],
                                [98.67110546031267, 3.909657043813212]
                            ]
                        ]
                    }
                }]
            };
            // L.geoJSON(yourGeoJSONdata).addTo(map);
            var pointToCheck = {
                latitude: lat,
                longitude: long,
            };
            var polygon = turf.polygon([yourGeoJSONdata.features[0].geometry.coordinates[0]]);
            var isInside = turf.booleanPointInPolygon([pointToCheck.longitude, pointToCheck.latitude], polygon);
            return isInside;
        }
    </script>
@endpush
