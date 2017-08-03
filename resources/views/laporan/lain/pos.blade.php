@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="{url}/laporan/lain/jurnal">POS Transaksi</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('laporan/lain/transaksi/pos/cetak') !!}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#umum" data-toggle="tab">Laporan POS Transaksi</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="umum">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dari" class="col-sm-3 control-label">Tanggal Transaksi</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input name="dari" type="text" class="form-control datepicker" id="dari" value="01/01/2015">
                                                        <span class="input-group-addon">s/d</span>
                                                        <input name="ke" type="text" class="form-control datepicker" id="ke" value="01/01/2015">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="urut" class="col-sm-3 control-label">Urut Berdasarkan</label>
                                                <div class="col-sm-9">
                                                    <select name="urut" class="form-control" id="urut">
                                                        <option value="no_transaksi">No Transaksi</option>
                                                        <option value="tgl">Tanggal</option>
                                                    </select>
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
                                    <button type="submit" class="btn btn-sm btn-warning mb15">&nbsp;<i class="ti-printer mr5"></i>Cetak &nbsp;</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <a href="" class="btn btn-sm btn-danger mb15">Cancel</a>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>


@stop