<div class="letter-wrapper">
    <div class="letter-inner">
        <div class="letter-header-footer">
            <img src="{{ asset('assets/img/Header-surat.png') }}" alt="">
        </div>
        <div class="letter-body">
            <p class="letter-title">
                SURAT PERJANJIAN KERJA KARYAWAN
            </p>
            <p class="letter-number">
                Nomor: {{ $karyawanBiodata[0]->karyawan->contract->no_surat }}
            </p>

            <div class="letter-content">
                <p>
                    --Pada hari ini, {{ hariIndo(date('N', strtotime($karyawanBiodata[0]->karyawan->contract->kontrak_check_date))) }}, tanggal {{ date('d-m-Y', strtotime($karyawanBiodata[0]->karyawan->contract->kontrak_check_date)) }} ({{ tanggalIndoText(date('d-m-Y', strtotime($karyawanBiodata[0]->karyawan->contract->kontrak_check_date))) }}), telah dibuat suatu perjanjian kerja antara pihak-pihak sebagai berikut :
                </p>

                <table class="w-100 table-identity-contract mt-2" border="1">
                    <tr>
                        <td><strong>Nama Pemberi Kerja</strong></td>
                        <td><strong>{{ strtoupper("Afriyan") }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Jabatan</strong></td>
                        <td>Project Manager</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>Jl. Eka Surya No. 48, Kel. Gedung Johor, Kec. Medan Johor, Kota Medan.</td>
                    </tr>

                    <tr>
                        <td colspan="2" class="p-1"></td>
                    </tr>

                    <tr>
                        <td><strong>Nama Penerima Kerja</strong></td>
                        <td><strong>Parto Siagian</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Jabatan</strong></td>
                        <td>Tukang Besi</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>Laki-Laki</td>
                    </tr>
                    <tr>
                        <td>Tempat Tanggal Lahir</td>
                        <td>Medan, 00-00-000</td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>1234567890987654</td>
                    </tr>
                    <tr>
                        <td>Alamat Pekerja</td>
                        <td>Jl. Eka Surya No. 48, Kel. Gedung Johor, Kec. Medan Johor, Kota Medan.</td>
                    </tr>
                    <tr>
                        <td>No. Hp</td>
                        <td>123456789098</td>
                    </tr>
                    <tr>
                        <td>Lokasi Kerja</td>
                        <td>Jl. Inkis</td>
                    </tr>
                    <tr>
                        <td>Jam Kerja</td>
                        <td>08:00 WIB s/d 17:00 WIB</td>
                    </tr>
                    <tr>
                        <td>Jam Istirahat</td>
                        <td>12:00 WIB s/d 13:00 WIB</td>
                    </tr>
                    <tr>
                        <td>Upah</td>
                        <td>Rp. 2.000.000</td>
                    </tr>
                    <tr>
                        <td>Jangka Waktu Pekerjaan</td>
                        <td>12 Hari</td>
                    </tr>
                    <tr>
                        <td>Atasan Langsung</td>
                        <td><strong>{{ strtoupper("Afriyan") }}</strong></td>
                    </tr>
                    <tr>
                        <td>Ruang Lingkup Pekerjaan</td>
                        <td>Membetulkan segala yang perlu dibetulkan</td>
                    </tr>
                </table>

                <p class="mt-2">
                    --Bahwa berdasarkan hal tersebut, maka <strong>Pemberi Kerja</strong> dan <strong>Penerima Pekerja</strong> sepakat dan setuju untuk melakukan perjanjian kerja yang selanjutnya disebut sebagai perjanjian, dengan syarat-syarat dan ketentuan-ketentuan sebagai berikut :
                </p>


                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 1</p>
                        <P>KESEPAKATAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                Bahwa dengan ini <strong>Pemberi Kerja</strong> menyatakan menerima <strong>Penerima Kerja</strong> sebagai Pekerja Harian lepas (PHL) dengan ruang lingkup pekerjaan dan lokasi kerja yang telah disebutkan dalam kolom diatas.
                            </li>
                            <li>
                                Bahwa dengan ini <strong>Penerima Kerja</strong> menyatakan kesediaannya untuk bekerja sebagai Pekerja Harian Lepas (PHL) <strong>Pemberi Kerja</strong>.
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
                        <P>HAK, KEWAJIBAN & LARANGAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>Penerima Kerja</strong> memiliki hak sebagai berikut :
                                <ol type="a">
                                    <li>
                                        Mendapat Upah dari <strong>Pemberi Kerja</strong>;
                                    </li>
                                    <li>
                                        Mendapatkan perlakuan yang baik dan sesuai di dalam pekerjaan
                                    </li>
                                    <li>
                                        Mendapatkan hak waktu kerja, waktu istirahat dan waktu untuk beribadah;
                                    </li>
                                    <li>
                                        Mendapatkan Alat Pelindung Diri
                                    </li>
                                    <li>
                                        Mendapatkan kesalamatan dan keamanan kerja;
                                    </li>
                                </ol>
                            </li>
                            <li>
                                <strong>Penerima Kerja</strong> memiliki kewajiban sebagai berikut :
                                <ol type="a">
                                    <li>
                                        Menjalankan SOP dan Peraturan Perusahaan dengan baik dan benar;
                                    </li>
                                    <li>
                                        Bekerja dan melaksanakan tugas sesuai posisi kerja yang telah ditetapkan secara penuh dan bertanggung jawab;
                                    </li>
                                    <li>
                                        Mematuhi dan Mentaati perintah atasan yang berkaitan dengan pekerjaan yang dilaksanakan;
                                    </li>
                                    <li>
                                        Memenuhi dan mematuhi waktu kerja yang telah ditetapkan di lokasi kerja;
                                    </li>
                                    <li>
                                        Menjaga nama baik perusahaan PT Maha Akbar Sejahtera;
                                    </li>
                                    <li>
                                        Menjaga dan merawat fasilitas kerja yang diberikan pemberi kerja
                                    </li>
                                    <li>
                                        Menghindari setiap perbuatan yang akan dapat merugikan <strong>Pemberi Kerja</strong> dan harus sepenuhnya memenuhi komitmen demi kepentingan <strong>Pemberi Kerja</strong>;
                                    </li>
                                    <li>
                                        Mematuhi dan menjalankan tata tertib perusahaan PT. Maha Akbar Sejahtera.
                                    </li>
                                </ol>
                            </li>
                            <li>
                                Larangan – Larangan bagi <strong>Penerima Kerja</strong> adalah sebagai berikut :
                                <ol type="a">
                                    <li>
                                        Tidak menggunakan Alat Pelindung Diri dengan lengkap;
                                    </li>
                                    <li>
                                        Melakukan perbuatan tindak pidana (Pencurian, Penggelapan, Penipuan, Pemalsuan, Penganiayaan dan lainnya);
                                    </li>
                                    <li>
                                        Melakukan perusakan dengan sengaja yang menimbulkan kerugian <strong>Pemberi Kerja</strong>.
                                    </li>
                                    <li>
                                        Melakukan hal-hal lain karena kecerobohannya yang mengakibatkan <strong>Pemberi Kerja</strong> mengalami kerugian;
                                    </li>
                                    <li>
                                        Mabuk-mabukkan atau mengkonsumsi narkotika dan obat-obatan terlarang di lingkungan kerja perusahaan;
                                    </li>
                                    <li>
                                        Melakukan keributan atau keonaran yang mengganggu suasana kerja dilingkungan kerja perusahaan;
                                    </li>
                                    <li>
                                        Menghasut para pekerja lain untuk melakukan mogok kerja.
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>

                <p class="mt-3">
                    Demikianlah surat perjanjian kerja ini dibuat, disetujui dan mulai berlaku pada saat ditandatangani oleh <strong>Pemberi Kerja</strong> dan <strong>Penerima Kerja</strong> sebagaimana tersebut pada awal perjanjian ini.
                </p>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="letter-signature-wrapper ml-0">
                        <p><strong>Pemberi Kerja</strong></p>
                        <div class="letter-signature-inner">
                            <img src="{{ asset("signature/".$karyawanBiodata[0]->karyawan->signature) }}" alt="">
                            <div class="qr-code">
                                <img src="" alt="">
                            </div>
                        </div>
                        <p class="letter-signature-name">{{ strtoupper("Afriyan") }}</p>
                        <p class="letter-signature-jabatan">Manajer Proyek</p>
                    </div>

                    <div class="letter-signature-wrapper">
                        <p>PIHAK KEDUA</p>
                        <div class="letter-signature-inner">
                            <img src="{{ asset("signature/".$karyawanBiodata[0]->karyawan->signature) }}" alt="">
                            <div class="qr-code">
                                <img src="" alt="">
                            </div>
                        </div>
                        <p class="letter-signature-name">{{ strtoupper($karyawanBiodata[0]->fullname) }}</p>
                        <p class="letter-signature-jabatan">Pekerja</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="letter-header-footer mt-5">
            <img src="{{ asset('assets/img/footer-surat.png') }}" alt="">
        </div>
    </div>
</div>
