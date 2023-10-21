@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Departemen
            </h2>
        </div>
    </header>
    <div class="container-add-rkk">
        <div class="mt-3">
            <div class="container-option">
                <a href="/manajer/hrd/scm">
                    <div class="badge-option">{{ $counts['SC'] }}</div>
                    <div class="text-center text-dark">SCM Department</div>
                </a>
            </div>
            <div class="container-option">
                <a href="/manajer/hrd/pm">
                    <div class="badge-option">{{ $counts['GM'] }}</div>
                    <div class="text-center text-dark">Project Manager</div>
                </a>
            </div>
            <div class="container-option">
                <a href="/manajer/hrd/eng">
                    <div class="badge-option">{{ $counts['TK'] }}</div>
                    <div class="text-center text-dark">Engineer Department</div>
                </a>
            </div>
            <div class="container-option">
                <a href="/manajer/hrd/pro">
                    <div class="badge-option">{{ $counts['PR'] }}</div>
                    <div class="text-center text-dark">Production Department</div>
                </a>
            </div>
            <div class="container-option">
                <a href="/manajer/hrd/it">
                    <div class="badge-option">{{ $counts['IT'] }}</div>
                    <div class="text-center text-dark">IT Department</div>
                </a>
            </div>
            <div class="container-option">
                <a href="/manajer/hrd/mr">
                    <div class="badge-option">{{ $counts['PN'] }}</div>
                    <div class="text-center text-dark">Marketing Department</div>
                </a>
            </div>
            <div class="container-option">
                <a href="/manajer/hrd/hrd">
                    <div class="badge-option">{{ $counts['HR'] }}</div>
                    <div class="text-center text-dark">HRD Department</div>
                </a>
            </div>
            <div class="container-option">
                <a href="/manajer/hrd/fin">
                    <div class="badge-option">{{ $counts['KU'] }}</div>
                    <div class="text-center text-dark">Finance Department</div>
                </a>
            </div>
        </div>
    </div>
@endsection
