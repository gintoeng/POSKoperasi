@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/customer') !!}">Daftar Customer</a></li>
        <li class="active">Import</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="{!! url('master/customer/import') !!}" id="fimcs">
                        <input type="hidden" name="konf" id="konf" value="">
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
                                        <input type='text' readonly class='form-control' value='Sheet 1 : KODE | NO_KTP | NAMA | TGL_LAHIR | AlAMAT | KOTA | PROVINSI | KODE_POS | TELEPON | '><br/>
                                        <input type='text' readonly class='form-control' value='JENIS_KELAMIN | TANGGAL_REGISTRASI | KD_CABANG_REK | NPK | DEPT'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="import" class="col-sm-2 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <ul>
                                            <li>KODE : Kode Customer</li>
                                            <li>JENIS_KELAMIN : L / P (Pilih salah satu)</li>
                                            <li>TANGGAL_REGISTRASI : YYYY-MM-DD</li>
                                            <li>TGL_LAHIR : YYYY-MM-DD</li>
                                            <li>NPK : Nomor Pegawai Karyawan</li>
                                            <li>DEPT : Departemen</li>
                                            <li>KD_CABANG_REK : Kode dari Cabang Rekening (Jika Kosong data akan di skip)</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="tanggal_lahir" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-2">
                                        <a href="{!! url('master/customer/import/sample') !!}" class="btn btn-warning btn-block"><i class="ti-download mr5"></i>Sample</a>
                                    </div>
                                    <div class="col-sm-2">
                                        <button id="btnsave" type="button" class="btn btn-primary btn-block" name="upload" value="Upload"><i class="ti-upload mr5"></i>Upload</button>
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
            $('#fimcs').submit();
        }

        function replace() {
            $('#konf').val("replace");
            $('#fimcs').submit();
        }

        function skip() {
            $('#konf').val("skip");
            $('#fimcs').submit();
        }
    </script>

    {{--<script>--}}
        {{--$('#btnsave').on('click', function() {--}}
            {{--$.ajax({--}}
                {{--url: "{!! url('master/customer/cek/import') !!}",--}}
                {{--data: {},--}}
                {{--dataType: "json",--}}
                {{--type: "get",--}}
                {{--success:function(data)--}}
                {{--{--}}
                    {{--if (data[0]["stat"] == "FAIL") {--}}
                        {{--var judul = data[0]["title"];--}}
                        {{--var pesan = data[0]["psg"];--}}
                        {{--$('#judul').html("<h4 class='modal-title' id=''judul'>" + judul + "</h4>");--}}
                        {{--$('#mess').html("<p id='mess'>" + pesan + "<p>");--}}
                        {{--$('#rejectModal').modal();--}}
                    {{--} else {--}}
                        {{--if ($('#import').val() == "") {--}}
                            {{--$('#judul').html('<h4 class="modal-title" id="judul">Excel File</h4>');--}}
                            {{--$('#mess').html('<p id="mess">File tidak boleh kosong.</p>');--}}
                            {{--$('#rejectModal').modal();--}}
                        {{--} else {--}}
                            {{--FunctionLoading();--}}
                            {{--$('#fimcs').submit();--}}
                        {{--}--}}
                    {{--}--}}

                {{--}--}}

            {{--});--}}

        {{--});--}}
    {{--</script>--}}

@stop
