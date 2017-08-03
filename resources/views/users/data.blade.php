@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li class="active">Pengaturan</li>
        <li class=""><a href="{!! url('pengaturan/user') !!}">Daftar User</a></li>
        <li class="active">Ubah User</li>
        <li class="active">{!! $user->id !!}</li>
    </ol>
    <section class="panel">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="post" action="{{ url('pengaturan/user/update') }}" enctype="multipart/form-data" id="fusered">
                <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-9">
                                <input name="username" type="text" class="form-control" id="username" placeholder="Username" value="{{ $user->username }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-9">
                                <input name="password" type="password" class="form-control" id="password" placeholder="Isi jika akan diganti">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role" class="col-sm-3 control-label">Hak Akses</label>
                            <div class="col-sm-9">
                                <select name="role_id" class="form-control" id="roleid">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{$user->role_id == $role->id ? 'selected' : ''}}>{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-9">
                                <select name="status" class="form-control">
                                    <option value="1" {{$user->status == "1" ? 'selected' : ''}}>AKTIF</option>
                                    <option value="0" {{$user->status == "0" ? 'selected' : ''}}>NON AKTIF</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group {{$user->roleid->akses == "koperasi" ? 'hide' : ''}}" id="cb">
                            <label for="cabang" class="col-sm-3 control-label">Cabang</label>
                            <div class="col-sm-9">
                                <select name="cabang" id="cabang" class="form-control" style="width: 100%">
                                    <option value="0" {{$user->cabang == "0" ? 'selected' : ''}}></option>
                                    @foreach($cabang as $item)
                                        <option value="{{ $item->id }}" {{$user->cabang == $item->id ? 'selected' : ''}}>{{ $item->kode }} - {{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group {{$user->roleid->akses != "koperasi" ? 'hide' : ''}}" id="postjr">
                            <label for="posting" class="col-sm-3 control-label">Posting Jurnal</label>
                            <div class="col-sm-9 icheck">
                                {{--<div class="checkbox icheck">--}}
                                <label><input name="posting" type="checkbox" value="1" id="posting" {!! $user->posting == 1 ? 'checked' : '' !!}>&nbsp;</label>
                                {{--</div>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir" class="col-sm-3 control-label"></label>
                            <div class="col-sm-2">
                                <input type="button" id="btnsave" class="btn btn-primary btn-block" name="save" value="Save">
                            </div>
                            <div class="col-sm-2">
                                <a href="{{ url('pengaturan/user') }}" class="btn btn-danger btn-block">Cancel</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foto" class="col-sm-3 control-label">Foto</label>
                            <div class="col-sm-9">
                                @if($user->photo == "ava")
                                    <img id="imgfoto" src="{{asset('foto/default-avatar-user.png')}}" alt="your image" width="200" />
                                @else
                                    <img id="imgfoto" src="{{asset('foto/user/'.$user->photo)}}" alt="your image" width="200" />
                                @endif
                                <input name="foto" type="file" id="foto" placeholder="Foto">
                                <input type="hidden" name="gambar" value="{{ $user->photo }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @include('master.modal_js')

    <script>
        $('#roleid').on('change', function() {
            $.ajax({
                url: "{!! url('pengaturan/user/ajax') !!}/" + $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    var tipe = data[0]["tipe"];
                    if (tipe == "koperasi") {
                        $('#cb').val("0");
                        $('#cb').hide();
                        $('#postjr').removeClass('hide');
                        $('#postjr').show();
                    } else {
                        $('#cb').removeClass('hide');
                        $('#cb').show();
                        $('#postjr').hide();
                    }
                }

            });
        });

        $("#cabang").removeAttr('class');
        $("#cabang").select2();

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imgfoto').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#foto").change(function(){
            readURL(this);
        });

        $('#btnsave').on('click', function() {
            if ($('#username').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Username</h4>');
                $('#mess').html('<p id="mess">Username tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                $.ajax({
                    url: "{!! url('pengaturan/user/ajax') !!}/" + $('#roleid').val(),
                    data: {},
                    dataType: "json",
                    type: "get",
                    success:function(data)
                    {
                        var tipe = data[0]["tipe"];

                        if (tipe != "koperasi") {
                            if ($('#cabang').val() == "" || $('#cabang').val() == "0") {
                                $('#judul').html('<h4 class="modal-title" id="judul">Cabang</h4>');
                                $('#mess').html('<p id="mess">Cabang tidak boleh kosong.</p>');
                                $('#rejectModal').modal();
                            } else {
                                FunctionLoading();
                                $('#fusered').submit();
                            }
                        } else {
                            FunctionLoading();
                            $('#fusered').submit();
                        }
                    }

                });
            }
        });
    </script>

@stop
