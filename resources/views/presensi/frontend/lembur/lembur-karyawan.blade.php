@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Data Lembur Karyawan</div>
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
<div class="row">
    <div class="col">
        @if (count($dataLemburKaryawan) > 0)
            @foreach ($dataLemburKaryawan as $d)
            <a href="{{ route('presensi.lembur.detail', $d->id_lb) }}">
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>
                                    <h3 class="employee-name">{{ $d->nama_lengkap }}</h3>
                                    <b>{{ tanggalBulanIndo($d->tgl_lembur) }}</b>
                                    <br>
                                    <small>{{ $d->perihal }}</small>
                                </div>
                                @if ($d->status_approved == $kodeStatusApproved && $d->is_read == 0)
                                    <span class="badge bg-success">Baru</span>
                                @elseif ($d->status_approved == $kodeStatusApproved && $d->is_read == 1)
                                    <span class="badge bg-warning">Dilihat</span>
                                @else
                                    <span class="badge {{ ($d->status_approved == 5) ? 'bg-primary' : (($d->status_approved > 5) ? 'bg-danger' : 'bg-secondary') }}">{{ labelStatusApprovedIzin($d->status_approved) }}</span>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            </a>
            @endforeach
        @else
        <div class="text-center">
            <img class="img-list-empty" src="{{ asset('assets/img/izin-blank.png') }}" alt="">
        </div>
        @endif

    </div>
</div>
@endsection
