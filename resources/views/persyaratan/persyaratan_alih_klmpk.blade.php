@inject('layouts', 'App\Http\Controllers\DashboardController')
@extends('layouts.main')
@section('title', 'Kelola Persyaratan')

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
                <h4>Persyaratan Alih Kelompok Jabatan Fungsional</h4>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Alih Kelompok</a></li>
            </ol>
        </div>
    </div>
    {{-- End --}}

    <div class="row">
        {{-- Tabel --}}
        <div class="col-xl-8 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tabel Pesyaratan Alih Kelompok</h4>
                    {{-- <div class="card-header-action">
                        <button type="button" class="btn btn-rounded btn-primary" id="tambahSyarat">
                            <i class="fa fa-plus"></i>
                            </span>  Tambah Syarat</button>
                        </button>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="Datasyarat" class="display" style="min-width: 100%">
                            <thead>
                                <tr>
                                    <th width="20%">Nama Dokumen</th>
                                    <th width="35%">Keterangan</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- End --}}

        {{-- Add Syarat--}}
        <div class="col-xl-4 col-lg-12 col-xxl-4 col-sm-12">
            <div class="row">
                <div class="col-xl-12 col-lg-6 col-xxl-12 col-md-6">
                    <div class="card">
                        <div class="social-graph-wrapper widget-twitter">
                            <span class="s-icon"><i class="fa fa-plus"></i> Tambah Syarat</span>
                        </div>
                        <div class="card-body">
                            <form id="form_syarat" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Nama Dokumen</label>
                                    <input type="hidden" class="form-control" id="id_dokumen" name="id_dokumen">
                                    <input type="hidden" class="form-control" id="jenis" name="jenis" value="alih">
                                    <input type="text" class="form-control" id="action" name="action" value="tambah" hidden>
                                    <textarea type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea type="text" class="form-control" id="keterangan" name="keterangan" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-info btn-xs" id="btn_simpan" name="btn_simpan">Add</button>
                                <button type="submit" class="btn btn-secondary btn-xs" id="btn_update" name="btn_update">Update</button>
                                <button type="reset" class="btn btn-warning btn-xs" id="btn_reset" name="btn_reset">Reset</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End --}}
        
    </div>

    

    <!-- Modal Tambah Syarat -->
    {{-- <div class="modal fade" id="tambah_form">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judul">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_add" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nm_dokumen">Nama dokumen</label>
                            <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" required>
                            <input type="hidden" name="id_dokumen" id="id_dokumen" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ket">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" required></textarea>
                            <input type="hidden" name="jenis_dokumen" id="jenis_dokumen" class="form-control">
                            <input type="hidden" name="action" id="action">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Batal</button>
                        <button type="submit" id="btn_simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    {{-- End Modal --}}

   {{-- Modal Hapus Dta --}}
   <div class="modal fade bd-example-modal-sm" id="hapusData" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_hapus"></h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span>
                </button>
            </div>
            <div class="modal-body" id="body_hapus"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Tidak</button>
                <button type="button" id="btn_konfirmasi" class="btn btn-primary">Ya</button>
            </div>
        </div>
    </div>
  </div>
  {{-- End Modal --}}

</div>
  <!-- /.content-wrapper -->
@endsection

@section('js')
    @include('partial.js')

    <script type="text/javascript">
        $(function(){
            var oTable = $('#Datasyarat').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "/syaratalih/get"
                },
                columns: [
                    //{data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false, searchable: false},
                    {data: 'nama_dokumen', name: 'nama_dokumen', searchable:true, orderable:true},
                    {data: 'keterangan', name: 'keterangan', searchable:true, orderable:true},
                    {data: 'aksi', name: 'aksi', 'className': 'text-center'},
                ],
            });
        });

        // $(document).off('click', '#tambahSyarat').on ('click', '#tambahSyarat', function(){
        //     $("#tambah_form").modal('show');
        //     $("#judul").text('Tambah Syarat Kenaikan Jabatan');
        //     $("#action").val("tambah");
        //     $("#jenis_dokumen").val("kenaikan");
        // });
        
        $(document).off('click', '#btn_reset').on('click', '#btn_reset', function(){
            document.getElementById("btn_update").disabled = true;
            document.getElementById("btn_simpan").disabled = false;

        });

        document.getElementById("btn_update").disabled = true;


        /* Jika click edit data */
        $(document).off('click', '.editData').on('click', '.editData', function () {
        var id = $(this).data('id');

        document.getElementById("btn_simpan").disabled = true;
        document.getElementById("btn_update").disabled = false;
        
        $.ajax({
          url:'/syaratinpassing/get/'+id,
          dataType:"json",
          success: function(html) {
            //$("#tambah_form").modal('show');
            //$("#modal-title").html("Edit Syarat Permohonan SK Kenaikan Jabatan");
            $("#id_dokumen").val(html.data.id_dokumen)
            $("#jenis").val(html.data.jenis_dokumen)
            $("#nama_dokumen").val(html.data.nama_dokumen)
            $("#keterangan").val(html.data.keterangan);
            $("#action").val("edit")
          }
        })
      });

        /* Jika click simpan */
        $('#form_syarat').off('submit').on('submit', function(event){
            event.preventDefault();

            //$('#btn_simpan').text("Sedang Proses...");
            document.getElementById("btn_simpan").disabled = true;

            /* Simpan data */
            if ($("#action").val() == "tambah") {
                
                $.ajax({
                    url: "/syaratalih/tambah",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function (data){
                        $('#Datasyarat').DataTable().ajax.reload();
                        //$('#btn_simpan').text('Simpan Data');
                        document.getElementById("btn_simpan").disabled = false;

                                      
                        if(data.success){
                                const Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: data.success
                            });
                        }
                        if(data.error){
                            Toast.fire({
                                icon: 'error',
                                title: data.error
                            });
                        }

                        $("#action").val("");
                        $("#id_dokumen").val("");
                    }
                })

            }

            /* Edit data */
            if ($("#action").val() == "edit") {
                
                $.ajax({
                    url: "/syaratalih/tambah",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    success: function (data){
                        $('#Datasyarat').DataTable().ajax.reload();
                        //$('#tambah_form').modal('hide');
                        //$('#btn_simpan').text('Simpan Data');
                        document.getElementById("btn_update").disabled = true;

                                      
                        if(data.success){
                                const Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: data.success
                            });
                        }
                        if(data.error){
                            Toast.fire({
                                icon: 'error',
                                title: data.error
                            });
                        }

                        $("#action").val("");
                        $("#id_dokumen").val("");
                    }
                })

            }
        });

        /* Jika click hapus */
        $(document).off('click', '.hapusData').on('click', '.hapusData', function(){
            var id = $(this).data('id');
            //alert(id);
            $('#hapusData').modal('show');
            $('#title_hapus').html("Konfirmasi Hapus Data");
            $('#body_hapus').html("Apakah anda yakin ingnin menghapus data ini??");

            $('#btn_konfirmasi').click(function(){
                $.ajax({
                    url: "/syarat/hapus/"+id,
                    beforeSend:function(){
                        document.getElementById("btn_konfirmasi").disabled = true;
                        $('#btn_konfirmasi').text('Proses...');
                    },
                    success:function(data){
                        setTimeout(function(){
                            $('#hapusData').modal('hide');
                            $('#Datasyarat').DataTable().ajax.reload();
                            $('#btn_konfirmasi').text('Ya');
                            document.getElementById("btn_konfirmasi").disabled = false;
                        });

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                                icon: 'success',
                                title: data.success
                            });
                    }
                })
            });
        });

    </script>

@endsection