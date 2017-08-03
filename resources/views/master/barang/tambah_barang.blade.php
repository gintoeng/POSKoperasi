@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/barang') !!}">Daftar Barang</a></li>
        <li class="active">Tambah</li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('master/barang') !!}" id="fpro" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <!--<div class="form-group">
                                    <label for="kode" class="col-sm-3 control-label">Kode</label>
                                    <div class="col-sm-9">
                                        <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode" required>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label for="barcode" class="col-sm-3 control-label">Barcode</label>
                                    <div class="col-sm-9">
                                        <input name="barcode" type="text" class="form-control" id="barcode" placeholder="Barcode">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama" class="col-sm-3 control-label">Nama barang</label>
                                    <div class="col-sm-9">
                                        <input name="nama" type="text" class="form-control" id="nama" placeholder="Nama barang" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kategori" class="col-sm-3 control-label">Kategori</label>
                                    <div class="col-sm-9">
                                        <select name="kategori" style="width:100%;" id="kategori" data-placeholder="Pilih Kategori" class="form-control chosen" required>
                                            <option value=""></option>
                                            @foreach($kategori as $value)
                                                <option value="{!! $value->id !!}">{!! $value->kode !!} - {!! $value->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="classification" class="col-sm-3 control-label">Merk</label>
                                    <div class="col-sm-9">
                                        <input name="classification" type="text" class="form-control" id="classification" placeholder="Merk">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="unit" class="col-sm-3 control-label">Unit</label>
                                    <div class="col-sm-9">
                                        <select name="unit" style="width:100%;" id="unit" data-placeholder="Pilih Unit" class="form-control chosen" required>
                                            <option value=""></option>
                                            @foreach($unit as $value)
                                                <option value="{!! $value->id !!}">{!! $value->kode !!} - {!! $value->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="matauang" class="col-sm-3 control-label">Mata uang</label>
                                    <div class="col-sm-9">
                                        <select name="curr" style="width:100%;" id="matauang" data-placeholder="Pilih Mata uang" class="form-control chosen" required>
                                            <option value=""></option>
                                            @foreach($matauang as $value)
                                                <option value="{!! $value->id !!}" {!! $value->def == "1" ? 'selected' : '' !!}>{!! $value->kode !!} - {!! $value->nama !!} {!! $value->def == 1 ? '( DEFAULT )' : '' !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="diskon-tipe" class="col-sm-3 control-label">Diskon</label>
                                    <div class="col-sm-9">
                                        <div class="spinner input-group">
                                            <select name="diskon_tipe" class="input-sm form-control" id="diskon-tipe">
                                                <option value="nominal">Diskon Nominal</option>
                                                <option value="percent">Diskon Persen</option>
                                            </select>
                                            <span id="spn1" class="input-group-addon">Nominal</span>
                                            <input type="text" class="input-sm form-control" id="diskon-nominal" name="diskon_nominal" value="0.00" placeholder="0.00" style="text-align: right;"/>
                                            <span id="spn2" class="input-group-addon" >;-</span>

                                            <span id="spn3" class="input-group-addon hide">Persen</span>
                                            <input type="text" class="form-control input-sm spinner-input hide" id="diskon-persen" name="diskon_persen" value="0" placeholder="0" style="text-align: right;"/>
                                            <span id="spn4" class="input-group-addon hide">%</span>
                                            <div class="spinner-buttons input-group-btn hide" id="spn5">
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
                                <div class="form-group" id="search_form">
                                    <label for="datepicker" class="col-sm-3 control-label">Tanggal Diskon</label>
                                    <div class="col-md-9">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input id="datefrom" type="text" class="input-sm form-control datepicker" name="datefrom" value="{!! $datefrom !!}"/>
                                            <span class="input-group-addon">to</span>
                                            <input id="dateto" type="text" class="input-sm form-control datepicker" name="dateto" value="{!! $dateto !!}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="stok" class="col-sm-3 control-label">Stok</label>
                                    <div class="col-sm-9">
                                        <input name="stok" type="text" class="form-control input-sm spinner-input" id="stok" value="0" placeholder="Stok" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="stokmin" class="col-sm-3 control-label">Stok Minimum</label>
                                    <div class="col-sm-9">
                                        <div class="spinner input-group">
                                            <input name="stokmin" type="text" class="form-control input-sm spinner-input" id="stokmin" value="0" placeholder="Stok Minimum" required>
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

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shu" class="col-sm-3 control-label">SHU</label>
                                    <div class="col-sm-9">
                                        <select name="shu" style="width:100%;" id="shu" data-placeholder="Pilih SHU"  class="form-control" required>
                                            <option value=""></option>
                                            @foreach($shu as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="remark" class="col-sm-3 control-label">Remark</label>
                                    <div class="col-sm-9">
                                        <input name="remark" type="text" class="form-control" id="remark" placeholder="Remark">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control" id="status">
                                            <option value="AKTIF">AKTIF</option>
                                            <option value="NONAKTIF">NONAKTIF</option>
                                        </select>
                                        {{--<input name="status" type="text" class="form-control" id="status" placeholder="Status">--}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="foto" class="col-sm-3 control-label">Foto</label>
                                    <div class="col-sm-9">
                                        <img id="imgfoto" src="{{asset('assets/img/avatar.jpg')}}" alt="your image" width="100" />
                                        <input name="foto" type="file" id="foto" placeholder="Foto">
                                    </div>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label for="printlabel" class="col-sm-3 control-label">Print Label</label>--}}
                                    {{--<div class="col-sm-9">--}}
                                        {{--<input name="print_label" type="text" class="form-control" id="print_label" placeholder="Print label">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="gantiharga" class="col-sm-3 control-label">Ganti harga</label>--}}
                                    {{--<div class="col-sm-9">--}}
                                        {{--<div class="radio">--}}
                                            {{--<label><input name="ganti_harga" type="radio" value="Y" checked>Ya</label>&nbsp;--}}
                                            {{--<label><input name="ganti_harga" type="radio" value="N">Tidak</label>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="form-group">
                                    <label for="ket" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input name="ket" type="text" class="form-control" id="ket" placeholder="Keterangan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="hargabeli" class="col-sm-3 control-label">Harga beli</label>
                                    <div class="col-sm-9">
                                        <input name="harga_beli" type="text" class="form-control" style="text-align:right" id="harga_beli" value="0.00" placeholder="0.00" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="hargajual" class="col-sm-3 control-label">Harga jual</label>
                                    <div class="col-sm-9">
                                        <input name="harga_jual" type="text" class="form-control" style="text-align:right" id="harga_jual" value="0.00" placeholder="0.00" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="untung" class="col-sm-3 control-label">Untung</label>
                                    <div class="col-sm-9">
                                        <input name="hu" type="text" class="form-control" id="untung" style="text-align:right" placeholder="0.00" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="konsinyasi" class="col-sm-3 control-label">Konsinyasi</label>
                                    <div class="col-sm-9 icheck">
                                        {{--<div class="checkbox icheck">--}}
                                        <label><input name="konsinyasi" type="checkbox" value="1" id="konsinyasi">&nbsp;</label>
                                        {{--</div>--}}
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
                                        <a href="{!! url('master/barang') !!}" class="btn btn-danger btn-block">Cancel</a>
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
        $("#unit").removeAttr('class');
        $("#unit").select2();
        $("#matauang").removeAttr('class');
        $("#matauang").select2();
        $("#kategori").removeAttr('class');
        $("#kategori").select2();

        $("#shu").removeAttr('class');
        $("#shu").select2();

        $('#harga_beli').maskMoney();
        $('#harga_jual').maskMoney();
        $('#diskon-nominal').maskMoney();
        $('#untung').maskMoney();

        $('#harga_jual').on('change', function() {
            $.ajax({
                url: "{!! url('master/barang/untung') !!}/" + $('#harga_jual').val() + "/" + $('#harga_beli').val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#untung').val(data[0]["untung"]);
                }

            });
        });

        $('#harga_beli').on('change', function() {
            $.ajax({
                url: "{!! url('master/barang/untung') !!}/" + $('#harga_jual').val() + "/" + $('#harga_beli').val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#untung').val(data[0]["untung"]);
                }

            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imgfoto').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#foto").change(function(){
            readURL(this);
        });

        $('#btnsave').on('click', function() {
            if ($('#nama').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama Barang</h4>');
                $('#mess').html('<p id="mess">Nama Barang tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#shu').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">SHU</h4>');
                $('#mess').html('<p id="mess">SHU tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            }  else if($('#matauang').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Matauang</h4>');
                $('#mess').html('<p id="mess">Matauang tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#unit').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Unit</h4>');
                $('#mess').html('<p id="mess">Unit tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            }  else if($('#kategori').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kategori</h4>');
                $('#mess').html('<p id="mess">Kategori tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            }  else if($('#harga_beli').val() == "" || $('#harga_beli').val() == "0.00" || $('#harga_beli').val() == "0") {
                $('#judul').html('<h4 class="modal-title" id="judul">Harga Beli</h4>');
                $('#mess').html('<p id="mess">Harga Beli tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#harga_jual').val() == "" || $('#harga_jual').val() == "0.00" || $('#harga_jual').val() == "0") {
                $('#judul').html('<h4 class="modal-title" id="judul">Harga Jual</h4>');
                $('#mess').html('<p id="mess">Harga Jual tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#fpro').submit();
            }

        });

        $('#diskon-tipe').on('change', function() {
            if ($(this).val() == "nominal") {
                $('#spn1').removeClass('hide');
                $('#spn1').show();
                $('#spn2').removeClass('hide');
                $('#spn2').show();
                $('#diskon-nominal').removeClass('hide');
                $('#diskon-nominal').show();

                $('#spn3').hide();
                $('#spn4').hide();
                $('#spn5').hide();
                $('#diskon-persen').hide();
            } else {
                $('#spn1').hide();
                $('#spn2').hide();
                $('#diskon-nominal').hide();

                $('#spn3').removeClass('hide');
                $('#spn3').show();
                $('#spn4').removeClass('hide');
                $('#spn4').show();
                $('#spn5').removeClass('hide');
                $('#spn5').show();
                $('#diskon-persen').removeClass('hide');
                $('#diskon-persen').show();
            }
        });
    </script>

@stop
