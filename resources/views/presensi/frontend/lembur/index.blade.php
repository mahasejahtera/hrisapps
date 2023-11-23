@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Data Lembur</div>
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
        <div class="alert alert-warning">
            {{ $messageerror }}
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col">
        @if (count($dataLembur) > 0)
            @foreach ($dataLembur as $d)
            <a href="{{ route('presensi.lembur.detail', $d->id) }}">
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>
                                    <b>{{ tanggalBulanIndo($d->tgl_lembur) }}</b><br>
                                    <small class="text-muted">{{ $d->perihal }}</small>
                                </div>
                                @if ($d->status_approved >= 0 & $d->status_approved < 5)
                                <span class="badge bg-warning">{{ labelStatusApprovedIzin($d->status_approved) }}</span>
                                @elseif($d->status_approved==5)
                                <span class="badge bg-success">{{ labelStatusApprovedIzin($d->status_approved) }}</span>
                                @elseif($d->status_approved > 5)
                                <span class="badge bg-danger">{{ labelStatusApprovedIzin($d->status_approved) }}</span>
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
<div class="fab-button bottom-right" style="margin-bottom:70px">
    <a href="{{ route('presensi.lembur.create') }}" class="fab bg-danger">
        <ion-icon name="add-outline"></ion-icon>
    </a>
</div>
@endsection
