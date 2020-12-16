<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* Route::get('main', function () {
    return view('layouts.main');
});
 */



Route::post('/login/validasi', 'ValidasiLoginController@validasiLogin');
Route::get('/logout', 'ValidasiLoginController@logout');

Route::group(['middleware' => 'usersession'], function () {
    //Disini letak route semua halaman view
    //Start

    /* Untuk DashboardController */
    Route::get('/', 'DashboardController@indexRoot');
    Route::get('/dashboard', 'DashboardController@indexDashboard');
    //Route::get('/user/getnama/{nip}', 'DashboardController@getNama');

    /* Untuk PengajuanController */
    Route::get('/user/getbio/{nip}', 'PengajuanController@getBiodata');
    Route::get('/jbt/getjbt', 'PengajuanController@pilihJbt');
    Route::get('/kenaikanjabatan', 'PengajuanController@ikenaikanJabatan');
    Route::get('/kenaikanjabatan/list', 'PengajuanController@getDraftPengajuan');
    Route::post('/kenaikanjabatan/tambah', 'PengajuanController@tambahPengajuan');
    Route::get('/kenaikanjabatan/get/{id}', 'PengajuanController@idPengajuan');
    Route::get('/kenaikanjabatan/hapus/{id}', 'PengajuanController@hapusPengajuan');
    Route::get('/kenaikan/syarat', 'PengajuanController@getSyarat');
    //Route::get('/kenaikanjabatan/edit/{id}', 'PengajuanController@editPengajuan');

    Route::get('/upload/berkas', 'BerkasController@iberkas');
    Route::post('/proses/upload', 'BerkasController@upload');
    Route::get('/upload/syarat', 'BerkasController@getSyarat');

    /* Untuk PersyaratanController */
    // Kenaikan Jabatan
    Route::get('/persyaratan/kenaikanjbt', 'PersyaratanController@iSyaratKenaikanJbt');
    Route::get('/syaratkenaikan/get', 'PersyaratanController@getSyaratKenaikan');
    Route::get('/syaratkenaikan/get/{id}', 'PersyaratanController@getIdSyaratKenaikan');
    Route::post('/syaratkenaikan/tambah', 'PersyaratanController@addSyaratKenaikan');
    //Route::get('/syaratkenaikan/edit/{id}', 'PersyaratanController@editSyaratKenaikan');
    
    // Alih Kelompok
    Route::get('/persyaratan/alihklmpk', 'PersyaratanController@iSyaratAlihKlmpk');
    Route::get('/syaratalih/get', 'PersyaratanController@getSyaratAlih');
    Route::get('/syaratalih/get/{id}', 'PersyaratanController@getIdSyaratAlih');
    Route::post('/syaratalih/tambah', 'PersyaratanController@addSyaratAlih');

    //Inpassing Guru
    Route::get('/persyaratan/inpassinggr', 'PersyaratanController@iSyaratInpassing');
    Route::get('/syaratinpassing/get', 'PersyaratanController@getSyaratInpassing');
    Route::get('/syaratinpassing/get/{id}', 'PersyaratanController@getIdSyaratInpassing');
    Route::post('/syaratinpassing/tambah', 'PersyaratanController@addSyaratInpassing');

    // Pemberhentian
    Route::get('/persyaratan/pemberhentian', 'PersyaratanController@iSyaratPemberhentian');
    Route::get('/syaratpemberhentian/get', 'PersyaratanController@getSyaratPemberhentian');
    Route::get('/syaratpemberhentian/get/{id}', 'PersyaratanController@getIdSyaratPemberhentian');
    Route::post('/syaratpemberhentian/tambah', 'PersyaratanController@addSyaratPemberhentian');
    
    Route::get('/syarat/hapus/{id}', 'PersyaratanController@deleteSyarat');
    /* End PersyaratanController */

    /* Periode */
    //Route::get('/periode', 'PeriodeController@iPeriode');
    /* End Periode */

    /* Route::get('/ubahpassword', 'DashboardController@ubahPassword');
    Route::post('/user/ubahpassword', 'DashboardController@ubahPasswordUser'); */
});

Route::group(['middleware' => 'userloginsession'], function () {
    //Disini letakkan route login
    Route::get('/login', 'ValidasiLoginController@login');
    //Route::post('/register', 'RegisterController@register');
});

