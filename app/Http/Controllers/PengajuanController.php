<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PengajuanController extends Controller
{
    public function ikenaikanJabatan(){

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
        return view('pengajuan.kenaikan_jabatan', ['nama_lengkap' => $output, 'nip' => $user->nip, 'status' =>$status_pengajuan]);
	
	}

    public function getDraftPengajuan(){
		$where = Session::get('username');
        $query = DB::table('tbl_pengajuan')->where('nip', '=', $where)->orderByDesc('created');
        
		return DataTables::queryBuilder($query)
		->addIndexColumn()
		->addColumn('nama_nip', function($row){
			$pegawai  = DB::connection('mysql2')->table('tbl_pegawai')->where('nip', '=', $row->nip)->first();
			if($pegawai->gelar_belakang){
				$nama_lengkap = $pegawai->gelar_depan.' '.strtoupper($pegawai->nama).', '.$pegawai->gelar_belakang;
			}else{
				$nama_lengkap = $pegawai->gelar_depan.' '.strtoupper($pegawai->nama);
			}
			$output = '<b>'.$nama_lengkap.'</b><br/>('.$pegawai->nip.')';
			return $output;
		}) 
		->addColumn('created', function($row){
			//$output = $row->created;
			//return $output;
			return $row->created ? with(new Carbon($row->created))->format('d/m/Y') : '';
		})
		->editColumn('status', function($row){
			$output = '';
			if ($row->status_pengajuan == 'Diajukan'){
				$output = '<a href="javascript:void()" class="badge badge-rounded badge-danger">Diajukan</a>';
			}elseif($row->status_pengajuan == 'Diproses'){
				$output = '<a href="javascript:void()" class="badge badge-rounded badge-warning">Diproses</a>';
			}elseif($row->status_pengajuan == 'Ditolak'){
				$output = '<a href="javascript:void()" class="badge badge-rounded badge-danger">Ditolak</a>';
			}else{
				$output = '<a href="javascript:void()" class="badge badge-rounded badge-success">Disetujui</a>';
			}
			return $output;
		})
        ->addColumn('aksi', function($row){
		 	$btn = '';
			if ($row->status_pengajuan == 'Ditolak') {
				$btn = '<a data-id="" title="Ditolak" class=""><i class="fa fa-times"></i></a>';
			}else {
				$btn = '<a href="javascript:void(0)" data-id="'.$row->id_pengajuan.'" title="Hapus" class="btn btn-danger shadow btn-xs sharp mr-1 hapusData"><i class="fa fa-trash"></i></a>';
				$btn = $btn.' <a href="javascript:void(0)" data-id="'.$row->id_pengajuan.'" title="Edit" class="btn btn-info shadow btn-xs sharp mr-1 editData"><i class="fa fa-edit"></i></a>';
			}
			 return $btn;
		 })
		 ->editColumn('proses', function($row){
			 $btn ='';
			if ($row->tahap_pengajuan == '1') {
				$btn = '<a href="/upload/berkas" role="button" data-id="'.$row->id_pengajuan.' title="Upload" class="btn btn-xxs btn-primary">
				<i class="fa fa-upload"></i></a>';
			}if($row->tahap_pengajuan == '2'){
				$btn = '<a href="javascript:void(0)" role="button" data-id="'.$row->id_pengajuan.'" title="Upload" class="btn btn-xxs btn-info disabled">
				<ion-icon size="small" name="cloud-upload-sharp"></ion-icon></a>';
			}if ($row->tahap_pengajuan == '3') {
				$btn = '<a href="javascript:void(0)" role="button" data-id="'.$row->id_pengajuan.'" title="Upload" class="btn btn-xxs btn-info disabled">
				<ion-icon size="small" name="cloud-upload-sharp"></ion-icon></a>';
			}
			// if ($row->tambahPengajuan == '0') {
			// 	$btn = '<a href="javascript:void(0)" role="button" data-id="'.$row->id_pengajuan.'" title="Upload" class="btn btn-xxs btn-info disabled">
			// 	<ion-icon size="small" name="cloud-upload-sharp"></ion-icon></a>';
			// }
            
			return $btn;
		})
		->rawColumns(['nama_nip', 'created','status','aksi','proses'])
		->make(true);
	}

	public function getBiodata($nip){

		$user = DB::connection('mysql2')->table('tbl_pegawai')->where('nip', '=', $nip)->first();
        if ($user->gelar_belakang) {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama).', '.$user->gelar_belakang;
        }else {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama);
        }
		$output = $nama_lengkap;

		$data = DB::connection('mysql2')->table('tbl_pegawai as pgw')
		->select('pgw.nip', 'pgw.tempat_lahir', 'pgw.tanggal_lahir', 'jbt.jabatan', 'storg.struktur_organisasi as org', 'gl.pangkat','gl.golongan as gol', 'unit.unit', 'rpk.tmt', 'subunit.sub_unit')
		->join('tbl_struktur_jabatan as stjbt', 'pgw.id_struktur_jabatan', '=', 'stjbt.id_struktur_jabatan')
		->join('tbl_jabatan as jbt', 'stjbt.id_jabatan', '=', 'jbt.id_jabatan')
		->join('tbl_struktur_organisasi as storg', 'stjbt.id_struktur_organisasi', '=', 'storg.id_struktur_organisasi')
		->join('tbl_sub_unit as subunit', 'storg.id_sub_unit', '=', 'subunit.id_sub_unit')
		->join('tbl_unit as unit', 'subunit.id_unit', '=', 'unit.id_unit')
		->join('tbl_riwayat_pekerjaan as rpk', 'rpk.nip', '=', 'pgw.nip')
		->join('tbl_golongan as gl', 'rpk.golongan', '=', 'gl.golongan')
		->whereIn('rpk.golongan', function($query){
			$query->select(DB::raw('MAX(tbl_riwayat_pekerjaan.golongan) as golongan'))
					->from('tbl_riwayat_pekerjaan')
					->whereRaw('pgw.nip = tbl_riwayat_pekerjaan.nip');
		})
		->where('pgw.nip','=', $nip)
		->first();

		return response()->json(['biodata' => $data, 'nama_lengkap' =>$output]);
	}

	// public function pilihJbt(){
	// 	$jbt = DB::connection('mysql2')->select('select * from tbl_jabatan');
	// 	$output_jbt = '<option value="">Pilih Jabatan Baru</option>';
	// 	foreach($jbt as $row){
	// 		$output_jbt .='<option value="'.$row->jabatan.'">'.$row->jabatan.'</option>';
	// 	}

	// 	return ['jbt' =>$output_jbt];
	// }
	public function pilihJbt(Request $request){
		if ($request->has('q')) {
			$cari = $request->q;
			$data = DB::connection('mysql2');
			$query = $data->table('tbl_jabatan')->select('id_jabatan', 'jabatan')->where('jabatan', 'LIKE', '%'.$cari.'%')->get();
			return response()->json($query);
		}
	}

	public function tambahPengajuan(Request $request){
		if ($request->action == "tambah") {
			$tambah = DB::table('tbl_pengajuan')->insert([

				'nip' 				=> $request->nip,
				'jenis' 			=> 'kenaikan',
				'nilai_pak' 		=> $request->pak,
				'tunjangan' 		=> $request->tunjangan,
				'jabatan_lama' 		=> $request->jabatan_lm,
				'jabatan_baru' 		=> $request->jabatan_br,
				'tmt'				=> $request->tmt,
				'tempat_lahir'		=> $request->t_lahir,
				'tanggal_lahir'		=> $request->tgl_lahir,
				'tahap_pengajuan' 	=> '1',
				'status_pengajuan' 	=> 'Diproses',
				'tunjangan'			=> $request->tunjangan,
				'created'		 	=> Carbon::now()
			]);

			$persyaratan = DB::table('tbl_persyaratan')
							->select()

			if ($tambah) {
				return response()->json(['success' => 'Data berhasil ditambahkan']);
			}else{
				return response()->json(['error' => 'Data gagal ditambahkan']);
			}
			
		}else{

			$edit = DB::table('tbl_pengajuan')->where('id_pengajuan', '=', $request->id_pengajuan)->update([
				'id_pengajuan' => $request->id_pengajuan,
				'nilai_pak' => $request->pak,
				'jabatan_baru' => $request->jabatan_br,
				'modified' =>Carbon::now()
			]);

			if ($edit) {
				return response()->json(['success' => 'Data berhasil diubah']);
			}else{
				return response()->json(['error' => 'Data gagal diubah']);
			}
		}
			
	}

	public function idPengajuan($id){
		$where = array('id_pengajuan' => $id);
		$idpengajuan = DB::table('tbl_pengajuan')->where($where)->first();

		$user = DB::connection('mysql2')->table('tbl_pegawai')->where('nip', '=', Session::get('username'))->first();
        if ($user->gelar_belakang) {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama).', '.$user->gelar_belakang;
        }else {
            $nama_lengkap = $user->gelar_depan.' '.strtoupper($user->nama);
        }
		$output = $nama_lengkap;

		$data = DB::connection('mysql2')->table('tbl_pegawai as pgw')
		->select('pgw.nip', 'jbt.jabatan', 'storg.struktur_organisasi as org', 'gl.pangkat','gl.golongan as gol', 'unit.unit', 'subunit.sub_unit', 'rpk.tmt')
		->join('tbl_struktur_jabatan as stjbt', 'pgw.id_struktur_jabatan', '=', 'stjbt.id_struktur_jabatan')
		->join('tbl_jabatan as jbt', 'stjbt.id_jabatan', '=', 'jbt.id_jabatan')
		->join('tbl_struktur_organisasi as storg', 'stjbt.id_struktur_organisasi', '=', 'storg.id_struktur_organisasi')
		->join('tbl_sub_unit as subunit', 'storg.id_sub_unit', '=', 'subunit.id_sub_unit')
		->join('tbl_unit as unit', 'subunit.id_unit', '=', 'unit.id_unit')
		->join('tbl_riwayat_pekerjaan as rpk', 'rpk.nip', '=', 'pgw.nip')
		->join('tbl_golongan as gl', 'rpk.golongan', '=', 'gl.golongan')
		->whereIn('rpk.golongan', function($query){
			$query->select(DB::raw('MAX(tbl_riwayat_pekerjaan.golongan) as golongan'))
					->from('tbl_riwayat_pekerjaan')
					->whereRaw('pgw.nip = tbl_riwayat_pekerjaan.nip');
		})
		->where('pgw.nip','=', Session::get('username'))
		->first();

		return response()->json(['data' => $idpengajuan, 'nama_lengkap'=>$output, 'biodata'=>$data]);
	}

	public function hapusPengajuan($id){

		 DB::table('tbl_pengajuan')->where('id_pengajuan', '=', $id)->delete();
		return response()->json(['success' => 'Data Berhasil Dihapus']);
	}

}
