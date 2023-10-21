@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                Departemen
            </h2>
        </div>
    </header>
    <div class="mt-3 container-add-rkk">
        <div class="container-option">
            <a href="/komisaris/du">
                <div class="badge-option">{{ $counts['DU'] }}</div>
                <div class="text-center text-dark">DU Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/komisaris/scm">
                <div class="badge-option">{{ $counts['SC'] }}</div>
                <div class="text-center text-dark">SCM Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/komisaris/eng">
                <div class="badge-option">{{ $counts['TK'] }}</div>
                <div class="text-center text-dark">Engineer Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/komisaris/pro">
                <div class="badge-option">{{ $counts['PR'] }}</div>
                <div class="text-center text-dark">Production Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/komisaris/it">
                <div class="badge-option">{{ $counts['IT'] }}</div>
                <div class="text-center text-dark">IT Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/komisaris/mr">
                <div class="badge-option">{{ $counts['PN'] }}</div>
                <div class="text-center text-dark">Marketing Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/komisaris/hrd">
                <div class="badge-option">{{ $counts['HR'] }}</div>
                <div class="text-center text-dark">HRD Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/komisaris/fin">
                <div class="badge-option">{{ $counts['KU'] }}</div>
                <div class="text-center text-dark">Finance Department</div>
            </a>
        </div>
    </div>
@endsection
