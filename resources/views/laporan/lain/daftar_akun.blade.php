@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Laporan</a>
        </li>
        <li class="active"><a href="">Daftar Akun Perkiraan</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('laporan/lain/daftar/akun/cetak') !!}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#umum" data-toggle="tab">Laporan Daftar Akun Perkiraan</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="umum">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kelompok_akun" class="col-sm-3 control-label">Kelompok Akun</label>
                                                <div class="col-sm-9">
                                                    <select name="kelompok_akun" class="form-control" id="kelompok_akun">
                                                        <option value=""></option>
                                                        <option value="1">1. AKTIVA</option>
                                                        <option value="2">2. PASIVA</option>
                                                        <option value="3">3. CADANGAN</option>
                                                        <option value="4">4. PENDAPATAN</option>
                                                        <option value="5">5. HPP</option>
                                                        <option value="6">6. BIAYA</option>
                                                        <option value="7">7. PENDAPATAN LAIN</option>
                                                        <option value="8">8. BIAYA LAIN</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="urut" class="col-sm-3 control-label">Urut Berdasarkan</label>
                                                <div class="col-sm-9">
                                                    <select name="urut" class="form-control" id="urut">
                                                        <option value="kode">Kode Akun</option>
                                                        <option value="nama">Nama Akun</option>
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
                                    <button type="submit" target="_blank" class="btn btn-sm btn-warning mb15">&nbsp;<i class="ti-printer mr5"></i>Cetak &nbsp;</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <a href="{url}/laporan/master/nasabah" class="btn btn-sm btn-danger mb15">Cancel</a>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <script src="plugins/icheck/icheck.js"></script>

@stop