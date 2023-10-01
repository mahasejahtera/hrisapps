@include('template.header')

<body>
    <header>
        <div class="page-header bg-prima">
            <div class="container-xl">
                <div class="row g-2">
                    <div class="col">
                        <h2 class="page-title text-sec p-1">
                            Rencana Kerja
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mt-3">
        <div class="container-option">
            <a href="/karyawan/task">
                <div class="badge-option">2</div>
                <div class="text-center text-dark">Daftar Tugas</div>
            </a>
        </div>
        <div class="container-option">
            <a href="/karyawan/listrkk">
                <div class="badge-option">7</div>
                <div class="text-center text-dark">Daftar Rencana Kerja</div>
            </a>
        </div>
    </div>
</body>
@include('template.bottomNav')
@include('template.footer')

</html>
