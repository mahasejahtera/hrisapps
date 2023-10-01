@include('template.header')

<body>
    <header id="header-nav">
        <div class="employee-header-nav">
            <div class="header-profile">
                <div class="header-profile-img">
                    <img src="{{ asset('images/ardi.jpg') }}" alt="default avatar">
                </div>
                <div class="header-profile-employee">
                    <p class="profile-name">Ardi Firmansyah</p>
                    <p class="profile-jobtitle">Software Engineer</p>
                </div>
            </div>
            <div class="header-icon-nav">
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
            </div>
        </div>
    </header>
    {{-- END : HEADER --}}

    {{-- START : MAIN --}}
    <main id="main-dashboard">
        {{-- START : DATA PROGRESS --}}
        <section class="personal-data-progress">
            <a href="">
                <p>Lengkapi data diri</p>
                <div class="maha__progress-bar">
                    <div class="progress-bar-fill">
                        <p>50%</p>
                    </div>
                </div>
            </a>
        </section>
        {{-- END : DATA PROGRESS --}}

        {{-- START : MENU --}}
        <section id="menu-wrapper">

            <div class="row justify-content-between">
                <div class="col-4">
                    <a href="" class="menu-item">
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
                    <a href="/karyawan/option" class="menu-item">
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
                        <div class="menu-item-icon success-hover">
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
                    <a href="#" class="menu-item">
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
                        <div class="menu-item-icon primary">
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
    </main>

</body>
@include('template.footer')
@include('template.bottomNav')

</html>
