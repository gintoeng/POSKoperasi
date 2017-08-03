@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="{!! url('laporan/simpanan/saldo') !!}">Saldo Simpanan</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="get" action="{!! url('laporan/simpanan/saldo/cetak') !!}" target="_blank" id="flapsimpsaldo">
                        <input type="hidden" name="print" id="print" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dari" class="col-sm-3 control-label"> Dari No. Simpanan</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select name="darisimp" type="text" class="form-control" id="darisimp" style="width: 100%">
                                                <option value=""></option>
                                                @foreach($simpanan as $tampil)
                                                    <option value="{!! $tampil->id !!}">{!! $tampil->nomor_simpanan !!} - {!! $tampil->anggotaid->nama !!}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-addon">s/d</span>
                                            <select name="kesimp" type="text" class="form-control" id="kesimp" style="width: 100%">
                                                <option value=""></option>
                                                @foreach($simpanan as $tampil)
                                                    <option value="{!! $tampil->id !!}">{!! $tampil->nomor_simpanan !!} - {!! $tampil->anggotaid->nama !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tgl" class="col-sm-3 control-label">Periode Tanggal</label>
                                    <div class="col-sm-9">
                                        <input name="tgl" type="text" class="form-control datepicker" id="tgl" value="{!! $today !!}">
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
                                            <option value="ANGGOTS">Biasa</option>
                                            <option value="UMUM">Luar Biasa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group icheck">
                                    <label for="urut" class="col-sm-3 control-label">Urut Berdasarkan</label>
                                    <div class="col-sm-5">
                                        <select name="urut" class="form-control" id="urut" style="width: 100%">
                                            <option value="nomor_simpanan">No Simpanan</option>
                                            {{--<option value="nama">Nama Nasabah</option>--}}
                                            {{--<option value="alamat">Nominal</option>--}}
                                            <option value="tanggal_pembuatan">Tanggal Daftar</option>
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
                                                    <input tabindex="1" type="radio" id="radio1" name="pilih" value="sld" checked>
                                                    <label for="radio1"><i class="fa fa-file-text-o mr5"></i>Laporan Saldo Simpanan</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="2" type="radio" id="radio2" name="pilih" value="sldjenis">
                                                    <label for="radio2"><i class="fa fa-file-text-o mr5"></i>Laporan Saldo Berdasarkan Jenis Simpanan</label>
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
                                    <a href="{!! url('laporan/simpanan/saldo') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
            $('#flapsimpsaldo').submit();
        });
        $('#btnctk').on('click', function(){
            $('#print').val("cetak");
            $('#flapsimpsaldo').submit();
        });
    </script>
@stop
