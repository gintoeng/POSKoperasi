@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Tabungan</a>
        </li>
        <li><a href="{!! url('simpanan/transaksi') !!}">Daftar Transaksi</a></li>
        <li class="active">Lihat</li>
        <li class="active">{!! $transaksi->kode !!}</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('simpanan/transaksi') !!}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaksi" class="col-sm-3 control-label">Transaksi</label>
                                    <div class="col-sm-9">
                                        <select name="tipe" type="text" class="form-control" id="transaksi" placeholder="Transaksi" style="width: 100%;" disabled>
                                            <option value="SETOR" {!! $transaksi->tipe == "SETOR" ? 'selected' : '' !!}>Setoran</option>
                                            <option value="TARIK" {!! $transaksi->tipe == "TARIK" ? 'selected' : '' !!}>Penarikan</option>
                                            <option value="TRANSFER" {!! $transaksi->tipe == "TRANSFER" ? 'selected' : '' !!}>Transfer/Pindah Buku</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_simpanan" class="col-sm-3 control-label">Nomor Simpanan</label>
                                    <div class="col-sm-9">
                                        <select name="nomor_simpanan" style="width: 100%;" type="text" class="chosen" id="nomor_simpanan" data-placeholder="Pilih Nomor Simpanan" required disabled>
                                            @foreach($simpanan as $value)
                                                <option value="{!! $value->id !!}" {!! $transaksi->id_dari == $value->id ? 'selected' : '' !!}>{!! $value->nomor_simpanan !!} - {!! $value->anggotaid->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_simpanan" class="col-sm-3 control-label">Jenis Simpanan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="jenis_simpanan" placeholder="Jenis Simpanan" value="{!! $transaksi->dariid->pengaturanid->jenis_simpanan !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="npk" class="col-sm-3 control-label">NPK</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="npk" placeholder="NPK" value="{!! $transaksi->simpananid->anggotaid->npk !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kode_anggota" class="col-sm-3 control-label">Kode Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="kode_anggota" placeholder="Kode Anggota" value="{!! $transaksi->simpananid->anggotaid->kode !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_anggota" class="col-sm-3 control-label">Nama Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama_anggota" placeholder="Nama Anggota" value="{!! $transaksi->dariid->anggotaid->nama !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_anggota" class="col-sm-3 control-label">Alamat Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="alamat_anggota" placeholder="Alamat Anggota" value="{!! $transaksi->dariid->anggotaid->provinsi !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="setoran-bulanan" class="col-sm-3 control-label">Setoran Bulanan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="setoran-bulanan" placeholder="Setoran Bulanan" value="{!! number_format($transaksi->simpananid->setoran_bulanan, 2, ',', '.') !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="saldo" class="col-sm-3 control-label">Saldo</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="saldo" placeholder="Saldo" value="{!! number_format($transaksi->saldo_akhir, 2, ',', '.') !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nominal" class="col-sm-3 control-label">Nominal</label>
                                    <div class="col-sm-9">
                                        <input name="nominal" type="text" class="form-control" id="nominal" placeholder="Nominal" value="{!! number_format($transaksi->nominal, 2, ',', '.') !!}" disabled>
                                        <input type="hidden" name="akun_kas" id="akun_kas">
                                        <input type="hidden" name="akun_setoran" id="akun_setoran">
                                        <input type="hidden" name="akun_penarikan" id="akun_penarikan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ket" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="ket" name="keterangan" placeholder="Keterangan" value="{!! $transaksi->keterangan !!}" readonly>
                                    </div>
                                </div>
                            </div>
                            @if($transaksi->id_tujuan != null)
                            <div class="col-md-6 {!! $transaksi->id_tujuan == null ? 'hide' : '' !!}" id="transfer">
                                <div class="form-group">
                                    <h3 class="col-sm-4 mb0">Tujuan Transfer</h3>

                                </div>
                                <div class="form-group">
                                    <label for="nomor_simpanan_to" class="col-sm-3 control-label">Nomor Simpanan</label>
                                    <div class="col-sm-9">
                                        <select name="nomor_simpanan_to" style="width: 100%;" type="text" class="form-control" id="nomor_simpanan_to" data-placeholder="Pilih Nomor Simpanan" required disabled>
                                            <option value=""></option>
                                            @foreach($simpanan as $value)
                                                <option value="{!! $value->id !!}" {!! $transaksi->id_tujuan == $value->id ? 'selected' : '' !!}>{!! $value->nomor_simpanan !!} - {!! $value->anggotaid->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_simpanan_to" class="col-sm-3 control-label">Jenis Simpanan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="jenis_simpanan_to" placeholder="Jenis Simpanan" value="{!! $transaksi->tujuanid->pengaturanid->jenis_simpanan !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="npk_to" class="col-sm-3 control-label">NPK</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="npk_to" placeholder="NPK" value="{!! $transaksi->tujuanid->anggotaid->npk !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kode_anggota_to" class="col-sm-3 control-label">Kode Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="kode_anggota_to" placeholder="Kode Anggota" value="{!! $transaksi->tujuanid->anggotaid->kode !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_anggota_to" class="col-sm-3 control-label">Nama Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama_anggota_to" placeholder="Nama Anggota" value="{!! $transaksi->tujuanid->anggotaid->nama !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_anggota_to" class="col-sm-3 control-label">Alamat Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="alamat_anggota_to" placeholder="Alamat Anggota" value="{!! $transaksi->tujuanid->anggotaid->provinsi !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="setoran-bulanan_to" class="col-sm-3 control-label">Setoran Bulanan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="setoran-bulanan_to" placeholder="Setoran Bulanan" value="{!! number_format($transaksi->tujuanid->setoran_bulanan, 2, ',', '.') !!}" readonly>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="save" class="col-sm-3 control-label"></label>
                                    {{--<div class="col-sm-2">--}}
                                        {{--<input type="submit" class="btn btn-primary btn-block" name="save" value="Save">--}}
                                    {{--</div>--}}
                                    <div class="col-sm-2">
                                        <a href="{!! url('simpanan/transaksi') !!}" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script>
        $("#transaksi").removeAttr('class');
        $("#transaksi").select2();

        $("#nomor_simpanan").removeAttr('class');
        $("#nomor_simpanan").select2();
        $("#nomor_simpanan_to").removeAttr('class');
        $("#nomor_simpanan_to").select2();
        $("#transaksi").change(function  () {
            if($(this).val() == "TRANSFER"){
                $("#transfer").removeClass('hide');
                $("#transfer").show();
            }else{
                $("#transfer").hide();
            }
        });
    </script>

@stop
