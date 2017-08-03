@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Simpanan</a>
        </li>
        <li><a href="{!! url('simpanan') !!}">Daftar Simpanan</a></li>
        <li class="active">Tambah</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    @if(session('msg'))
                        <div class="alert alert-{!! session('msgclass') !!}">
                            {!! session('msg') !!}
                        </div>
                    @endif
                    <br>
                    <form role="form" class="form-horizontal" method="post" action="{!! url('simpanan') !!}" id="fsimp">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_tabungan" class="col-sm-3 control-label">Jenis Simpanan</label>
                                    <div class="col-sm-9">
                                        <select name="jenis_simpanan" style="width: 100%;" type="text" class="chosen" id="jenis_simpanan" data-placeholder="Jenis Simpanan">
                                            <option value=""></option>
                                            @foreach($pengaturan as $value)
                                            <option value="{!! $value->id !!}">{!! $value->jenis_simpanan !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_simpanan" class="col-sm-3 control-label">Nomor Simpanan</label>
                                    <div class="col-sm-9">
                                        <div class="input-group" id="nomor_simpanan">
                                            <input name="nomor_simpanan" type="text" class="form-control disabled" placeholder="Nomor Simpanan" readonly>
                                            <span class="input-group-addon"><i class="ti-lock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kode_anggota" class="col-sm-3 control-label">Kode Anggota</label>
                                    <div class="col-sm-9">
                                        <select name="kode_anggota" style="width: 100%;" type="text" class="chosen" id="kode_anggota" data-placeholder="Pilih Anggota">
                                            <option value=""></option>
                                            @foreach($anggota as $value)
                                                <option value="{!! $value->id !!}">{!! $value->kode !!} - {!! $value->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_anggota" class="col-sm-3 control-label">Nama Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama_anggota" placeholder="Nama" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_anggota" class="col-sm-3 control-label">Alamat Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="alamat_anggota" placeholder="Provinsi" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="suku_bunga" class="col-sm-3 control-label">Suku Bunga</label>
                                    <div class="col-sm-9">
                                        <div class="spinner input-group" id="suku_bunga">
                                            <input name="suku_bunga" type="text" class="form-control input-sm spinner-input" id="suku-bunga" value="0" placeholder="Suku Bunga" readonly>
                                            <span class="input-group-addon">% PA</span>
                                            {{--<div class="spinner-buttons input-group-btn">--}}
                                                {{--<button type="button" class="btn btn-warning btn-sm spinner-down">--}}
                                                    {{--<i class="ti-minus"></i>--}}
                                                {{--</button>--}}
                                                {{--<button type="button" class="btn btn-success btn-sm spinner-up">--}}
                                                    {{--<i class="ti-plus"></i>--}}
                                                {{--</button>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_pembuatan" class="col-sm-3 control-label">Tanggal Pembuatan</label>
                                    <div class="col-sm-9">
                                        <input name="tanggal_pembuatan" value="{!! $today !!}" type="text" class="form-control datepicker" id="tanggal_pembuatan" placeholder="Tanggal Pembuatan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sistem_bunga" class="col-sm-3 control-label">Sistem Bunga</label>
                                    <div class="col-sm-9" id="sistem_bunga">
                                        <input name="sistem_bunga" id="sistem_bunga" type="text" class="form-control disabled" placeholder="Sistem Bunga" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="setoran_bulanan" class="col-sm-3 control-label">Setoran Bulanan</label>
                                    <div class="col-sm-9">
                                        <input name="setoran_bulanan" type="text" class="form-control" id="setoran_bulanan" value="0.00" placeholder="0.00" style="text-align:right">
                                    </div>
                                </div>
                                <div class="form-group" id="jwaktu">
                                    <label for="jangka_waktu" class="col-sm-3 control-label">Jangka Waktu</label>
                                    <div class="col-sm-9">
                                        <div class="spinner input-group">
                                            <input name="jangka_waktu" type="text" class="form-control input-sm spinner-input" id="jangka_waktu" value="0" placeholder="Suku Bunga">
                                            <span class="input-group-addon">Bulan</span>
                                            <div class="spinner-buttons input-group-btn">
                                                <button type="button" class="btn btn-warning btn-sm spinner-down">
                                                    <i class="ti-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm spinner-up">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control">
                                            <option value="0">-</option>
                                            <option value="1">Blokir</option>
                                            <option value="2">Tutup</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_status" class="col-sm-3 control-label">Tanggal Status</label>
                                    <div class="col-sm-9">
                                        <input name="tanggal_status" value="{!! $today !!}" type="text" class="form-control datepicker" id="tanggal_status" placeholder="Tanggal Status">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="saldo_blokir" class="col-sm-3 control-label">Saldo Blokir</label>
                                    <div class="col-sm-9">
                                        <input name="saldo_blokir" type="text" class="form-control" id="saldo_blokir" value="0.00" placeholder="0.00" style="text-align:right">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input name="keterangan" type="text" class="form-control" id="keterangan" placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="tanggal_lahir" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <input type="button" class="btn btn-primary btn-block" name="save" value="Save" id="btnsave">
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('simpanan') !!}" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    @include('simpanan.simpanan_js')
@stop
