@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="{!! url('laporan/pinjaman/realisasi') !!}">Realisasi Pinjaman</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="get" action="{!! url('laporan/pinjaman/realisasi/cetak') !!}" target="_blank" id="flappinjreal">
                        <input type="hidden" name="print" id="print" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dari" class="col-sm-3 control-label">Dari No.Pinjaman </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select name="daripinj" type="text" class="form-control" id="daripinj" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($pinjaman as $tampil)
                                                    <option value="{!! $tampil->id !!}">{!! $tampil->nomor_pinjaman !!} - {!! $tampil->anggotaid->nama !!}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-addon">s/d</span>
                                            <select name="kepinj" type="text" class="form-control" id="kepinj" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($pinjaman as $tampil)
                                                    <option value="{!! $tampil->id !!}">{!! $tampil->nomor_pinjaman !!} - {!! $tampil->anggotaid->nama !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dari" class="col-sm-3 control-label">Dari Customer</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select name="csdari" type="text" class="form-control col-sm-4" id="csdari" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($customer as $item)
                                                    <option value="{!! $item->id !!}">{!! $item->kode !!} - {!! $item->nama !!}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-addon">s/d</span>
                                            <select name="cske" type="text" class="form-control col-sm-4" id="cske" style="width: 100%">
                                                <option value="0"></option>
                                                @foreach($customer as $item)
                                                    <option value="{!! $item->id !!}">{!! $item->kode !!} - {!! $item->nama !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tgl" class="col-sm-3 control-label">Tanggal Realisasi</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="dari" type="text" class="form-control datepicker" id="dari" value="01/01/2015">
                                            <span class="input-group-addon">s/d</span>
                                            <input name="ke" type="text" class="form-control datepicker" id="ke" value="{!! $today !!}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_pinjaman" class="col-sm-3 control-label">Jenis Pinjaman</label>
                                    <div class="col-sm-9">
                                        <select name="jenis_pinjaman" class="form-control" id="jenis_pinjaman" style="width: 100%">
                                            <option value=""></option>
                                            @foreach($pengaturan as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nama_pinjaman !!}</option>
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
                                        <select name="urut" class="form-control" id="urut" style="width: 100%;">
                                            <option value="id_pinjaman">No. Pinjaman</option>
                                            {{--<option value="nama">Nama</option>--}}
                                            {{--<option value="alamat">Alamat</option>--}}
                                            {{--<option value="kota">Kota</option>--}}
                                            <option value="tanggal_realisasi">Tanggal Realisasi</option>
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
                                    <a href="{!! url('laporan/pinjaman/realisasi') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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

    @include('laporan.pinjaman.lap_pinjaman_js')
    <script>
        $('#btnpre').on('click', function(){
            $('#print').val("preview");
            $('#flappinjreal').submit();
        });
        $('#btnctk').on('click', function(){
            $('#print').val("cetak");
            $('#flappinjreal').submit();
        });
    </script>
@stop
