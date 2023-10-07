<?php

namespace App\Http\Controllers\Rencanakerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Rencanakerja;

class ManajerController extends Controller
{

    public function option()
    {
        return view('rencanakerja.manajer.option');
    }

    public function listrkk()
    {
        return view('rencanakerja.manajer.listrkk');

    }

    public function detailrkkkaryawan(Request $request)
    {
        return view('rencanakerja.manajer.detail-rkk-karyawan');

    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
