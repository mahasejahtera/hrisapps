<div class="letter-wrapper">
    <div class="letter-inner">
        <div class="letter-header-footer">
            <img src="{{ asset('assets/img/Header-surat.png') }}" alt="">
        </div>
        <div class="letter-body">
            <p class="letter-title">
                PERJANJIAN KERJA MASA PERCOBAAN
            </p>
            <p class="letter-number">
                Nomor: {{ $karyawanBiodata[0]->karyawan->contract->no_surat }}
            </p>

            <div class="letter-content">
                <p>
                    --Pada hari ini, {{ hariIndo(date('N', strtotime($karyawanBiodata[0]->karyawan->contract->kontrak_check_date))) }}, tanggal {{ date('d-m-Y', strtotime($karyawanBiodata[0]->karyawan->contract->kontrak_check_date)) }} ({{ tanggalIndoText(date('d-m-Y', strtotime($karyawanBiodata[0]->karyawan->contract->kontrak_check_date))) }}), telah dibuat suatu perjanjian kerja antara pihak-pihak sebagai berikut :
                </p>

                <table>
                    <tr>
                        <td>1.<span class="mr-2"></span></td>
                        <td>Nama</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>
                            {{ $karyawanBiodata[0]->karyawan->contract->atasanApprove->nama_lengkap }}
                        </td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>Jabatan</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>
                            {{ $karyawanBiodata[0]->karyawan->contract->jabatanAtasanApprove->nama_jabatan }}
                        </td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>Alamat</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>Jl. Eka Surya No. 48, Kel. Gedung Johor, Kec. Medan Johor, Kota Medan.</td>
                    </tr>
                </table>

                <p class="mt-2 ml-3">
                    -Dalam hal ini bertindak untuk dan atas nama PT. Maha Akbar Sejahtera yang berkedudukan di Jl. Eka Surya No. 48, Kel. Gedung Johor, Kec. Medan Johor, Kota Medan. Sebagaimana yang tercantum dalam Akta nomor 34 tanggal 16 Januari 2019, yang dibuat dihadapan Notaris Farida Hanum, SH, yang berkedudukan dan berkantor di Medan. Dengan demikian sah bertindak mewakili untuk dan atas nama PT. Maha Akbar Sejahtera.
                </p>

                <p class="ml-3">
                    -Selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.
                </p>


                <table class="mt-3">
                    <tr>
                        <td>2.<span class="mr-2"></span></td>
                        <td>Nama</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>{{ $karyawanBiodata[0]->fullname }}</td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>Jenis Kelamin</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>{{ ($karyawanBiodata[0]->gender == 'L') ? 'Laki-Laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>Tempat/Tanggal Lahir</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>{{ $karyawanBiodata[0]->birthplace .  ', ' . tanggalBulanIndo($karyawanBiodata[0]->birthdate) }}</td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>Umur</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>{{ hitungUmur($karyawanBiodata[0]->birthdate) }}</td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>Agama</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>{{ ucFirst($karyawanBiodata[0]->religion) }}</td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>Pendidikan Terakhir</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>{{ ($karyawanEducation[0]->last_education == 's1' || $karyawanEducation[0]->last_education == 's2' || $karyawanEducation[0]->last_education == 's3') ? strtoupper($karyawanEducation[0]->last_education) . ' - ' . $karyawanEducation[0]->major : strtoupper($karyawanEducation[0]->last_education) }}</td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>Alamat Sesuai KTP</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>
                            {{ $karyawanBiodata[0]->address_identity }}, Kel. {{ Str::title($karyawanBiodata[0]->identityVillage->name) }}, Kec. {{ Str::title($karyawanBiodata[0]->identityDistrict->name) }}, {{ Str::title($karyawanBiodata[0]->identityRegency->name) }}, {{ Str::title($karyawanBiodata[0]->identityProvince->name) }}
                        </td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>NIK</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>{{ $karyawanBiodata[0]->nik }}</td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>No. Telepon/HP</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>{{ $karyawanBiodata[0]->phone }}</td>
                    </tr>
                    <tr>
                        <td><span class="mr-2"></span></td>
                        <td>Status Perkawinan</td>
                        <td><span class="ml-5 mr-3">:</span></td>
                        <td>
                            @php
                                if($karyawanBiodata[0]->marital_status == 'kawin') echo 'Kawin';
                                if($karyawanBiodata[0]->marital_status == 'belum_kawin') echo 'Belum Kawin';
                                if($karyawanBiodata[0]->marital_status == 'janda') echo 'Janda';
                                if($karyawanBiodata[0]->marital_status == 'duda') echo 'Duda';
                            @endphp
                        </td>
                    </tr>
                </table>

                <p class="mt-1 ml-3">
                    -Selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong>.
                </p>

                <p class="mt-1">
                    --Bahwa berdasarkan hal tersebut, maka <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> sepakat dan setuju untuk melakukan masa percobaan kerja, dengan syarat-syarat dan ketentuan-ketentuan sebagai berikut :
                </p>


                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 1</p>
                        <P>KETENTUAN UMUM</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong></strong> dengan ini menyatakan menerima <strong>PIHAK KEDUA</strong> sebagai karyawan dalam masa percobaan perusahaan PT. Maha Akbar Sejahtera yang terletak Jl.Eka Surya No. 48 Kec. Medan Johor, Kota Medan, yang bergerak dalam bidang usaha Konstruksi, Telekomunikasi, Development dan IT.
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> dengan ini menyatakan kesediaannya menjadi Karyawan masa percobaan <strong>PIHAK PERTAMA</strong>.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="letter-header-footer mt-5">
            <img src="{{ asset('assets/img/footer-surat.png') }}" alt="">
        </div>
    </div>
</div>

<div class="letter-wrapper">

    <div class="letter-inner">
        <div class="letter-header-footer">
            <img src="{{ asset('assets/img/Header-surat.png') }}" alt="">
        </div>
        <div class="letter-body">
            <div class="letter-content">
                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 2</p>
                        <P>JANGKA WAKTU</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <P><strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> sepakat bahwa Masa Percobaan dilaksanakan selama {{ $karyawanBiodata[0]->karyawan->contract->lama_kontrak_num }} ({{ angkaTeks($karyawanBiodata[0]->karyawan->contract->lama_kontrak_num) }}) {{ ucFirst($karyawanBiodata[0]->karyawan->contract->lama_kontrak_waktu) }} yaitu dimulai pada tanggal {{ tanggalIndo($karyawanBiodata[0]->karyawan->contract->mulai_kontrak) }} ({{ tanggalIndoText(tanggalIndo($karyawanBiodata[0]->karyawan->contract->mulai_kontrak)) }}) sampai dengan {{ tanggalIndo($karyawanBiodata[0]->karyawan->contract->akhir_kontrak) }} ({{ tanggalIndoText(tanggalIndo($karyawanBiodata[0]->karyawan->contract->akhir_kontrak)) }}).</P>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 3</p>
                        <P>PENILAIAN DAN EVALUASI</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK PERTAMA</strong> selama masa percobaan berhak melakukan penilaian dan evaluasi terhadap kinerja <strong>PIHAK KEDUA</strong> dan berhak mengakhiri hubungan kerja sewaktu-waktu bilamana berdasarkan penilaian <strong>PIHAK PERTAMA</strong>, <strong>PIHAK KEDUA</strong> tidak mampu melaksanakan pekerjaan sesuai dengan hasil yang telah ditentukan serta tanpa adanya penggantian atau kewajiban apapun dari <strong>PIHAK PERTAMA</strong>.
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> menyatakan kesediaannya untuk mematuhi dan mentaati peraturan perusahaan dan tata tertib perusahaan yang telah ditetapkan <strong>PIHAK PERTAMA</strong>.
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 4</p>
                        <P>JABATAN, PENEMPATAN & UPAH</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK KEDUA</strong> akan bekerja sebagai {{ $karyawanBiodata[0]->karyawan->contract->jabatan->nama_jabatan }} pada Departemen {{ $karyawanBiodata[0]->karyawan->contract->department->nama_dept }}.
                            </li>
                            <li>
                                <strong>PIHAK PERTAMA</strong> berhak menempatkan <strong>PIHAK KEDUA</strong> dalam melaksanakan tugas baik didalam kota maupun diluar kota dan pekerjaan lain yang oleh <strong>PIHAK PERTAMA</strong> dianggap lebih sesuai dengan keahlian yang dimiliki oleh <strong>PIHAK KEDUA</strong>, dengan syarat masih tetap berada di dalam lingkungan perusahaan PT. Maha Akbar Sejahtera.
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> selama masa percobaan berhak mendapatkan upah dari <strong>PIHAK PERTAMA</strong> sebesar Rp.{{ number_format($karyawanBiodata[0]->karyawan->contract->salary,0,',','.') }},- ({{ bilanganTeks($karyawanBiodata[0]->karyawan->contract->salary) }} rupiah).
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> dengan ini bersedia dilakukan pembayaran gaji dibulan pertama secara prorata.
                            </li>
                            <li>
                                Pembayaran gaji secara prorata sebagaimana ayat 2 pasal ini yaitu gaji perbulan dibagi 26 hari kerja dan hasilnya dikali dengan jumlah hari masuk kerja dibulan pertama sebelum tutup buku.
                            </li>
                        </ol>
                    </div>
                </div>

                <p class="mt-3">
                    Demikianlah perjanjian kerja masa percobaan ini dibuat dan mulai berlaku pada saat ditandatangani oleh <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> sebagaimana tersebut pada awal perjanjian ini.
                </p>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="letter-signature-wrapper ml-0">
                        <p><strong>PIHAK PERTAMA</strong></p>
                        <div class="letter-signature-inner">
                            <img src="{{ asset("signature/".$karyawanBiodata[0]->karyawan->contract->atasanApprove->signature) }}" alt="">

                            <div class="qr-code">
                                <img src="" alt="">
                            </div>
                        </div>
                        <p class="letter-signature-name">({{ strtoupper($karyawanBiodata[0]->karyawan->contract->atasanApprove->nama_lengkap) }})</p>
                        <p class="letter-signature-jabatan">{{ $karyawanBiodata[0]->karyawan->contract->jabatanAtasanApprove->nama_jabatan }}</p>
                    </div>

                    <div class="letter-signature-wrapper">
                        <p>PIHAK KEDUA</p>
                        <div class="letter-signature-inner">
                            <img src="{{ asset("signature/".$karyawanBiodata[0]->karyawan->signature) }}" alt="">

                            <div class="qr-code">
                                <img src="" alt="">
                            </div>
                        </div>
                        <p class="letter-signature-name">({{ strtoupper($karyawanBiodata[0]->fullname) }})</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="letter-header-footer mt-5">
            <img src="{{ asset('assets/img/footer-surat.png') }}" alt="">
        </div>
    </div>
</div>
