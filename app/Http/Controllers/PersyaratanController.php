<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class PersyaratanController extends Controller
{
    /* Kenaikan Jabatan */
    public function iSyaratKenaikanJbt(){
        $user = DB::connection('mysql2')->table('tbl_pegawai')->where('nip', '=', Session::get('username'))->first();
        if ($user->gelar_belakang) {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama).', '.$user->gelar_belakang;
        }else {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama);
        }

        return view('persyaratan.persyaratan_kenaikan_jbt', ['nama_lengkap'=>$nama_lengkap, 'nip'=>$user->nip]);
    }

    public function getSyaratKenaikan(){
        $query = DB::table('tbl_persyaratan')->where('jenis_dokumen', '=', 'kenaikan')->orderByDesc('id_dokumen');

        return DataTables::queryBuilder($query)
        ->addIndexColumn()
        ->addColumn('nama_dokumen', function($row){
            $output = $row->nama_dokumen;
            return $output;
        })
        ->addColumn('keterangan', function($row){
            $output = $row->keterangan;
            return $output;
        })
        ->addColumn('aksi', function($row){
            $btn = '<a href="javascript:void(0)" data-id="'.$row->id_dokumen.'" title="Hapus" class="btn btn-danger shadow btn-xs sharp mr-1 hapusData"><i class="fa fa-trash"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id_dokumen.'" title="Edit" class="btn btn-info shadow btn-xs sharp mr-1 editData"><i class="fa fa-edit"></i></a>';
    
            return $btn;
        })
        ->rawColumns(['nama_dokumen', 'keterangan', 'aksi'])
        ->make(true);
    }

    public function getIdSyaratKenaikan($id){
        $data = DB::table('tbl_persyaratan')->where('id_dokumen', '=', $id)->first();

        return response()->json(['data' => $data]);
    }

    public function addSyaratKenaikan(Request $request){
        if ($request->action == "tambah") {
            $add = DB::table('tbl_persyaratan')->insert([

                'nama_dokumen'       =>$request->nama_dokumen,
                'jenis_dokumen'      => 'kenaikan',
                'keterangan'        =>$request->keterangan,
                'created'           => Carbon::now()

            ]);

            if ($add) {
                return response()->json(['success' => 'Data Berhasil Ditambahkan']);
            }else{
                return response()->json(['error' => 'Data Gagal Ditambahkan']);
            }
        }else{
            $update = DB::table('tbl_persyaratan')->where('id_dokumen', '=', $request->id_dokumen)->update([
                'id_dokumen'     => $request->id_dokumen,
                'nama_dokumen'   => $request->nama_dokumen,
                'keterangan'    => $request->keterangan,
                'modified'      => Carbon::now()
            ]);

            if ($update) {
                return response()->json(['success' => 'Data Berhasil Diubah']);
            }else {
                return response()->json(['error' => 'Data Gagal Diubah']);
            }
        }
    }
    /* End */

    /* Alih Kelompok */
    public function iSyaratAlihKlmpk(){
        $user = DB::connection('mysql2')->table('tbl_pegawai')->where('nip', '=', Session::get('username'))->first();
        if ($user->gelar_belakang) {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama).', '.$user->gelar_belakang;
        }else {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama);
        }
        
        return view('persyaratan.persyaratan_alih_klmpk', ['nama_lengkap'=>$nama_lengkap, 'nip'=>$user->nip]);
    
    }

    public function getSyaratAlih(){
        $query = DB::table('tbl_persyaratan')->where('jenis_dokumen', '=', 'alih')->orderByDesc('id_dokumen');

        return DataTables::queryBuilder($query)
        ->addIndexColumn()
        ->addColumn('nama_dokumen', function($row){
            $output = $row->nama_dokumen;
            return $output;
        })
        ->addColumn('keterangan', function($row){
            $output = $row->keterangan;
            return $output;
        })
        ->addColumn('aksi', function($row){
            $btn = '<a href="javascript:void(0)" data-id="'.$row->id_dokumen.'" title="Hapus" class="btn btn-danger shadow btn-xs sharp mr-1 hapusData"><i class="fa fa-trash"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id_dokumen.'" title="Edit" class="btn btn-info shadow btn-xs sharp mr-1 editData"><i class="fa fa-edit"></i></a>';
            
            return $btn;
        })
        ->rawColumns(['nama_dokumen', 'keterangan', 'aksi'])
        ->make(true);
    }

    public function getIdSyaratAlih($id){
        $data = DB::table('tbl_persyaratan')->where('id_dokumen', '=', $id)->first();

        return response()->json(['data' => $data]);
    }
    
    public function addSyaratAlih(Request $request){
        if ($request->action == "tambah") {
            $add = DB::table('tbl_persyaratan')->insert([
                
                'nama_dokumen'       =>$request->nama_dokumen,
                'jenis_dokumen'      => 'alih',
                'keterangan'        =>$request->keterangan,
                'created'           => Carbon::now()
                
            ]);
            
            if ($add) {
                return response()->json(['success' => 'Data Berhasil Ditambahkan']);
            }else{
                return response()->json(['error' => 'Data Gagal Ditambahkan']);
            }
        }else{
            $update = DB::table('tbl_persyaratan')->where('id_dokumen', '=', $request->id_dokumen)->update([
                'id_dokumen'     => $request->id_dokumen,
                'nama_dokumen'   => $request->nama_dokumen,
                'keterangan'    => $request->keterangan,
                'modified'      => Carbon::now()
                ]);
                
                if ($update) {
                    return response()->json(['success' => 'Data Berhasil Diubah']);
                }else {
                return response()->json(['error' => 'Data Gagal Diubah']);
            }
        }
    }
    /* End */

    /* Inpassing Guru */
    public function iSyaratInpassing(){
        $user = DB::connection('mysql2')->table('tbl_pegawai')->where('nip', '=', Session::get('username'))->first();
        if ($user->gelar_belakang) {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama).', '.$user->gelar_belakang;
        }else {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama);
        }
        
        return view('persyaratan.persyaratan_inpassing_gr', ['nama_lengkap'=>$nama_lengkap, 'nip'=>$user->nip]);
    
    }

    public function getSyaratInpassing(){
        $query = DB::table('tbl_persyaratan')->where('jenis_dokumen', '=', 'inpassing')->orderByDesc('id_dokumen');

        return DataTables::queryBuilder($query)
        ->addIndexColumn()
        ->addColumn('nama_dokumen', function($row){
            $output = $row->nama_dokumen;
            return $output;
        })
        ->addColumn('keterangan', function($row){
            $output = $row->keterangan;
            return $output;
        })
        ->addColumn('aksi', function($row){
            $btn = '<a href="javascript:void(0)" data-id="'.$row->id_dokumen.'" title="Hapus" class="btn btn-danger shadow btn-xs sharp mr-1 hapusData"><i class="fa fa-trash"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id_dokumen.'" title="Edit" class="btn btn-info shadow btn-xs sharp mr-1 editData"><i class="fa fa-edit"></i></a>';
            
            return $btn;
        })
        ->rawColumns(['nama_dokumen', 'keterangan', 'aksi'])
        ->make(true);
    }

    public function getIdSyaratInpassing($id){
        $data = DB::table('tbl_persyaratan')->where('id_dokumen', '=', $id)->first();

        return response()->json(['data' => $data]);
    }
    
    public function addSyaratInpassing(Request $request){
        if ($request->action == "tambah") {
            $add = DB::table('tbl_persyaratan')->insert([
                
                'nama_dokumen'       =>$request->nama_dokumen,
                'jenis_dokumen'      => 'inpassing',
                'keterangan'        =>$request->keterangan,
                'created'           => Carbon::now()
                
            ]);
            
            if ($add) {
                return response()->json(['success' => 'Data Berhasil Ditambahkan']);
            }else{
                return response()->json(['error' => 'Data Gagal Ditambahkan']);
            }
        }else{
            $update = DB::table('tbl_persyaratan')->where('id_dokumen', '=', $request->id_dokumen)->update([
                'id_dokumen'     => $request->id_dokumen,
                'nama_dokumen'   => $request->nama_dokumen,
                'keterangan'    => $request->keterangan,
                'modified'      => Carbon::now()
                ]);
                
                if ($update) {
                    return response()->json(['success' => 'Data Berhasil Diubah']);
                }else {
                return response()->json(['error' => 'Data Gagal Diubah']);
            }
        }
    }
    /* end */

    /* Pemberhentian */
    public function iSyaratPemberhentian(){
        $user = DB::connection('mysql2')->table('tbl_pegawai')->where('nip', '=', Session::get('username'))->first();
        if ($user->gelar_belakang) {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama).', '.$user->gelar_belakang;
        }else {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama);
        }
        
        return view('persyaratan.persyaratan_pemberhentian', ['nama_lengkap'=>$nama_lengkap, 'nip'=>$user->nip]);
    
    }

    public function getSyaratPemberhentian(){
        $query = DB::table('tbl_persyaratan')->where('jenis_dokumen', '=', 'henti')->orderByDesc('id_dokumen');

        return DataTables::queryBuilder($query)
        ->addIndexColumn()
        ->addColumn('nama_dokumen', function($row){
            $output = $row->nama_dokumen;
            return $output;
        })
        ->addColumn('keterangan', function($row){
            $output = $row->keterangan;
            return $output;
        })
        ->addColumn('aksi', function($row){
            $btn = '<a href="javascript:void(0)" data-id="'.$row->id_dokumen.'" title="Hapus" class="btn btn-danger shadow btn-xs sharp mr-1 hapusData"><i class="fa fa-trash"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id_dokumen.'" title="Edit" class="btn btn-info shadow btn-xs sharp mr-1 editData"><i class="fa fa-edit"></i></a>';
            
            return $btn;
        })
        ->rawColumns(['nama_dokumen', 'keterangan', 'aksi'])
        ->make(true);
    }

    public function getIdSyaratPemberhentian($id){
        $data = DB::table('tbl_persyaratan')->where('id_dokumen', '=', $id)->first();

        return response()->json(['data' => $data]);
    }
    
    public function addSyaratPemberhentian(Request $request){
        if ($request->action == "tambah") {
            $add = DB::table('tbl_persyaratan')->insert([
                
                'nama_dokumen'       =>$request->nama_dokumen,
                'jenis_dokumen'      => 'henti',
                'keterangan'        =>$request->keterangan,
                'created'           => Carbon::now()
                
            ]);
            
            if ($add) {
                return response()->json(['success' => 'Data Berhasil Ditambahkan']);
            }else{
                return response()->json(['error' => 'Data Gagal Ditambahkan']);
            }
        }else{
            $update = DB::table('tbl_persyaratan')->where('id_dokumen', '=', $request->id_dokumen)->update([
                'id_dokumen'     => $request->id_dokumen,
                'nama_dokumen'   => $request->nama_dokumen,
                'keterangan'    => $request->keterangan,
                'modified'      => Carbon::now()
                ]);
                
                if ($update) {
                    return response()->json(['success' => 'Data Berhasil Diubah']);
                }else {
                return response()->json(['error' => 'Data Gagal Diubah']);
            }
        }
    }
    /* End */

    public function deleteSyarat($id){
        $delete =DB::table('tbl_persyaratan')->where('id_dokumen', '=', $id)->delete();
    
        if ($delete) {
            return response()->json(['success' => 'Data Berhasil Dihapus']);
        }else{
            return response()->json(['error' => 'Data Gagal Dihapus']);
        }

    }
}
