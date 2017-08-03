@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/katshudetail') !!}">Daftar SHU</a></li>
        <li class="active">Tambah</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('master/katshudetail') !!}" id="fshud">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="idheader" class="col-sm-3 control-label">Kelompok SHU</label>
                                    <div class="col-sm-9">
                                        <select name="id_header" class="form-control" id="idheader" data-placeholder="Kelompok SHU" style="width: 100%">
                                            <option value=""></option>
                                            @foreach($header as $item)
                                                <option value="{!! $item->id !!}">{!! $item->kode !!} - {!! $item->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namaunit" class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input name="nama" type="text" class="form-control" id="nama" placeholder="Nama" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="percent" class="col-sm-3 control-label">Persen</label>
                                    <div class="col-sm-9">
                                        <div class="spinner input-group">
                                            <input name="percent" type="text" class="form-control input-sm spinner-input" id="percent" value="0" placeholder="Persen">
                                            <span class="input-group-addon">%</span>
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
                                    <label for="menerima-shu" class="col-sm-3 control-label">Menerima SHU</label>
                                    <div class="col-sm-9">
                                        <div class="checkbox">
                                            <label><input name="menerima_shu" type="checkbox" value="1" id="shu">&nbsp;(Masuk SHU)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field" class="col-sm-3 control-label">Field</label>
                                    <div class="col-sm-9">
                                        <input name="field" type="text" class="form-control" id="field" placeholder="Field" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="tanggal_lahir" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <button id="btnsave" type="button" class="btn btn-primary btn-block" name="save">Save</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('master/katshudetail') !!}" class="btn btn-danger btn-block">Cancel</a>
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

        $("#idheader").removeAttr('class');
        $("#idheader").select2();

        $('#btnsave').on('click', function() {
            if ($('#idheader').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kelompok SHU</h4>');
                $('#mess').html('<p id="mess">Kelompok SHU tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#nama').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama SHU</h4>');
                $('#mess').html('<p id="mess">Nama SHU tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#percent').val() == "" || $('#percent').val() == "0") {
                $('#judul').html('<h4 class="modal-title" id="judul">Perren SHU</h4>');
                $('#mess').html('<p id="mess">Persen SHU tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#field').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Field SHU</h4>');
                $('#mess').html('<p id="mess">Field SHU tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            }else {
                FunctionLoading();
                $('#fshud').submit();
            }

        });
    </script>
@stop
