@extends('layouts.main')
@section('title', 'Permohonan Kenaikan Jabatan')

@section('header')
    @include('partial.header')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Upload Berkas </h4>
                    </div>
                    <div class="col-12">
                        <div class="card-body">
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="">Nomor Surat Rekomendasi dari Pimpinan Unit Kerja</label>
                                  <input type="text" class="form-control" id="no_surat" name="no_surat" placeholder="">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="">Tanggal Surat Rekomendasi dari Pimpinan Unit Kerja</label>
                                  <input type="date" name="tgl_surat" class="form-control" id="tgl_surat" required >
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Perihal</label>
                                    <input type="text" class="form-control" id="perihal" name="perihal">
                                </div>
                              </div>
                              <hr>
                            <div class="table-responsive">
                                <table class="display" id="datatable" style="min-width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th width="35%">Nama Dokumen</th>
                                            <th width="55%">Keterangan</th>
                                            <th width="20%">Detail Dokumen</th>
                                            <th width="5%">Upload</th>
                                            <th width="5%">Status</th>
                                        </tr>
                                    </thead>
                                </table>
                                    <button type="button" class="btn btn-primary" style="float: right" >Ajukan Permohonan <ion-icon name="arrow-up-circle-outline"></ion-icon></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Form Upload Dokumen --}}
        <div class="modal fade bd-example-modal-lg" id="upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modal-title"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form id="form_upload" enctype="multipart/form-data"
                    method="POST">
                    @csrf
                        <input type="hidden" id="id_syarat" name="id_syarat" value="">
                        <input type="hidden" id="id_permohonan" name="id_permohonan" value="1">
                        <input type="hidden" id="jenis" name="jenis" value="">
                        <input type="hidden" id="namaberkas" name="namaberkas" value="{{ $nip }}">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe id="preview_file" class="embed-responsive-item" allowfullscreen></iframe>
                        </div><br>
                        <input type="file" name="file" id="file" accept=".pdf" onchange="document.getElementById('preview_file').src = 
                        window.URL.createObjectURL(this.files[0])" required><br><br>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btn_upload">Upload</button>
                        </div>
                    </form>
              </div>
            </div>
        </div>
        </div>

        <div class="modal fade bd-example-modal-lg" id="detailBerkas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="judul"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form id="form_details" enctype="multipart/form-data">
                        <div id="frameDiv" class="embed-responsive embed-responsive-16by9">
                            <iframe id="frame"></iframe>
                        </div>
                    </form>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn_upload">Upload</button>
            </div>
            </div>
        </div>
        </div>
    
    </div>
@endsection

@section('js')
    @include('partial.js')

    <script type="text/javascript">
        
        /* Start Datatable */
        $(function () {
            var oTable = $('#datatable').DataTable({
                processing: true,
                serverSide: false,
                "paging":   false,
                ajax: {
                    url: "/upload/syarat"
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false, searchable: false},
                    {data: 'nama_berkas', name: 'nama_berkas'},
                    {data: 'keterangan', name: 'keterangan', className: "text-center"},
                    {data: 'detail_doc', name: 'detail_doc', className: "text-center"},
                    {data: 'upload', name: 'upload', className: "text-center"},
                    {data: 'status', name: 'status', className: "text-center"},
                ],
            });
        });
        /* End Datatable */

        /* Jika click Upload */
        $(document).off('click', '.upload').on ('click', '.upload', function () {
            var id_berkas = $(this).data('id');
            //alert(id_berkas);
                    $("#upload").modal('show');
                    $("#modal-title").html('Upload (Scan Berkas Menjadi Satu File Dalam Format .pdf)')
                    $("#id_syarat").val(id_berkas);
                    $("#jenis").val('kenaikan jabatan');
        });

        /* Jika click Button Submit */
        $('#form_upload').off('submit').on('submit', function(event){
            event.preventDefault();

            $('#btn_upload').text("Sedang Proses...");
            document.getElementById("btn_upload").disabled = true;

            $.ajax({
                url: "/proses/upload",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function(data){
                    $('#form').modal('hide');
                    $('#btn_upload').text('Upload');
                    document.getElementById("btn_upload").disabled = false;

                    /* Jika berhasil */
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
                    /* Jika gagal */
                    if(data.error){
                        Toast.fire({
                            icon: 'error',
                            title: data.error
                        });
                    }
                }
            })
        });

        /* Jika click lihatFile */
        $(document).off('click', '.lihatFile').on ('click', '.lihatFile', function () {
            var id_berkas = $(this).data('id');
            persyaratan = id_berkas.split('/');
            //alert(persyaratan);
            var url = "../berkas_upload/kenaikan jabatan/"+persyaratan[0]+"/"+persyaratan[0]+"_"+persyaratan[1]+".pdf";
            //alert(url);
                    $("#detailBerkas").modal('show');
                    $("#judul").html('Detail Berkas');
                    //document.getElementById('frame').src = '<iframe id="frame" src="berkas_upload/kenaikan_jabatan/'+persyaratan[0]+'/'+persyaratan[0]+'_'+persyaratan[1]+'.pdf" class="embed-responsive-item" allowfullscreen></iframe>';
                    /* if (url) {
                        
                    } */
                    document.getElementById('frame').src = url;
                    window.location();
                    // document.getElementById("btn_upload").style.display = "none";
                    // document.getElementById("file").style.display = "none";
                    //alert(s);
                    //$("#iframe").src =url;
                    
        });         

    </script>

    <script>
        (function($) {
            "use strict"

            var direction =  getUrlParams('dir');
            if(direction != 'rtl')
            {direction = 'ltr'; }
            
            new dezSettings({
                typography: "roboto",
                version: "light",
                layout: "vertical",
                headerBg: "color_1",
                navheaderBg: "color_3",
                sidebarBg: "color_1",
                sidebarStyle: "full",
                sidebarPosition: "fixed",
                headerPosition: "fixed",
                containerLayout: "wide",
                direction: direction
            }); 

        })(jQuery);	
    </script>
@endsection