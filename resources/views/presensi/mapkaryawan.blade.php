@extends('layouts.admin.tabler')
@section('content')
    <style>
        #map {
            height: 1000px;
        }
    </style>
    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        function showMap(latitude, longitude) {
            var map = L.map('map').setView([latitude, longitude], 18);
            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 22,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);
            var redIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-shadow.png',
                iconSize: [35, 55],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var marker = L.marker([latitude, longitude], {
                icon: redIcon
            }).addTo(map);
        }

        var lokasi_kantor = "{{ $data->lokasi_in }}";
        var lok = lokasi_kantor.split(",");
        var lat_kantor = parseFloat(lok[0]);
        var long_kantor = parseFloat(lok[1]);
        showMap(lat_kantor, long_kantor);
    </script>
@endpush
