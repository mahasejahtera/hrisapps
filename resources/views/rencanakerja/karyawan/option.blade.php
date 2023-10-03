@include('template.header')


<body>
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                Rencana Kerja
            </h2>
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
