@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="{url}/laporan/keuangan/lababulanan">Laba Rugi Bulanan</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post">

                        <div class="box-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#umum" data-toggle="tab">Laporan Laba Rugi Bulanan</a>
                                </li>
                                <li><a href="#pilih" data-toggle="tab">Pilih Laporan</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="umum">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tgl" class="col-sm-3 control-label">Periode</label>
                                                <div class="input-group">
                                                    <div class="col-sm-8">
                                                        <select name="bulan" class="form-control" id="bulan">
                                                            <option value="Januari">Januari</option>
                                                            <option value="Februari">Februari</option>
                                                            <option value="Maret">Maret</option>
                                                            <option value="April">April</option>
                                                            <option value="Mei">Mei</option>
                                                            <option value="Juni">Juni</option>
                                                            <option value="Juli">Juli</option>
                                                            <option value="September">September</option>
                                                            <option value="Oktober">Oktober</option>
                                                            <option value="November">November</option>
                                                            <option value="Desember">Desember</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input name="th" type="text" class="form-control" id="max_baris" placeholder="Tahun">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="urut" class="col-sm-3 control-label"></label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span>Periode  :  </span>
                                                        <input name="dari" type="text" value="" placeholder="01/01/2015" disabled>
                                                        <span> s/d </span>
                                                        <input name="ke" type="text" value="" placeholder="31/12/2015" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pilih">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pilih" class="col-sm-1 control-label"></label>
                                                <div class="col-sm-10 icheck">
                                                    <div class="mb5 mt5">
                                                        <input tabindex="1" type="radio" id="radio1" name="pilih">
                                                        <label for="radio1"><i class="fa fa-file-text-o mr5"></i>Laporan Laba Rugi Bulanan</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <a href="{url}/laporan/keuangan/lababulanan/preview" target="_blank" class="btn btn-sm btn-warning mb15"><i class="fa fa-file-text-o mr5"></i>Preview</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <a href="{url}/laporan/keuangan/lababulanan/cetak" target="_blank" class="btn btn-sm btn-info mb15"><i class="ti-printer mr5"></i>Cetak</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="pull-right">
                                <div class="col-sm-2">
                                    <a href="{url}/laporan/keuangan/lababulanan" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>


@stop