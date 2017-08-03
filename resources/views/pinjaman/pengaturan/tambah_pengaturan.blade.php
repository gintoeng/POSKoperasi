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
        <li class="active">Tambah</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('pinjaman/pengaturan') !!}" id="fppin" enctype="multipart/form-data">

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
                                                    <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tipepinjaman" class="col-sm-3 control-label">Tipe Pinjaman</label>
                                                <div class="col-sm-9">
                                                    <select name="tipe_pinjaman" style="width:100%;" id="tipepinjaman" data-placeholder="Pilih Tipe Pinjaman"  class="form-control" required>
                                                        {{--<option value=""></option>--}}
                                                        <option value="uang">Uang</option>
                                                        <option value="barang">Non Uang</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama-pinjaman" class="col-sm-3 control-label">Nama Pinjaman</label>
                                                <div class="col-sm-9">
                                                    <input name="nama_pinjaman" type="text" class="form-control" id="nama-pinjaman" placeholder="Nama Pinjaman">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="suku-bunga" class="col-sm-3 control-label">Suku Bunga</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="suku_bunga" type="text" class="form-control input-sm spinner-input" id="suku-bunga" value="0" placeholder="Suku Bunga">
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
                                                    <select name="sistem_bunga" style="width:100%;" id="sistem-bunga" data-placeholder="Pilih Sistem Bunga"  class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($sistem as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->sistem !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="foto" class="col-sm-3 control-label">Gambar</label>
                                                <div class="col-sm-3">
                                                    <img id="imgfoto" src="{{asset('assets/img/avatar.jpg')}}" alt="your image" width="100" />
                                                    <input name="foto" type="file" id="foto" placeholder="Foto">
                                                </div>
                                                <label for="foto2" class="col-sm-2 control-label">Gambar2</label>
                                                <div class="col-sm-3">
                                                    <img id="imgfoto2" src="{{asset('assets/img/avatar.jpg')}}" alt="your image" width="100" />
                                                    <input name="foto2" type="file" id="foto2" placeholder="Foto">
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
                                                            <option value="{!! $value->id !!}">{!! $value->nama !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="maksimum_waktu" class="col-sm-3 control-label">Maksimum Waktu</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input type="text" class="form-control input-sm spinner-input" name="maksimum_waktu" placeholder="Maksimum Waktu" value="0"/>
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
                                                            {{--<option value="hari">Hari</option>--}}
                                                            {{--<option value="bulan">Bulan</option>--}}
                                                        {{--</select>--}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="denda-perhari" class="col-sm-3 control-label">Denda Perhari</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <select name="tipe_denda_perhari" class="input-sm form-control" style="width: 100%" placeholder="Denda Perhari" id="tipe-denda-perhari">
                                                            <option value="denda_nominal">Denda Nominal</option>
                                                            <option value="saldo_X_persen%_X_hari">Saldo X Persen% X Hari</option>
                                                            <option value="angsuran_X_persen%_X_hari">Angsuran X Persen% X Hari</option>
                                                        </select>
                                                        <span id="spn1" class="input-group-addon">Nominal</span>
                                                        <input type="text" class="input-sm form-control" id="jml-denda" name="jumlah_denda_perhari" value="0.00" placeholder="0.00" style="text-align: right;"/>
                                                        <span id="spn2" class="input-group-addon">;-</span>

                                                        <span id="spn3" class="input-group-addon hide">Persen</span>
                                                        <input type="text" class="form-control input-sm spinner-input hide" id="per-denda" name="persen_denda_perhari" value="0" placeholder="0" style="text-align: right;"/>
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
                                                        <input name="toleransi_denda" type="text" class="form-control input-sm spinner-input" id="toleransi_denda" placeholder="Toleransi Denda" value="0">
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
                                                        <input type="text" class="input-sm form-control" id="adminbank" name="admin_bank" value="0.00" placeholder="0.00" style="text-align: right;"/>
                                                        <span class="input-group-addon">;-</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="adminfee" class="col-sm-3 control-label">Biaya Admin Fee</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="admin_fee" type="text" class="form-control input-sm spinner-input" id="adminfee" value="0" placeholder="Admin Fee">
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
                                            <div class="form-group hide" id="admtam">
                                                <label for="admintambahan" class="col-sm-3 control-label">Biaya Admin Tambahan</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="admin_tambahan" type="text" class="form-control input-sm spinner-input" id="admintambahan" value="0" placeholder="Admin Tambahan">
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
                                                    <select name="akun_kas_bank" type="text" style="width: 100%;" class="form-control" id="akun-kas-bank" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-realisasi" class="col-sm-3 control-label">Akun Realisasi</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_realisasi" type="text" style="width: 100%;" class="form-control" id="akun-realisasi" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Angsuran</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_angsuran" type="text" style="width: 100%;" class="form-control" id="akun-angsuran" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Administrasi</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_administrasi" type="text" style="width: 100%;" class="form-control" id="akun-administrasi" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
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
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
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
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
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
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Pendapatan Bunga</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_bunga" type="text" style="width: 100%;" class="form-control" id="akun-bunga" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Denda</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_denda" type="text" style="width: 100%;" class="form-control" id="akun-denda" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Biaya Provisi</label>
                                                <div class="col-sm-9">
                                                    <select name="biaya_provinsi" type="text" style="width: 100%;" class="form-control" id="biaya-provinsi" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Akun Lain - Lain</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_lain_lain" type="text" style="width: 100%;" class="form-control" id="akun-lain-lain" data-placeholder="Pilih Akun">
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
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
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
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
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
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
                                                    <input name="kode_awal_rekening" type="text" class="form-control" id="kode_awal_rek" placeholder="Kode Awal Rekening">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kode" class="col-sm-3 control-label">Jumlah Digit Rekening</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="jumlah_digit_rekening" type="text" class="form-control input-sm spinner-input" value="0" id="jml-digit-rekening" placeholder="Jumlah Digit Rekening">
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
                                                        <input name="nomor_akhir_rekening" type="text" class="form-control" value="0" id="nomor-akhir-rekening" placeholder="Nomor Akhir">
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
                                                    <tr id="f0">
                                                        <td class="text-center">1</td>
                                                        <td>
                                                            <select name="levels[]" style="width:100%" required>
                                                                <option value="1">Level 1</option>
                                                                <option value="2">Level 2</option>
                                                                <option value="3">Level 3</option>
                                                                <option value="4" selected>Release</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="users[]" style="width:100%" required>
                                                                {{--<option>Pilih User</option>--}}
                                                                @foreach($user as $item)
                                                                    <option value="{!! $item->id !!}">{!! $item->username !!} - {!! $item->roleid->role_name !!}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn btn-sm btn-danger btn-del"><i class="ti-trash"></i></a>
                                                        </td>
                                                    </tr>
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

        $('#tipepinjaman').on('change', function() {
            if ($(this).val() == "barang") {
                $('#admtam').removeClass('hide');
                $('#admtam').show();
            } else {
                $('#admtam').hide();
            }
        });


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
    </script>
@stop
