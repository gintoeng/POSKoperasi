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
        <li class="active">ubah</li>
        <li class="active">{!! $simpanan->nomor_simpanan !!}</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('simpanan/'.$simpanan->id.'/update') !!}" id="fsimp">
                        <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_simpanan" class="col-sm-3 control-label">Jenis Simpanan</label>
                                    <div class="col-sm-9">
                                        <select name="jenis_simpanan" style="width: 100%;" type="text" class="chosen" id="jenis_simpanan" data-placeholder="Jenis Simpanan">
                                            @foreach($pengaturan as $value)
                                                <option value="{!! $value->id !!}" {!! $simpanan['selected_no1'] !!}>{!! $value->jenis_simpanan !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_simpanan" class="col-sm-3 control-label">Nomor Simpanan</label>
                                    <div class="col-sm-9">
                                        <div class="input-group" id="nomor_tabungan">
                                            <input name="nomor_simpanan" type="text" class="form-control disabled" placeholder="Nomor Simpanan" value="{!! $simpanan->nomor_simpanan !!}" readonly>
                                            <span class="input-group-addon"><i class="ti-lock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kode_anggota" class="col-sm-3 control-label">Kode Anggota</label>
                                    <div class="col-sm-9">
                                        <select name="kode_anggota" style="width: 100%;" type="text" class="chosen" id="kode_anggota" data-placeholder="Pilih Anggota">
                                            @foreach($anggota as $value)
                                                <option value="{!! $value->id !!}" {!! $simpanan->anggota == $value->id ? 'selected' : '' !!}>{!! $value->kode !!} - {!! $value->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_anggota" class="col-sm-3 control-label">Nama Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama_anggota" placeholder="Nama" value="{!! $simpanan->anggotaid->nama !!}"readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_anggota" class="col-sm-3 control-label">Alamat Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="alamat_anggota" placeholder="Alamat" value="{!! $simpanan->anggotaid->provinsi !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="suku_bunga" class="col-sm-3 control-label">Suku Bunga</label>
                                    <div class="col-sm-9">
                                        <div class="spinner input-group" id="suku_bunga">
                                            <input name="suku_bunga" type="text" class="form-control input-sm spinner-input" id="suku-bunga" value="{!! $simpanan->suku_bunga !!}" placeholder="Suku Bunga" readonly>
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
                                        <input name="tanggal_pembuatan" value="{!! $simpanan["pemb"] !!}" type="text" class="form-control datepicker" id="tanggal_pembuatan" placeholder="Tanggal Pembuatan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sistem_bunga" class="col-sm-3 control-label">Sistem Bunga</label>
                                    <div class="col-sm-9" id="sistem_bunga">
                                        <input name="sistem_bunga" id="sistem_bunga" type="text" value="{!! $simpanan->pengaturanid->sbunga->sistem !!}" class="form-control disabled" placeholder="Sistem Bunga" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="setoran_bulanan" class="col-sm-3 control-label">Setoran Bulanan</label>
                                    <div class="col-sm-9">
                                        <input name="setoran_bulanan" type="text" class="form-control" id="setoran_bulanan" placeholder="Setoran Bulanan" style="text-align:right" value="{!! number_format($simpanan->setoran_bulanan, 2, '.', ',') !!}">
                                    </div>
                                </div>
                                <div class="form-group {{$simpanan->pengaturanid->wajibpokok != 0 ? 'hide' : ''}}" id="jwaktu">
                                    <label for="jangka_waktu" class="col-sm-3 control-label">Jangka Waktu</label>
                                    <div class="col-sm-9">
                                        <div class="spinner input-group">
                                            <input name="jangka_waktu" type="text" class="form-control input-sm spinner-input" id="jangka_waktu" value="{!! $simpanan->jangka_waktu !!}" placeholder="Suku Bunga">
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
                                        <?php
                                            if ($simpanan->status == "0") {
                                                $z = "selected";
                                                $b = "";
                                                $t = "";
                                            } else if ($simpanan->status == "1") {
                                                $z = "";
                                                $b = "selected";
                                                $t = "";
                                            } else {
                                                $z = "";
                                                $b = "";
                                                $t = "selected";
                                            }
                                        ?>
                                        <select name="status" class="form-control">
                                            <option value="0" {!! $z !!}>-</option>
                                            <option value="1" {!! $b !!}>Blokir</option>
                                            <option value="2" {!! $t !!}>Tutup</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_status" class="col-sm-3 control-label">Tanggal Status</label>
                                    <div class="col-sm-9">
                                        <input name="tanggal_status" type="text" class="form-control datepicker" id="tanggal_status" placeholder="Tanggal Status" value="{!! $simpanan["stat"] !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="saldo_blokir" class="col-sm-3 control-label">Saldo Blokir</label>
                                    <div class="col-sm-9">
                                        <input name="saldo_blokir" type="text" class="form-control" id="saldo_blokir" placeholder="Saldo Blokir" style="text-align:right" value="{!! number_format($simpanan->saldo_blokir, 2, '.', ',') !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input name="keterangan" type="text" class="form-control" id="keterangan" placeholder="Keterangan" value="{!! $simpanan->keterangan !!}">
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
                                        <input type="submit" onclick="FunctionLoading()" class="btn btn-primary btn-block" name="save" value="Save" id="btnsave">
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
