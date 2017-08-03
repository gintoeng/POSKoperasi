@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="{url}/laporan/keuangan/neraca">Neraca</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post">

                        <div class="box-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#umum" data-toggle="tab">Laporan Neraca</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="umum">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tgl" class="col-sm-3 control-label">Periode</label>
                                                <div class="col-sm-9">
                                                    <input name="periode" type="text" class="form-control datepicker" id="max_baris" value="{{$tanggal}}">
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
                                    <a href="{!! url('laporan/keuangan/neraca/cetak') !!}" target="_blank" class="btn btn-sm btn-info mb15"><i class="ti-printer mr5"></i>Cetak</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-11">
                            <div class="pull-right">
                                <div class="col-sm-2">
                                    <a href="{url}/laporan/keuangan/neraca" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>


@stop
