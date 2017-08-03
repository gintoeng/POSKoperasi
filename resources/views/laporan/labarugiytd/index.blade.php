@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="">Laba Rugi Year To Date</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="get" action="{!! url('laporan/jurnal/cetak') !!}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#umum" data-toggle="tab">Laporan Laba Rugi YTD</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="umum">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dari" class="col-sm-3 control-label">Periode</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input name="tgl" type="text" style="width: 150%" class="form-control datepicker" id="tgl" value="{{$date}}">
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
