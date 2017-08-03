@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Akuntansi</a>
        </li>
        <li class="active"><a href="{!! url('akuntansi/perkiraan') !!}">Daftar Perkiraan</a></li>
        <li class="active">Import</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data"  action="{!! url('akuntansi/perkiraan/import/post') !!}"  id="fimak">
                        <input type="hidden" name="konf" id="konf" value="">
                        @if(session('alert'))
                            <br/><br/>
                            {!! session('alert') !!}
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="import" class="col-sm-2 control-label">Excel File</label>
                                    <div class="col-sm-6">
                                        <input name="import" type="file" id="import" placeholder="Import" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="import" class="col-sm-2 control-label">Format</label>
                                    <div class="col-sm-10">
                                        <input type='text' readonly class='form-control' value='Sheet 1 : TIPE_AKUN | KELOMPOK | PARENT | KODE_AKUN | NAMA_AKUN | KAS '>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="import" class="col-sm-2 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <ul>
                                            <li>TIPE AKUN : header / detail (Pilih salah satu)</li>
                                            <li>KELOMPOK : kelompok akun tersebut (isi dengan kode akun yang dijadikan header utama) | untuk header utama isikan dengan 0</li>
                                            <li>PARENT : Tulis kode akun parent secara jelas dan akurat | untuk header utama isikan dengan 0 </li>
                                            <li>KODE AKUN : kode dari akun</li>
                                            <li>NAMA AKUN : Nama dari akun</li>
                                            <li>KAS : Jika akun adalah kas isikan Ya, jika tidak kosongkan atau isi dengan Tidak</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="tanggal_lahir" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-2">
                                        <a id="btnsave" class="btn btn-primary btn-block" name="upload" value="Upload"><i class="ti-upload mr5"></i>Upload</a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('akuntansi/perkiraan/import/sample') !!}" class="btn btn-warning btn-block"><i class="ti-download mr5"></i>Sample</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal fade" id="rejectModal11" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header"  style="background-color: #e30100;color: white">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Peringatan</h4>
                              </div>
                        	  <div class="modal-body">
                        		  <p>Apakah anda yakin ingin mengimport data?<br>Jika anda mengimport data, data akun yang lama akan terhapus semua!</p>
                        	  </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Import</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    @include('master.modal_js')

    <div class="modal fade" id="rejectModal4" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="judul">Konfirmasi Import</h4>
                </div>
                <div class="modal-body">
                    <p id="mess">Apakah anda ingin melanjutkan? Data yang sudah ada akan di replace.</p>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" onclick="cekdata()" class="btn btn-warning" data-dismiss="modal">Cek Data</button>
                        </div>
                        <div class="col-md-10">
                            <button type="button" onclick="replace()" class="btn btn-primary" data-dismiss="modal">Replace</button>
                            <button type="button" onclick="skip()" class="btn btn-success" data-dismiss="modal">Skip</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#btnsave').on('click', function() {
            if ($('#import').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Excel File</h4>');
                $('#mess').html('<p id="mess">File tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                $('#rejectModal4').modal();
            }
        });

        function cekdata() {
            $('#konf').val("cekdata");
            $('#fimak').submit();
        }

        function replace() {
            $('#konf').val("replace");
            $('#fimak').submit();
        }

        function skip() {
            $('#konf').val("skip");
            $('#fimak').submit();
        }
    </script>
    {{--<script>--}}
        {{--$('#btnsave').on('click', function() {--}}
            {{--$('#rejectModal').modal();--}}
        {{--});--}}
    {{--</script>--}}
@stop
