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
                    -Dalam hal ini bertindak untuk dan atas nama PT. Maha Akbar Sejahtera yang berkedudukan di     Jl. Eka Surya No. 48, Kel. Gedung Johor, Kec. Medan Johor, Kota Medan. Sebagaimana yang tercantum dalam Akta nomor 34 tanggal 16 Januari 2019, yang dibuat dihadapan Notaris Farida Hanum, SH, yang berkedudukan dan berkantor di Medan. Dengan demikian sah bertindak mewakili untuk dan atas nama PT. Maha Akbar Sejahtera.
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
                    --Bahwa berdasarkan hal tersebut, maka Pihak Pertama dan Pihak Kedua sepakat dan setuju untuk melakukan perjanjian kerja yang selanjutnya disebut sebagai perjanjian, dengan syarat-syarat dan ketentuan-ketentuan sebagai berikut :
                </p>


                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 1</p>
                        <P>KETENTUAN UMUM</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK PERTAMA</strong> dengan ini menyatakan menerima <strong>PIHAK KEDUA</strong> sebagai karyawan perusahaan PT Maha Akbar Sejahtera yang terletak Jl. Eka Surya No. 48 Kecamatan Medan Johor, Kota Medan, yang bergerak dalam bidang usaha Konstruksi, Telekomunikasi, Development dan IT.
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> dengan ini menyatakan kesediaannya menjadi Karyawan <strong>PIHAK PERTAMA</strong>.
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
                        <P><strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> sepakat bahwa perjanjian kerja ini dilaksanakan dengan waktu tertentu (PKWT) selama {{ $karyawanBiodata[0]->karyawan->contract->lama_kontrak_num }} ({{ angkaTeks($karyawanBiodata[0]->karyawan->contract->lama_kontrak_num) }}) {{ ucFirst($karyawanBiodata[0]->karyawan->contract->lama_kontrak_waktu) }} yaitu dimulai sejak tanggal {{ tanggalIndo($karyawanBiodata[0]->karyawan->contract->mulai_kontrak) }} ({{ tanggalIndoText(tanggalIndo($karyawanBiodata[0]->karyawan->contract->mulai_kontrak)) }}) sampai dengan tanggal {{ tanggalIndo($karyawanBiodata[0]->karyawan->contract->akhir_kontrak) }} ({{ tanggalIndoText(tanggalIndo($karyawanBiodata[0]->karyawan->contract->akhir_kontrak)) }}).</P>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 3</p>
                        <P>TATA TERTIB PERUSAHAAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK KEDUA</strong> menyatakan kesediaannya untuk mematuhi serta mentaati seluruh peraturan dan tata tertib perusahaan yang telah ditetapkan <strong>PIHAK PERTAMA</strong>.
                            </li>
                            <li>
                                Bahwa semua peraturan dan tata tertib <strong>PIHAK PERTAMA</strong> baik secara tertulis dalam Surat Perjanjian Kerja maupun tidak tertulis termasuk peraturan-peraturan yang akan dibuat dikemudian hari oleh <strong>PIHAK PERTAMA</strong> dinyatakan berlaku dan mengikat kepada <strong>PIHAK KEDUA</strong>.
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> dengan ini memahami dan menyetujui bahwa pelanggaran terhadap peraturan-peraturan perusahaan dapat mengakibatkan <strong>PIHAK KEDUA</strong> dapat dikenakan sanksi, berupa :

                                <ol type="a">
                                    <li>
                                        Surat Teguran, Surat Peringatan (SP) 1 dan 2;
                                    </li>
                                    <li>
                                        Pemutusan Hubungan Kerja secara sepihak oleh <strong>PIHAK PERTAMA</strong>;
                                    </li>
                                    <li>
                                        Hukuman dalam bentuk lain yang merujuk kepada peraturan perundang-undangan yang berlaku.
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 4</p>
                        <P>WAKTU KERJA</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK KEDUA</strong> wajib memenuhi waktu kerja 8 (delapan) jam kerja sehari dalam 5 (lima) hari kerja dan terkhusus di hari sabtu jam kerja selama 5 (lima) jam atau 45 (empat puluh lima) jam kerja selama 1 (satu) minggu di luar jam istirahat.
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> berhak mendapatkan :
                                <ol type="a">
                                    <li>
                                        Waktu istirahat sebanyak 1 (satu) jam pada 1 (satu) hari kerja sesuai waktu kerja yang berlaku di perusahaan.
                                    </li>
                                    <li>
                                        Waktu istirahat sebanyak 1 (satu) hari setelah 6 (enam) hari bekerja.
                                    </li>
                                </ol>
                            </li>
                            <li>
                                Bahwa <strong>PIHAK PERTAMA</strong> apabila dipandang perlu dapat menugaskan <strong>PIHAK KEDUA</strong> untuk bekerja lembur sesuai dengan ketentuan perundang-undangan yang berlaku dan diatur oleh <strong>PIHAK PERTAMA</strong>;
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 5</p>
                        <P>MANGKIR DAN KETIDAKHADIRAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                Bahwa <strong>PIHAK KEDUA</strong> tidak diperkenankan untuk tidak hadir bekerja tanpa pemberitahuan sebelumnya;
                            </li>
                            <li>
                                <strong>PIHAK PERTAMA</strong> dapat menerima ketidakhadiran dari <strong>PIHAK KEDUA</strong> dalam waktu jam kerja bilamana <strong>PIHAK KEDUA</strong> dalam kondisi :
                                <ol type="a">
                                    <li>
                                        Sakit, dibuktikan dengan membawa Surat Keterangan Sakit dan/atau Surat Keterangan Istirahat dikarenakan sakit dari Dokter baik dari Rumah Sakit, Puskesmas dan/atau Klinik Kesehatan.
                                    </li>
                                    <li>
                                        Kemalangan dan/atau meninggal dunia keluarga kandung
                                    </li>
                                    <li>
                                        Force Majeure dan/atau Keadaan diluar kehendak manusia seperti Bencana Alam, Kebakaran, Kebanjiran yang menimpa <strong>PIHAK KEDUA</strong>.
                                    </li>
                                </ol>
                            </li>
                            <li>
                                Bahwa apabila <strong>PIHAK KEDUA</strong> tidak hadir bekerja tanpa ada pemberitahuan dan alasan yang sah kepada <strong>PIHAK PERTAMA</strong>, maka dianggap sebagai mangkir;
                            </li>
                            <li>
                                Bahwa jika <strong>PIHAK KEDUA</strong> tidak masuk bekerja karena mangkir selama 5 (lima) hari berturut-turut atau tanpa keterangan tertulis dan bukti yang sah serta telah dipanggil sebanyak 2 (dua) kali secara patut oleh <strong>PIHAK PERTAMA</strong>, maka <strong>PIHAK KEDUA</strong> dianggap mengundurkan diri;
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
                        <p>PASAL 6</p>
                        <P>PENEMPATAN, TUGAS & TANGGUNG JAWAB</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK KEDUA</strong> akan bekerja sebagai {{ $karyawanBiodata[0]->karyawan->contract->jabatan->nama_jabatan }} Pada Departemen {{ $karyawanBiodata[0]->karyawan->contract->department->nama_dept }}.
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> memiliki Tugas dan Tanggung Jawab kerja sebagai berikut :
                                <ol type="a">
                                    {{-- @foreach ($karyawanJobdesk as $kj)
                                        <li>
                                            {{ $kj->jobdesk }}
                                        </li>
                                    @endforeach --}}
                                    <div class="ml-2">{!! $karyawan->contract->jobdesk_content !!}</div>
                                </ol>
                            </li>
                            <li>
                                <strong>PIHAK PERTAMA</strong> berhak menempatkan <strong>PIHAK KEDUA</strong> dalam melaksanakan tugas baik didalam kota maupun diluar kota dan pekerjaan lain yang oleh <strong>PIHAK PERTAMA</strong> dianggap lebih sesuai dengan keahlian yang dimiliki oleh <strong>PIHAK KEDUA</strong>, dengan syarat masih tetap berada di dalam lingkungan perusahaan PT. Maha Akbar Sejahtera.
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 7</p>
                        <P>HAK – HAK</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK PERTAMA</strong> berhak untuk :
                                <ol type="a">
                                    <li>
                                        Mendapatkan hasil pekerjaan dari <strong>PIHAK KEDUA</strong>;
                                    </li>
                                    <li>
                                        Mendapatkan hasil progres kerja dari <strong>PIHAK KEDUA</strong>;
                                    </li>
                                    <li>
                                        Melakukan Pengaturan dan Perintah kerja kepada <strong>PIHAK KEDUA</strong>;
                                    </li>
                                    <li>
                                        Memberikan arahan dan putusan sesuai lingkup pekerjaan <strong>PIHAK KEDUA</strong>;
                                    </li>
                                    <li>
                                        Melakukan Penilaian dan Evaluasi terhadap kinerja <strong>PIHAK KEDUA</strong>;
                                    </li>
                                    <li>
                                        Melakukan Teguran, Peringatan dan Pemutusan Hubungan Kerja;
                                    </li>
                                </ol>
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> berhak untuk :
                                <ol type="a">
                                    <li>
                                        Mendapat Upah dari <strong>PIHAK PERTAMA</strong>;
                                    </li>
                                    <li>
                                        Mendapatkan perlakuan yang baik dan sesuai di dalam pekerjaan;
                                    </li>
                                    <li>
                                        Mendapatkan hak waktu kerja dan waktu istirahat yang disebut pada pasal 4 ayat (2);
                                    </li>
                                    <li>
                                        Mendapatkan fasilitas Wi-Fi
                                    </li>
                                    <li>
                                        Mendapatkan alat kerja dari perusahaan berupa komputer dan/atau laptop serta printer;
                                    </li>
                                    <li>
                                        Mendapatkan waktu untuk beribadah;
                                    </li>
                                    <li>
                                        Mendapatkan kenyamanan dan keamanan kerja;
                                    </li>
                                </ol>
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
                        <p>PASAL 8</p>
                        <P>KEWAJIBAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK PERTAMA</strong> berkewajiban untuk :
                                <ol type="a">
                                    <li>
                                        Memberikan hak-hak <strong>PIHAK KEDUA</strong> secara penuh;
                                    </li>
                                    <li>
                                        Memberikan arahan dan putusan sesuai lingkup pekerjaan kepada <strong>PIHAK KEDUA</strong>;
                                    </li>
                                    <li>
                                        Melakukan Penilaian dan Evaluasi kinerja <strong>PIHAK KEDUA</strong>;
                                    </li>
                                    <li>
                                        Melakukan Arahan dan Perintah Kerja kepada <strong>PIHAK KEDUA</strong>;
                                    </li>
                                    <li>
                                        Melakukan Teguran & Peringatan bila diperlukan kepada <strong>PIHAK KEDUA</strong>.
                                    </li>
                                </ol>
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> berkewajiban untuk :
                                <ol  type="a">
                                    <li>
                                        Menjalankan SOP dan Peraturan Perusahaan dengan baik dan benar;
                                    </li>
                                    <li>
                                        Memahami dan melaksanakan visi dan misi perusahaan PT Maha Akbar Sejahtera secara penuh dan bertanggung jawab;
                                    </li>
                                    <li>
                                        Bekerja dan melaksanakan tugas sesuai posisi kerja yang telah ditetapkan secara penuh dan bertanggung jawab;
                                    </li>
                                    <li>
                                        Memenuhi waktu kerja yaitu hari Senin s/d Jumat pukul 08.30 wib s/d 17.00 wib dan Sabtu 08.30 wib s/d 15.00 wib untuk bagian Office;
                                    </li>
                                    <li>
                                        Menjaga nama baik perusahaan PT Maha Akbar Sejahtera;
                                    </li>
                                    <li>
                                        Menjaga dan merawat aset, fasilitas, dan kerahasiaan data-data perusahaan PT Maha Akbar Sejahtera;
                                    </li>
                                    <li>
                                        Saling menghormati, mendukung dan bersinergi antar sesama Karyawan PT. Maha Akbar Sejahtera;
                                    </li>
                                    <li>
                                        Menghindari setiap perbuatan yang akan dapat merugikan <strong>PIHAK PERTAMA</strong> dan harus sepenuhnya memenuhi komitmen demi kepentingan <strong>PIHAK PERTAMA</strong>;
                                    </li>
                                    <li>
                                        Menghormati dan melaksanakan nilai-nilai yang telah ditetapkan perusahaan PT. Maha Akbar Sejahtera
                                    </li>
                                    <li>
                                        Mematuhi dan menjalankan tata tertib perusahaan PT. Maha Akbar Sejahtera
                                    </li>
                                    <li>
                                        Mematuhi dan menjalankan ketentuan khusus PT. Maha Akbar Sejahtera.
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 9</p>
                        <P>KERJA RANGKAP</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK KEDUA</strong> tidak dibenarkan melakukan kerja rangkap diperusahaan lain selama berlakunya ikatan perjanjian ini
                            </li>
                            <li>
                                <strong>PIHAK PERTAMA</strong> dapat memberikan sanksi kepada PIHAK KEDUA sebagaimana Pasal 3 Ayat (3) bilamana <strong>PIHAK KEDUA</strong> terbukti melakukan kerja rangkap.
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 10</p>
                        <P>UPAH</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK KEDUA</strong> berhak mendapatkan upah pokok dari <strong>PIHAK PERTAMA</strong> sebesar Rp.{{ number_format($karyawanBiodata[0]->karyawan->contract->salary,0,',','.') }},- ({{ bilanganTeks($karyawanBiodata[0]->karyawan->contract->salary) }} rupiah).
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> dengan ini bersedia dilakukan pembayaran upah dibulan pertama secara prorata.
                            </li>
                            <li>
                                Pembayaran upah secara prorata sebagaimana ayat 3 pasal ini yaitu upah perbulan dibagi 26 hari kerja dan hasilnya dikali dengan jumlah hari masuk kerja dibulan pertama sebelum tutup buku.
                            </li>
                            <li>
                                <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> sepakat untuk tidak menerbitkan Addendum dalam hal terjadinya peningkatan upah pokok kecuali terjadi kejadian yang memaksa kedua belah pihak untuk menerbitkannya dan akan diatur dalam peraturan perusahaan.
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
                        <p>PASAL 11</p>
                        <P>GANTI RUGI</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK KEDUA</strong> wajib memberikan ganti rugi kepada <strong>PIHAK PERTAMA</strong> bilamana <strong>PIHAK KEDUA</strong> mengundurkan diri sebelum berakhirnya Jangka Waktu dalam perjanjian ini;
                            </li>
                            <li>
                                Biaya ganti rugi sebagaimana ayat 1 pasal ini, dihitung dari sisa jangka waktu perjanjian kerja sampai berakhir.
                            </li>
                            <li>
                                Ganti Rugi sebagaimana pasal ini dapat dikesampingkan atas persetujuan <strong>PIHAK PERTAMA</strong>, bilamana terdapat pilihan lain dan/atau keputusan lain dari <strong>PIHAK PERTAMA</strong>.
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 12</p>
                        <P>PEMUTUSAN HUBUNGAN KERJA</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK PERTAMA</strong> dapat melakukan Pemutusan Hubungan Kerja secara sepihak kepada <strong>PIHAK KEDUA</strong>, dengan alasan sebagai berikut :
                                <ol type="a">
                                    <li>
                                        <strong>PIHAK PERTAMA</strong> menilai <strong>PIHAK KEDUA</strong> tidak dapat memenuhi persyaratan, tugas dan tanggung jawab kerja yang telah ditentukan oleh <strong>PIHAK PERTAMA</strong>;
                                    </li>
                                    <li>
                                        <strong>PIHAK KEDUA</strong> mangkir/tidak hadir bekerja selama 5 hari berturut-turut atau lebih tanpa kabar atau keterangan tertulis kepada <strong>PIHAK PERTAMA</strong>;
                                    </li>
                                    <li>
                                        <strong>PIHAK KEDUA</strong> melakukan pelanggaran yang diatur dalam peraturan perusahaan;
                                    </li>
                                    <li>
                                        <strong>PIHAK KEDUA</strong> melakukan kecurangan baik membocorkan informasi perusahaan secara langsung atau tidak langsung atau membawa customer perusahaan PT Maha Akbar Sejahtera ke perusahaan lainnya  baik saat masih bekerja atau sudah tidak bekerja di PT. Maha Akbar Sejahtera, memanipulasi data maupun penyelewengan dana dan wewenang yang akan langsung dilakukan Pemutusan Hubungan Kerja tanpa peringatan SP1, SP2 dan SP3 dan apabila <strong>PIHAK PERTAMA</strong> menilai terdapat kerugian perusahaan maka akan di proses ke pihak berwajib (polisi atau aparat penegak hukum lainnya);
                                    </li>
                                    <li>
                                        <strong>PIHAK KEDUA</strong> terbukti melakukan hal-hal pelanggaraan berat sebagai berikut namun tidak terbatas pada:
                                        <ol type="I">
                                            <li>
                                                Mabuk, membawa dan/atau menggunakan Narkoba, Judi dan sejenisnya;
                                            </li>
                                            <li>
                                                Pelecehan, penghinaan, ancaman, intimidasi atau tindakan kekerasan baik fisik, verbal maupun non verbal kepada Karyawan lain dan/atau <strong>PIHAK PERTAMA</strong>;
                                            </li>
                                            <li>
                                                Kerusakan alat kerja atau properti milik <strong>PIHAK PERTAMA</strong> yang disengaja;
                                            </li>
                                            <li>
                                                Pelanggaran tugas yang mengakibatkan kerugian materil maupun immateril yang berdampak besar bagi <strong>PIHAK PERTAMA</strong>;
                                            </li>
                                            <li>
                                                Penipuan, penggelapan, pencurian, korupsi, penyuapan.
                                            </li>
                                        </ol>
                                    </li>
                                    <li>
                                        Kebijakan yang diambil demi kepentingan dan keberlanjutan Perusahaan PT. Maha Akbar Sejahtera.
                                    </li>
                                </ol>
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> melakukan pengunduran diri secara sukarela dengan melampirkan surat Permohonan pengunduran diri secara tertulis kepada <strong>PIHAK PERTAMA</strong> selambat-lambatnya 30 (tiga puluh) hari kerja sebelum hari terakhir bekerja untuk Level setingkat  Supervisor kebawah, dan 60 (enam puluh) hari kerja untuk Level setingkat Manager keatas sebelum hari terakhir bekerja.
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> dengan ini bersedia memberi pelatihan kepada karyawan baru yang menggantikan dirinya dikarenakan pengunduran diri <strong>PIHAK KEDUA</strong> sebagaimana Pasal 12 Ayat (2) paling sedikit selama 30 (tiga puluh) hari kerja sebelum hari terakhir bekerja.
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> diharuskan mengembalikan barang barang dan/atau asset-aset milik <strong>PIHAK PERTAMA</strong> yang dipercayakan kepada <strong>PIHAK KEDUA</strong> bilamana terjadi Pemutusan Hubungan Kerja dan/atau berakhirnya perjanjian kerja ini.
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
                        <p>PASAL 13</p>
                        <P>KELALAIAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK PERTAMA</strong> berhak memberi teguran kepada <strong>PIHAK KEDUA</strong> baik tertulis ataupun lisan dan/atau pemotongan gaji sesuai dengan kerugian yang dialami perusahaan bilamana ditemukan kelalaian/kesengajaan yang menyebabkan kerugian kepada <strong>PIHAK PERTAMA</strong>.
                            </li>
                            <li>
                                Segala kerugian yang mungkin akan timbul dikemudian hari baik bersifat materil maupun immateril sebagai akibat dari kelalaian ataupun kesengajaan yang dilakukan oleh <strong>PIHAK KEDUA</strong> dalam melaksanakan pekerjaan dan/atau penggunaan asset-aset milik <strong>PIHAK PERTAMA</strong> dalam perjanjian ini termasuk kerugian dan/atau tuntutan dari pihak manapun yang mungkin akan timbul menjadi tanggung jawab <strong>PIHAK KEDUA</strong>.
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 14</p>
                        <P>JENIS PERJANJIAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <p>
                            Perjanjian ini bersifat mengikat dan dapat dilakukan perubahan sesuai dengan kesepakatan <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> secara bersama-sama.
                        </p>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 15</p>
                        <P>PERUBAHAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <p>
                            Perubahan isi surat perjanjian dapat dilakukan apabila <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> menemui kesepakatan bersama untuk mengubah isi perjanjian. Perubahan isi surat perjanjian ini diatur kemudian dalam bentuk Addendum yang ditandatangani <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> serta merupakan satu kesatuan yang tidak terpisahkan dari perjanjian ini.
                        </p>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 16</p>
                        <P>BERAKHIRNYA PERJANJIAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                Perjanjian ini akan berakhir dengan sendirinya bilamana terjadi Pemutusan Hubungan Kerja antara <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> sebagaimana yang terdapat dalam pasal 11 perjanjian ini;
                            </li>
                            <li>
                                <strong>PIHAK PERTAMA</strong> dapat mengakhiri perjanjian ini secara sepihak bilamana <strong>PIHAK KEDUA</strong> melakukan kelalaian, kesengajaan atau hal lainnya yang mengakibatkan kerugian dan/atau mengancam keberlanjutan dan kelangsungan perusahaan PT. Maha Akbar Sejahtera.
                            </li>
                            <li>
                                <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> sepakat untuk mengesampingkan ketentuan dan persyaratan sebagaimana Pasal 1266 dan Pasal 1267 Kitab Undang Undang Hukum Perdata (KUHPerdata) tentang keputusan pengadilan diperlukan untuk mengakhiri perjanjian.
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
                        <p>PASAL 17</p>
                        <P>FORCE MAJEUR</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <p>
                            <strong>PIHAK KEDUA</strong> dengan ini membebaskan <strong>PIHAK PERTAMA</strong> dari segala kerugian maupun tuntutan yang dialami <strong>PIHAK KEDUA</strong> bilamana terjadi keadaan diluar kehendak <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> dan/atau keadaan yang diluar kehendak manusia seperti bencana alam, banjir, kebakaran, ledakan, gempa bumi,  peperangan, huru-hara, keributan, blokade dan wabah penyakit yang secara langsung dapat mempengaruhi isi perjanjian ini.
                        </p>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 18</p>
                        <P>INFORMASI RAHASIA DAN KEPEMILIKAN PERUSAHAAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                Bahwa <strong>PIHAK KEDUA</strong> wajib menjaga semua informasi, data dan dokumen rahasia milik <strong>PIHAK PERTAMA</strong> maupun Perusahaan yang diterima oleh <strong>PIHAK KEDUA</strong> untuk tidak disebar luaskan atau diberitahukan atau digandakan untuk kepentingan Pihak Ketiga atau Pihak Lainnya dan Ketentuan ini berlaku baik selama perjanjian ini berlangsung maupun setelah perjanjian ini berakhir dan diakhiri;
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> secara langsung atau tidak langsung, selama atau setelah masa kerja dilarang memberitahukan informasi yang bersifat rahasia, kepemilikan atas informasi teknik, keuangan, pemasaran, informasi bisnis lainnya atau informasi yang diwajibkan untuk diperlakukan sebagai sesuatu yang bersifat rahasia, atau setiap informasi yang bersifat rahasia yang diedarkan melalui sistem elektronik internal atau lainnya, kecuali telah memperoleh persetujuan <strong>PIHAK PERTAMA</strong>.
                            </li>
                            <li>
                                Bahwa seluruh barang yang disediakan oleh <strong>PIHAK PERTAMA</strong> atau perusahaan untuk keperluan <strong>PIHAK KEDUA</strong> dalam melaksanakan perjanjian ini sepenuhnya adalah milik <strong>PIHAK PERTAMA</strong> atau perusahaan, apabila pada saat pekerjaan telah selesai dilaksanakan atau perjanjian ini telah berakhir maka <strong>PIHAK KEDUA</strong> berkewajiban untuk mengembalikan seketika semua fasilitas tersebut kepada <strong>PIHAK PERTAMA</strong> atau Perusahaan dan dituangkan dalam Berita Acara yang digunakan untuk keperluan tersebut.
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 19</p>
                        <P>KETENTUAN KHUSUS</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                Jika <strong>PIHAK KEDUA</strong> dikemudian hari mengundurkan diri/ berhenti bekerja, maka <strong>PIHAK KEDUA</strong> tidak akan mengajak atau membawa Customer <strong>PIHAK PERTAMA</strong> ketempat <strong>PIHAK KEDUA</strong> akan bekerja nantinya.
                            </li>
                            <li>
                                <strong>PIHAK KEDUA</strong> tidak diperbolehkan memanipulasi data maupun penyelewengan dana dan wewenang yang telah diberikan oleh <strong>PIHAK PERTAMA</strong>.
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
                        <p>PASAL 20</p>
                        <P>PENYELESAIAN PERSELISIHAN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                Segala perselisihan atau perbedaan pendapat antara <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> yang terjadi berkenaan dengan surat perjanjian ini, demikian juga terhadap hal-hal lain yang dianggap sebagai perselisihan akan diselesaikan secara musyawarah dan mufakat.
                            </li>
                            <li>
                                Apabila penyelesaian secara musyawarah dan mufakat tidak mungkin tercapai, maka para Pihak yang mengikatkan diri dalam perjanjian ini sepakat untuk menyelesaikan perselisihan  sesuai dengan ketentuan Undang-Undang No.2 Tahun 2004 tentang Perselisihan Hubungan Industrial.
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="pasal-wrapper">
                    <div class="pasal-title">
                        <p>PASAL 21</p>
                        <P>LAIN - LAIN</P>
                    </div>

                    <div class="pasal-body mt-2">
                        <ol class="p-0">
                            <li>
                                <strong>PIHAK KEDUA</strong> dengan ini menyatakan dan menjamin bahwa telah membaca, memahami,  mengerti  dan menerima perjanjian ini beserta seluruh interpretasi dalam perjanjian ini.
                            </li>
                            <li>
                                Hal-hal yang belum diatur dalam perjanjian ini diatur dalam peraturan perusahaan, prosedur kerja, segala aturan yang mengatur <strong>PIHAK KEDUA</strong> dan perjanjian lain antara <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong>.
                            </li>
                            <li>
                                Para Pihak tidak dapat mengalihkan hak dan kewajiban yang timbul dari pelaksanaan perjanjian ini kepada pihak ketiga tanpa persetujuan tertulis dari pihak lainnya.
                            </li>
                        </ol>
                    </div>
                </div>

                <p class="mt-3">
                    Demikianlah surat perjanjian kerja ini dibuat dan mulai berlaku pada saat ditandatangani oleh <strong>PIHAK PERTAMA</strong> dan <strong>PIHAK KEDUA</strong> sebagaimana tersebut pada awal perjanjian ini dan dibuat dalam 2 (dua) rangkap bermaterai cukup yang masing-masing rangkap mempunyai kekuatan hukum yang sama.
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
