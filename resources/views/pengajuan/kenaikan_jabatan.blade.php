@inject('layouts', 'App\Http\Controllers\PengajuanController')
@extends('layouts.main')
@section('title', 'Pengajuan Kenaikan Jabatan')

@section('header')
    @include('partial.header')
@endsection

@section('content')
<div class="container-fluid">

  {{-- Judul halaman --}}
  <div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Pengajuan Kenaikan Jabatan</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ asset('/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Pengajuan Kenaikan Jabatan</a></li>
        </ol>
    </div>
  </div>
  {{-- End --}}

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Data Pengajuan SK Kenaikan Jabatan</h4>
          <div class="card-header-action">
            @if($status != null || !empty($status))
              @if(($status[0]->status_pengajuan == "Ditolak") || ($status[0]->status_pengajuan == "Disetujui"))
                <button type="button" class="btn btn-rounded btn-primary" id="tambahData" value="{{ $nip }}">
                  <i class="fa fa-plus"></i>
                  </span>  Tambah pengajuan SK</button>
                </button>
              @elseif(($status[0]->status_pengajuan == "Diajukan") /* || ($status[0]->status_pengajuan == 'Belum Diajukan') */)
                <button type="button" class="btn btn-rounded btn-primary disabled" title="Tidak bisa mengajukan permohonan karena dalam proses diajukan!">
                  <i class="fa fa-plus"></i>
                  </span>  Tambah Pengajuan SK</button>
                </button>
              @endif
            @else
              <button type="button" class="btn btn-rounded btn-primary" id="tambahData" value="{{ $nip }}"><i class="fa fa-plus" aria-hidden="true"></i>
                </span>  Tambah Pengajuan SK</button>
              </button>
            @endif
          </div>
        </div>
        <div class="col-12">
        <div class="card-body">
          <div class="table-responsive">
            <table class="display" id="datatable" style="min-width: 100%">
              <thead>
                <tr>
                  <th class="text-center"> # </th>
                  <th class="text-center">Nama Pegawai</th>
                  <th class="text-center">Tanggal Pengajuan</th>
                  <th class="text-center">Status Pengajuan</th>
                  <th class="text-center">Aksi</th>
                  <th class="text-center">Proses Pengajuan</th>
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
                <label for="nama_pegawai">Nama Pegawai</label>
                <input type="text" class="form-control" id="nama" name="nama" readonly>
                <input type="hidden" name="id_pengajuan" id="id_pengajuan" class="form-control">
              </div>
              <div class="form-group col-md-6">
                  <label for="nip">NIP</label>
                  <input type="nip" class="form-control" id="nip" name="nip" value="" readonly>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="pangkat/golongan">Pangkat ~ Golongan</label>
                <input type="text" class="form-control" id="pangkat_gol" name="pangkat_gol" value="" readonly>
              </div>
              <div class="form-group col-md-6">
                <label for="tmt">TMT</label>
                <input type="date" name="tmt" class="form-control" id="tmt" required >
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="t_lahir">Tempat Lahir</label>
                <input type="text" class="form-control" id="t_lahir" name="t_lahir" value="" readonly>
              </div>
              <div class="form-group col-md-6">
                <label for="tgl_lahir">Tanggal Lahir</label>
                <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" value="" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="jabatan_lm">Jabatan Lama</label>
              <input type="text" class="form-control" id="jabatan_lm" name="jabatan_lm" value="" readonly>
            </div>
              <div class="form-group">
                <label for="jabatan_br">Jabatan Baru</label>
                <select id="jabatan_br" name="jabatan_br" id="jabatan_br" class="form-control" required>
                  {{-- <option value="">Pilih Jabatan Baru</option> --}}
                </select>
              </div>
              <div class="form-group">
                <label for="opd">Unit Organisasi (OPD)</label>
                <input type="text" class="form-control" id="opd" name="opd" value="" readonly>
              </div>
              <div class="form-group">
                <label for="subunit">Sub Unit</label>
                <input type="text" class="form-control" id="subunit" name="subunit" value="" readonly>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputZip">Nilai PAK</label>
                  <input type="text" class="form-control" id="pak" name="pak" placeholder="Ex:150" required>
                  <input type="hidden" name="status" id="status" value="Belum Diajukan">
                  <input type="hidden" name="action" id="action">
                </div>
                <div class="form-group col-md-6">
                  <label for="tunjangan">Tunjangan</label>
                  <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Rp.</span>
                  </div>
                  <input type="text" class="form-control rupiah" id="tunjangan" name="tunjangan" required>
                  <div class="input-group-append">
                      <span class="input-group-text">.-00</span>
                  </div>
                </div>
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
                {data: 'created', name: 'created', searchable: true, 'className': 'text-center'},
                {data: 'status', name: 'status', searchable: true, 'className': 'text-center'},
                {data: 'aksi', name: 'aksi', searchable: false, 'className': 'text-center'},
                {data: 'proses', name: 'proses', searchable: true, 'className': 'text-center'},
            ],
          });
      });

      /* Reset Form */
      function reset_form() {
        $("#tmt").val("");
      }
      /* End */

      /* Ketika click tambah data */
      $(document).off('click', '#tambahData').on ('click', '#tambahData', function(){
        var nip = $(this).val();
        reset_form();

        $.ajax({
          url:'/user/getbio/'+nip,
          dataType:"json",
          success: function(html) {
            $("#form").modal('show');
            $("#modal-title").html('Permohonan SK Kenaikan Jabatan')
            $("#nama").val(html.nama_lengkap);
            $("#nip").val(html.biodata.nip);
            $("#pangkat_gol").val(html.biodata.pangkat + (' ~ ') + html.biodata.gol);
            $("#t_lahir").val(html.biodata.tempat_lahir);
            $("#tgl_lahir").val(html.biodata.tanggal_lahir);
            $("#jabatan_lm").val(html.biodata.jabatan + (' pada ') + html.biodata.org);
            $("#opd").val(html.biodata.unit);
            $("#subunit").val(html.biodata.sub_unit);
            $("#action").val("tambah")
          }
        })
    
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
            $("#jabatan_br").val(html.data.jabatan_baru).trigger('change');
            $("#pak").val(html.data.nilai_pak);
            $("#opd").val(html.biodata.unit);
            $("#subunit").val(html.biodata.sub_unit);
            $("#tmt").val(html.data.tmt);
            $("#t_lahir").val(html.data.tempat_lahir);
            $("#tgl_lahir").val(html.data.tanggal_lahir);
            $("#tunjangan").val(html.data.tunjangan);
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
                    id: item.jabatan
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
              document.getElementById("tambahData").disabled= true;
              
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
