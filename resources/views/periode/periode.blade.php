@inject('layouts', 'App\Http\Controllers\PengajuanController')
@extends('layouts.main')
@section('title', 'Periode Seleksi')

@section('header')
    @include('partial.header')
@endsection

@section('content')
<div class="container-fluid">

  {{-- Judul halaman --}}
  <div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Periode Seleksi</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ asset('/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Periode Seleksi</a></li>
        </ol>
    </div>
  </div>
  {{-- End --}}

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data Periode Seleksi</h4>
          <div class="card-header-action">
            <button type="button" class="btn btn-rounded btn-primary" id="tambahData" value="">
                <i class="fa fa-plus"></i>
                </span> Tambah Periode</button>
            </button>
          </div>
        </div>
        <div class="col-12">
        <div class="card-body">
          <div class="table-responsive">
            <table class="display" id="datatable" style="min-width: 100%">
              <thead>
                <tr>
                  <th class="text-center"> # </th>
                  <th class="text-center">Nama Periode</th>
                  <th class="text-center">Tahun</th>
                  <th class="text-center">Periode Dibuka</th>
                  <th class="text-center">Periode Ditutup</th>
                  <th class="text-center">Tanggal Buka Pendaftaran</th>
                  <th class="text-center">Tanggal Tutup Pendaftaran</th>
                  <th class="text-center">Status Data</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>

  {{-- Modal Tambah Permohonan --}}
  <div class="modal fade bd-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="data_form" method="POST">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="nama_periode">Nama Periode</label>
                <input type="text" class="form-control" id="nama_periode" name="nama_periode" required>
                <input type="hidden" name="id_periode" id="id_periode" class="form-control">
              </div>
              <div class="form-group col-md-6">
                  <label for="tahun">Tahun</label>
                  <select name="tahun" id="tahun" class="form-control">
                      <option value="">Pilih Tahun</option>
                      <?php
                        $thn_sekarang = date('Y');
                        for ($i=$thn_sekarang; $i>= 2015 ; $i--) { ?>
                            <option value="{{ $i }}">{{ $i }}</option>
                      <?php      
                        }
                      ?>
                  </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="p_buka">Periode Dibuka</label>
                <input name="p_buka" class="datepicker-default form-control picker__input" required id="p_buka" readonly="" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="datepicker_root">
              </div>
              <div class="form-group col-md-6">
                <label for="p_tutup">Periode Ditutup</label>
                <input name="p_tutup" class="datepicker-default form-control picker__input" required id="p_tutup" readonly="" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="datepicker_root">
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="tgl_buka">Tanggal Buka Pendaftaran</label>
                  <input name="tgl_buka" class="datepicker-default form-control picker__input" required id="tgl_buka" readonly="" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="datepicker_root">
                </div>
                <div class="form-group col-md-6">
                  <label for="tgl_tutup">Periode Tutup Pendaftaran</label>
                  <input name="tgl_tutup" class="datepicker-default form-control picker__input" required id="tgl_tutup" readonly="" aria-haspopup="true" aria-expanded="false" aria-readonly="false" aria-owns="datepicker_root">
                </div>
            </div>
            <div class="form-group">
                <label>Status Data</label>
                <div class="dropdown bootstrap-select form-control">
                    <select class="form-control" id="sel1" tabindex="-98">
                    <option value="tampil">Tampilkan</option>
                    <option value="sembunyi">Sembunyikan/Jangan Tampilkan</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary" id="btn_simpan">Simpan</button>
        </div>
      </form>
      </div>
    </div>
  </div>
  {{-- End Modal --}}

  {{-- Modal Konfirmasi Hapus --}}
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
</div>
@endsection

@section('js')
    @include('partial.js')

    <script type="text/javascript">
      $(function() {
         var oTable = $('#datatable').DataTable({
              processing: true,
              serverSide: false,
              ajax: {
                  url: "/kenaikanjabatan/list"
              },
              columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false, searchable: false},
                {data: 'nama_nip', name: 'nama_nip', searchable:true, 'className': 'text-center' },
                {data: 'tgl_pengajuan', name: 'tgl_pengajuan', searchable: true, 'className': 'text-center'},
                {data: 'status', name: 'status', searchable: true, 'className': 'text-center'},
                {data: 'aksi', name: 'aksi', searchable: false, 'className': 'text-center'},
                {data: 'proses', name: 'proses', searchable: true, 'className': 'text-center'},
            ],
          });
      });

      /* Ketika click tambah data */
      $(document).off('click', '#tambahData').on ('click', '#tambahData', function(){
        $("#form").modal('show');
        $("#modal-title").html("Tambah Data Periode Seleksi");
    
       });

      /* Ketika click edit data */
      $(document).off('click', '.editData').on('click', '.editData', function () {
        var id = $(this).data('id');
        
        $.ajax({
          url:'/kenaikanjabatan/get/'+id,
          dataType:"json",
          success: function(html) {
            $("#form").modal('show');
            $("#modal-title").html("Edit Permohonan SK Kenaikan Jabatan");
            $("#nama").val(html.nama_lengkap);
            $("#id_pengajuan").val(html.data.id_pengajuan);
            $("#nip").val(html.biodata.nip);
            $("#pangkat_gol").val(html.biodata.pangkat + (' ~ ') + html.biodata.gol);
            $("#tmt").val(html.biodata.tmt);
            $("#jabatan_lm").val(html.biodata.jabatan + (' pada ') + html.biodata.org);
            $("#jabatan_br").val(html.data.jabatan_baru);
            $("#pak").val(html.data.nilai_pak);
            $("#opd").val(html.biodata.unit);
            $("#subunit").val(html.biodata.sub_unit);
            $("#action").val("edit")
          }
        })
      });

      $('#jabatan_br').select2({
        placeholder: 'Cari...',
          ajax: {
            url: '/jbt/getjbt',
            dataType: 'json',
            delay: 250,
            processResults: function (query) {
              return {
                results:  $.map(query, function (item) {
                  return {
                    text: item.jabatan,
                    id: item.id_jabatan
                  }
                })
              };
            },
            cache: true
          }
      });
      
      /* Untuk memunculkan jabatan baru */
      // $.ajax({
      //   url:'/jbt/getjbt',
      //   method:"GET",
      //   success: function (data) {
      //     $('#jabatan_br').html(data.jbt)
      //   }

      // });

      /* jika click simpan */
      $('#data_form').off('submit').on('submit', function(event){
        event.preventDefault();

        $('#btn_simpan').text("Sedang Proses...");
        document.getElementById("btn_simpan").disabled = true;

        /* tambah data */
        if ($("#action").val() == "tambah") {
          
          $.ajax({
            url: "/kenaikanjabatan/tambah",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "JSON",
            success: function (data) {
              $('#datatable').DataTable().ajax.reload();
              $('#form').modal('hide');
              $('#btn_simpan').text('Simpan Data');
              document.getElementById("btn_simpan").disabled= false;
              
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
             }
          })
        }

        /* edit data */
        if ($("#action").val() == "edit") {
          
          $.ajax({
            url: "/kenaikanjabatan/tambah",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "JSON",
            success: function (data) {
              $('#datatable').DataTable().ajax.reload();
              $('#form').modal('hide');
              $('#btn_simpan').text('Simpan Data');
              document.getElementById("btn_simpan").disabled= false;
              
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

              if(data.success){                    
                    Toast.fire({
                      icon:'success',
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
                }
          })
        }
      });

      /* jika click hapus */
      $(document).off('click', '.hapusData').on('click', '.hapusData', function(){
         var id = $(this).data('id');
        $('#hapusData').modal('show');
        $('#title_hapus').html("Konfirmasi Hapus Data");
        $('#body_hapus').html("Apakah anda yakin ingin menghapus data ini??");

        $('#btn_konfirmasi').click(function(){
          $.ajax({
            url: 'kenaikanjabatan/hapus/'+id,
            beforeSend:function(){
              document.getElementById("btn_konfirmasi").disabled = true;
              $('#btn_konfirmasi').text('Proses...');
            },
            success:function(data){
              setTimeout(function(){
                $('#hapusData').modal('hide');
                $('#datatable').DataTable().ajax.reload();
                window.location.reload();
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
