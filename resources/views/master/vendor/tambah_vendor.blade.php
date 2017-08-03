@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/vendor') !!}">Daftar Vendor</a></li>
        <li class="active">Tambah</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('master/vendor') !!}" id="fven">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode" class="col-sm-3 control-label">Kode</label>
                                    <div class="col-sm-9">
                                        <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode" value="{!! $kode !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_vendor" class="col-sm-3 control-label">Nama vendor</label>
                                    <div class="col-sm-9">
                                        <input name="nama_vendor" type="text" class="form-control" id="namavendor" placeholder="Nama vendor">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_kontak" class="col-sm-3 control-label">Nama kontak</label>
                                    <div class="col-sm-9">
                                        <input name="nama_kontak" type="text" class="form-control" id="namakontak" placeholder="Nama kontak">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat1" class="col-sm-3 control-label">Alamat 1</label>
                                    <div class="col-sm-9">
                                        <textarea name="alamat_1" type="text" class="form-control" id="alamat1" placeholder="Alamat"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat2" class="col-sm-3 control-label">Alamat 2</label>
                                    <div class="col-sm-9">
                                        <textarea name="alamat_2" type="text" class="form-control" id="alamat2" placeholder="Alamat alternatif"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="col-sm-3 control-label">Telepon</label>
                                    <div class="col-sm-9">
                                        <input name="phone" type="text" class="form-control" id="telepon" placeholder="Telepon">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fax" class="col-sm-3 control-label">Fax</label>
                                    <div class="col-sm-9">
                                        <input name="fax" type="text" class="form-control" id="fax" placeholder="Fax">
                                    </div>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label for="matauang" class="col-sm-3 control-label">Mata uang</label>--}}
                                    {{--<div class="col-sm-9">--}}
                                        {{--<select name="mata_uang" style="width:100%;" id="matauang" data-placeholder="Pilih Mata uang" class="chosen" required>--}}
                                            {{--<option value=""></option>--}}
                                            {{--@foreach($matauang as $value)--}}
                                                {{--<option value="{!! $value->id !!}">{!! $value->kode !!} - {!! $value->nama !!}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="form-group">
                                    <label for="bank" class="col-sm-3 control-label">Bank</label>
                                    <div class="col-sm-9">
                                        <select name="bank" style="width:100%;" id="bank" data-placeholder="Pilih Bank" class="chosen" required>
                                            <option value=""></option>
                                            @foreach($bank as $value)
                                                <option value="{!! $value->id !!}">{!! $value->kode !!} - {!! $value->nama_bank !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namaakun" class="col-sm-3 control-label">Nama Akun Bank</label>
                                    <div class="col-sm-9">
                                        <input name="nama_akun" type="text" class="form-control" id="namaakun" placeholder="Nama Akun">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nomorakun" class="col-sm-3 control-label">Nomor Akun Bank</label>
                                    <div class="col-sm-9">
                                        <input name="nomor_akun" type="text" class="form-control" id="nomorakun" placeholder="Nomor Akun">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input name="keterangan" type="text" class="form-control" id="keterangan" placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <button id="btnsave" type="button" class="btn btn-primary btn-block" name="save">Save</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('master/vendor') !!}" class="btn btn-danger btn-block">Cancel</a>
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
            if ($('#namavendor').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama Vendor</h4>');
                $('#mess').html('<p id="mess">Nama Vendor tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#bank').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Bank</h4>');
                $('#mess').html('<p id="mess">Bank tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#fven').submit();
            }

        });

        {{--$('#bank').on('change', function() {--}}
            {{--$.ajax({--}}
                {{--url: "{!! url('master/vendor/ajax') !!}/" + $(this).val(),--}}
                {{--data: {},--}}
                {{--dataType: "json",--}}
                {{--type: "get",--}}
                {{--success: function (data) {--}}
                    {{--$('#namaakun').val(data[0]["nama"]);--}}
                    {{--$('#nomorakun').val(data[0]["nomor"]);--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    </script>

@stop
