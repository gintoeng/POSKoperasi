@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Simpanan</a>
        </li>
        <li class="active"><a href="{!! url('simpanan/pengaturan') !!}">Pengaturan Simpanan</a></li>
        <li class="active">Ubah</li>
        <li class="active">{!! $pengaturan->kode !!}</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('simpanan/pengaturan/'.$pengaturan->id.'/update') !!}" id="fpsimp">
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
                                <li><a href="#akses" data-toggle="tab">Hak Akses Status</a>
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
                                                <label for="jenis-simpanan" class="col-sm-3 control-label">Jenis Simpanan</label>
                                                <div class="col-sm-9">
                                                    <input name="jenis_simpanan" type="text" class="form-control" id="jenis-simpanan" placeholder="Jenis Simpanan" value="{!! $pengaturan->jenis_simpanan !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="suku-bunga" class="col-sm-3 control-label">Suku Bunga</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="suku_bunga" type="text" class="form-control input-sm spinner-input" id="suku-bunga" value="{!! $pengaturan->suku_bunga !!}" placeholder="Suku Bunga">
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
                                                <label for="saldo_minimum_bunga" class="col-sm-3 control-label">Saldo Minimum Dapat Bunga</label>
                                                <div class="col-sm-9">
                                                    <input name="saldo_minimum_bunga" type="text" class="form-control" id="saldo_minimum_bunga" style="text-align:right" placeholder="Saldo Minimum Dapat Bunga" value="{!! number_format($pengaturan->saldo_minimum_bunga, 2, '.', ',') !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="saldo_minimum" class="col-sm-3 control-label">Saldo Minimum</label>
                                                <div class="col-sm-9">
                                                    <input name="saldo_minimum" type="text" class="form-control" id="saldo_minimum" style="text-align:right" placeholder="Saldo Minimum" value="{!! number_format($pengaturan->saldo_minimum, 2, '.', ',') !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="status" class="col-sm-3 control-label">Status Simpanan</label>
                                                <div class="col-sm-9">
                                                    <div class="radio">
                                                        <label><input name="status" type="radio" value="0" {{$pengaturan->wajibpokok == 0 ? 'checked' : '' }}>Lainnya</label>&nbsp;
                                                        <label><input name="status" type="radio" value="1" {{$pengaturan->wajibpokok == 1 ? 'checked' : '' }}>Wajib</label>&nbsp;
                                                        <label><input name="status" type="radio" value="2" {{$pengaturan->wajibpokok == 2 ? 'checked' : '' }}>Pokok</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="setoran_minimum" class="col-sm-3 control-label">Setoran Minimum</label>
                                                <div class="col-sm-9">
                                                    <input name="setoran_minimum" type="text" class="form-control" id="setoran_minimum" style="text-align:right" placeholder="Setoran Minimum" value="{!! number_format($pengaturan->setoran_minimum, 2, '.', ',') !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="saldo_minimum_pajak" class="col-sm-3 control-label">Saldo Minimum Pajak</label>
                                                <div class="col-sm-9">
                                                    <input name="saldo_minimum_pajak" type="text" class="form-control" id="saldo_minimum_pajak" style="text-align:right" placeholder="Saldo Minimum Pajak" value="{!! number_format($pengaturan->saldo_minimum_pajak, 2, '.', ',') !!}">
                                                </div>
                                            </div>
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
                                                <label for="administrasi" class="col-sm-3 control-label">Administrasi</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input name="administrasi" type="text" class="form-control" id="administrasi" style="text-align:right" placeholder="Administrasi" value="{!! number_format($pengaturan->administrasi, 2, '.', ',') !!}">
                                                        <span class="input-group-addon">per Bulan</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="persen-pajak" class="col-sm-3 control-label">Persen Pajak</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="persen_pajak" type="text" class="form-control input-sm spinner-input" id="persen-pajak" value="{!! $pengaturan->persen_pajak !!}" placeholder="Persen Pajak">
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
                                            <div class="form-group">
                                                <label for="autocreate" class="col-sm-3 control-label">Autocreate</label>
                                                <div class="col-sm-9 icheck">
                                                    {{--<div class="checkbox icheck">--}}
                                                    <label><input name="autocreate" type="checkbox" value="1" id="autocreate" {!! $pengaturan->autocreate == 1 ? 'checked' : '' !!}>&nbsp;</label>
                                                    {{--</div>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="akuntansi">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="akun-kas-bank" class="col-sm-3 control-label">Akun Kas Bank</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_kas_bank" style="width:100%;" id="akun-kas-bank" data-placeholder="Pilih Akun Kas Bank" class="chosen" required>
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_kas_bank == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-setoran" class="col-sm-3 control-label">Akun Setoran</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_setoran" style="width:100%;" id="akun-setoran" data-placeholder="Pilih Akun Setoran" class="chosen" required>
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_setoran == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-penarikan" class="col-sm-3 control-label">Akun Penarikan</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_penarikan" style="width:100%;" id="akun-penarikan" data-placeholder="Pilih Akun Penarikan" class="chosen" required>
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_penarikan == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="akun-bunga" class="col-sm-3 control-label">Akun Bunga</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_bunga" style="width:100%;" id="akun-bunga" data-placeholder="Pilih Akun Bunga" class="chosen" required>
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_bunga == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-administrasi" class="col-sm-3 control-label">Akun Administrasi</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_administrasi" style="width:100%;" id="akun-administrasi" data-placeholder="Pilih Akun Administrasi" class="chosen" required>
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_administrasi == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-pajak" class="col-sm-3 control-label">Akun Pajak</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_pajak" style="width:100%;" id="akun-pajak" data-placeholder="Pilih Akun Pajak" class="chosen" required>
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $pengaturan->akun_pajak == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
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
                                                        <input name="jumlah_digit_rekening" type="text" class="form-control input-sm spinner-input" id="persen-pajak" value="{!! $pengaturan->jumlah_digit_rekening !!}" placeholder="Jumlah Digit Rekening">
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
                                                        <input name="nomor_akhir_rekening" type="text" class="form-control input-sm spinner-input" id="persen-pajak" value="{!! $pengaturan->nomor_akhir_rekening !!}" placeholder="Nomor Akhir Rekening">
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
                                                        <th width="30%" class="text-center">Akses</th>
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
                                                                <select name="aksess2[]" style="width:100%" required>
                                                                    {{--<option>Pilih Akses</option>--}}
                                                                    {{--<option value="aktif" {{$value->jenis == "aktif" ? 'selected' : ''}}>Aktif</option>--}}
                                                                    {{--<option value="blokir" {{$value->jenis == "blokir" ? 'selected' : ''}}>Blokir</option>--}}
                                                                    <option value="tutup" {{$value->jenis == "tutup" ? 'selected' : ''}}>Tutup</option>
                                                                </select>
                                                            </td>
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
                                    <a href="{!! url('simpanan/pengaturan') !!}" class="btn btn-danger btn-block">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    @include('simpanan.simpanan_js')
    @include('master.modal_js')
    <script>
        $('#btnpsave').on('click', function() {
            if ($('#kode').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kode</h4>');
                $('#mess').html('<p id="mess">Kode tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#jenis-simpanan').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Jenis Simpanan</h4>');
                $('#mess').html('<p id="mess">Jenis Simpanan tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#shu').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">SHU Simpanan</h4>');
                $('#mess').html('<p id="mess">SHU tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#kode_awal_rek').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kode Awal Rekening</h4>');
                $('#mess').html('<p id="mess">Kode Awal Rekening tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#fpsimp').submit();
            }

        });

//        $('#shu').on('click', function(){
//            var x=$("#shu").is(":checked");
//            if (x == true) {
//                $("#shus").removeClass('hide');
//                $("#shus").show();
//            } else {
//                $('#shus').hide();
//            }
//        });

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
                url: "{!! url('simpanan/pengaturan/approve/delete') !!}/"+ id,
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
                    "<select name=\"aksess2[]\" style=\"width:100%\" required>" +
//                    "<option>Pilih Akses</option>" +
//                    "<option value=\"aktif\">Aktif</option>" +
//                    "<option value=\"blokir\">Blokir</option>" +
                    "<option value=\"tutup\">Tutup</option>" +
                    "</select>" +
                    "</td>" +
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
                url: "{!! url('simpanan/pengaturan/akses/delete') !!}/"+ id,
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
