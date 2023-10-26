@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                Arsip
            </h2>
        </div>
    </header>
    <div class="mt-3">
        <div class="container-option">
            <a href="/arsip/rkk">
                <div class="badge-option">3</div>
                <div class="text-center text-dark">Rencana Kerja</div>
            </a>
        </div>
    </div>
    <div class="mt-3">
        <div class="container-option">
            <a href="/arsip/permintaan">
                <div class="badge-option">2</div>
                <div class="text-center text-dark">Permintaan</div>
            </a>
        </div>
    </div>
</body>
@include('template.bottomNav')
@include('template.footer')
</html>
