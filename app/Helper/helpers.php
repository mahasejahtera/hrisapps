<?php
function hitungjamterlambat($jadwal_jam_masuk, $jam_presensi)
{
    $j1 = strtotime($jadwal_jam_masuk);
    $j2 = strtotime($jam_presensi);

    $diffterlambat = $j2 - $j1;

    $jamterlambat = floor($diffterlambat / (60 * 60));
    $menitterlambat = floor(($diffterlambat - ($jamterlambat * (60 * 60))) / 60);

    $jterlambat = $jamterlambat <= 9 ? "0" . $jamterlambat : $jamterlambat;
    $mterlambat = $menitterlambat <= 9 ? "0" . $menitterlambat : $menitterlambat;


    $terlambat = $jterlambat . ":" . $mterlambat;
    return $terlambat;
}


function hitungjamterlambatdesimal($jam_masuk, $jam_presensi)
{
    $j1 = strtotime($jam_masuk);
    $j2 = strtotime($jam_presensi);

    $diffterlambat = $j2 - $j1;

    $jamterlambat = floor($diffterlambat / (60 * 60));
    $menitterlambat = floor(($diffterlambat - ($jamterlambat * (60 * 60))) / 60);

    // $jterlambat = $jamterlambat <= 9 ? "0" . $jamterlambat : $jamterlambat;
    // $mterlambat = $menitterlambat <= 9 ? "0" . $menitterlambat : $menitterlambat;

    $jterlambat = $jamterlambat <= 9 ? "0" . $jamterlambat : $jamterlambat;
    $mterlambat = $menitterlambat <= 9 ? "0" . $menitterlambat : $menitterlambat;


    $desimalterlambat = ROUND(($menitterlambat / 60), 2);
    // return $desimalterlambat;
    // return intval($jterlambat) . '.' . intval($mterlambat);
    return $mterlambat + 60;
}

function jumlahHari($tglAwal, $tglAkhir)
{
    $tgl1 = strtotime($tglAwal);
    $tgl2 = strtotime($tglAkhir);
    $jarak = $tgl2 - $tgl1;

    $hari = ($jarak / 60 / 60 / 24) + 1;
    return $hari;
}

function jumlahHariMinggu($startDate, $endDate) {
    $startTimestamp = strtotime($startDate);
    $endTimestamp = strtotime($endDate);

    $sundayCount = 0;

    // Loop melalui setiap hari dalam rentang waktu
    for ($currentTimestamp = $startTimestamp; $currentTimestamp <= $endTimestamp; $currentTimestamp += 86400) {
        // 86400 detik = 1 hari
        $currentDayOfWeek = date('N', $currentTimestamp);

        // Jika hari ini adalah Minggu (7 adalah hari Minggu dalam format ISO-8601)
        if ($currentDayOfWeek == 7) {
            $sundayCount++;
        }
    }

    return $sundayCount;
}


// bulan indo
function bulanIndo($bulan)
{
    $bulanIndo = '';

    switch ($bulan) {
        case '01':
            $bulanIndo = 'Januari';
            break;
        case '02':
            $bulanIndo = 'Februari';
            break;
        case '03':
            $bulanIndo = 'Maret';
            break;
        case '04':
            $bulanIndo = 'April';
            break;
        case '05':
            $bulanIndo = 'Mei';
            break;
        case '06':
            $bulanIndo = 'Juni';
            break;
        case '07':
            $bulanIndo = 'Juli';
            break;
        case '08':
            $bulanIndo = 'Agustus';
            break;
        case '09':
            $bulanIndo = 'September';
            break;
        case '10':
            $bulanIndo = 'Oktober';
            break;
        case '11':
            $bulanIndo = 'November';
            break;
        case '12':
            $bulanIndo = 'Desember';
            break;
        default:
            $bulanIndo = 'Januari';
            break;
        }

        return $bulanIndo;
}


function bulanRomawi($bulan)
{
    $bulanRomawi = '';

    switch ($bulan) {
        case 1:
            $bulanRomawi = 'I';
            break;
        case 2:
            $bulanRomawi = 'II';
            break;
        case 3:
            $bulanRomawi = 'III';
            break;
        case 4:
            $bulanRomawi = 'IV';
            break;
        case 5:
            $bulanRomawi = 'V';
            break;
        case 6:
            $bulanRomawi = 'VI';
            break;
        case 7:
            $bulanRomawi = 'VII';
            break;
        case 8:
            $bulanRomawi = 'VIII';
            break;
        case 9:
            $bulanRomawi = 'IX';
            break;
        case 10:
            $bulanRomawi = 'X';
            break;
        case 11:
            $bulanRomawi = 'XI';
            break;
        case 12:
            $bulanRomawi = 'XII';
            break;
        default:
            $bulanRomawi = 'I';
            break;
    }

    return $bulanRomawi;
}


function tanggalIndo($tanggalInggris)
{
    [$year, $month, $date] = explode('-', $tanggalInggris);

    $tanggalIndo = "$date-$month-$year";
    return $tanggalIndo;
}


function tanggalBulanIndo($tanggalInggris)
{
    [$year, $month, $date] = explode('-', $tanggalInggris);

    $tanggalIndo = "$date " . bulanIndo($month) . " $year";
    return $tanggalIndo;
}


function tanggalIndoText($tanggalIndo)
{
    [$date, $month, $year] = explode('-', $tanggalIndo);

    // tanggal teks
    $dateInt = intval($date);
    $dateTeks = '';

    if($dateInt <= 11) {
        $dateTeks = angkaTeks($dateInt);
    }

    if($dateInt > 11 && $dateInt < 20) {
        $teks = substr($dateInt, -1, 1);
        $dateTeks = angkaTeks($teks) . ' belas';
    }

    if($dateInt >= 20 && $dateInt < 100) {
        $angka1 = angkaTeks(substr($dateInt,0,1));
        $angka2 = angkaTeks(substr($dateInt,-1,1));
        $dateTeks = "$angka1 puluh $angka2";
    }


    //  tahun teks
    $angka1 = angkaTeks(substr($year, 0,1));
    $angka2 = angkaTeks(substr($year, 1,1));
    $angka3 = angkaTeks(substr($year, 2,1));
    $angka4 = angkaTeks(substr($year, 3,1));

    $yearTeks ='';

    if(substr($year, 0,1) == 1) {
        $yearTeks .= 'seribu';
    } else {
        $yearTeks .= "$angka1 ribu";
    }

    if(substr($year, 1,1) != 0) $yearTeks .= " $angka2 ratus";
    if(substr($year, 2,1) != 0) $yearTeks .= " $angka3 puluh";

    $yearTeks .= " $angka4";

    // result teks
    $result = "$dateTeks " . strtolower(bulanIndo($month)) . " $yearTeks";

    return  $result;
}


function hitungJumlahhari($tglAwal, $tglAkhir)
{
    $tgl1 = strtotime($tglAwal);
    $tgl2 = strtotime($tglAkhir);

    $selisih = $tgl2 - $tgl1;
    $selisihHari = $selisih / 60 / 60 / 24 + 1;
    return $selisihHari . ' Hari';
}


function angkaTeks($angka)
{

    $resultAngka = '';

    switch ($angka) {
        case 1:
            $resultAngka = 'satu';
            break;
        case 2:
            $resultAngka = 'dua';
            break;
        case 3:
            $resultAngka = 'tiga';
            break;
        case 4:
            $resultAngka = 'empat';
            break;
        case 5:
            $resultAngka = 'lima';
            break;
        case 6:
            $resultAngka = 'enam';
            break;
        case 7:
            $resultAngka = 'tujuh';
            break;
        case 8:
            $resultAngka = 'delapan';
            break;
        case 9:
            $resultAngka = 'sembilan';
            break;
        case 10:
            $resultAngka = 'sepuluh';
            break;
        case 11:
            $resultAngka = 'sebelas';
            break;
        case 100:
            $resultAngka = 'seratus';
            break;
        case 1000:
            $resultAngka = 'seribu';
            break;
        default :
            $resultAngka = '';
            break;
    }

    return $resultAngka;
}

// bilangan teks
function bilanganTeks($number) {
    $resultTeks = '';

    if(strlen($number) < 3) $resultTeks = bilanganTwoDigit($number);
    if(strlen($number) == 3) $resultTeks = bilanganThreeDigit($number);
    if(strlen($number) == 4) $resultTeks = bilanganFourDigit($number);
    if(strlen($number) == 5) $resultTeks = bilanganFiveDigit($number);
    if(strlen($number) == 6) $resultTeks = bilanganSixDigit($number);
    if(strlen($number) == 7) $resultTeks = bilanganSevenDigit($number);
    if(strlen($number) == 8) $resultTeks = bilanganEightDigit($number);
    if(strlen($number) == 9) $resultTeks = bilanganNineDigit($number);

    return $resultTeks;
}

function bilanganTwoDigit($bilangan) {

    $bilanganTeks = '';

    if($bilangan <= 11) {
        $bilanganTeks = angkaTeks($bilangan);
    }

    if($bilangan > 11 && $bilangan < 20) {
        $teks = substr($bilangan, -1, 1);
        $bilanganTeks = angkaTeks($teks) . ' belas';
    }

    if($bilangan >= 20 && $bilangan < 100) {
        $angka1 = angkaTeks(substr($bilangan,0,1));
        $angka2 = angkaTeks(substr($bilangan,-1,1));
        $bilanganTeks = "$angka1 puluh $angka2";
    }

    return $bilanganTeks;
}

function bilanganThreeDigit($bilangan) {
    $bilanganTeks ='';
    $angka1 = substr($bilangan,0,1);

    if($angka1 == 1) {
        $bilanganTeks = 'seratus ';
    } else {
        $bilanganTeks = (angkaTeks($angka1)) ? angkaTeks($angka1) . ' ratus ' : '';
    }

    $bilanganTeks .= bilanganTwoDigit(substr($bilangan,1));

    return $bilanganTeks;
}

function bilanganFourDigit($bilangan) {
    $bilanganTeks ='';
    $angka1 = substr($bilangan,0,1);

    if($angka1 == 1) {
        $bilanganTeks = 'seribu ';
    } else {
        $bilanganTeks = (angkaTeks($angka1)) ? angkaTeks($angka1) . ' ribu ' : '';
    }

    $bilanganTeks .= bilanganThreeDigit(substr($bilangan,1));

    return $bilanganTeks;
}

function bilanganFiveDigit($bilangan) {
    $bilanganTeks ='';

    $bilanganTeks = bilanganTwoDigit(substr($bilangan,0,2)) . ' ribu ' . bilanganThreeDigit(substr($bilangan,2));

    return $bilanganTeks;
}


function bilanganSixDigit($bilangan) {
    $bilanganTeks ='';

    $bilanganTeks = (bilanganThreeDigit(substr($bilangan,0,3))) ? bilanganThreeDigit(substr($bilangan,0,3)) . ' ribu ' . bilanganThreeDigit(substr($bilangan,3)) : '';

    return $bilanganTeks;
}


function bilanganSevenDigit($bilangan) {
    $bilanganTeks ='';

    $bilanganTeks = angkaTeks(substr($bilangan,0,1)) . ' juta ' . bilanganSixDigit(substr($bilangan,1));

    return $bilanganTeks;
}


function bilanganEightDigit($bilangan) {
    $bilanganTeks ='';

    $bilanganTeks = bilanganTwoDigit(substr($bilangan,0,2)) . ' juta ' . bilanganSixDigit(substr($bilangan,2));

    return $bilanganTeks;
}


function bilanganNineDigit($bilangan) {
    $bilanganTeks ='';

    $bilanganTeks = bilanganThreeDigit(substr($bilangan,0,3)) . ' juta ' . bilanganSixDigit(substr($bilangan,3));

    return $bilanganTeks;
}

// hari indo
function hariIndo($dayInt) {
    $hariIndo ='';

    switch ($dayInt) {
        case 1:
            $hariIndo = 'Senin';
            break;
        case 2:
            $hariIndo = 'Selasa';
            break;
        case 3:
            $hariIndo = 'Rabu';
            break;
        case 4:
            $hariIndo = 'Kamis';
            break;
        case 5:
            $hariIndo = 'Jumat';
            break;
        case 6:
            $hariIndo = 'Sabtu';
            break;
        case 7:
            $hariIndo = 'Minggu';
            break;
        default:
            $hariIndo = '';
            break;
    }

    return $hariIndo;
}


// hitung umur
function hitungUmur($tanggal_lahir){
	$birthDate = new DateTime($tanggal_lahir);
	$today = new DateTime("today");
	if ($birthDate > $today) {
	    exit("0 tahun 0 bulan 0 hari");
	}
	$y = $today->diff($birthDate)->y;
	// $m = $today->diff($birthDate)->m;
	// $d = $today->diff($birthDate)->d;
	return "$y Tahun" ;
}




/*========================================
            STATUS LABEL
========================================*/

// pengajuan Izin
function labelStatusApprovedIzin($status=0)
{
    $label ='';

    switch ($status) {
        case 0 :
            $label = 'Pending Manager';
            break;
        case 1 :
            $label = 'Pending GM';
            break;
        case 2 :
            $label = 'Pending HRD';
            break;
        case 3 :
            $label = 'Pending Direktur';
            break;
        case 4 :
            $label = 'Pending Komisaris';
            break;
        case 5 :
            $label = 'Approved';
            break;
        case 6 :
            $label = 'Ditolak Manager';
            break;
        case 7 :
            $label = 'Ditolak GM';
            break;
        case 8 :
            $label = 'Ditolak HRD';
            break;
        case 9 :
            $label = 'Ditolak Direktur';
            break;
        case 10 :
            $label = 'Ditolak Komisaris';
            break;
        case 11 :
            $label = 'Proses Input';
            break;

        default:
            $label = 'Pending -';
            break;
    }

    return $label;
}
