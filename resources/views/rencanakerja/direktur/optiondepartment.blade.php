@extends('template.main')
@section('content')
    <header>
        <div class="bg-prima btn-header ">
            <h2 class="text-sec pt-2 p-1">
                Departemen
            </h2>
        </div>
    </header>
    <div class="mt-3 container-add-rkk">
        <div class="container-option">
            <a href="/direktur/du">
                <div class="badge-option">2</div>
                <div class="text-center text-dark">DU Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/direktur/scm">
                <div class="badge-option">2</div>
                <div class="text-center text-dark">SCM Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/direktur/eng">
                <div class="badge-option">7</div>
                <div class="text-center text-dark">Engineer Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/direktur/pro">
                <div class="badge-option">2</div>
                <div class="text-center text-dark">Production Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/direktur/it">
                <div class="badge-option">7</div>
                <div class="text-center text-dark">IT Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/direktur/mr">
                <div class="badge-option">2</div>
                <div class="text-center text-dark">Marketing Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/direktur/hrd">
                <div class="badge-option">7</div>
                <div class="text-center text-dark">HRD Department</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/direktur/fin">
                <div class="badge-option">2</div>
                <div class="text-center text-dark">Finance Department</div>
            </a>
        </div>
    </div>
@endsection
