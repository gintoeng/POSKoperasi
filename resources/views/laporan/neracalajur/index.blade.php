@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="">Transaksi Neraca Lajur</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="get" action="{!! url('laporan/neracalajur/cetak') !!}" target="_blank" id="flapnerlaj">
                        <input type="hidden" name="print" id="print" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dari" class="col-sm-3 control-label">Tanggal Neraca</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="dari" type="text" class="form-control datepicker" id="dari" value="{{$dari}}">
                                            <span class="input-group-addon">s/d</span>
                                            <input name="ke" type="text" class="form-control datepicker" id="ke" value="{{$ke}}">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-group icheck">
                                    <label for="urut" class="col-sm-3 control-label">Angak Dibagi</label>
                                    <div class="col-sm-5">
                                        <select name="bagi" class="form-control" id="bagi" style="width: 100%">
                                            <option value="1">1</option>
                                            <option value="100">100</option>
                                            <option value="1000">1000</option>
                                        </select>
                                    </div>
                                </div> -->
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
                                    <a href="{!! url('laporan/neracalajur') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
        $('#btnpre').on('click', function(){
            $('#print').val("preview");
            $('#flapnerlaj').submit();
        });
        $('#btnctk').on('click', function(){
            $('#print').val("cetak");
            $('#flapnerlaj').submit();
        });
    </script>

@stop
