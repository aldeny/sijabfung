@inject('layouts', 'App\Http\Controllers\DashboardController')

@extends('layouts.master')

@section('title', 'Ubah Password')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Ubah Password</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                      <form action="/user/ubahpassword" method="POST">
                        @csrf
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-12">
                              <label for="nama">Nama</label>
                              <input type="text" class="form-control" id="nama" name="nama" value="{{ $nama_lengkap }}">
                              </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-12">
                              <label for="username">NIP/Username</label>
                              <input type="text" class="form-control" id="username" name="username" value="{{ Session::get('username') }}">
                              </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-6">
                              <label for="pass_lama">Password Lama</label>
                              <input type="password" class="form-control" id="pass_lama" name="pass_lama" >
                              </div>

                              <div class="col-md-6">
                              <label for="pass_baru">Password Baru</label>
                              <input type="password" class="form-control" name="pass_baru" id="pass_baru">
                              </div>
                              </div>
                          </div>
                          <button class="btn btn-primary btn-sm btn" type="submit" id="simpan">Simpan Perubahan</button>
                      </form>
                  <!-- /.row -->
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
      </div>
    </section>
</div>



  @endsection