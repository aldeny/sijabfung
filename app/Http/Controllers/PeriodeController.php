<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PeriodeController extends Controller
{
    public function iPeriode(){

        $user = DB::connection('mysql2')->table('tbl_pegawai')->where('nip', '=', Session::get('username'))->first();
        if ($user->gelar_belakang) {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama).', '.$user->gelar_belakang;
        }else {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama);
        }
		$output = $nama_lengkap; 

		$status_pengajuan = DB::select("SELECT * FROM tbl_pengajuan WHERE nip = :nip ORDER BY       
		id_pengajuan DESC LIMIT 1", ['nip' => Session::get('username')]);

		// if ($id == 1) {
		// 	return view('pengajuan.kenaikan_jabatan', ['nama_lengkap' => $output, 'nip' => $user->nip, 'status' =>$status_pengajuan]);

		// }
        return view('periode.periode', ['nama_lengkap' => $output, 'nip' => $user->nip, 'status' =>$status_pengajuan]);
	
    }
}
