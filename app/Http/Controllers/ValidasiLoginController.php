<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ValidasiLoginController extends Controller
{
    public function login(){
        return view('auth.login');
        
    }

    public function validasiLogin(Request $request){
        //Mengambil data dari DB Sijafung
        $user = DB::connection('mysql2')->table('tbl_users')->where('username', $request->username)->first();
        if ($user) {
            if ($user->username == $request->username && $user->password == $request->password) {
                    $request->session()->put('username', $user->username);
                    $request->session()->put('role_kgb', $user->role_kgb);
             if (DashboardController::getRole() == "Pegawai") {
                return redirect()->to('/dashboard');
             }
                return redirect()->to('/dashboard');
            }else {
                return back()->with('toast_error', 'Login Gagal, Silahkan Coba Lagi');
            }
        }else{
            return back()->with('toast_error', 'Maaf Anda Belum Terdaftar');
        }      

    }

    public function logout(Request $request){
        DB::table('tbl_users')->where('username', $request->session()->get('username'));

        $request->session()->flush();
		return redirect()->to('/login')->with('toast_info', 'Semoga Hari Anda Menyenangkan');;
    }
}
