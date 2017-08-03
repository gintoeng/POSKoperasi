@extends('layouts.master')

@section('content')
    <style>
        #table-wrapper {
            position:relative;
        }
        #table-scroll {
            height:250px;
            overflow:auto;
            margin-top:20px;
        }
        #table-wrapper table {
            width:100%;

        }

        #table-wrapper table thead th .text {
            position:absolute;
            top:-20px;
            z-index:2;
            height:20px;
            width:35%;
            border:1px solid red;
        }
    </style>

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pinjaman</a>
        </li>
        <li><a href="{!! url('pinjaman/pembayaran') !!}">Daftar Pembayaran</a></li>
        <li class="active">Tambah</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('pinjaman/pembayaran') !!}" id="fpem">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id_pinjaman" id="id_pinjaman">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nomor_pinjaman" class="col-sm-3 control-label">Nomor Pinjaman</label>
                                    <div class="col-sm-9">
                                        <select name="nomor_pinjaman" style="width: 100%;" type="text" class="chosen" id="nomor_pinjaman" data-placeholder="Pilih Nomor Pinjaman" required>
                                            <option value=""></option>
                                            @foreach($pinjaman as $value)
                                                <?php
                                                    $maxlev = $value->pengaturanid->approveroleid->max('level');
                                                    $approve = \App\Approve::where('id_for', $value->id)->first();
                                                        if($maxlev == 1) {
                                                            if($approve->lev1 == 1) {
                                                                $wait = "OK";
                                                            } else {
                                                                $wait = "FAIL";
                                                            }
                                                        } else if($maxlev == 2) {
                                                            if($approve->lev2 == 1) {
                                                                $wait = "OK";
                                                            } else {
                                                                $wait = "FAIL";
                                                            }
                                                        } else if($maxlev == 3) {
                                                            if($approve->lev3 == 1) {
                                                                $wait = "OK";
                                                            } else {
                                                                $wait = "FAIL";
                                                            }
                                                        } else {
                                                            if($approve->release == 1) {
                                                                $wait = "OK";
                                                            } else {
                                                                $wait = "FAIL";
                                                            }
                                                        }
                                                ?>
                                                    @if($wait == "OK")
                                                        <option value="{!! $value->id !!}">{!! $value->nomor_pinjaman !!} - {!! $value->anggotaid->nama !!}</option>
                                                    @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_pinjaman" class="col-sm-3 control-label">Jenis Pinjaman</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="jenis_pinjaman" placeholder="Jenis Pinjaman" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_anggota" class="col-sm-3 control-label">Nama Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama_anggota" placeholder="Nama Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_anggota" class="col-sm-3 control-label">Alamat Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="alamat_anggota" placeholder="Alamat Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="realisasi" class="col-sm-3 control-label">Realisasi</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="hidden" name="jwaktu" id="jwaktu">
                                            <input name="realisasi" type="text" class="form-control right" id="realisasi" style="text-align:right" placeholder="0.00" value="0.00">
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="suku_bunga" class="col-sm-3 control-label">Suku Bunga</label>
                                    <div class="col-sm-9">
                                        <div class="spinner input-group" id="suku_bunga">
                                            <input name="suku_bunga" type="text" class="form-control input-sm spinner-input" id="suku-bunga" placeholder="Suku Bunga" value="0">
                                            <span class="input-group-addon">% PA</span>
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
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_realisasi" class="col-sm-6 control-label">Tanggal Realisasi</label>
                                    <div class="col-sm-6">
                                        <input name="tanggal_realisasi" type="text" class="form-control datepicker" id="tanggal_realisasi" value="{!! $today !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_jt_pinjaman" class="col-sm-6 control-label">Tanggal Jatuh Pinjaman</label>
                                    <div class="col-sm-6">
                                        <input name="tanggal_jt_pinjaman" type="text" class="form-control datepicker" id="tanggal_jt_pinjaman" value="{!! $today !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tangaal_jt_periode" class="col-sm-6 control-label">Tanggal JT Periode</label>
                                    <div class="col-sm-6">
                                        <input name="tanggal_jt_periode" type="text" class="form-control datepicker" id="tanggal_jt_periode" value="{!! $today !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tangaal_transaksi" class="col-sm-6 control-label">Tanggal Transaksi</label>
                                    <div class="col-sm-6">
                                        <input name="tanggal_transaksi" type="text" class="form-control datepicker" id="tanggal_transaksi" value="{!! $today !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_hari" class="col-sm-6 control-label">Pembayaran Ke</label>
                                    <div class="col-sm-6">
                                        <div class="spinner input-group" id="suku_bunga">
                                            <input name="jumlah_hari" type="text" class="form-control input-sm spinner-input" id="jumlah_hari" placeholder="Jumlah Hari" value="0" readonly>
                                            {{--<div class="spinner-buttons input-group-btn">--}}
                                                {{--<button type="button" class="btn btn-warning btn-sm spinner-down">--}}
                                                    {{--<i class="ti-minus"></i>--}}
                                                {{--</button>--}}
                                                {{--<button type="button" class="btn btn-success btn-sm spinner-up">--}}
                                                    {{--<i class="ti-plus"></i>--}}
                                                {{--</button>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_hari_terlambat" class="col-sm-6 control-label">Jml Hari Terlambat</label>
                                    <div class="col-sm-6">
                                        <div class="spinner input-group" id="suku_bunga">
                                            <input name="jumlah_hari_terlambat" type="text" class="form-control input-sm spinner-input" id="jumlah_hari_terlambat" placeholder="Jml Hari Terlambat" value="0" readonly>
                                            {{--<div class="spinner-buttons input-group-btn">--}}
                                                {{--<button type="button" class="btn btn-warning btn-sm spinner-down">--}}
                                                    {{--<i class="ti-minus"></i>--}}
                                                {{--</button>--}}
                                                {{--<button type="button" class="btn btn-success btn-sm spinner-up">--}}
                                                    {{--<i class="ti-plus"></i>--}}
                                                {{--</button>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/><br/>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bayar_pokok" class="col-sm-3 control-label">Bayar Pokok</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="bayar_pokok" type="text" class="form-control right" id="bayar_pokok" style="text-align:right" placeholder="0.00" value="0.00">
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bayar_bunga" class="col-sm-3 control-label">Bayar Bunga</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="bayar_bunga" type="text" class="form-control right" id="bayar_bunga" style="text-align:right" placeholder="0.00" value="0.00">
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bayar_denda" class="col-sm-3 control-label">Bayar Denda</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="bayar_denda" type="text" class="form-control right" id="bayar_denda" style="text-align:right" placeholder="0.00" value="0.00">
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="total" class="col-sm-3 control-label">Total</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="total" type="text" class="form-control right" id="total" style="text-align:right" placeholder="0.00" value="0.00">
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="table-wrapper">
                                <div class="table-responsive no-border" id="table-scroll">
                                    <table id="table" class="table table-bordered table-striped mg-t editable-datatable scroll">
                                        <thead>
                                        <tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">
                                            <th class="text-center" width="70">No</th>
                                            <th class="text-center">Tanggal Bayar</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Saldo</th>
                                        </tr>
                                        </thead>
                                        <tbody style="overflow-y: scroll;height: 250px;width: auto;position: absolute;">
                                            <?php
                                                $i = 0;
                                            ?>
                                            <tr style="width: 100%;display: inline-table;table-layout: fixed;">
                                                <td class="text-center" width="70">{!! $i++ !!}</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                        <br/><br/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cara_bayar" class="col-sm-2 control-label">Cara Bayar</label>
                                    <div class="col-sm-10">
                                        <div class="radio">
                                            <label><input name="cara_bayar" type="radio" value="Tunai" checked id="tun"> Tunai</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input name="cara_bayar" type="radio" value="Simpanan" id="simp"> Dari Simpanan</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{--<label><input name="cara_bayar" type="radio" value="Autodebet" id="autod"> Autodebet</label>--}}
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label for="akun-kas" class="col-sm-2 control-label">Akun Kas</label>--}}
                                    {{--<div class="col-sm-10">--}}
                                        {{--<select name="akun_kas" type="text" style="width: 100%;" class="form-control chosen" id="akun-kas-">--}}
                                            {{--<option value=""></option>--}}
                                            {{--@foreach($perkiraan as $value)--}}
                                                {{--<option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="form-group hide" id="psimp">
                                    <label for="pilih_simpanan" class="col-sm-2 control-label">Pilih Simpanan</label>
                                    <div class="col-sm-4">
                                        <select name="pilih_simpanan" type="text" style="width: 100%;" class="form-control chosen" id="pilih-simpanan">
                                            @foreach($simpanan as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nomor_simpanan !!} - {!! $value->anggotaid->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="saldo_simpanan" class="col-sm-2 control-label">Saldo Simpanan</label>
                                    <div class="col-sm-4" id="saldo_simpanan">
                                        <input type="text" class="form-control" id="saldo-simpanan" placeholder="0.00" value="0.00" readonly>
                                    </div>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label for="saldo_simpanan" class="col-sm-2 control-label">Saldo Simpanan</label>--}}
                                    {{--<div class="col-sm-4" id="saldo_simpanan">--}}
                                        {{--<input type="text" class="form-control" id="saldo-simpanan" placeholder="0.00" value="0.00" readonly>--}}
                                    {{--</div>--}}
                                    {{--<label for="status_simpanan" class="col-sm-2 control-label">Status Simpanan</label>--}}
                                    {{--<div class="col-sm-4">--}}
                                        {{--<input type="text" class="form-control" id="status_simpanan" placeholder="Status Simpanan" readonly>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="form-group">
                                    <label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="idpem" id="idpem">
                                    <input type="hidden" name="bakhir" id="bakhir">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <input type="button" id="btnsave" class="btn btn-primary btn-block" name="save" value="Save">
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('pinjaman/pembayaran') !!}" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:void(0)" id="btnsimulasi" class="btn btn-success btn-block">Simulasi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <input type="hidden" id="simbid" value="">
    <input type="hidden" id="simb" value="">
    <input type="hidden" id="autodstat" value="">
    @include('pinjaman.pembayaran.simulasi_pembayaran')

    <script>

        $('#realisasi').maskMoney();
        $('#bayar_pokok').maskMoney();
        $('#bayar_bunga').maskMoney();
        $('#bayar_denda').maskMoney();
        $('#saldo_simpanan').maskMoney();
        $('#total').maskMoney();

        $('#btnsave').on('click', function() {
            if ($('#nomor_pinjaman').val()=='') {
                $('#mess').html('<p id="mess">Pilih nomor pinjaman terlebih dahulu untuk Save.</p>');
                $('#rejectModal').modal();
            } else {

                $.ajax({
                    url: "{{ url('pinjaman/bayar/cekauto') }}/"+$('#autodstat').val(),
                    data: {},
                    dataType: "json",
                    type: "get",
                    success:function(data)
                    {
                        if (data[0]["stat"] == "FAIL") {
                            var judul = data[0]["title"];
                            var pesan = data[0]["psg"];
                            $('#judul').html("<h4 class='modal-title' id=''judul'>" + judul + "</h4>");
                            $('#mess').html("<p id='mess'>" + pesan + "<p>");
                            $('#rejectModal').modal();
                        } else {


                            if($('input:radio[name=cara_bayar]:checked').val() == "Tunai") {
                                FunctionLoading();
                                $('#fpem').submit();
                            } else if($('input:radio[name=cara_bayar]:checked').val() == "Simpanan") {
                                $.ajax({
                                    url: "{{ url('pinjaman/bayar/ceksaldo') }}/" + $('#pilih-simpanan').val() + "/" + $('#total').val(),
                                    data: {},
                                    dataType: "json",
                                    type: "get",
                                    success:function(data)
                                    {
                                        if (data[0]["stat"] == "FAIL") {
                                            var judul = data[0]["title"];
                                            var pesan = data[0]["psg"];
                                            $('#judul').html("<h4 class='modal-title' id=''judul'>" + judul + "</h4>");
                                            $('#mess').html("<p id='mess'>" + pesan + "<p>");
                                            $('#rejectModal').modal();
                                        } else {
                                            FunctionLoading();
                                            $('#fpem').submit();
                                        }
                                    }
                                });
                            }
                        }
                    }
                });

            }
        });

        $("#pilih-simpanan").removeAttr('class');
        $("#pilih-simpanan").select2();

        $('#bayar_denda').on('change', function() {
            var formData = {
                'bpokok'    : $('#bayar_pokok').val(),
                'bbunga'    : $('#bayar_bunga').val(),
                'bdenda'    : $('#bayar_denda').val()
            };
            $.ajax({
                url: "{!! url('pinjaman/bayar/total') !!}",
                data: formData,
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#total').val(data[0]["btotal"]);
                }

            });
        });

        $('#nomor_pinjaman').on('change', function () {
            $.ajax({
                url: "{!! url('pinjaman/bayar/ajax') !!}/" + $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#autodstat').val("at");
                    $('#id_pinjaman').val(data[0]["id"]);
                    $('#jenis_pinjaman').val(data[0]["jenis"]);
                    $('#nama_anggota').val(data[0]["nama"]);
                    $('#alamat_anggota').val(data[0]["alamat"]);
                    $('#realisasi').val(data[0]["realisasi"]);
                    $('#akun_kas_bank').val(data[0]["akun"]);
                    $('#bayar_pokok').val(data[0]["bpokok"]);
                    $('#bayar_bunga').val(data[0]["bbunga"]);
                    $('#suku-bunga').val(data[0]["sbunga"]);
                    $('#tanggal_realisasi').val(data[0]["tgl_real"]);
                    $('#tanggal_jt_pinjaman').val(data[0]["tgl_tempo"]);
                    $('#total').val(data[0]["btotal"]);
                    $('#idpem').val(data[0]["idpem"]);
                    $('#bakhir').val(data[0]["bakhir"]);
                    $('#jwaktu').val(data[0]["jwaktu"]);
                    $('#simb').val(data[0]["simb"]);
                    $('#simbid').val(data[0]["simbid"]);
                    $('#bayar_denda').val(data[0]["bdenda"]);
                    $('#jumlah_hari').val(data[0]["hari_ke"]);
                    $('#jumlah_hari_terlambat').val(data[0]["hari_terlambat"]);
                    $('#tanggal_jt_periode').val(data[0]["tgl_periode"]);
                }

            });
            $('#table').load("{!! url('pinjaman/listbayar') !!}/" + $(this).val());
        });

        $('#pilih-simpanan').on('change', function () {
            $.ajax({
                url: "{!! url('simpanan/transaksi/ajax/') !!}/" + $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#saldo-simpanan').val(data[0]["saldo"]);
                    if (data[0]["stat"] == "FAIL") {
                        var judul = data[0]["title"];
                        var pesan = data[0]["psg"];
                        $('#judul').html("<h4 class='modal-title' id=''judul'>" + judul + "</h4>");
                        $('#mess').html("<p id='mess'>" + pesan + "<p>");
                        $('#rejectModal').modal();
                    }
                }

            });
        });

        $('#btnsimulasi').on('click', function(){
            if ($('#nomor_pinjaman').val()=='') {
                $('#rejectModal').modal();
            }

            else {
                $('.bungatr').remove();
                $('#id_simulasi').val($('#id_pinjaman').val());
                $('#nama_simulasi').val($('#nama_anggota').val());
                $('#bunga_simulasi').val($('#suku-bunga').val());
                $('#jangkawaktu_simulasi').val($('#jwaktu').val());
                $('#jmlpengajuan_simulasi').val($('#realisasi').val());
                $('#tgl_pengajuan').val($('#tanggal_realisasi').val());
                $('#jth_tempo').val($('#tanggal_jt_pinjaman').val());
                $('#angsuran_simulasi').val($('#bayar_pokok').val());
                $('#sistem_bungasim').val($('#simb').val());
                $('#simulasiModal').modal();

                $.ajax({
                    url: "{{ url('pinjaman/sistembunga') }}/"+$('#simbid').val()+"/"+$('#id_simulasi').val(),
                    data: {},
                    type: "get",
                    success:function(data)
                    {
                        $('#bodybunga').html($('#bodybunga').html()+data);
                    }
                });
            }
        });

        $('#sistem_bunga').on('change',function() {
            if ($(this).val()=='') {
                $('.bungatr').remove();
            }

            else {
                $('.bungatr').remove();
                $.ajax({
                    url: "{{ url('pinjaman/sistembunga2') }}/"+$(this).val()+"/"+$('#id_simulasi').val(),
                    data: {},
                    type: "get",
                    success:function(data)
                    {
                        $('#bodybunga').html($('#bodybunga').html()+data);
                    }
                });
            }
        });

        $('#simp').on('click', function(){
            $("#psimp").removeClass('hide');
            $("#psimp").show();
        });

        $('#tun').on('click', function(){
            $("#psimp").hide();
        });

//        $('#autod').on('click', function(){
//            $("#psimp").hide();
//        });

        {{--$('#pilih-simpanan').on('click', function(){--}}
            {{--$('#saldo_simpanan').load("{!! url('pinjaman/bayar/loadsaldo') !!}/" + $(this).val());--}}
        {{--});--}}
    </script>

@stop

