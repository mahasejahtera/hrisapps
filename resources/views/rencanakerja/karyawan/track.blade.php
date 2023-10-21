@extends('template.main')
@section('content')
    <style>
        body {
            background-color: #f9f9fa
        }

        @media (min-width:992px) {
            .page-container {
                max-width: 1140px;
                margin: 0 auto;

            }

            .page-sidenav {
                display: block !important
            }
        }

        .padding {
            padding: 2rem
        }

        .w-32 {
            width: 32px !important;
            height: 32px !important;
            font-size: .85em
        }

        .tl-item .avatar {
            z-index: 2
        }

        .circle {
            border-radius: 500px
        }

        .gd-warning {
            color: #fff;
            border: none;
            background: #f4c414 linear-gradient(45deg, #f4c414, #f45414)
        }

        .timeline {
            position: relative;
            border-color: rgba(160, 175, 185, .15);
            padding: 0;
            margin: 0
        }

        .p-4 {
            padding: 1.5rem !important
        }

        .block,
        .card {
            background: #fff;
            border-width: 0;
            border-radius: .25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .05);
            margin-bottom: 1.5rem
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important
        }

        .tl-item {
            border-radius: 3px;
            position: relative;
            display: -ms-flexbox;
            display: flex
        }

        .tl-item>* {
            padding: 10px
        }

        .tl-item .avatar {
            z-index: 2
        }

        .tl-item:last-child .tl-dot:after {
            display: none
        }

        .tl-item.active .tl-dot:before {
            border-color: #448bff;
            box-shadow: 0 0 0 4px rgba(68, 139, 255, .2)
        }

        .tl-item:last-child .tl-dot:after {
            display: none
        }

        .tl-item.active .tl-dot:before {
            border-color: #448bff;
            box-shadow: 0 0 0 4px rgba(68, 139, 255, .2)
        }

        .tl-dot {
            position: relative;
            border-color: rgba(160, 175, 185, .15)
        }

        .tl-dot:after,
        .tl-dot:before {
            content: '';
            position: absolute;
            border-color: inherit;
            border-width: 2px;
            border-style: solid;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            top: 15px;
            left: 50%;
            transform: translateX(-50%)
        }

        .tl-dot:after {
            width: 0;
            height: auto;
            top: 25px;
            bottom: -15px;
            border-right-width: 0;
            border-top-width: 0;
            border-bottom-width: 0;
            border-radius: 0
        }

        tl-item.active .tl-dot:before {
            border-color: #448bff;
            box-shadow: 0 0 0 4px rgba(68, 139, 255, .2)
        }

        .tl-dot {
            position: relative;
            border-color: rgba(160, 175, 185, .15)
        }

        .tl-dot:after,
        .tl-dot:before {
            content: '';
            position: absolute;
            border-color: inherit;
            border-width: 2px;
            border-style: solid;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            top: 15px;
            left: 50%;
            transform: translateX(-50%)
        }

        .tl-dot:after {
            width: 0;
            height: auto;
            top: 25px;
            bottom: -15px;
            border-right-width: 0;
            border-top-width: 0;
            border-bottom-width: 0;
            border-radius: 0
        }

        .tl-content p:last-child {
            margin-bottom: 0
        }

        .tl-date {
            font-size: .85em;
            margin-top: 2px;
            min-width: 100px;
            max-width: 100px
        }

        .avatar {
            position: relative;
            line-height: 1;
            border-radius: 500px;
            white-space: nowrap;
            font-weight: 700;
            border-radius: 100%;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: center;
            justify-content: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-negative: 0;
            flex-shrink: 0;
            border-radius: 500px;
            box-shadow: 0 5px 10px 0 rgba(50, 50, 50, .15)
        }

        .b-warning {
            border-color: #f4c414 !important;
        }

        .b-primary {
            border-color: #448bff !important;
        }

        .b-danger {
            border-color: #f54394 !important;
        }
        .b-success {
            border-color: #0ab889 !important;
        }
    </style>
    <header>
        <div class="bg-prima btn-header fix-header">
            <h2 class="text-sec pt-2 p-1">
                Tracking Rencana Kerja
            </h2>
        </div>
    </header>
    <div class="page-content page-container mt-7" id="page-content">
        <div class="padding">
            <div class="row">
                <div class="col-lg-6">
                    <div class="timeline p-4 block mb-4">
                        <div class="tl-item active">
                            <div class="tl-dot b-warning"></div>
                            <div class="tl-content">
                                <div class="">Diperiksa Oleh Manajer</div>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot b-warning"></div>
                            <div class="tl-content">
                                <div class="">Diperiksa Oleh PM</div>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot b-warning"></div>
                            <div class="tl-content">
                                <div class="">Diperiksa oleh HRD
                                </div>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot b-warning"></div>
                            <div class="tl-content">
                                <div class="">Diperiksa oleh Direktur</div>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot b-warning"></div>
                            <div class="tl-content">
                                <div class="">Diperiksa oleh Komisaris</div>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot b-success"></div>
                            <div class="tl-content">
                                <div class="">Disetujui</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
