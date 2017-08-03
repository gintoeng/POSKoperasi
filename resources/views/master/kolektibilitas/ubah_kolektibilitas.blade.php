@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/kolektibilitas') !!}">Daftar Kolektibilitas</a></li>
        <li class="active">Ubah</li>
        <li class="active">{!! $kolektibilitas->kode !!}</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('master/kolektibilitas/'.$kolektibilitas->id.'/update') !!}" id="fkolek">
                        <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode" class="col-sm-3 control-label">Kode</label>
                                    <div class="col-sm-9">
                                        <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode" value="{!! $kolektibilitas->kode !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kode" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input name="keterangan" type="text" class="form-control" id="nama" placeholder="Keterangan" value="{!! $kolektibilitas->keterangan !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kode" class="col-sm-3 control-label">Batas Hari</label>
                                    <div class="col-sm-9">
                                        <div class="spinner input-group">
                                            <input name="batas_hari" type="text" class="form-control input-sm spinner-input" id="batas_hari" placeholder="Batas Hari" value="{!! $kolektibilitas->batas_hari !!}">
                                            <div class="spinner-buttons input-group-btn">
                                                <button type="button" class="btn btn-warning btn-sm spinner-down">
                                                    <i class="ti-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm spinner-up">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
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
                                        <a href="{{ url('master/kolektibilitas') }}" class="btn btn-danger btn-block">Cancel</a>
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
                $('#judul').html('<h4 class="modal-title" id="judul">Kode Kolektibilitas</h4>');
                $('#mess').html('<p id="mess">Kode Kolektibilitas tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#nama').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Keterangan Kolektibilitas</h4>');
                $('#mess').html('<p id="mess">Keterangan Kolektibilitas tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#fkolek').submit();
            }

        });
    </script>
@stop
