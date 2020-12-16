<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public static function getRole(){
        $role = Session::get('role_kgb');
        if ($role == 1) {
            return 'Pegawai';
        }
        if ($role == 2) {
            return 'Operator';
        }
        if ($role == 3) {
            return 'Kasubid';
        }
        if ($role == 4) {
            return 'Kabid';
        }
        if ($role == 5) {
            return 'Sekban';
        }
        if ($role == 6) {
            return 'Kaban';
        }
    }
    
    public function indexDashboard(){
        
        $user = DB::connection('mysql2')->table('tbl_pegawai')->where('nip', '=', Session::get('username'))->first();
        if ($user->gelar_belakang) {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama).', '.$user->gelar_belakang;
        }else {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama);
        }
        return view('admin.admin', ['nama_lengkap' => $nama_lengkap, 'nip' =>$user->nip, 'foto' =>$user->image]);
    }

    public function indexRoot(){
        return redirect('/dashboard');
    }

   /*  public function ubahPassword(){
        return view('password.ubahPassword');
    } */

    /* public function getNama(){
        $user = DB::table('tbl_pegawai')->where('nip', '=', Session::get('username'))->first();
        if ($user->gelar_belakang) {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama).', '.$user->gelar_belakang;
        }else {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama);
        }
        $output = $nama_lengkap;

        return response()->json(['nama_lengkap' => $output]);
    } */

    // public function ubahPasswordUser(Request $request){
    //     $user = DB::table('tbl_users')->where('username', $request->username)->first();
    //     if ($request->pass_lama == $user->password) {
    //         # Jika pass lama sama dengan pass baru maka lanjut
    //         DB::table('tbl_users')->where('username', $request->username)->update([
    //             'password' => $request->pass_baru
    //         ]);

    //         return redirect()->to('/')->with('toast_success', 'Password Berhasil Diperbarui');
    //     }else{
    //         return back()->with('toast_error', 'Password Lama Salah');
    //     }

    // }

}
