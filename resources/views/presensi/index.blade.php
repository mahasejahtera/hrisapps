@extends('layouts.presensi')
@section('content')
<style>
    .logout {
        position: absolute;
        color: white;
        font-size: 30px;
        text-decoration: none;
        right: 8px;
    }

    .logout:hover {
        color: white;

    }

</style>
<div class="section" id="user-section">
    <p>Absensi</p>
</div>

<div class="section" id="presence-section">
    <div class="todaypresence">
        <div class="row">

            <div class="col-6">
                <a href="{{ route('presensi.create') }}" class="card gradasigreen">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                <ion-icon name="camera" class="text-white"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Masuk</h4>
                                <span class="text-white text-nowrap">{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen' }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('presensi.create') }}" class="card gradasired">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                <ion-icon name="camera" class="text-white"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Pulang</h4>
                                <span class="text-white text-nowrap">{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : 'Belum Absen' }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div id="rekappresensi">
        <h3>Rekap Presensi Bulan {{ bulanIndo(date('m')) }} Tahun {{ date('Y') }}</h3>
        <div class="row justify-content-center">
            <div class="col-3">
                <a href="{{ route('presensi.histori') }}" class="text-dark">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999">{{ $rekappresensi->jmlhadir }}</span>
                            <ion-icon name="accessibility-outline" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Hadir</span>
                        </div>
                    </div>
                </a>
            </div>
            @php
                $jabatanCurrentUser = auth()->guard('karyawan')->user()->contract->jabatan->id;
                $cabangCurrentUser = auth()->guard('karyawan')->user()->contract->cabang->id ? auth()->guard('karyawan')->user()->contract->cabang->id : 0;
            @endphp
            @if ($jabatanCurrentUser != 8 && $jabatanCurrentUser != 11 && $jabatanCurrentUser != 16 && $jabatanCurrentUser != 21 && $jabatanCurrentUser != 27 && $jabatanCurrentUser != 34 && $jabatanCurrentUser != 41 && $jabatanCurrentUser != 48)
                {{-- cek cabang --}}
                @if ($cabangCurrentUser == 1 || $cabangCurrentUser == 2)
                    <div class="col-3">
                        <a href="{{ route('presensi.lembur') }}" class="text-dark">
                            <div class="card">
                                <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                                    <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999">{{ $rekapizin->jmlizin }}</span>
                                    <ion-icon name="newspaper-outline" style="font-size: 1.6rem;" class="text-success mb-1"></ion-icon>
                                    <br>
                                    <span style="font-size: 0.8rem; font-weight:500">Lembur</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endif

            <div class="col-3">
                <a href="{{ route('presensi.izin') }}" class="text-dark">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999">{{$rekapizin->jmlsakit}}</span>
                            {{-- <ion-icon name="medkit-outline" style="font-size: 1.6rem;" class="text-warning mb-1"></ion-icon> --}}
                            <ion-icon name="paper-plane-outline" style="font-size: 1.6rem;" class="text-warning mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Izin</span>
                        </div>
                    </div>
                </a>
            </div>
            {{-- <div class="col-3">
                <a href="#"  class="text-dark">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999">{{ $rekappresensi->jmlterlambat }}</span>
                            <ion-icon name="alarm-outline" style="font-size: 1.6rem;" class="text-danger mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:500">Telat</span>
                        </div>
                    </div>
                </a>
            </div> --}}
        </div>
    </div>
    <div class="presencetab mt-2">
        {{-- <div class="tab-pane fade show active" id="pilled" role="tabpanel">
            <ul class="nav nav-tabs style1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                        Bulan Ini
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                        Leaderboard
                    </a>
                </li>
            </ul>
        </div> --}}
        <div class="tab-content mt-2" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <!--
                <ul class="listview image-listview">
                    @foreach ($historibulanini as $d)
                    @php
                    $path = Storage::url('uploads/absensi/'.$d->foto_in);
                    @endphp
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="finger-print-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>{{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</div>
                                <span class="badge badge-success">{{ $d->jam_in }}</span>
                                <span class="badge badge-danger">{{ $presensihariini != null && $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            -->
                <style>
                    .historicontent {
                        display: flex;
                    }

                    .datapresensi {
                        margin-left: 10px;
                    }

                </style>
                @foreach ($historibulanini as $d)
                <div class="card {{ ($d->absen_in_status == 0 || $d->absen_in_status == 4) ? 'bg-secondary' : '' }} {{ ($d->absen_out_status == 0 || $d->absen_out_status == 4) ? 'bg-warning' : '' }}">
                    <div class="card-body">
                        <div class="historicontent">
                            <div class="iconpresensi">
                                @if ($d->status_absen == 1)
                                    <img src="{{ asset('storage/uploads/absensi/' . $d->foto_in) }}" alt="" width="50">
                                @else
                                    <ion-icon name="finger-print-outline" style="font-size: 48px;" class="text-success"></ion-icon>
                                @endif
                            </div>
                            <div class="datapresensi">
                                <h3 style="line-height: 3px">{{ $d->nama_jam_kerja }}</h3>
                                <h4 style="margin:0px !important">{{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</h4>
                                <span>
                                    {!! $d->jam_in != null ? date("H:i",strtotime($d->jam_in)) : '<span class="text-danger">Belum Scan</span>' !!}
                                </span>
                                <span>
                                    @if ($d->status == 6)
                                        <span class="text-danger">{{ '-' . date("H:i",strtotime($d->jam_out)) }}</span>
                                    @else
                                        {!! $d->jam_out != null ? "-". date("H:i",strtotime($d->jam_out)) : '<span class="text-danger">- Belum Scan</span>' !!}
                                    @endif
                                </span>
                                <br>
                                @php
                                //Jam Ketika dia Absen
                                $jam_in = date("H:i",strtotime($d->jam_in));

                                //Jam Jadwal Masuk
                                $jam_masuk = date("H:i",strtotime($d->jam_masuk));

                                $jadwal_jam_masuk = $d->tgl_presensi." ".$jam_masuk;
                                $jam_presensi = $d->tgl_presensi." ".$jam_in;
                                @endphp
                                @if ($jam_in > $jam_masuk)
                                @php
                                $jmlterlambat = hitungjamterlambat($jadwal_jam_masuk,$jam_presensi);
                                $jmlterlambatdesimal = hitungjamterlambatdesimal($jadwal_jam_masuk,$jam_presensi);
                                @endphp
                                <span class="danger">Terlambat {{ $jmlterlambatdesimal }} Menit</span>
                                @else
                                <span style="color:green">Tepat Waktu</span>
                                @endif

                                @if ($d->status == 0)
                                    <p class="text-danger m-0">Absen masuk menunggu approve</p>
                                @endif
                                @if ($d->status == 5)
                                    <p class="text-danger m-0">Absen pulang menunggu approve</p>
                                @endif
                                @if ($d->status == 4)
                                    <p class="text-danger m-0">Absen ditolak</p>
                                @endif
                                @if ($d->status == 6)
                                    <p class="text-white m-0">Absen pulang ditolak</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <ul class="listview image-listview">
                    @foreach ($leaderboard as $d)
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    <b>{{ $d->nama_lengkap }}</b><br>
                                    <small class="text-muted">{{ $d->jabatan }}</small>
                                </div>
                                <span class="badge {{ $d->jam_in < "07:00" ? "bg-success" : "bg-danger" }}">
                                    {{ $d->jam_in }}
                                </span>
                            </div>
                        </div>
                    </li>

                    @endforeach

                </ul>
            </div>

        </div>
    </div>
</div>
@endsection