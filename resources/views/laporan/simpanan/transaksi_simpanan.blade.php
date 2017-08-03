@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="{!! url('laporan/simpanan/transaksi') !!}">Transaksi Simpanan</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="get" action="{!! url('laporan/simpanan/transaksi/cetak') !!}" target="_blank" id="flapsimptran">
                        <input type="hidden" name="print" id="print" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dari" class="col-sm-3 control-label">Dari No. Transaksi</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select name="daritran" type="text" class="form-control" id="daritran" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($transaksi as $tampil)
                                                    <option value="{!! $tampil->id !!}">{!! $tampil->kode !!}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-addon">s/d</span>
                                            <select name="ketran" type="text" class="form-control" id="ketran" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($transaksi as $tampil)
                                                    <option value="{!! $tampil->id !!}">{!! $tampil->kode !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dari" class="col-sm-3 control-label">Dari No. Simpanan</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select name="darisimp" type="text" class="form-control" id="darisimp" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($simpanan as $tampil)
                                                    <option value="{!! $tampil->id !!}">{!! $tampil->nomor_simpanan !!} - {!! $tampil->anggotaid->nama !!}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-addon">s/d</span>
                                            <select name="kesimp" type="text" class="form-control" id="kesimp" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($simpanan as $tampil)
                                                    <option value="{!! $tampil->id !!}">{!! $tampil->nomor_simpanan !!} - {!! $tampil->anggotaid->nama !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tgl" class="col-sm-3 control-label">Tanggal Transaksi</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="dari" type="text" class="form-control datepicker" id="dari" value="01/01/2015">
                                            <span class="input-group-addon">s/d</span>
                                            <input name="ke" type="text" class="form-control datepicker" id="ke" value="{!! $today !!}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_simpanan" class="col-sm-3 control-label">Jenis Simpanan</label>
                                    <div class="col-sm-9">
                                        <select name="jenis_simpanan" class="form-control" id="jenis_simpanan" style="width: 100%">
                                            <option value=""></option>
                                            @foreach($pengaturan as $value)
                                                <option value="{!! $value->id !!}">{!! $value->jenis_simpanan !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_customer" class="col-sm-3 control-label">Jenis Customer</label>
                                    <div class="col-sm-9">
                                        <select name="jenis_customer" class="form-control" id="jenis_customer" style="width: 100%">
                                            <option value=""></option>
                                            <option value="UMUM">Umum</option>
                                            <option value="BIASA">Biasa</option>
                                            <option value="LUAR BIASA">Luar Biasa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group icheck">
                                    <label for="urut" class="col-sm-3 control-label">Urut Berdasarkan</label>
                                    <div class="col-sm-5">
                                        <select name="urut" class="form-control" id="urut" style="width: 100%">
                                            <option value="kode">No Transaksi</option>
                                            <option value="tipe">Tipe Transaksi</option>
                                            <option value="tanggal">Tanggal</option>
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
                                                    <input tabindex="1" type="radio" id="radio1" name="pilih" value="transimp" checked>
                                                    <label for="radio1"><i class="fa fa-file-text-o mr5"></i>Transaksi Simpanan</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="2" type="radio" id="radio3" name="pilih" value="retrantipe">
                                                    <label for="radio2"><i class="fa fa-file-text-o mr5"></i>Rekap Transaksi Berdasarkan Tipe</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="3" type="radio" id="radio3" name="pilih" value="detrantipe">
                                                    <label for="radio3"><i class="fa fa-file-text-o mr5"></i>Detail Transaksi Berdasarkan Tipe</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="4" type="radio" id="radio4" name="pilih" value="retranjenis">
                                                    <label for="radio4"><i class="fa fa-file-text-o mr5"></i>Rekap Transaksi Berdasarkan Jenis</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="5" type="radio" id="radio5" name="pilih" value="detranjenis">
                                                    <label for="radio5"><i class="fa fa-file-text-o mr5"></i>Detail Transaksi Berdasarkan Jenis</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="6" type="radio" id="radio6" name="pilih" value="retranjeniscs">
                                                    <label for="radio6"><i class="fa fa-file-text-o mr5"></i>Rekap Transaksi Berdasarkan Jenis Customer</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="7" type="radio" id="radio7" name="pilih" value="detranjeniscs">
                                                    <label for="radio7"><i class="fa fa-file-text-o mr5"></i>Detail Transaksi Berdasarkan Jenis Customer</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="8" type="radio" id="radio8" name="pilih" value="jenissimp">
                                                    <label for="radio8"><i class="fa fa-file-text-o mr5"></i>Jenis Simpanan -> Tipe Transaksi</label>
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
                                    <a href="{!! url('laporan/simpanan/transaksi') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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

    @include('laporan.simpanan.lap_simpanan_js')
    <script>
        $('#btnpre').on('click', function(){
            $('#print').val("preview");
            $('#flapsimptran').submit();
        });
        $('#btnctk').on('click', function(){
            $('#print').val("cetak");
            $('#flapsimptran').submit();
        });
    </script>
@stop
