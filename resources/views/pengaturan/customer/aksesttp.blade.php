@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pengaturan</a>
        </li>
        <li class="active"><a href="{!! url('pengaturan/customer/aksesttp') !!}">Hak Akses Status Customer</a></li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('pengaturan/customer/aksesttp') !!}" id="fakcs">
                        <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">

                        <div class="box-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#umum" data-toggle="tab">Umum</a>
                                </li>
                                <li><a href="#biasa" data-toggle="tab">Biasa</a>
                                </li>
                                <li><a href="#luarbiasa" data-toggle="tab">Luar Biasa</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="umum">
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
                                                        <th width="30%" class="text-center">Akses</th>
                                                        <th width="60%" class="text-center">User</th>
                                                        <th width="5%">&nbsp;</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($akses as $key => $value)
                                                        <input type="hidden" name="ida[]" value="{!! $value->id !!}">
                                                        <tr id="f{{$key+1}}">
                                                            <td class="text-center">{!! $key+1 !!}</td>
                                                            <td>
                                                                <select name="aksess[]" style="width:100%" required>
                                                                    {{--<option>Pilih Akses</option>--}}
                                                                    <option value="aktif" {{$value->jenis == "aktif" ? 'selected' : ''}}>AKTIF</option>
                                                                    <option value="block" {{$value->jenis == "block" ? 'selected' : ''}}>BLOCK</option>
                                                                    <option value="tutup" {{$value->level == "tutup" ? 'selected' : ''}}>NONAKTIF</option>
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
                                <div class="tab-pane fade" id="biasa">
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
                                                                    <option>Pilih Akses</option>
                                                                    <option value="aktif" {{$value->jenis == "aktif" ? 'selected' : ''}}>AKTIF</option>
                                                                    <option value="block" {{$value->jenis == "block" ? 'selected' : ''}}>BLOCK</option>
                                                                    <option value="tutup" {{$value->level == "tutup" ? 'selected' : ''}}>NONAKTIF</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="users2[]" style="width:100%" required>
                                                                    <option>Pilih User</option>
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
                                <div class="tab-pane fade" id="luarbiasa">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="pull-left">
                                                        <a href="javascript:void(0)" id="add_row3" class="btn btn-sm btn-primary"><i class="ti-plus"> Tambah</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered responsive no-m" id="input-jurnal3">
                                                    <thead>
                                                    <tr class="bg-color">
                                                        <th width="5%" class="text-center">No</th>
                                                        <th width="30%" class="text-center">Akses</th>
                                                        <th width="60%" class="text-center">User</th>
                                                        <th width="5%">&nbsp;</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($akses3 as $key => $value)
                                                        <input type="hidden" name="ida3[]" value="{!! $value->id !!}">
                                                        <tr id="f{{$key+1}}">
                                                            <td class="text-center">{!! $key+1 !!}</td>
                                                            <td>
                                                                <select name="aksess3[]" style="width:100%" required>
                                                                    <option>Pilih Akses</option>
                                                                    <option value="aktif" {{$value->jenis == "aktif" ? 'selected' : ''}}>AKTIF</option>
                                                                    <option value="block" {{$value->jenis == "block" ? 'selected' : ''}}>BLOCK</option>
                                                                    <option value="tutup" {{$value->level == "tutup" ? 'selected' : ''}}>NONAKTIF</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="users3[]" style="width:100%" required>
                                                                    <option>Pilih User</option>
                                                                    @foreach($user as $item)
                                                                        <option value="{!! $item->id !!}" {{$value->id_user == $item->id ? 'selected' : ''}}>{!! $item->username !!} - {!! $item->roleid->role_name !!}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="javascript:void(0)" onclick="hapusapprove3({{$value->id}})" class="btn btn-sm btn-danger btn-del"><i class="ti-trash"></i></a>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="col-sm-1 pull-right">
                                    <a href="javascript:void(0)" id="btnsave" class="btn btn-info btn-block" name="save">Save</a>
                                </div>
                                {{--<div class="col-sm-2">--}}
                                    {{--<a href="{!! url('simpanan/pengaturan') !!}" class="btn btn-danger btn-block">Cancel</a>--}}
                                {{--</div>--}}
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
        $('#btnsave').on('click', function() {
            FunctionLoading();
            $('#fakcs').submit();
        });


        $("select").select2();

        $("#add_row").click(function () {
            var current_row = $("#input-jurnal > tbody > tr").length - 1;
            var tr_tag = "<tr id=\"f"+current_row+"\">" +
                    "<td class=\"text-center\">"+ (current_row + 1) +"</td>" +
                    "<td>" +
                    "<select name=\"aksess[]\" style=\"width:100%\" required>" +
//                    "<option>Pilih Akses</option>" +
                    "<option value=\"aktif\">AKTIF</option>" +
                    "<option value=\"block\">BLOCK</option>" +
                    "<option value=\"tutup\">NONAKTIF</option>" +
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
        function del_row(el) {
            el.click(function(){
                el.parent().parent().remove();
            })
        }
        function hapusapprove(id) {
            $.ajax({
                url: "{!! url('pengaturan/customer/aksesttp/delete') !!}/"+ id,
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    alert(data[0]["stat"]);
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
                    "<option value=\"aktif\">AKTIF</option>" +
                    "<option value=\"block\">BLOCK</option>" +
                    "<option value=\"tutup\">NONAKTIF</option>" +
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
                url: "{!! url('pengaturan/customer/aksesttp/delete') !!}/"+ id,
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    alert(data[0]["stat"]);
                }
            });
        }

        $("#add_row3").click(function () {
            var current_row = $("#input-jurnal3 > tbody > tr").length - 1;
            var tr_tag = "<tr id=\"f"+current_row+"\">" +
                    "<td class=\"text-center\">"+ (current_row + 1) +"</td>" +
                    "<td>" +
                    "<select name=\"aksess3[]\" style=\"width:100%\" required>" +
//                    "<option>Pilih Akses</option>" +
                    "<option value=\"aktif\">AKTIF</option>" +
                    "<option value=\"block\">BLOCK</option>" +
                    "<option value=\"tutup\">NONAKTIF</option>" +
                    "</select>" +
                    "</td>" +
                    "<td>" +
                    "<select name=\"users3[]\" style=\"width:100%\" required>" +
//                    "<option>Pilih User</option>" +
                    "@foreach($user as $item)" +
                    "<option value=\"{!! $item->id !!}\">{!! $item->username !!} - {!! $item->roleid->role_name !!}</option>"  +
                    "@endforeach" +
                    "</select>" +
                    "</td>" +
                    "<td class=\"text-center\">" +
                    "<a href=\"#\" class=\"btn btn-sm btn-danger btn-del3\"><i class=\"ti-trash\"></i></a>" +
                    "</td>" +
                    "</tr>";
            $("#input-jurnal3 > tbody > tr:last-child").before(tr_tag);
            $("select").select2();

            $(".btn-del3").each(function (key) {
                del_row3($(this));
            });

        });
        $(".btn-del3").each(function (key) {
            del_row3($(this));
        });
        function del_row3(el) {
            el.click(function(){
                el.parent().parent().remove();
            })
        }
        function hapusapprove3(id) {
            $.ajax({
                url: "{!! url('pengaturan/customer/aksesttp/delete') !!}/"+ id,
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    alert(data[0]["stat"]);
                }
            });
        }


    </script>
@stop
