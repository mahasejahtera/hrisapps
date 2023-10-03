@include('template.header')

<body>
    <header>
        <div class="bg-prima btn-header">
            <h2 class="text-sec pt-2 p-1">
                List Rencana Kerja
            </h2>
        </div>
    </header>
    <div class="">
        <img src="{{ asset('assets/img/iconrkk.png') }}" alt="">
        <button class="btn bg-prima floating-button-rkk">
            <a href="/karyawan/add-rkk" class="text-sec">+</a>
        </button>
    </div>
</body>
@include('template.bottomNav')
@include('template.footer')

</html>
