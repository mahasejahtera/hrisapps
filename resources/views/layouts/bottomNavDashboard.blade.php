<!-- App Bottom Menu -->
<div class="appBottomMenu">
    @if (auth()->guard('karyawan')->user()->status != 3)
        <div class="suspend-wrapper"></div>
    @endif
    
    <a href="{{ route('karyawan') }}" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="/presensi/historii" class="item {{ request()->is('presensi/histori') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline"></ion-icon>
            <strong>Kalender</strong>
        </div>
    </a>
    <a href="/presensi/izinn" class="item {{ request()->is('presensi/izin') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="chatbox-outline"></ion-icon>
            <strong>Pesan</strong>
        </div>
    </a>
    <a href="/editprofilee" class="item {{ request()->is('editprofile') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="settings-outline"></ion-icon>
            <strong>Setting</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->
