<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{
    public function register(Request $request){
        
        DB::table('tbl_users')->insert([

            'username'      => $request->nip,
            'nama'          => $request->nama,
            'role'          => 6,
            'password'      => $request->pass,
            'created'       => Carbon::now()
        ]);
        
        return back()->with('toast_success', 'Berhasil Mendaftar');

    }
}
