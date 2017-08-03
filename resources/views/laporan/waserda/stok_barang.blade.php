@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="{!! url('laporan/waserda/stok') !!}">Stok Barang</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="get" action="{!! url('laporan/waserda/stok/cetak') !!}" target="_blank" id="flapst">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="print" id="print" value="">
                        <div class="row">
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
                                    <label for="unit" class="col-sm-3 control-label">Unit</label>
                                    <div class="col-sm-9">
                                            <select name="unit" type="text" class="form-control" id="unit" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($unit as $item)
                                                    <option value="{!! $item->id !!}">{!! $item->kode !!} - {!! $item->nama !!}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="unit" class="col-sm-3 control-label">Kategori</label>
                                    <div class="col-sm-9">
                                            <select name="kategori" type="text" class="form-control" id="kategori" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($kategori as $item)
                                                    <option value="{!! $item->id !!}">{!! $item->kode !!} - {!! $item->nama !!}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control" id="status" style="width: 100%">
                                            <option value=""></option>
                                            <option value="AKTIF">AKTIF</option>
                                            <option value="NONAKTIF">NONAKTIF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group icheck">
                                    <label for="urut" class="col-sm-3 control-label">Urut Berdasarkan</label>
                                    <div class="col-sm-5">
                                        <select name="urut" class="form-control" id="urut" style="width: 100%">
                                            <option value="nama">Nama</option>
                                            <option value="merk">Merk</option>
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
                                                <div class="mb5 mt5">
                                                    <input tabindex="1" type="radio" id="radio1" name="pilih" value="stok" checked>
                                                    <label for="radio1"><i class="fa fa-file-text-o mr5"></i>Stok Barang</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="2" type="radio" id="radio3" name="pilih" value="stokcab">
                                                    <label for="radio2"><i class="fa fa-file-text-o mr5"></i>Stok Barang per Cabang</label>
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
                                    <a href="{!! url('laporan/waserda/stok') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
            $('#flapst').submit();
        });
        $('#btnctk').on('click', function(){
            $('#print').val("cetak");
            $('#flapst').submit();
        });

        $("#urut").removeAttr('class');
        $("#urut").select2();

        $("#cbdari").removeAttr('class');
        $("#cbdari").select2();
        $("#cbke").removeAttr('class');
        $("#cbke").select2();

        $("#status").removeAttr('class');
        $("#status").select2();

        $("#unit").removeAttr('class');
        $("#unit").select2();

        $("#kategori").removeAttr('class');
        $("#kategori").select2();
    </script>
@stop
