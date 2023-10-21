@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                Departemen
            </h2>
        </div>
    </header>
    <div class="mt-3">
        <div class="container-option">
            <a href="/pm/listrkk/eng">
                <div class="badge-option">{{ $jmleng }}</div>
                <div class="text-center text-dark">Engineering Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/pm/listrkk/pro">
                <div class="badge-option">{{ $jmlpro }}</div>
                <div class="text-center text-dark">Production Department</div>
            </a>
        </div>
    </div>
@endsection
