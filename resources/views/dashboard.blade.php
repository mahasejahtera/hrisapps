@extends('layouts.main')

@section('content')

    {{-- START : HEADER --}}
    <header id="header-nav">
        <div class="employee-header-nav">
            <a href="{{ route('profil', auth()->guard('karyawan')->user()->email) }}">
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
                            {{ (!empty(Auth::guard('karyawan')->user()->old_contract_id)) ? ((Auth::guard('karyawan')->user()->contract->kontrak_check == 0) ? Auth::guard('karyawan')->user()->contract->jabatan->nama_jabatan : Auth::guard('karyawan')->user()->oldContract->jabatan->nama_jabatan) : Auth::guard('karyawan')->user()->contract->jabatan->nama_jabatan }}
                        </p>
                    </div>
                </div>
            </a>

            <div class="header-icon-nav">
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn" type="button" data-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256"><path d="M225.29,165.93C216.61,151,212,129.57,212,104a84,84,0,0,0-168,0c0,25.58-4.59,47-13.27,61.93A20.08,20.08,0,0,0,30.66,186,19.77,19.77,0,0,0,48,196H84.18a44,44,0,0,0,87.64,0H208a19.77,19.77,0,0,0,17.31-10A20.08,20.08,0,0,0,225.29,165.93ZM128,212a20,20,0,0,1-19.6-16h39.2A20,20,0,0,1,128,212ZM54.66,172C63.51,154,68,131.14,68,104a60,60,0,0,1,120,0c0,27.13,4.48,50,13.33,68Z"></path></svg>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here Something else here</a>
                        </div>
                    </div>

                    <button type="button" data-toggle="modal" data-target="#logoutModal" style="background: none; border: none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256"><path d="M112,216a8,8,0,0,1-8,8H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h56a8,8,0,0,1,0,16H48V208h56A8,8,0,0,1,112,216Zm109.66-93.66-40-40A8,8,0,0,0,168,88v32H104a8,8,0,0,0,0,16h64v32a8,8,0,0,0,13.66,5.66l40-40A8,8,0,0,0,221.66,122.34Z"></path></svg>
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
                <a href="{{ route('karyawan.datadiri', auth()->guard('karyawan')->user()->email) }}">
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
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><path d="M243.28,68.24l-24-23.56a16,16,0,0,0-22.58,0L104,136h0l-.11-.11L67.25,100.62a16,16,0,0,0-22.57.06l-24,24a16,16,0,0,0,0,22.61l71.62,72a16,16,0,0,0,22.63,0L243.33,90.91A16,16,0,0,0,243.28,68.24ZM103.62,208,32,136l24-24,.11.11,36.64,35.27a16,16,0,0,0,22.52,0L208.06,56,232,79.6Z"></path></svg>
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
                    <a href="{{ route('karyawan.presensi') }}" class="menu-item">
                        <div class="menu-item-icon success-hover">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256"><path d="M128,20A108,108,0,1,0,236,128,108.12,108.12,0,0,0,128,20Zm0,192a84,84,0,1,1,84-84A84.09,84.09,0,0,1,128,212Zm68-84a12,12,0,0,1-12,12H128a12,12,0,0,1-12-12V72a12,12,0,0,1,24,0v44h44A12,12,0,0,1,196,128Z"></path></svg>
                        </div>

                        <p class="menu-item-title">Absensi</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="http://hrisapps-rencana-kerja.test/" class="menu-item">
                        <div class="menu-item-icon blue">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256"><path d="M28,64A12,12,0,0,1,40,52H216a12,12,0,0,1,0,24H40A12,12,0,0,1,28,64Zm12,76H216a12,12,0,0,0,0-24H40a12,12,0,0,0,0,24Zm104,40H40a12,12,0,0,0,0,24H144a12,12,0,0,0,0-24Zm88,0H220V168a12,12,0,0,0-24,0v12H184a12,12,0,0,0,0,24h12v12a12,12,0,0,0,24,0V204h12a12,12,0,0,0,0-24Z"></path></svg>
                        </div>

                        <p class="menu-item-title">Rencana Kerja</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="menu-item">
                        <div class="menu-item-icon success-hover">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256"><path d="M216.49,79.52l-56-56A12,12,0,0,0,152,20H56A20,20,0,0,0,36,40V216a20,20,0,0,0,20,20H200a20,20,0,0,0,20-20V88A12,12,0,0,0,216.49,79.52ZM160,57l23,23H160ZM60,212V44h76V92a12,12,0,0,0,12,12h48V212Zm112-80a12,12,0,0,1-12,12H96a12,12,0,0,1,0-24h64A12,12,0,0,1,172,132Zm0,40a12,12,0,0,1-12,12H96a12,12,0,0,1,0-24h64A12,12,0,0,1,172,172Z"></path></svg>
                        </div>

                        <p class="menu-item-title">Permintaan</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="menu-item">
                        <div class="menu-item-icon warning">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 256 256"><path d="M216,60H179.83A52,52,0,0,0,76.17,60H40A20,20,0,0,0,20,80V200a20,20,0,0,0,20,20H216a20,20,0,0,0,20-20V80A20,20,0,0,0,216,60ZM128,36a28,28,0,0,1,27.71,24H100.29A28,28,0,0,1,128,36Zm84,160H44V84H76V96a12,12,0,0,0,24,0V84h56V96a12,12,0,0,0,24,0V84h32Z"></path></svg>
                        </div>

                        <p class="menu-item-title">Tugas</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('pengajuan.index') }}" class="menu-item">
                        <div class="menu-item-icon purple">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23 20" fill="none">
                                <path d="M11.5 7.5L6.38889 12.5H10.2222V20H12.7778V12.5H16.6111M20.4444 0H2.55556C1.13722 0 0 1.125 0 2.5V17.5C0 18.163 0.269245 18.7989 0.748505 19.2678C1.22776 19.7366 1.87778 20 2.55556 20H7.66667V17.5H2.55556V5H20.4444V17.5H15.3333V20H20.4444C21.1222 20 21.7722 19.7366 22.2515 19.2678C22.7308 18.7989 23 18.163 23 17.5V2.5C23 1.83696 22.7308 1.20107 22.2515 0.732233C21.7722 0.263392 21.1222 0 20.4444 0Z" fill="white"/>
                              </svg>
                        </div>

                        <p class="menu-item-title">Pengajuan</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="menu-item">
                        <div class="menu-item-icon primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none " viewBox="0 0 256 256"><path d="M228,56H160L133.33,36a20.12,20.12,0,0,0-12-4H76A20,20,0,0,0,56,52V72H36A20,20,0,0,0,16,92V204a20,20,0,0,0,20,20H188.89A19.13,19.13,0,0,0,208,204.89V184h20.89A19.13,19.13,0,0,0,248,164.89V76A20,20,0,0,0,228,56ZM184,200H40V96H80l26.67,20a20.12,20.12,0,0,0,12,4H184Zm40-40H208V116a20,20,0,0,0-20-20H120L93.33,76a20.12,20.12,0,0,0-12-4H80V56h40l26.67,20a20.12,20.12,0,0,0,12,4H224Z"></path></svg>
                        </div>

                        <p class="menu-item-title">Arsip</p>
                    </a>
                </div>
                {{-- <div class="col-4">
                    <a href="#" class="menu-item">
                        <div class="menu-item-icon success-focus">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
                                <path d="M16 9H12.82C12.4 7.84 11.3 7 10 7C8.7 7 7.6 7.84 7.18 9H4C3.67 9 2 8.9 2 7V6C2 4.17 3.54 4 4 4H14.18C14.6 5.16 15.7 6 17 6C17.7956 6 18.5587 5.68393 19.1213 5.12132C19.6839 4.55871 20 3.79565 20 3C20 2.20435 19.6839 1.44129 19.1213 0.87868C18.5587 0.316071 17.7956 0 17 0C15.7 0 14.6 0.84 14.18 2H4C2.39 2 0 3.06 0 6V7C0 9.94 2.39 11 4 11H7.18C7.6 12.16 8.7 13 10 13C11.3 13 12.4 12.16 12.82 11H16C16.33 11 18 11.1 18 13V14C18 15.83 16.46 16 16 16H5.82C5.4 14.84 4.3 14 3 14C2.20435 14 1.44129 14.3161 0.87868 14.8787C0.316071 15.4413 0 16.2044 0 17C0 17.7956 0.316071 18.5587 0.87868 19.1213C1.44129 19.6839 2.20435 20 3 20C4.3 20 5.4 19.16 5.82 18H16C17.61 18 20 16.93 20 14V13C20 10.07 17.61 9 16 9ZM17 2C17.2652 2 17.5196 2.10536 17.7071 2.29289C17.8946 2.48043 18 2.73478 18 3C18 3.26522 17.8946 3.51957 17.7071 3.70711C17.5196 3.89464 17.2652 4 17 4C16.7348 4 16.4804 3.89464 16.2929 3.70711C16.1054 3.51957 16 3.26522 16 3C16 2.73478 16.1054 2.48043 16.2929 2.29289C16.4804 2.10536 16.7348 2 17 2ZM3 18C2.73478 18 2.48043 17.8946 2.29289 17.7071C2.10536 17.5196 2 17.2652 2 17C2 16.7348 2.10536 16.4804 2.29289 16.2929C2.48043 16.1054 2.73478 16 3 16C3.26522 16 3.51957 16.1054 3.70711 16.2929C3.89464 16.4804 4 16.7348 4 17C4 17.2652 3.89464 17.5196 3.70711 17.7071C3.51957 17.8946 3.26522 18 3 18Z" fill="white"/>
                              </svg>
                        </div>

                        <p class="menu-item-title">Arsip</p>
                    </a>
                </div> --}}
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

            if(employeeStatus != 3) {
                deleteHrefMenu();
            }
        });

        $('.suspend-wrapper').on('click', (e) => {
            if(employeeStatus == 2) {
                alert('Tunggu verifikasi admin...!!!');
            } else {
                alert('Silahkan Lengkapi Data Diri...!!!');
            }
        });

        // $('.menu-item').on('click', (e) => {
        //     alert('Silahkan Lengkapi Data Diri...!!!');
        // });

        // $('.item').on('click', (e) => {
        //     alert('Silahkan Lengkapi Data Diri...!!!');
        // });

        // delete href menu
        function deleteHrefMenu() {
            const menus = $('.menu-item');
            const bottomMenu = $('.item');

            menus.each( (i, e) => {
                $(e).attr('href', '#');

                $(e).on('click', function() {
                    if(employeeStatus == 2) {
                        alert('Tunggu verifikasi admin...!!!');
                    } else {
                        alert('Silahkan Lengkapi Data Diri...!!!');
                    }
                });
            });

            bottomMenu.each( (i, e) => {
                $(e).attr('href', '#');

                $(e).on('click', function() {
                    if(employeeStatus == 2) {
                        alert('Tunggu verifikasi admin...!!!');
                    } else {
                        alert('Silahkan Lengkapi Data Diri...!!!');
                    }
                });
            });
        }
    </script>
@endsection
