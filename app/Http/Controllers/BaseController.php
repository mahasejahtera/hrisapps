<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $hrisDbName_ = 'mahasejahtera_hrisapps';
    protected $payrollDbName_ = 'mahasejahtera_hrispayroll';
    protected $suratDbName_ = 'mahasejahtera_hrissurat';
    protected $rkkDbName_ = 'mahasejahtera_hrisrkk';


    public function encryptData_($data)
    {
        $cryptMethod = "aes-128-cbc";
        $key = hash('sha256', 'Ptmaha@48');
        $iv = substr(hash('sha256', 'Ptmaha@48'), 0, 16);

        $output = openssl_encrypt(json_encode($data), $cryptMethod, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    public function decryptData_($data)
    {
        $cryptMethod = "aes-128-cbc";
        $key = hash('sha256', 'Ptmaha@48');
        $iv = substr(hash('sha256', 'Ptmaha@48'), 0, 16);

        $output = base64_decode($data);
        $output = openssl_decrypt(json_encode($output), $cryptMethod, $key, 0, $iv);
        return json_decode($output, true);
    }
}
