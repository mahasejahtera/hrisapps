<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\Setjamkerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookIclockController extends Controller
{
    public function index(Request $request){
        $data = $request->post('data');
        $deviceId = $request->get('deviceId');

        if(!empty($data)){
            $collect = collect($data)->groupBy(function($r){
                return $r[0];
            });
            $this->processAttendanceLog($collect, $deviceId);
        }
    }

    private function processAttendanceLog($collect, $deviceId){
        $karyawan = Karyawan::select(['id', 'nik', 'nama_lengkap'])->whereIn('nik', $collect->keys())->get();

        Log::info($collect);
        activity()->withProperties($collect)->log('Get Attendance From ADMS');

        if($karyawan){
            // $rawMessageNotif = [];
            foreach($karyawan as $kry){
                $logs = $collect->get($kry->nik);
                $raw = [];

                // get kode jam kerja
                $hari = hariIndo(date('N'));
                Log::info($hari);
                $jamkerja = Setjamkerja::with(['jam_kerja'])
                            ->where('nik', $kry->nik)
                            ->where('hari', $hari)
                            ->first();

                Log::info($jamkerja);

                $jamMasuk = $jamkerja->jam_kerja->jam_masuk;
                $batasAbsenMasuk = $jamkerja->jam_kerja->akhir_jam_masuk;
                $jamPulang = $jamkerja->jam_kerja->jam_pulang;

                foreach($logs as $log){

                    $tanggal        = $log[1];
                    $jam            = $log[2];
                    $fingerStatus   = $log[3];

                    // get presensi by tanggal
                    $presensi = Presensi::with(['karyawan', 'jam_kerja'])
                                    ->where('tgl_presensi', $tanggal)
                                    ->where('nik', $kry->nik)
                                    ->first();

                    // jam pulang lebih awal atau tidak
                    $earlyOut = 0;
                    if($jam < $jamPulang) $earlyOut = 1;

                    //cek absen status
                    //masuk
                    if($fingerStatus == 0) {
                        if(empty($presensi)) {
                            // cek telat
                            $is_late = 0;
                            if($jam > $jamMasuk) $is_late = 1;
                            // cek status absen diatas batas absen
                            $status = 1;
                            if($jam > $batasAbsenMasuk) $status = 4;

                            $data = [
                                'nik'                   => $kry->nik,
                                'tgl_presensi'          => $tanggal,
                                'jadwal_masuk'          => $jamMasuk,
                                'jadwal_pulang'         => $jamPulang,
                                'jam_in'                => $jam,
                                'kode_jam_kerja'        => $jamkerja->kode_jam_kerja,
                                'status_absen'          => 2,
                                'finger_status'         => $fingerStatus,
                                'is_late'               => $is_late,
                                'status'                => $status,
                                'absen_in_status'       => $status
                            ];

                            Presensi::create($data);
                            Log::info("add presensi masuk $kry->nama_lengkap");
                            activity()->withProperties($data)->log("add presensi masuk $kry->nama_lengkap");
                        }
                    }

                    // pulang
                    if($fingerStatus == 1) {
                        if(!empty($presensi)) {
                            // cek jam pulang kosong atau tidak
                            if(empty($presensi->jam_out)) {
                                // kalau kosong insert
                                $presensi->jam_out = $jam;
                                $presensi->early_out = $earlyOut;
                                $presensi->save();

                                Log::info("Update jam pulang $kry->nama_lengkap");
                                activity()->withProperties(['tanggal' => $tanggal, 'jam_out' => $jam])->log("Update jam pulang $kry->nama_lengkap");
                            } else {
                                // kalau tidak kosong cek apakah jam nya kurang dr jam pulang
                                if($jam <= $jamPulang) {
                                    // jam pulang lebih awal atau tidak
                                    // kalau kosong insert
                                    $presensi->jam_out = $jam;
                                    $presensi->early_out = $earlyOut;
                                    $presensi->lembur_in = $jam;
                                    $presensi->save();

                                    Log::info("Update jam pulang dan lembur mulai $kry->nama_lengkap");
                                    activity()->withProperties(['tanggal' => $tanggal, 'jam_out' => $jam, 'lembur_in' => $jam])->log("Update jam pulang dan lembur mulai $kry->nama_lengkap");
                                } else {
                                    // kalau ada datanya update jam pulang dan lembur mulai
                                    if($presensi->jam_out < $jamPulang) {
                                        $presensi->early_out = $earlyOut;
                                        $presensi->jam_out = $jam;
                                    }
                                    $presensi->lembur_in = $jam;
                                    $presensi->save();

                                    Log::info("Update jam pulang dan lembur mulai $kry->nama_lengkap");
                                    activity()->withProperties(['tanggal' => $tanggal, 'jam_out' => $jam, 'lembur_in' => $jam])->log("Update jam pulang dan lembur mulai $kry->nama_lengkap");
                                }
                            }
                        }
                    }

                    // istirahat mulai
                    if($fingerStatus == 2) {
                        if(!empty($presensi)) {
                            // apakah sudah finger istirahat
                            if(empty($presensi->break_start)) {
                                $presensi->break_start = $jam;
                                $presensi->save();

                                Log::info("Update istirahat mulai $kry->nama_lengkap");
                                activity()->withProperties(['tanggal' => $tanggal, 'break_start' => $jam])->log("Update istirahat mulai $kry->nama_lengkap");
                            }
                        }
                    }

                    // istirahat selesai
                    if($fingerStatus == 3) {
                        if(!empty($presensi)) {
                            // apakah sudah finger istirahat
                            if(empty($presensi->break_finish)) {
                                $presensi->break_finish = $jam;
                                $presensi->save();

                                Log::info("Update istirahat selesai $kry->nama_lengkap");
                                activity()->withProperties(['tanggal' => $tanggal, 'break_finish' => $jam])->log("Update istirahat selesai $kry->nama_lengkap");
                            }
                        }
                    }

                    // lembur mulai
                    if($fingerStatus == 4) {
                        if(!empty($presensi)) {
                            // cek jam pulang kosong atau tidak, kalau kosong input jam pulang dgn jam lembur
                            if(empty($presensi->jam_out)) $presensi->jam_out = $jam;

                            //cek jam lembur kosong atau tidak
                            if(empty($presensi->lembur_in)) {
                                // kalau kosong input jam lembur
                                $presensi->lembur_in = $jam;
                                $presensi->save();

                                Log::info("Update lembur in $kry->nama_lengkap");
                                activity()->withProperties(['tanggal' => $tanggal, 'lembur_in' => $jam])->log("Update lembur in $kry->nama_lengkap");
                            } else {
                                // kalau ada isi cek jam lembur nya < jam pulang atau tidak
                                if($presensi->lembur_in < $jamPulang) {
                                    // kalau < maka insert jam lembur
                                    $presensi->lembur_in = $jam;
                                    $presensi->save();

                                    Log::info("Update lembur in $kry->nama_lengkap");
                                    activity()->withProperties(['tanggal' => $tanggal, 'lembur_in' => $jam])->log("Update lembur in $kry->nama_lengkap");
                                }
                            }
                        }
                    }

                    // lembur selesai
                    if($fingerStatus == 5) {
                        if(!empty($presensi)) {
                            // apakah sudah finger lembur
                            if(empty($presensi->lembur_in)) {
                                $presensi->lembur_out = $jam;
                                $presensi->save();

                                Log::info("Update lembur selesai $kry->nama_lengkap");
                                activity()->withProperties(['tanggal' => $tanggal, 'lembur_out' => $jam])->log("Update lembur selesai $kry->nama_lengkap");
                            }
                        } else {
                            $tanggalKemarin = date('Y-m-d', strtotime("-1 day", strtotime($tanggal)));

                            // get presensi tanggal kemarin
                            $presensiKemarin = Presensi::with(['karyawan', 'jam_kerja'])
                                        ->where('tgl_presensi', $tanggalKemarin)
                                        ->where('nik', $kry->nik)
                                        ->first();

                            if(!empty($presensiKemarin)) {
                                $presensiKemarin->lembur_out = $jam;
                                $presensiKemarin->save();

                                Log::info("Update lembur selesai $kry->nama_lengkap");
                                activity()->withProperties(['tanggal' => $tanggalKemarin, 'lembur_out' => $jam])->log("Update lembur selesai $kry->nama_lengkap");
                            }
                        }
                    }
                    // $rawMessageNotif[] = $kry->code_name.' finger at '.$log[1].' '.$log[2];
                }
                // AttendanceLogfinger::upsert($raw, ['employee_id', 'fingertime']);
            }

            // if($rawMessageNotif){
            //     $messageJob = '*EasyHRIS - LJP* '.PHP_EOL.'Log Finger'.PHP_EOL.implode(PHP_EOL, $rawMessageNotif).PHP_EOL.Carbon::now()->format('j M Y H:i:s');
            //     $userIdTelegram = Setting::where(['type' => 'notification', 'name' => 'id_telegram'])->first();
            //     if($userIdTelegram){
            //         if(!empty($userIdTelegram->value)){
            //             Notification::route('telegram', 'easyhhris - LJP')->notify(new AlertNotification(new AlertMessage($messageJob, $userIdTelegram->value)));
            //             // Notification::send(\Auth::user(), new AlertNotification(new AlertMessage($messageJob, $userIdTelegram->value)));
            //         }
            //     }
            // }
        }
    }
}
