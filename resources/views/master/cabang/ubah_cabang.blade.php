@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/cabang') !!}">Daftar Cabang</a></li>
        <li class="active">Ubah</li>
        <li class="active">{!! $cabang->kode !!}</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('master/cabang/'.$cabang->id.'/update') !!}" id="fcab">
                        <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">
                        <div class="box-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#umum" data-toggle="tab">Umum</a>
                                </li>
                                <li><a href="#akuntansi" data-toggle="tab">Akuntansi</a>
                                </li>
                                <li><a href="#approve" data-toggle="tab">Hak Akses Approve</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="umum">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Kode" class="col-sm-3 control-label">Kode</label>
                                                <div class="col-sm-9">
                                                    <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode" value="{!! $cabang->kode !!}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="namaunit" class="col-sm-3 control-label">Nama Cabang</label>
                                                <div class="col-sm-9">
                                                    <input name="nama" type="text" class="form-control" id="nama" placeholder="Nama Cabang" value="{!! $cabang->nama !!}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat" class="col-sm-3 control-label">Alamat</label>
                                                <div class="col-sm-9">
                                                    <textarea name="alamat" type="text" class="form-control" id="alamat" placeholder="Alamat">{!! $cabang->alamat !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="kota" class="col-sm-3 control-label">Kota</label>
                                                <div class="col-sm-9">
                                                    <input name="kota" type="text" class="form-control" id="kota" placeholder="Kota" value="{!! $cabang->kota !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="provinsi" class="col-sm-3 control-label">Provinsi</label>
                                                <div class="col-sm-9">
                                                    <input name="provinsi" type="text" class="form-control" id="provinsi" placeholder="Provinsi" value="{!! $cabang->provinsi !!}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{--<div class="form-group">--}}
                                                {{--<label for="shu" class="col-sm-3 control-label">SHU POS</label>--}}
                                                {{--<div class="col-sm-9">--}}
                                                    {{--<select name="shu" style="width:100%;" id="shu" data-placeholder="Pilih SHU"  class="form-control" required>--}}
                                                        {{--<option value=""></option>--}}
                                                        {{--@foreach($shu as $value)--}}
                                                            {{--<option value="{!! $value->id !!}" {!! $cabang->id_shu == $value->id ? 'selected' : '' !!}>{!! $value->nama !!}</option>--}}
                                                        {{--@endforeach--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            <div class="form-group">
                                                <label for="kode_pos" class="col-sm-3 control-label">Kode Pos</label>
                                                <div class="col-sm-9">
                                                    <input name="kode_pos" type="text" class="form-control" id="kode_pos" placeholder="Kode Pos" value="{!! $cabang->kode_pos !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="telepon" class="col-sm-3 control-label">Telepon</label>
                                                <div class="col-sm-9">
                                                    <input name="telepon" type="text" class="form-control" id="telepon" placeholder="Telepon" value="{!! $cabang->telepon !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pesawat" class="col-sm-3 control-label">Pesawat</label>
                                                <div class="col-sm-9">
                                                    <input name="pesawat" type="text" class="form-control" id="kota" placeholder="Pesawat" value="{!! $cabang->pesawat !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="fax" class="col-sm-3 control-label">Fax</label>
                                                <div class="col-sm-9">
                                                    <input name="fax" type="text" class="form-control" id="fax" placeholder="Fax" value="{!! $cabang->fax !!}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="norekening" class="col-sm-3 control-label">No. Rekening</label>
                                                <div class="col-sm-9">
                                                    <input name="nomor_rekening" type="text" class="form-control" id="norekening" value="{!! $cabang->nomor_rekening !!}" placeholder="No. Rekening" onkeyup="validAngka(this)" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="akuntansi">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="akun-kas" class="col-sm-3 control-label">Akun Kas</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_kas" style="width:100%;" id="akun-kas" data-placeholder="Pilih Akun Kas" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option style="width: 100%" value="{!! $value->id !!}" {!! $cabang->akun_kas == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-persediaan" class="col-sm-3 control-label">Akun Persediaan</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_persediaan" style="width:100%;" id="akun-persediaan" data-placeholder="Pilih Akun Persediaan" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $cabang->akun_persediaan_wsd == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-piutang" class="col-sm-3 control-label">Akun Piutang</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_piutang" style="width:100%;" id="akun-piutang" data-placeholder="Pilih Akun Piutang" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $cabang->akun_piutang_wsd == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-penjualan" class="col-sm-3 control-label">Akun Penjualan</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_penjualan" style="width:100%;" id="akun-penjualan" data-placeholder="Pilih Akun Penjualan" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $cabang->akun_penjualan_wsd == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="akun-cabang" class="col-sm-3 control-label">Akun Cabang</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_cabang" style="width:100%;" id="akun-cabang" data-placeholder="Pilih Akun Cabang" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option style="width: 100%" value="{!! $value->id !!}" {!! $cabang->akun_cabang == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-pendapatan" class="col-sm-3 control-label">Akun Pendapatan</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_pendapatan" style="width:100%;" id="akun-pendapatan" data-placeholder="Pilih Akun Pendapatan" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $cabang->akun_pendapatan_wsd == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-penampungan" class="col-sm-3 control-label">Akun Penampungan Retur</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_penampungan" style="width:100%;" id="akun-penampungan" data-placeholder="Pilih Akun Penampungan" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $cabang->akun_penampungan_retur == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-biaya-opname" class="col-sm-3 control-label">Biaya Selisih Opname</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_biaya_opname" style="width:100%;" id="akun-biaya_opname" data-placeholder="Pilih Akun Biaya opname" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}" {!! $cabang->akun_biaya_selisih_opname == $value->id ? 'selected' : '' !!}>{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
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
                                                                    <option>Pilih Level</option>
                                                                    <option value="1" {{$value->level == 1 ? 'selected' : ''}}>Level 1</option>
                                                                    <option value="2" {{$value->level == 2 ? 'selected' : ''}}>Level 2</option>
                                                                    <option value="3" {{$value->level == 3 ? 'selected' : ''}}>Level 3</option>
                                                                    <option value="4" {{$value->level == 4 ? 'selected' : ''}}>Release</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="users[]" style="width:100%" required>
                                                                    <option>Pilih User</option>
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
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="tanggal_lahir" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <button id="btnsave" type="button" class="btn btn-primary btn-block" name="save">Save</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('master/cabang') !!}" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    @include('master.modal_js')
    <script>
        $("select").removeAttr('class');
        $("select").select2();

        $('#btnsave').on('click', function() {
            if ($('#kode').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kode Cabang</h4>');
                $('#mess').html('<p id="mess">Kode Cabang tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#nama').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama Cabang</h4>');
                $('#mess').html('<p id="mess">Nama Cabang tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#norekening').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nomor Rekening</h4>');
                $('#mess').html('<p id="mess">Nomor Rekening Cabang tidak boleh kosong.</p>');
                $('#rejectModal').modal();
//            } else if($('#shu').val() == "") {
//                $('#judul').html('<h4 class="modal-title" id="judul">SHU POS</h4>');
//                $('#mess').html('<p id="mess">SHU POS tidak boleh kosong.</p>');
//                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#fcab').submit();
            }

        });

        function validAngka(a)
        {
            if(!/^[0-9.]+$/.test(a.value))
            {
                a.value = a.value.substring(0,a.value.length-1000);
            }
        }

        $("#add_row").click(function () {
            var current_row = $("#input-jurnal > tbody > tr").length - 1;
            var tr_tag = "<tr id=\"f"+current_row+"\">" +
                    "<td class=\"text-center\">"+ (current_row + 1) +"</td>" +
                    "<td>" +
                    "<select name=\"levels[]\" style=\"width:100%\" required>" +
                    "<option>Pilih Level</option>" +
                    "<option value=\"1\">Level 1</option>" +
                    "<option value=\"2\">Level 2</option>" +
                    "<option value=\"3\">Level 3</option>" +
                    "<option value=\"4\">Release</option>" +
                    "</select>" +
                    "</td>" +
                    "<td>" +
                    "<select name=\"users[]\" style=\"width:100%\" required>" +
                    "<option>Pilih User</option>" +
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
    </script>
@stop
