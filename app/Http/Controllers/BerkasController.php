<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class BerkasController extends Controller
{
    public function iberkas(){
        $user = DB::connection('mysql2')->table('tbl_pegawai')->where('nip', '=', Session::get('username'))->first();
        if ($user->gelar_belakang) {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama).', '.$user->gelar_belakang;
        }else {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama);
        }
        $output = $nama_lengkap;
        
        //$data = DB::table('tbl_persyaratan');
        //$data = DB::table('tbl_permohonan');

         return view('berkas.berkas_kenaikan',
                        ['nama_lengkap'=>$output, 
                         'nip' => $user->nip,
                        //'datas'=>$data->id_berkas
                        ]);

    }

    public function getSyarat(){
        $query = DB::table('tbl_persyaratan')->where('jenis_dokumen', '=', 'kenaikan');

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
        ->addColumn('detail_doc', function($row){
            $btn ='';
            //$btn = '<a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-search" aria-hidden="true"></i></a>';
            $btn = '<a href="javascript:void(0)" role="button" data-id="'.Session::get('username').'/'.$row->id_berkas.'" class="btn btn-primary shadow btn-xs sharp mr-1 lihatFile"><i class="fa fa-search" aria-hidden="true"></i></a>';
            return $btn;
        })
        ->addColumn('upload', function($row){
            $btn ='';
            $btn = '<a href="javascript:void(0)" role="button" data-id="'.$row->id_berkas.'" class="btn btn-primary shadow btn-xs sharp mr-1 upload"><i class="fa fa-upload" aria-hidden="true"></i></a>';
            return $btn;
        })
        ->addColumn('status', function($row){
            $output = '<i class="fa fa-circle text-danger mr-1"></i>';
            return $output;
        })
        ->rawColumns(['nama_dokumen', 'keterangan', 'detail_doc', 'upload','status'])
        ->make(true);
    }

    public function upload(Request $request){
        $file = $request->file('file');
        //$id_permohonan = $request->id_permohonan;
        $nama_berkas = $request->namaberkas;
        $id_syarat = $request->id_syarat;
        $jenis = $request->jenis;
        //$time = time();
        $berkas = $nama_berkas.'_'.$id_syarat;

        $file->getClientOriginalName();
        $file->getClientOriginalExtension();
        $file->getSize();

        $tujuan_upload = 'berkas_upload/'.$jenis.'/'.$nama_berkas;
        $file->move($tujuan_upload,$berkas.'.pdf');

        //dd($tujuan_upload);

         /* $tambah = DB::table('tbl_berkas')->insert([
            'id_berkas'     =>$request->id_berkas,
            'id_permohonan' => $request->id_permohonan,
            'jenis_berkas'  => $request->jenis,
            'dokumen'       => $berkas,
            
        ]); */
/* 
        if ($tambah) {
            return response()->json(['success' => 'Data berhasil ditambahkan']);
        }else{
            return response()->json(['error' => 'Data gagal ditambahkan']);
        } */
        return response()->json(['success' => 'Data berhasil ditambahkan']);

    }

}
