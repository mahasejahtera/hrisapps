<section class="profile-menu-wrapper">
    <div class="profile-menu-inner">
        @php
            $urlKontrak = '';

            if($karyawan->kontrak_tampil == 0) {
                $urlKontrak = asset('storage/' . auth()->guard('karyawan')->user()->contract->contract_file);
            } else {
                $urlKontrak = route('profil.kontrakkerja', auth()->guard('karyawan')->user()->email);
            }
        @endphp

        @if ($karyawan->status == 3)
            @if ($karyawan->kontrak_tampil == 1)
                <a href="{{ $urlKontrak }}" class="profile-menu-item">
                    <p>Kontrak Kerja</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#3e3737" viewBox="0 0 256 256"><path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path></svg>
                </a>

            @else
                @if (!empty($karyawan->contract->contract_file))
                    <a href="{{ $urlKontrak }}" class="profile-menu-item">
                        <p>Kontrak Kerja</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#3e3737" viewBox="0 0 256 256"><path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path></svg>
                    </a>
                @else
                    <a href="#" class="profile-menu-item" onclick="alert('Kontrak anda belum diupload oleh admin!')">
                        <p>Kontrak Kerja</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#3e3737" viewBox="0 0 256 256"><path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path></svg>
                    </a>
                @endif
            @endif
        @endif

        <a href="{{ route('profil.changepassword') }}" class="profile-menu-item">
            <p>Ubah Password</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#3e3737" viewBox="0 0 256 256"><path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path></svg>
        </a>
    </div>
</section>
