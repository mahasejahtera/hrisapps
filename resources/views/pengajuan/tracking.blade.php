@extends('layouts.pengajuan')

@push('styles')
<style>
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700");

    .timeline {
        width: 100%;
        height: 696px;
        background: #ecf1f524;
        mix-blend-mode: normal;
        backdrop-filter: blur(15px);
        overflow: hidden;
        position: absolute;
        top: 144px;
        /* margin-left: 71px; */
        box-shadow: 0px 20px 53px -30px rgba(95, 102, 173, 0.566816);
        border-radius: 10px;
    }

    .timeline h3 {
        font-family: Open Sans;
        font-style: normal;
        font-weight: bold;
        font-size: 22px;
        line-height: 30px;
        color: #ffffff;
        margin-left: 66px;
        margin-top: 40px;
    }

    .timeline label {
        font-family: Open Sans;
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 22px;
        /* identical to box height */
        margin-left: 66px;
        margin-top: 10px;
        color: #ffffff;
    }

    .timeline .box {
        width: 100%;
        height: 509px;
        background: #fbfcfd;
        margin-top: 99.5px;
    }

    .timeline .box .container {
        width: 100%;
        height: 357px;
        display: flex;
    }

    .timeline .box .container .lines {
        margin-left: 20px;
        /* margin-top: 46px; */
    }

    .timeline .box .container .lines .dots {
        width: 14px;
        height: 14px;
        background: #d1d6e6;
        border-radius: 7px;
    }

    .timeline .box .container .lines .line {
        height: 103px;
        width: 2px;
        background: #d1d6e6;
        margin-left: 5.3px;
    }

    .timeline .box .container .cards {
        width: 100%;
        margin-left: 12px;
        transform: translateY(-50px);
    }

    .timeline .box .container .cards .card {
        width: 100%;
        height: 100px;
        padding-top: 25px;
        background: #ffffff;
        box-shadow: 0 2px 2px 0 #eeeeee40;
        border-radius: 10px;
        box-shadow: 0px 16px 15px -10px rgba(105, 96, 215, 0.0944602);
        margin-bottom: 10px;
    }

    .timeline .box .container .cards .card.mid {
        height: 71px;
    }

    .timeline .box .container .cards .card h4 {
        font-family: Open Sans;
        font-style: normal;
        font-weight: bold;
        font-size: 14px;
        line-height: 19px;
        margin-left: 25px;
        margin-bottom: 5px;
        color: #2b2862;
    }

    .timeline .box .container .cards .card p {
        font-family: Open Sans;
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 22px;
        color: #2b2862;
        margin-left: 25px;
    }

    .timeline .box .bottom {
        width: 100%;
        height: 107px;
        background: #fff;
        box-shadow: 0 0 2px #eeeeee50;
        padding-top: 45px;
    }

    .timeline .box .bottom .btn {
        width: 249px;
        height: 62px;
        background: #ffffff40;
        mix-blend-mode: normal;
        cursor: pointer;
        border: 1px solid #8260d780;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: Open Sans;
        font-style: normal;
        font-weight: bold;
        font-size: 14px;
        line-height: 19px;
        color: #2b2862;
        margin-left: 53px;
        transition: 0.3s;
        background: #2b2862;
        color: #fff;
        border-color: #2b2862;
    }

    .timeline .box .bottom .btn:hover {
        transform: scale(1.03);
    }

    .timeline .dots {
        width: 12px;
        height: 12px;
        border-radius: 100%;
        background: #a1a1a2;
        left: -5px;
        top: 50%;
        margin-top: -6px;
        z-index: 10;
        box-shadow: 0 0 0 3px #fff;
    }

    .activedot {
        background: green !important; 
    }
</style>
@endpush

@section('content')

{{-- START : MAIN --}}
<main id="main-dashboard">

    {{-- START : MENU --}}
    <section id="menu-wrapper">
        <div class="col-sm-12 col-lg-3">
            <div style="width: 100%; height: 100%; background: #FF0000; border-top-right-radius: 10px" class="p-2 mb-3">
                <div style="width: 100%; height: 100%; color: white; font-size: 28px; font-family: Poppins; font-weight: 700; word-wrap: break-word">Tracking Pengajuan</div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="timeline">

                <div class="box">

                    <div class="container">

                        <div class="lines">
                            <div class="dots activedot"></div>
                            <div class="line"></div>
                            <div class="dots"></div>
                            <div class="line"></div>
                            <div class="dots"></div>
                            <div class="line"></div>
                        </div>

                        <div class="cards">
                            <div class="card">

                                <h4>16:30</h4>
                                <p>Believing Is The Absence Of Doubt</p>
                            </div>
                            <div class="card">
                                <h4>15:22</h4>
                                <p>Start With A Baseline</p>
                            </div>
                            <div class="card">
                                <h4>14:15</h4>
                                <p>Break Through Self Doubt And Fear</p>
                            </div>
                        </div>



                    </div>
                </div>


            </div>
        </div>
    </section>
    {{-- END : MENU --}}
</main>
{{-- END : MAIN --}}


@endsection