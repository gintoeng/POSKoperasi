@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pinjaman</a>
        </li>
        <li class="active"><a href="{!! url('pinjaman/pengaturan') !!}">Pengaturan Pinjaman</a></li>
        <li class="active">Ubah</li>
        <li class="active">{!! $pengaturan->kode !!}</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('pinjaman/pengaturan/'.$pengaturan->id.'/update') !!}" id="fppin" enctype="multipart/form-data">
                        <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">
                        <div class="box-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#umum" data-toggle="tab">Umum</a>
                                </li>
                                <li><a href="#akuntansi" data-toggle="tab">Akuntansi</a>
                                </li>
                                <li><a href="#nomor" data-toggle="tab">Nomor</a>
                                </li>
                                <li><a href="#approve" data-toggle="tab">Hak Akses Approve</a>
                                </li>
                                <li><a href="#akses" data-toggle="tab">Hak Akses Tutup</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="umum">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Kode</label>
                                                <div class="col-sm-9">
                                                    <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode" value="{!! $pengaturan->kode !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tipepinjaman" class="col-sm-3 control-label">Tipe Pinjaman</label>
                                                <div class="col-sm-9">
                                                    <select name="tipe_pinjaman" style="width:100%;" id="tipepinjaman" data-placeholder="Pilih Tipe Pinjaman"  class="form-control" required>
                                                        {{--<option value=""></option>--}}
                                                        <option value="uang" {{$pengaturan->tipe_pinjaman == "uang" ? 'selected' : ''}}>Uang</option>
                                                        <option value="barang" {{$pengaturan->tipe_pinjaman == "barang" ? 'selected' : ''}}>Non Uang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama-pinjaman" class="col-sm-3 control-label">Nama Pinjaman</label>
                                                <div class="col-sm-9">
                                                    <input name="nama_pinjaman" type="text" class="form-control" id="nama-pinjaman" placeholder="Nama Pinjaman" value="{!! $pengaturan->nama_pinjaman !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="suku-bunga" class="col-sm-3 control-label">Suku Bunga</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="suku_bunga" type="text" class="form-control input-sm spinner-input" id="suku-bunga" placeholder="Suku Bunga" value="{!! $pengaturan->suku_bunga !!}">
                                                        <span class="input-group-addon">% PA</span>
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
                                                <label for="sitem-bunga" class="col-sm-3 control-label">Sistem Bunga</label>
                                                <div class="col-sm-9">
                                                    <select name="sistem_bunga" style="width:100%;" id="sistem-bunga" data-placeholder="Pilih Sistem Bunga" class="form-control" required>
                                                        @foreach($sistem as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->sistem_bunga == $value->id ? 'selected' : '' !!}>{!! $value->sistem !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="foto" class="col-sm-3 control-label">Gambar</label>
                                                <div class="col-sm-3">
                                                    @if($pengaturan->gambar == "")
                                                        <img id="imgfoto" src="{{asset('assets/img/avatar.jpg')}}" alt="your image" width="100" />
                                                    @else
                                                        <img id="imgfoto" src="{{asset('foto/pinjaman/'.$pengaturan->gambar)}}" alt="your image" width="100" />
                                                    @endif
                                                    <input name="foto" type="file" id="foto" placeholder="Foto">
                                                    <input type="hidden" name="gambar" value="{!! $pengaturan->gambar !!}">
                                                </div>
                                                <label for="foto2" class="col-sm-2 control-label">Gambar2</label>
                                                <div class="col-sm-3">
                                                    @if($pengaturan->gambar2 == "")
                                                        <img id="imgfoto2" src="{{asset('assets/img/avatar.jpg')}}" alt="your image" width="100" />
                                                    @else
                                                        <img id="imgfoto2" src="{{asset('foto/pinjaman/'.$pengaturan->gambar2)}}" alt="your image" width="100" />
                                                    @endif
                                                    <input name="foto2" type="file" id="foto2" placeholder="Foto">
                                                    <input type="hidden" name="gambar2" value="{!! $pengaturan->gambar2 !!}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shu" class="col-sm-3 control-label">SHU</label>
                                                <div class="col-sm-9">
                                                    <select name="shu" style="width:100%;" id="shu" data-placeholder="Pilih SHU"  class="form-control" required>
                                                        <option value=""></option>
                                                        @foreach($shu as $value)
                                                            <option value="{!! $value->id !!}" {{$pengaturan->id_shu == $value->id ? 'selected' : ''}}>{!! $value->nama !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="maksimum_waktu" class="col-sm-3 control-label">Maksimum Waktu</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input type="text" class="form-control input-sm spinner-input" name="maksimum_waktu" placeholder="Maksimum Waktu" value="{!! $pengaturan->maksimum_waktu !!}"/>
                                                        <span class="input-group-addon">Bulan</span>
                                                        <div class="spinner-buttons input-group-btn">
                                                            <button type="button" class="btn btn-warning btn-sm spinner-down">
                                                                <i class="ti-minus"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-success btn-sm spinner-up">
                                                                <i class="ti-plus"></i>
                                                            </button>
                                                        </div>
                                                        {{--<select name="tipe_maksimum_waktu" class="input-sm form-control">--}}
                                                            {{--<option value="hari" {!! $pengaturan->tipe_maksimum_waktu == "hari" ? 'selected' : '' !!}>Hari</option>--}}
                                                            {{--<option value="bulan" {!! $pengaturan->tipe_maksimum_waktu == "bulan" ? 'selected' : '' !!}>Bulan</option>--}}
                                                        {{--</select>--}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="denda-perhari" class="col-sm-3 control-label">Denda Perhari</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <select name="tipe_denda_perhari" class="input-sm form-control" placeholder="Denda Perhari" id="tipe-denda-perhari">
                                                            <option value="denda_nominal" {!! $pengaturan->tipe_denda_perhari == "denda_nominal" ? 'selected' : '' !!}>Denda Nominal</option>
                                                            <option value="saldo_X_persen%_X_hari" {!! $pengaturan->tipe_denda_perhari == "saldo_X_persen%_X_hari" ? 'selected' : '' !!}>Saldo X Persen% X Hari</option>
                                                            <option value="angsuran_X_persen%_X_hari" {!! $pengaturan->tipe_denda_perhari == "angsuran_X_persen%_X_hari" ? 'selected' : '' !!}>Angsuran X Persen% X Hari</option>
                                                        </select>
                                                        <span id="spn1" class="input-group-addon">Nominal</span>
                                                        <input type="text" class="input-sm form-control" id="jml-denda" name="jumlah_denda_perhari" value="{!! number_format($pengaturan->jumlah_denda_perhari, 2, '.', ',') !!}" style="text-align: right;"/>
                                                        <span id="spn2" class="input-group-addon">;-</span>

                                                        <span id="spn3" class="input-group-addon hide">Persen</span>
                                                        <input type="text" class="form-control input-sm spinner-input hide" id="per-denda" name="persen_denda_perhari" value="{!! $pengaturan->persen_denda_perhari !!}" style="text-align: right;"/>
                                                        <span id="spn4" class="input-group-addon hide">%</span>
                                                        <div class="spinner-buttons input-group-btn hide" id="spn5">
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
                                                <label for="toleransi_denda" class="col-sm-3 control-label">Toleransi Denda</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="toleransi_denda" type="text" class="form-control input-sm spinner-input" id="toleransi_denda" placeholder="Toleransi Denda" value="{!! $pengaturan->toleransi_denda !!}">
                                                        <span class="input-group-addon">Hari</span>
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
                                                <label for="adminbank" class="col-sm-3 control-label">Biaya Admin Bank</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="input-sm form-control" id="adminbank" name="admin_bank" value="{!! number_format($pengaturan->biaya_admin_bank, 2, '.', ',') !!}" placeholder="0.00" style="text-align: right;"/>
                                                        <span class="input-group-addon">;-</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="adminfee" class="col-sm-3 control-label">Biaya Admin Fee</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="admin_fee" type="text" class="form-control input-sm spinner-input" id="adminfee" value="{!! $pengaturan->biaya_admin_fee !!}" placeholder="Admin Fee">
                                                        <span class="input-group-addon">%</span>
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
                                            <div class="form-group {{$pengaturan->biaya_admin_tambahan == "uang" ? 'hide' : ''}}" id="admtam">
                                                <label for="admintambahan" class="col-sm-3 control-label">Biaya Admin Tambahan</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="admin_tambahan" type="text" class="form-control input-sm spinner-input" id="admintambahan" value="{!! $pengaturan->biaya_admin_tambahan !!}" placeholder="Admin Tambahan">
                                                        <span class="input-group-addon">%</span>
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
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="akuntansi">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="akun-kas-bank" class="col-sm-3 control-label">Akun Kas</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_kas_bank" type="text" style="width: 100%;" class="form-control" id="akun-kas-bank">
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_kas_bank == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-realisasi" class="col-sm-3 control-label">Akun Realisasi</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_realisasi" type="text" style="width: 100%;" class="form-control" id="akun-realisasi">
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_realisasi == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Angsuran</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_angsuran" type="text" style="width: 100%;" class="form-control" id="akun-angsuran">
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_angsuran == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Administrasi</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_administrasi" type="text" style="width: 100%;" class="form-control" id="akun-administrasi">
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_administrasi == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Administrasi Bank</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_administrasi_bank" type="text" style="width: 100%;" class="form-control" id="akun-administrasi-bank" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_administrasi_bank == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Administrasi Tambahan</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_administrasi_tambahan" type="text" style="width: 100%;" class="form-control" id="akun-administrasi-tambahan" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_administrasi_tambahan == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="akun-piutang-pinjaman" class="col-sm-3 control-label">Akun Piutang Pinjaman</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_piutang_pinjaman" type="text" style="width: 100%;" class="form-control" id="akun-piutang-pinjaman" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_piutang_pinjaman == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Pendapatan Bunga</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_bunga" type="text" style="width: 100%;" class="form-control" id="akun-bunga">
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_bunga == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Denda</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_denda" type="text" style="width: 100%;" class="form-control" id="akun-denda">
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_denda == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Biaya Provisi</label>
                                                <div class="col-sm-9">
                                                    <select name="biaya_provinsi" type="text" style="width: 100%;" class="form-control" id="biaya-provinsi">
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->biaya_provinsi == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Lain - Lain</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_lain_lain" type="text" style="width: 100%;" class="form-control" id="akun-lain-lain">
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_lain_lain == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Tampungan Pinjaman</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_tampungan_pinjaman" type="text" style="width: 100%;" class="form-control" id="akun-tampungan-pinjaman" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_tampungan_pinjaman == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Piutang Tak Tertagih</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_piutang_tak_tertagih" type="text" style="width: 100%;" class="form-control" id="akun-piutang-tak-tertagih" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_piutang_tak_tertagih == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nomor">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="akun-kas-bank" class="col-sm-3 control-label">Kode Awal Rekening</label>
                                                <div class="col-sm-9">
                                                    <input name="kode_awal_rekening" type="text" class="form-control" id="kode_awal_rek" placeholder="Kode Awal Rekening" value="{!! $pengaturan->kode_awal_rekening !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Jumlah Digit Rekening</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="jumlah_digit_rekening" type="text" class="form-control input-sm spinner-input" id="jml-digit-rekening" placeholder="Jumlah Digit Rekening" value="{!! $pengaturan->jumlah_digit_rekening !!}">
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
                                                <label for="kode" class="col-sm-3 control-label">Nomor Akhir Rekening</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="nomor_akhir_rekening" type="text" class="form-control" id="nomor-akhir-rekening" placeholder="Nomor Akhir" value="{!! $pengaturan->nomor_akhir_rekening !!}">
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
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="approve">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="pull-left">
                                                        <a href="javascript:void(0)" id="add_row" class="btn btn-sm btn-primary"><i class="ti-plus"> Tambah</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered responsive no-m" id="input-jurnal">
                                                    <thead>
                                                    <tr class="bg-color">
                                                        <th width="5%" class="text-center">No</th>
                                                        <th width="30%" class="text-center">Level</th>
                                                        <th width="60%" class="text-center">User</th>
                                                        <th width="5%">&nbsp;</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($approve as $key => $value)
                                                        <input type="hidden" name="ida[]" value="{!! $value->id !!}">
                                                        <tr id="f{{$key+1}}">
                                                            <td class="text-center">{!! $key+1 !!}</td>
                                                            <td>
                                                                <select name="levels[]" style="width:100%" required>
                                                                    {{--<option>Pilih Level</option>--}}
                                                                    <option value="1" {{$value->level == 1 ? 'selected' : ''}}>Level 1</option>
                                                                    <option value="2" {{$value->level == 2 ? 'selected' : ''}}>Level 2</option>
                                                                    <option value="3" {{$value->level == 3 ? 'selected' : ''}}>Level 3</option>
                                                                    <option value="4" {{$value->level == 4 ? 'selected' : ''}}>Release</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="users[]" style="width:100%" required>
                                                                    {{--<option>Pilih User</option>--}}
                                                                    @foreach($user as $item)
                                                                        <option value="{!! $item->id !!}" {{$value->id_user == $item->id ? 'selected' : ''}}>{!! $item->username !!} - {!! $item->roleid->role_name !!}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="javascript:void(0)" onclick="hapusapprove({{$value->id}})" class="btn btn-sm btn-danger btn-del"><i class="ti-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="akses">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="pull-left">
                                                        <a href="javascript:void(0)" id="add_row2" class="btn btn-sm btn-primary"><i class="ti-plus"> Tambah</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered responsive no-m" id="input-jurnal2">
                                                    <thead>
                                                    <tr class="bg-color">
                                                        <th width="5%" class="text-center">No</th>
                                                        {{--<th width="30%" class="text-center">Akses</th>--}}
                                                        <th width="60%" class="text-center">User</th>
                                                        <th width="5%">&nbsp;</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($akses2 as $key => $value)
                                                        <input type="hidden" name="ida2[]" value="{!! $value->id !!}">
                                                        <tr id="f{{$key+1}}">
                                                            <td class="text-center">{!! $key+1 !!}</td>

                                                            <td>
                                                                <select name="users2[]" style="width:100%" required>
                                                                    {{--<option>Pilih User</option>--}}
                                                                    @foreach($user as $item)
                                                                        <option value="{!! $item->id !!}" {{$value->id_user == $item->id ? 'selected' : ''}}>{!! $item->username !!} - {!! $item->roleid->role_name !!}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="javascript:void(0)" onclick="hapusapprove2({{$value->id}})" class="btn btn-sm btn-danger btn-del"><i class="ti-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="col-sm-2">
                                    <a href="javascript:void(0)" id="btnpsave" class="btn btn-primary btn-block" name="save">Save</a>
                                </div>
                                <div class="col-sm-2">
                                    <a href="{!! url('pinjaman/pengaturan') !!}" class="btn btn-danger btn-block">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    @include('pinjaman.pinjaman_js')
    @include('master.modal_js')
    <script>

        if ($('#tipe-denda-perhari').val() == "denda_nominal") {
            $('#spn1').removeClass('hide');
            $('#spn1').show();
            $('#spn2').removeClass('hide');
            $('#spn2').show();
            $('#jml-denda').removeClass('hide');
            $('#jml-denda').show();

            $('#spn3').hide();
            $('#spn4').hide();
            $('#spn5').hide();
            $('#per-denda').hide();
        } else {
            $('#spn1').hide();
            $('#spn2').hide();
            $('#jml-denda').hide();

            $('#spn3').removeClass('hide');
            $('#spn3').show();
            $('#spn4').removeClass('hide');
            $('#spn4').show();
            $('#spn5').removeClass('hide');
            $('#spn5').show();
            $('#per-denda').removeClass('hide');
            $('#per-denda').show();
        }

        $('#btnpsave').on('click', function() {
            if ($('#kode').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kode</h4>');
                $('#mess').html('<p id="mess">Kode tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#nama-pinjaman').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama Pinjaman</h4>');
                $('#mess').html('<p id="mess">Nama Pinjaman tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#shu').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">SHU Pinjaman</h4>');
                $('#mess').html('<p id="mess">SHU tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#kode_awal_rek').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kode Awal Rekening</h4>');
                $('#mess').html('<p id="mess">Kode Awal Rekening tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#fppin').submit();
            }

        });

        $('#tipe-denda-perhari').on('change', function() {
            if ($(this).val() == "denda_nominal") {
                $('#spn1').removeClass('hide');
                $('#spn1').show();
                $('#spn2').removeClass('hide');
                $('#spn2').show();
                $('#jml-denda').removeClass('hide');
                $('#jml-denda').show();

                $('#spn3').hide();
                $('#spn4').hide();
                $('#spn5').hide();
                $('#per-denda').hide();
            } else {
                $('#spn1').hide();
                $('#spn2').hide();
                $('#jml-denda').hide();

                $('#spn3').removeClass('hide');
                $('#spn3').show();
                $('#spn4').removeClass('hide');
                $('#spn4').show();
                $('#spn5').removeClass('hide');
                $('#spn5').show();
                $('#per-denda').removeClass('hide');
                $('#per-denda').show();
            }
        });

        $("#add_row").click(function () {
            var current_row = $("#input-jurnal > tbody > tr").length - 1;
            var tr_tag = "<tr id=\"f"+current_row+"\">" +
                    "<td class=\"text-center\">"+ (current_row + 1) +"</td>" +
                    "<td>" +
                    "<select name=\"levels[]\" style=\"width:100%\" required>" +
//                    "<option>Pilih Level</option>" +
                    "<option value=\"1\">Level 1</option>" +
                    "<option value=\"2\">Level 2</option>" +
                    "<option value=\"3\">Level 3</option>" +
                    "<option value=\"4\">Release</option>" +
                    "</select>" +
                    "</td>" +
                    "<td>" +
                    "<select name=\"users[]\" style=\"width:100%\" required>" +
//                    "<option>Pilih User</option>" +
                    "@foreach($user as $item)" +
                    "<option value=\"{!! $item->id !!}\">{!! $item->username !!} - {!! $item->roleid->role_name !!}</option>"  +
                    "@endforeach" +
                    "</select>" +
                    "</td>" +
                    "<td class=\"text-center\">" +
                    "<a href=\"#\" class=\"btn btn-sm btn-danger btn-del\"><i class=\"ti-trash\"></i></a>" +
                    "</td>" +
                    "</tr>";
            $("#input-jurnal > tbody > tr:last-child").before(tr_tag);
            $("select").select2();

            $(".btn-del").each(function (key) {
                del_row($(this));
            });

        });

        $(".btn-del").each(function (key) {
            del_row($(this));
        });

        $("select").select2();

        function del_row(el) {
            el.click(function(){
                el.parent().parent().remove();
            })
        }

        function hapusapprove(id) {
            $.ajax({
                url: "{!! url('pinjaman/pengaturan/approve/delete') !!}/"+ id,
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
//                    alert(data[0]["stat"]);
                }
            });
        }


        $("#add_row2").click(function () {
            var current_row = $("#input-jurnal2 > tbody > tr").length - 1;
            var tr_tag = "<tr id=\"f"+current_row+"\">" +
                    "<td class=\"text-center\">"+ (current_row + 1) +"</td>" +
                    "<td>" +
                    "<select name=\"users2[]\" style=\"width:100%\" required>" +
//                    "<option>Pilih User</option>" +
                    "@foreach($user as $item)" +
                    "<option value=\"{!! $item->id !!}\">{!! $item->username !!} - {!! $item->roleid->role_name !!}</option>"  +
                    "@endforeach" +
                    "</select>" +
                    "</td>" +
                    "<td class=\"text-center\">" +
                    "<a href=\"#\" class=\"btn btn-sm btn-danger btn-del2\"><i class=\"ti-trash\"></i></a>" +
                    "</td>" +
                    "</tr>";
            $("#input-jurnal2 > tbody > tr:last-child").before(tr_tag);
            $("select").select2();

            $(".btn-del2").each(function (key) {
                del_row2($(this));
            });

        });
        $(".btn-del2").each(function (key) {
            del_row2($(this));
        });
        function del_row2(el) {
            el.click(function(){
                el.parent().parent().remove();
            })
        }
        function hapusapprove2(id) {
            $.ajax({
                url: "{!! url('pinjaman/pengaturan/akses/delete') !!}/"+ id,
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
//                    alert(data[0]["stat"]);
                }
            });
        }

    </script>
@stop
