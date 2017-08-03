@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="">Transaksi Kas</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="get" action="{!! url('laporan/kas/cetak') !!}" target="_blank" id="flapkas">
                        <input type="hidden" name="print" id="print" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dari" class="col-sm-3 control-label">Tanggal Transaksi</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="dari" type="text" class="form-control datepicker" id="dari" value="{{$dari}}">
                                            <span class="input-group-addon">s/d</span>
                                            <input name="ke" type="text" class="form-control datepicker" id="ke" value="{{$ke}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="urut" class="col-sm-3 control-label">Jenis Transaksi</label>
                                    <div class="col-sm-9">
                                        <select name="jenis" class="form-control" id="jenis" style="width: 100%">
                                            <option value="masuk">Kas Masuk</option>
                                            <option value="keluar">Kas Keluar</option>
                                            <option value="transfer">Kas Transfer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group icheck">
                                    <label for="urut" class="col-sm-3 control-label">Urut Berdasarkan</label>
                                    <div class="col-sm-5">
                                        <select name="urut" class="form-control" id="urut" style="width: 100%">
                                            <option value="tgl">Tanggal</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="radio" id="minimal-checkbox-1" name="urutan" value="asc" checked>
                                        <label for="minimal-checkbox-1"> ASC</label>&nbsp;&nbsp;
                                        <input type="radio" id="minimal-checkbox-2" name="urutan" value="desc">
                                        <label for="minimal-checkbox-2"> DESC</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <section class="panel panel-success">
                                    <header class="panel-heading" style="background-color: #00ae00; color: white">Pilih Laporan</header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="pilih" class="col-sm-1 control-label"></label>
                                            <div class="col-sm-10 icheck">
                                                <div class="mb5">
                                                    <input tabindex="3" type="radio" id="radio3" name="pilih" value="kastipe" checked>
                                                    <label for="radio3"><i class="fa fa-file-text-o mr5"></i>Laporan Transaksi Kas Tipe</label>
                                                </div>
                                                <div class="mb5 mt5">
                                                    <input tabindex="1" type="radio" id="radio1" name="pilih" value="kasdetail">
                                                    <label for="radio1"><i class="fa fa-file-text-o mr5"></i>Laporan Transaksi Kas Detail</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="3" type="radio" id="radio3" name="pilih" value="kasrekap">
                                                    <label for="radio3"><i class="fa fa-file-text-o mr5"></i>Laporan Transaksi Kas Rekap</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <button id="btnpre" type="button" class="btn btn-sm btn-warning mb15"><i class="fa fa-file-text-o mr5"></i>Preview</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <button id="btnctk" type="button" class="btn btn-sm btn-info mb15"><i class="ti-printer mr5"></i>Cetak</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <a href="{!! url('laporan/kas') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="pull-right">
                                <div class="col-sm-2">
                                    <a href="{!! url('/') !!}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script>
        $("#jenis").removeAttr('class');
        $("#jenis").select2();
        $("#urut").removeAttr('class');
        $("#urut").select2();

        $('#btnpre').on('click', function(){
            $('#print').val("preview");
            $('#flapkas').submit();
        });
        $('#btnctk').on('click', function(){
            $('#print').val("cetak");
            $('#flapkas').submit();
        });
    </script>
@stop
