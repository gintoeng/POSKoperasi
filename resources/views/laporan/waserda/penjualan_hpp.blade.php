@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="{!! url('laporan/waserda/penjualan') !!}">Penjualan HPP</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="get" action="{!! url('laporan/waserda/penjualan/hpp/cetak') !!}" target="_blank" id="flapjual">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="print" id="print" value="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="dari" class="col-sm-1 control-label">Dari Produk</label>
                                    <div class="col-sm-11">
                                        <div class="input-group">
                                            <select name="brdari" type="text" class="form-control col-sm-4" id="ksdari" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($produk as $item)
                                                    <option value="{!! $item->id !!}">{!! $item->nama !!}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-addon">s/d</span>
                                            <select name="brke" type="text" class="form-control col-sm-4" id="kske" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($produk as $item)
                                                    <option value="{!! $item->id !!}">{!! $item->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dari" class="col-sm-3 control-label">Dari Cabang</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select name="cbdari" type="text" class="form-control col-sm-4" id="cbdari" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($cabang as $item)
                                                    <option value="{!! $item->id !!}">{!! $item->kode !!} - {!! $item->nama !!}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-addon">s/d</span>
                                            <select name="cbke" type="text" class="form-control col-sm-4" id="cbke" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($cabang as $item)
                                                    <option value="{!! $item->id !!}">{!! $item->kode !!} - {!! $item->nama !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tgl" class="col-sm-3 control-label">Tanggal</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="dari" type="text" class="form-control datepicker" id="dari" value="01/01/2015">
                                            <span class="input-group-addon">s/d</span>
                                            <input name="ke" type="text" class="form-control datepicker" id="ke" value="{!! $today !!}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group icheck">
                                    <label for="urut" class="col-sm-3 control-label">Urut Berdasarkan</label>
                                    <div class="col-sm-5">
                                        <select name="urut" class="form-control" id="urut" style="width: 100%">
                                            <option value="tanggal">Tanggal</option>
                                            <option value="produk">'Nama Produk</option>
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
                                    <a href="{!! url('laporan/waserda/penjualan') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
            $('#flapjual').submit();
        });
        $('#btnctk').on('click', function(){
            $('#print').val("cetak");
            $('#flapjual').submit();
        });

        $("#urut").removeAttr('class');
        $("#urut").select2();

        $("#csdari").removeAttr('class');
        $("#csdari").select2();
        $("#cske").removeAttr('class');
        $("#cske").select2();

        $("#cbdari").removeAttr('class');
        $("#cbdari").select2();
        $("#cbke").removeAttr('class');
        $("#cbke").select2();

        $("#ksdari").removeAttr('class');
        $("#ksdari").select2();
        $("#kske").removeAttr('class');
        $("#kske").select2();

        $("#status").removeAttr('class');
        $("#status").select2();

    </script>
@stop
