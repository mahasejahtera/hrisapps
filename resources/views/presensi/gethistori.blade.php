@if ($histori->isEmpty())
<div class="alert  alert-outline-warning">
    <p>Data Belum Aada</p>
</div>
@endif

<table class="table table-bordered table-striped">
    <tr align="middle">
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Pulang</th>
    </tr>
    @foreach ($histori as $d)
        <tr align="middle">
            <td>
                {{ date("d-m-Y",strtotime($d->tgl_presensi)) }}
            </td>
            <td>
                <span class="badge {{ $d->jam_in <= "08:00" ? "bg-success" : "bg-danger" }}">
                    {{ $d->jam_in }}
                </span>
            </td>
            <td>
                <span class="badge {{ $d->jam_out < "17:00" ? "bg-danger" : "bg-primary" }}">{{ $d->jam_out }}</span>
            </td>
        </tr>
    {{-- <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                $path = Storage::url('uploads/absensi/'.$d->foto_in);
                @endphp
                <img src="{{ url($path) }}" alt="image" class="image">
                <div class="in">
                    <div>
                        <b>{{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</b><br>
                    </div>
                    <span class="badge {{ $d->jam_in < "07:00" ? "bg-success" : "bg-danger" }}">
                        {{ $d->jam_in }}
                    </span>
                    <span class="badge bg-primary">{{ $d->jam_out }}</span>
                </div>
            </div>
        </li>
    </ul> --}}
    @endforeach
</table>
