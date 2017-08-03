@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pinjaman</a>
        </li>
        <li><a href="{!! url('pinjaman') !!}">Daftar Pinjaman</a></li>
        <li class="active">Ubah</li>
        <li class="active">{!! $pinjaman->nomor_pinjaman !!}</li>
    </ol>
    <div class="row">
        @if(session('alert'))
            <br/><br/>
            {!! session('alert') !!}
        @endif
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('pinjaman/'.$pinjaman->id.'/update') !!}" enctype="multipart/form-data" id="fpinj">
                        <input type="hidden" name="status_realisasi" value="{!! $pinjaman->status_realisasi !!}">
                        <input type="hidden" name="status_lunas" value="{!! $pinjaman->status_lunas !!}">
                        <input type="hidden" name="pstat" id="pstat">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#umum" data-toggle="tab">Data Pinjaman</a>
                                </li>
                                <li><a href="#penjamin" data-toggle="tab">Data Keluarga & Penjamin</a>
                                </li>
                                <li><a href="#jaminan" data-toggle="tab">Data Agunan / Jaminan</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="umum">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_pinjaman" class="col-sm-3 control-label">Nama Pinjaman</label>
                                                <div class="col-sm-9">
                                                    <select name="nama_pinjaman" type="text" style="width: 100%;" class="chosen" id="nama_pinjaman" data-placeholder="Pilih Nama Pinjaman">
                                                        @foreach($pengaturan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pinjaman->nama_pinjaman == $value->id ? 'selected' : '' !!}>{!! $value->nama_pinjaman !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nomor_pinjaman" class="col-sm-3 control-label">Nomor pinjaman</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group" id="nomor_pinjaman">
                                                        <input name="nomor_pinjaman" type="text" class="form-control disabled" placeholder="Nomor Pinjaman" id="no_pinjaman" value="{!! $pinjaman->nomor_pinjaman !!}" readonly>
                                                        <span class="input-group-addon"><i class="ti-lock"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode_anggota" class="col-sm-3 control-label">Kode Anggota</label>
                                                <div class="col-sm-9">
                                                    <select name="kode_anggota" style="width: 100%;" type="text" class="chosen" id="kode_anggota" data-placeholder="Pilih Anggota">
                                                        @foreach($anggota as $value)
                                                            <option value="{!! $value->id !!}" {!! $pinjaman->anggota == $value->id ? 'selected' : ''!!}>{!! $value->kode !!} - {!! $value->nama !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_anggota" class="col-sm-3 control-label">Nama Anggota</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="nama_anggota" placeholder="Nama" value="{!! $pinjaman->anggotaid->nama !!}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat_anggota" class="col-sm-3 control-label">Alamat Anggota</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="alamat_anggota" placeholder="Provinsi" value="{!! $pinjaman->anggotaid->provinsi !!}" readonly>
                                                </div>
                                            </div>
                                            <?php
                                            $tanggal_pengajuan = Carbon::createFromFormat('Y-m-d',$pinjaman->tanggal_pengajuan)->format('m/d/Y');
                                            ?>
                                            <div class="form-group">
                                                <label for="tanggal_pengajuan" class="col-sm-3 control-label">Tanggal Pengajuan</label>
                                                <div class="col-sm-9">
                                                    <input name="tanggal_pengajuan" value="{{ $tanggal_pengajuan }}" type="text" class="form-control datepicker" id="tanggal_pengajuan" placeholder="Tanggal Pengajuan">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="jangka_waktu" class="col-sm-3 control-label">Jangka Waktu</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group" id="nomor_kredit">
                                                        <input name="jangka_waktu" onchange="minmax()" value="{{ $pinjaman->jangka_waktu }}" type="text" class="form-control input-sm spinner-input" id="jangka_waktu" placeholder="Jangka Waktu">
                                                        <span id="adtw" class="input-group-addon">Bulan</span>
                                                        <div class="spinner-buttons input-group-btn">
                                                            <button onclick="minmax()" type="button" class="btn btn-warning btn-sm spinner-down">
                                                                <i class="ti-minus"></i>
                                                            </button>
                                                            <button onclick="minmax()" type="button" class="btn btn-success btn-sm spinner-up">
                                                                <i class="ti-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="jumlah_pengajuan" class="col-sm-3 control-label">Jumlah Pengajuan Rp.</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group" id="jumlah_pengajuan">
                                                        <input name="jumlah_pengajuan" type="text" class="form-control" id="jumlah-pengajuan" value="{!! number_format($pinjaman->jumlah_pengajuan, 2, '.', ',') !!}" style="text-align:right">
                                                        <span class="input-group-addon">,-</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="jumlah_angsuran_pokok" class="col-sm-3 control-label">Jumlah Angsuran Pokok</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group" id="jumlah_angsuran_pokok">
                                                        <input name="jumlah_angsuran_pokok" type="text" class="form-control" id="jumlah-angsuran-pokok" value="{!! number_format($pinjaman->jumlah_angsuran_pokok, 2, '.', ',') !!}" style="text-align:right">
                                                        <span class="input-group-addon">&nbsp;</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sistem_bunga" class="col-sm-3 control-label">Sistem Bunga</label>
                                                <div class="col-sm-9" id="sistem_bunga">
                                                    <input type="hidden" id="simbid" value="{!! $pinjaman->pengaturanid->sistem_bunga !!}">
                                                    <input type="hidden" id="simb" value="{!! $pinjaman->pengaturanid->sbunga->sistem !!}">
                                                    <input name="sistem_bunga" id="sistem_bunga" type="text" value="{!! $pinjaman->pengaturanid->sbunga->sistem !!}" class="form-control disabled" placeholder="Sistem Bunga" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="suku_bunga" class="col-sm-3 control-label">Suku Bunga</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group" id="suku_bunga">
                                                        <input name="suku_bunga" type="text" class="form-control input-sm spinner-input" id="suku-bunga" placeholder="Suku Bunga" value="{!! $pinjaman->suku_bunga !!}" readonly>
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
                                            <!--<div class="form-group">
                                                <label for="sistem_bunga" class="col-sm-3 control-label">Sistem Bunga</label>
                                                <div class="col-sm-9">
                                                    <input name="sistem_bunga" type="text" class="form-control" id="sistem_bunga" placeholder="Sistem Bunga">
                                                </div>
                                            </div>-->
                                            <?php
                                            $jatuh_tempo = Carbon::createFromFormat('Y-m-d',$pinjaman->jatuh_tempo)->format('m/d/Y');
                                            ?>
                                            <div class="form-group">
                                                <label for="jatuh-tempo" class="col-sm-3 control-label">Jatuh Tempo</label>
                                                <div class="col-sm-9">
                                                    <input name="jatuh_tempo" type="text" class="form-control datepicker" id="jatuh-tempo" placeholder="Jatuh Tempo" value="{{ $jatuh_tempo }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="perhitungan_bunga" class="col-sm-3 control-label">Perhitungan Bunga</label>
                                                <div class="col-sm-9">
                                                    <?php
                                                        if ($pinjaman->perhitungan_bunga == "bulanan") {
                                                            $hr = "";
                                                            $bln = "selected";
                                                        } else {
                                                            $hr = "selected";
                                                            $bln = "";
                                                        }
                                                    ?>
                                                    <select name="perhitungan_bunga" class="form-control" id="perhitungan_bunga" placeholder="Perhitungan Bunga">
                                                        <option value="bulanan" {!! $bln !!}>Bulanan</option>
                                                        <option value="harian" {!! $hr !!}>Harian</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="digunakan_untuk" class="col-sm-3 control-label">Digunakan Untuk</label>
                                                <div class="col-sm-9">
                                                    <input name="digunakan_untuk" type="text" class="form-control" id="keterangan" placeholder="Digunakan Untuk" value="{!! $pinjaman->digunakan_untuk !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sumber_dana" class="col-sm-3 control-label">Sumber Dana</label>
                                                <div class="col-sm-9">
                                                    <input name="sumber_dana" type="text" class="form-control" id="sumber_dana" placeholder="Sumber Dana" value="{!! $pinjaman->sumber_dana !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
                                                <div class="col-sm-9">
                                                    <input name="keterangan" type="text" class="form-control" id="keterangan" placeholder="Keterangan" value="{!! $pinjaman->keterangan !!}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="penjamin">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status_pasangan" class="col-sm-3 control-label">Status Pasangan</label>
                                                <div class="col-sm-9">
                                                    <?php
                                                        if ($pinjaman->status_pasangan == "Suami") {
                                                            $s = "selected";
                                                            $i = "";
                                                        } else {
                                                            $s = "";
                                                            $i = "selected";
                                                        }
                                                    ?>
                                                    <select name="status_pasangan" type="text" class="form-control" id="status_pasangan" placeholder="Status Pasangan" style="width: 100%;">
                                                        <OPTION VALUE="Suami" {!! $s !!}>Suami</OPTION>
                                                        <OPTION VALUE="Istri" {!! $i !!}>Istri</OPTION>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_pasangan" class="col-sm-3 control-label">Nama Pasangan</label>
                                                <div class="col-sm-9">
                                                    <input name="nama_pasangan" type="text" class="form-control" id="nama_pasangan" placeholder="Nama Pasangan" value="{!! $pinjaman->nama_pasangan !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pekerjaan_pasangan" class="col-sm-3 control-label">Pekerjaan Pasangan</label>
                                                <div class="col-sm-9">
                                                    <input name="pekerjaan_pasangan" type="text" class="form-control" id="pekerjaan_pasangan" placeholder="Pekerjaan Pasangan" value="{!! $pinjaman->pekerjaan_pasangan !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat_pasangan" class="col-sm-3 control-label">Alamat Pasangan</label>
                                                <div class="col-sm-9">
                                                    <textarea name="alamat_pasangan" type="text" class="form-control" id="alamat_pasangan" placeholder="Alamat Pasangan">{!! $pinjaman->alamat_pasangan !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nomor_telepon_pasangan" class="col-sm-3 control-label">Nomor Telepon Pasangan</label>
                                                <div class="col-sm-9">
                                                    <input name="nomor_telepon_pasangan" type="text" class="form-control" id="nomor_telepon_pasangan" placeholder="Nomor Telepon Pasangan" value="{!! $pinjaman->nomor_telepon_pasangan !!}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_penjamin" class="col-sm-3 control-label">Nama Penjamin</label>
                                                <div class="col-sm-9">
                                                    <input name="nama_penjamin" type="text" class="form-control" id="nama_penjamin" placeholder="Nama Penjamin" value="{!! $pinjaman->nama_penjamin !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pekerjaan_penjamin" class="col-sm-3 control-label">Pekerajaan Penjamin</label>
                                                <div class="col-sm-9">
                                                    <input name="pekerjaan_penjamin" type="text" class="form-control" id="pekerjaan_penjamin" placeholder="Pekerjaan Penjamin" value="{!! $pinjaman->pekerjaan_penjamin !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat_penjamin" class="col-sm-3 control-label">Alamat Penjamin</label>
                                                <div class="col-sm-9">
                                                    <textarea name="alamat_penjamin" type="text" class="form-control" id="alamat_penjamin" placeholder="Alamat Penjamin">{!! $pinjaman->alamat_penjamin !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nomor_telepon_penjamin" class="col-sm-3 control-label">Nomor Telepon Penjamin</label>
                                                <div class="col-sm-9">
                                                    <input name="nomor_telepon_penjamin" type="text" class="form-control" id="nomor_telepon_penjamin" placeholder="Nomor Telepon Penjamin" value="{!! $pinjaman->nomor_telepon_penjamin !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nomor_ktp_penjamin" class="col-sm-3 control-label">Nomor KTP Penjamin</label>
                                                <div class="col-sm-9">
                                                    <input name="nomor_ktp_penjamin" type="text" class="form-control" id="nomor_ktp_penjamin" placeholder="Nomor KTP Penjamin" value="{!! $pinjaman->nomor_ktp_penjamin !!}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </form>
                                <div class="tab-pane fade" id="jaminan">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <section class="panel" id="ptabel">
                                                <!-- <header class="panel-heading">Test Panel</header>-->
                                                <div class="panel-body">
                                                    <div class="pull-left">
                                                        <a class="btn btn-primary mb15" id="tambah"><i class="ti ti-plus"></i> Tambah</a>
                                                    </div>
                                                    @if(session('msg'))
                                                        <br/><br/>
                                                        <div class="alert alert-{!! session('msgclass') !!}">
                                                            {!! session('msg') !!}
                                                        </div>
                                                    @endif
                                                    <div class="table-responsive no-border">
                                                        <table class="table table-bordered table-striped mg-t editable-datatable" id="table">
                                                            <thead>
                                                            <tr class="bg-color">
                                                                <th class="text-center" width="20">No</th>
                                                                <th class="text-center">Jenis Agunan</th>
                                                                <th class="text-center">Ikatan Hukum</th>
                                                                <th class="text-center">Pemilik</th>
                                                                <th class="text-center">Alamat</th>
                                                                <th class="text-center">Keterangan</th>
                                                                <th class="text-center">Option</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $i = 1;?>
                                                            @foreach($pinjaman->jaminanid as $value)
                                                                <tr>
                                                                    <td class="text-center">{!! $i++ !!}</td>
                                                                    <td>{!! $value->jenisid->jenis !!}</td>
                                                                    <td>{!! $value->ikatan_hukum !!}</td>
                                                                    <td>{!! $value->nama_pemilik !!}</td>
                                                                    <td>{!! $value->alamat_pemilik !!}</td>
                                                                    <td>{!! $value->keterangan !!}</td>
                                                                    <td align="center" class="fa-hover">
                                                                        <a href="javascript:void(0)" onclick="isedit({!! $value->id !!})" data-toggle="tooltip" data-placement="left" title="Ubah"><i class="ti-pencil mr5" style="color: blue; font-size: medium"></i></a>
                                                                        <a href="javascript:void(0)" onclick="isdelete({!! $value->id !!})" data-toggle="tooltip" data-placement="right" title="Hapus"><i class="ti-trash mr5" style="color: red; font-size: medium"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </section>
                                            @include('pinjaman.jaminan_pinjaman')
                                            <input type="hidden" id="idpin" name="idpin" value="{!! $pinjaman->id !!}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="col-sm-2">
                                    <input type="hidden" id="inibtn" value="ubah">
                                    <input id="btnsa" type="button" class="btn btn-primary btn-block" name="save" value="Save">
                                </div>
                                <div class="col-sm-2">
                                    <a href="javascript:void(0)" id="btnsimulasi" class="btn btn-success btn-block">Simulasi</a>
                                </div>
                                <div class="col-sm-2">
                                    <a href="{!! url('pinjaman') !!}" class="btn btn-danger btn-block">Cancel</a>
                                </div>
                            </div>
                        </div>
                </div>
            </section>
        </div>
    </div>

    @include('pinjaman.simulasi.simulasi_pinjaman')
    @include('pinjaman.pinjaman_js')

@stop
