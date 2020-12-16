
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>SIJAFUNG | @yield('title')</title>
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="{{ url('assets/vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ url('assets/vendor/chartist/css/chartist.min.css') }}">
    <link href="{{ url('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">
    {{-- <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet"> --}}
    <link href="{{ url('assets/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <!-- Daterange picker -->
    <link href="{{ url('assets/vendor/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- Clockpicker -->
    <link href="{{ url('assets/vendor/clockpicker/css/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
    <!-- asColorpicker -->
    <link href="{{ url('assets/vendor/jquery-asColorPicker/css/asColorPicker.min.css') }}" rel="stylesheet">
    <!-- Material color picker -->
    <link href="{{ url('assets/vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <!-- Pick date -->
    <link rel="stylesheet" href="{{ url('assets/vendor/pickadate/themes/default.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendor/pickadate/themes/default.date.css') }}">

    <link rel="stylesheet" href="{{ url('assets/fontawesome/css/all.css') }}">

</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="./images/logo-white.png" alt="">
                <img class="logo-compact" src="./images/logo-text.png" alt="">
                <img class="brand-title" src="./images/logo-text.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->		
		
        <!--**********************************
            Header start
        ***********************************-->
        @yield('header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    <li class="nav-label">Main Menu</li>
                    <li><a class="ai-icon" href="{{ asset('/dashboard') }}" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <span class="nav-text">Dashboard</span>
						</a>{{-- 
                        <ul aria-expanded="false">
                            <li><a href="index.html">Light</a></li>
							<li><a href="index-2.html">Dark</a></li>
							<li><a href="index-3.html">Mini Sidebar</a></li>
							<li><a href="index-4.html">Sidebar</a></li>
                        </ul> --}}
                    </li>
                    <li class="nav-label">Data</li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="fas fa-file-import"></i>
                            <span class="nav-text">Pengajuan</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ asset('/kenaikanjabatan') }}">Kenaikan Jabatan</a></li>
                            <li><a href="javascript:void()" aria-expanded="false">Alih Kelompok</a></li>
                            <li><a href="javascript:void()">Inpassing Guru</a></li>
							<li><a href="javascript:void()" aria-expanded="false">Pemberhentian</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="fas fa-file-alt"></i>
                            <span class="nav-text">Kelola Persyaratan</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ asset('/persyaratan/kenaikanjbt') }}">Kenaikan Jabatan</a></li>
                            <li><a href="{{ asset('/persyaratan/alihklmpk') }}">Alih Kelompok</a></li>
                            <li><a href="{{ asset('/persyaratan/inpassinggr') }}">Inpassing Guru</a></li>
                            <li><a href="{{ asset('/persyaratan/pemberhentian') }}">Pemberhentian</a></li>
                        </ul>
                    </li>
                    {{-- <li><a href="{{ asset('/periode') }}" aria-expanded="false">
                            <i class="fas fa-hourglass-half"></i>
                            <span class="nav-text">Kelola Periode</span>
                        </a>
                    </li> --}}
                </ul>
            </div>


        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            @yield('content')
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
       @include('partial.footer')
        <!--**********************************
            Footer end
        ***********************************-->

        {{-- SWEET ALERT --}}
        @include('sweetalert::alert')


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    @yield('js')
	
</body>
</html>