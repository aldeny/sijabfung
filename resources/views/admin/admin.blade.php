@inject('layouts', 'App\Http\Controllers\DashboardController')
@extends('layouts.main')
@section('title', 'Dashboard')

@section('header')
    @include('partial.header')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->  
<div class="container-fluid">

  {{-- Judul halaman --}}
  <div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Dashboard Admin</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ol>
    </div>
  </div>
  {{-- End --}}

  <div class="row">
    <div class="col-xl-3 col-lg-6 col-sm-6">
      <div class="widget-stat card">
        <div class="card-body p-4">
          <div class="media ai-icon">
            <span class="mr-3">
              <!-- <i class="ti-user"></i> -->
              <svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              </span>
              <div class="media-body">
                <p class="mb-1">Patient</p>
                <h4 class="mb-0">3280</h4>
                <span class="badge badge-primary">+3.5%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  
</div>
  <!-- /.content-wrapper -->
@endsection

@section('js')
    @include('partial.js')
@endsection