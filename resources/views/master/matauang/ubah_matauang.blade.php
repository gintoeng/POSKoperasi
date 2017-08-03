@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/matauang') !!}">Daftar Mata Uang</a></li>
        <li class="active">Ubah</li>
        <li class="active">{!! $matauang->kode !!}</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('master/matauang/'.$matauang->id.'/update') !!}" id="fmat">
                        <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Kode" class="col-sm-3 control-label">Kode</label>
                                    <div class="col-sm-9">
                                        <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode" value="{!! $matauang->kode !!}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namaunit" class="col-sm-3 control-label">Nama Mata Uang</label>
                                    <div class="col-sm-9">
                                        <input name="nama" type="text" class="form-control" id="nama" placeholder="Nama Unit" value="{!! $matauang->nama !!}" required>
                                    </div>
                                </div>
                                <div class="form-group icheck">
                                    <label for="def" class="col-sm-3 control-label">Set as Default</label>
                                    <div class="col-sm-9">
                                        <div class="checkbox">
                                            <label><input name="def" type="checkbox" value="1" {!! $matauang->def == "1" ? 'checked' : '' !!}>&nbsp;Set Default</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="tanggal_lahir" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <button id="btnsave" type="button" class="btn btn-primary btn-block" name="save">Save</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('master/matauang') !!}" class="btn btn-danger btn-block">Cancel</a>
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
    <script>
        $('#btnsave').on('click', function() {
            if ($('#kode').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kode Mata Uang</h4>');
                $('#mess').html('<p id="mess">Kode Mata Uang tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#nama').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama Mata Uang</h4>');
                $('#mess').html('<p id="mess">Nama Mata Uang tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#fmat').submit();
            }

        });
    </script>
@stop
