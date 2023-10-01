@include('template.header')

<body>
    <header>
        <div class="page-header bg-prima">
            <div class="container-xl">
                <div class="row g-2">
                    <div class="col">
                        <h2 class="page-title text-sec p-1">
                            List Rencana Kerja
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="">
        <img src="{{ asset('assets/img/iconrkk.png') }}" alt="">
        <button class="btn bg-prima floating-button-rkk text-sec">+
        </button>
    </div>
</body>
@include('template.bottomNav')
@include('template.footer')
</html>
