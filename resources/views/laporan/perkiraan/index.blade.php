@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="">Perkiraan</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="get" action="{!! url('laporan/perkiraan/cetak') !!}" target="_blank" id="flapper">
                        <input type="hidden" name="print" id="print" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="urut" class="col-sm-3 control-label">Kelompok Akun</label>
                                    <div class="col-sm-9">
                                        <select name="kelompok" class="form-control" id="kelompok" style="width: 100%">
                                            <option value="all">Semua</option>
                                            @foreach($kelompok as $kel)
                                                <option value="{{$kel->id}}">{{$kel->nama_akun}}</option>
                                            @endforeach()
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group icheck">
                                    <label for="urut" class="col-sm-3 control-label">Urut Berdasarkan</label>
                                    <div class="col-sm-5">
                                        <select name="urut" class="form-control" id="urut" style="width: 100%">
                                            <option value="kode_akun">Kode Akun</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="radio" id="minimal-checkbox-1" name="urutan" value="ASC" checked>
                                        <label for="minimal-checkbox-1"> ASC</label>&nbsp;&nbsp;
                                        <input type="radio" id="minimal-checkbox-2" name="urutan" value="DESC">
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
                                    <a href="{!! url('laporan/perkiraan') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
        $("#kelompok").removeAttr('class');
        $("#kelompok").select2();
        $("#urut").removeAttr('class');
        $("#urut").select2();

        $('#btnpre').on('click', function(){
            $('#print').val("preview");
            $('#flapper').submit();
        });
        $('#btnctk').on('click', function(){
            $('#print').val("cetak");
            $('#flapper').submit();
        });
    </script>
@stop
