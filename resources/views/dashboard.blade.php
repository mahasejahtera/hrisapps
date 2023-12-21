@extends('layouts.presensi')

@section('content')

    {{-- START : HEADER --}}
    <header id="header-nav">
        <div class="employee-header-nav">
            <a href="{{ route('profil',auth()->guard('karyawan')->user()->email) }}">
                <div class="header-profile">
                    <div class="header-profile-img">
                        @if (!empty(Auth::guard('karyawan')->user()->foto))
                            <img src="{{ asset('storage/' . Auth::guard('karyawan')->user()->foto) }}" alt="default avatar">
                        @else
                            <img src="{{ asset('assets/img/nophoto.png') }}" alt="default avatar">
                        @endif
                    </div>
                    <div class="header-profile-employee">
                        <p class="profile-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</p>
                        <p class="profile-jobtitle">
                            {{ !empty(Auth::guard('karyawan')->user()->old_contract_id) ? (Auth::guard('karyawan')->user()->contract->kontrak_check == 0 ? Auth::guard('karyawan')->user()->contract->jabatan->nama_jabatan : Auth::guard('karyawan')->user()->oldContract->jabatan->nama_jabatan) : Auth::guard('karyawan')->user()->contract->jabatan->nama_jabatan }}
                        </p>
                    </div>
                </div>
            </a>

            <div class="header-icon-nav">
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn" type="button" data-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256">
                                <path
                                    d="M225.29,165.93C216.61,151,212,129.57,212,104a84,84,0,0,0-168,0c0,25.58-4.59,47-13.27,61.93A20.08,20.08,0,0,0,30.66,186,19.77,19.77,0,0,0,48,196H84.18a44,44,0,0,0,87.64,0H208a19.77,19.77,0,0,0,17.31-10A20.08,20.08,0,0,0,225.29,165.93ZM128,212a20,20,0,0,1-19.6-16h39.2A20,20,0,0,1,128,212ZM54.66,172C63.51,154,68,131.14,68,104a60,60,0,0,1,120,0c0,27.13,4.48,50,13.33,68Z">
                                </path>
                            </svg>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here Something else here</a>
                        </div>
                    </div>

                    <button type="button" data-toggle="modal" data-target="#logoutModal"
                        style="background: none; border: none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256">
                            <path
                                d="M112,216a8,8,0,0,1-8,8H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h56a8,8,0,0,1,0,16H48V208h56A8,8,0,0,1,112,216Zm109.66-93.66-40-40A8,8,0,0,0,168,88v32H104a8,8,0,0,0,0,16h64v32a8,8,0,0,0,13.66,5.66l40-40A8,8,0,0,0,221.66,122.34Z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>
    {{-- END : HEADER --}}


    {{-- START : MAIN --}}
    <main id="main-dashboard">
        {{-- START : DATA PROGRESS --}}
        @if (auth()->guard('karyawan')->user()->status == 1)
            <section class="personal-data-progress">
                <a href="{{ route('karyawan.datadiri',auth()->guard('karyawan')->user()->email) }}">
                    <p>Lengkapi data diri</p>
                    <button class="btn primary btn-block">
                        Klik disini
                    </button>
                </a>
            </section>
        @endif
        {{-- END : DATA PROGRESS --}}

        {{-- START : MENU --}}
        <section id="menu-wrapper">
            @if (auth()->guard('karyawan')->user()->status != 3)
                <div class="suspend-wrapper text-center">
                    @if (auth()->guard('karyawan')->user()->status == 2)
                        <div class="suspend-data">
                            <div class="icon-rounded-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <path
                                        d="M243.28,68.24l-24-23.56a16,16,0,0,0-22.58,0L104,136h0l-.11-.11L67.25,100.62a16,16,0,0,0-22.57.06l-24,24a16,16,0,0,0,0,22.61l71.62,72a16,16,0,0,0,22.63,0L243.33,90.91A16,16,0,0,0,243.28,68.24ZM103.62,208,32,136l24-24,.11.11,36.64,35.27a16,16,0,0,0,22.52,0L208.06,56,232,79.6Z">
                                    </path>
                                </svg>
                            </div>

                            <div class="">
                                <p>Data diri anda sudah lengkap</p>
                                <p>Tunggu admin verifikasi data kamu!!!</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            <div class="row justify-content-between">
                <div class="col-4">
                    <a href="{{ route('approval') }}" class="menu-item">
                        <div class="menu-item-icon zaitun">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256">
                                <path
                                    d="M119.76,217.94A8,8,0,0,1,112,224a8.13,8.13,0,0,1-2-.24l-32-8a8,8,0,0,1-2.5-1.11l-24-16a8,8,0,1,1,8.88-13.31l22.84,15.23,30.66,7.67A8,8,0,0,1,119.76,217.94Zm132.69-96.46a15.89,15.89,0,0,1-8,9.25l-23.68,11.84-15.08,15.09-40,40a8,8,0,0,1-7.6,2.1l-64-16a8.06,8.06,0,0,1-2.71-1.25L35.86,142.87,11.58,130.73a16,16,0,0,1-7.16-21.46L29.27,59.58h0a16,16,0,0,1,21.46-7.16l22.06,11,53-15.14a8,8,0,0,1,4.4,0l53,15.14,22.06-11a16,16,0,0,1,21.46,7.16l24.85,49.69A15.9,15.9,0,0,1,252.45,121.48ZM188,152.66l-27.71-22.19c-19.54,16-44.35,18.11-64.91,5a16,16,0,0,1-2.72-24.82.6.6,0,0,1,.08-.08L137.6,67.06,128,64.32,77.58,78.73,50.21,133.46l49.2,35.15,58.14,14.53Zm18.24-18.24L179.06,80H147.24L104,122c12.66,8.09,32.51,10.32,50.32-7.63a8,8,0,0,1,10.68-.61l34.41,27.57Z">
                                </path>
                            </svg>
                        </div>

                        <p class="menu-item-title">Approval</p>
                        @if ($approveCount > 0)
                            <div class="count-rounded">{{ $approveCount }}</div>
                        @endif
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('karyawan.presensi') }}" class="menu-item">
                        <div class="menu-item-icon success-hover">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256">
                                <path
                                    d="M128,20A108,108,0,1,0,236,128,108.12,108.12,0,0,0,128,20Zm0,192a84,84,0,1,1,84-84A84.09,84.09,0,0,1,128,212Zm68-84a12,12,0,0,1-12,12H128a12,12,0,0,1-12-12V72a12,12,0,0,1,24,0v44h44A12,12,0,0,1,196,128Z">
                                </path>
                            </svg>
                        </div>

                        <p class="menu-item-title">Absensi</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="menu-item">
                        <div class="menu-item-icon blue">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256">
                                <path
                                    d="M28,64A12,12,0,0,1,40,52H216a12,12,0,0,1,0,24H40A12,12,0,0,1,28,64Zm12,76H216a12,12,0,0,0,0-24H40a12,12,0,0,0,0,24Zm104,40H40a12,12,0,0,0,0,24H144a12,12,0,0,0,0-24Zm88,0H220V168a12,12,0,0,0-24,0v12H184a12,12,0,0,0,0,24h12v12a12,12,0,0,0,24,0V204h12a12,12,0,0,0,0-24Z">
                                </path>
                            </svg>
                        </div>

                        <p class="menu-item-title">Rencana Kerja</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="menu-item">
                        <div class="menu-item-icon primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256">
                                <path
                                    d="M216.49,79.52l-56-56A12,12,0,0,0,152,20H56A20,20,0,0,0,36,40V216a20,20,0,0,0,20,20H200a20,20,0,0,0,20-20V88A12,12,0,0,0,216.49,79.52ZM160,57l23,23H160ZM60,212V44h76V92a12,12,0,0,0,12,12h48V212Zm112-80a12,12,0,0,1-12,12H96a12,12,0,0,1,0-24h64A12,12,0,0,1,172,132Zm0,40a12,12,0,0,1-12,12H96a12,12,0,0,1,0-24h64A12,12,0,0,1,172,172Z">
                                </path>
                            </svg>
                        </div>

                        <p class="menu-item-title">Permintaan</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="menu-item">
                        <div class="menu-item-icon warning">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256">
                                <path
                                    d="M216,60H179.83A52,52,0,0,0,76.17,60H40A20,20,0,0,0,20,80V200a20,20,0,0,0,20,20H216a20,20,0,0,0,20-20V80A20,20,0,0,0,216,60ZM128,36a28,28,0,0,1,27.71,24H100.29A28,28,0,0,1,128,36Zm84,160H44V84H76V96a12,12,0,0,0,24,0V84h56V96a12,12,0,0,0,24,0V84h32Z">
                                </path>
                            </svg>
                        </div>

                        <p class="menu-item-title">Tugas</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('pengajuan.index') }}" class="menu-item">
                        <div class="menu-item-icon purple">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23 20" fill="none">
                                <path
                                    d="M11.5 7.5L6.38889 12.5H10.2222V20H12.7778V12.5H16.6111M20.4444 0H2.55556C1.13722 0 0 1.125 0 2.5V17.5C0 18.163 0.269245 18.7989 0.748505 19.2678C1.22776 19.7366 1.87778 20 2.55556 20H7.66667V17.5H2.55556V5H20.4444V17.5H15.3333V20H20.4444C21.1222 20 21.7722 19.7366 22.2515 19.2678C22.7308 18.7989 23 18.163 23 17.5V2.5C23 1.83696 22.7308 1.20107 22.2515 0.732233C21.7722 0.263392 21.1222 0 20.4444 0Z"
                                    fill="white" />
                            </svg>
                        </div>

                        <p class="menu-item-title">Pengajuan</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="menu-item">
                        <div class="menu-item-icon brown">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none " viewBox="0 0 256 256">
                                <path
                                    d="M228,56H160L133.33,36a20.12,20.12,0,0,0-12-4H76A20,20,0,0,0,56,52V72H36A20,20,0,0,0,16,92V204a20,20,0,0,0,20,20H188.89A19.13,19.13,0,0,0,208,204.89V184h20.89A19.13,19.13,0,0,0,248,164.89V76A20,20,0,0,0,228,56ZM184,200H40V96H80l26.67,20a20.12,20.12,0,0,0,12,4H184Zm40-40H208V116a20,20,0,0,0-20-20H120L93.33,76a20.12,20.12,0,0,0-12-4H80V56h40l26.67,20a20.12,20.12,0,0,0,12,4H224Z">
                                </path>
                            </svg>
                        </div>

                        <p class="menu-item-title">Arsip</p>
                    </a>
                </div>
            </div>
        </section>
        {{-- END : MENU --}}
    </main>
    {{-- END : MAIN --}}

    {{-- modal delete --}}
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin keluar dari aplikasi ?</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('karyawan.logout') }}" class="btn btn-danger">Keluar</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scriptJS')
    <script>
        const employeeStatus = {{ auth()->guard('karyawan')->user()->status }};
        // document ready
        $(document).ready(function() {

            if (employeeStatus != 3) {
                deleteHrefMenu();
            }
        });

        $('.suspend-wrapper').on('click', (e) => {
            if (employeeStatus == 2) {
                alert('Tunggu verifikasi admin...!!!');
            } else {
                alert('Silahkan Lengkapi Data Diri...!!!');
            }
        });

        // delete href menu
        function deleteHrefMenu() {
            const menus = $('.menu-item');
            const bottomMenu = $('.item');

            menus.each((i, e) => {
                $(e).attr('href', '#');

                $(e).on('click', function() {
                    if (employeeStatus == 2) {
                        alert('Tunggu verifikasi admin...!!!');
                    } else {
                        alert('Silahkan Lengkapi Data Diri...!!!');
                    }
                });
            });

            bottomMenu.each((i, e) => {
                $(e).attr('href', '#');

                $(e).on('click', function() {
                    if (employeeStatus == 2) {
                        alert('Tunggu verifikasi admin...!!!');
                    } else {
                        alert('Silahkan Lengkapi Data Diri...!!!');
                    }
                });
            });
        }
    </script>
@endsection
