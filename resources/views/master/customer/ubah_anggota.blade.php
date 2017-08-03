@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/customer') !!}">Daftar Customer</a></li>
        <li class="active">Ubah</li>
        <li class="active">{!! $anggota->kode !!}</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('master/customer/'.$anggota->id.'/update') !!}" enctype="multipart/form-data" id="fcus">
                        <input name="ida" type="hidden" value="{!! $anggota->id !!}">
                        <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode" class="col-sm-3 control-label">Kode</label>
                                    <div class="col-sm-9">
                                        <input name="kode" value="{!! $anggota->kode !!}" type="text" class="form-control" id="kode" placeholder="Kode" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_customer" class="col-sm-3 control-label">Jenis Customer</label>
                                    <div class="col-sm-9">
                                        <select name="jenis_customer" type="text" class="form-control" id="jenis_nasabah" placeholder="Jenis Customer">
                                            <option value="UMUM" {{$anggota->jenis_nasabah == "UMUM" ? 'selected' : ''}}>Umum</option>
                                            <option value="BIASA" {{$anggota->jenis_nasabah == "BIASA" ? 'selected' : ''}}>Biasa</option>
                                            <option value="LUAR BIASA" {{$anggota->jenis_nasabah == "LUAR BIASA" ? 'selected' : ''}}>Luar Biasa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="npkni">
                                    <label for="npk" class="col-sm-3 control-label">NPK</label>
                                    <div class="col-sm-9">
                                        <input name="npk" type="text" class="form-control" id="npk" placeholder="NPK" value="{!! $anggota->npk !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_ktp" class="col-sm-3 control-label">Nomor KTP</label>
                                    <div class="col-sm-9">
                                        <input name="nomor_ktp" type="text" class="form-control" id="nomor_ktp" placeholder="Nomor KTP" value="{!! $anggota->nomor_ktp !!}" onkeyup="validAngka(this)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama" class="col-sm-3 control-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input name="nama" type="text" class="form-control" id="nama" placeholder="Nama" value="{!! $anggota->nama !!}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-9">
                                        <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="{!! $anggota->email !!}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat" class="col-sm-3 control-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea name="alamat" type="text" class="form-control" id="alamat" placeholder="Alamat">{!! $anggota->alamat !!}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kota" class="col-sm-3 control-label">Kota</label>
                                    <div class="col-sm-9">
                                        <input name="kota" type="text" class="form-control" id="kota" placeholder="Kota" value="{!! $anggota->kota !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="provinsi" class="col-sm-3 control-label">Provinsi</label>
                                    <div class="col-sm-9">
                                        <input name="provinsi" type="text" class="form-control" id="provinsi" placeholder="Provinsi" value="{!! $anggota->provinsi !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kode_pos" class="col-sm-3 control-label">Kode Pos</label>
                                    <div class="col-sm-9">
                                        <input name="kode_pos" type="text" class="form-control" id="kode_pos" placeholder="Kode Pos" value="{!! $anggota->kode_pos !!}" onkeyup="validAngka(this)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telepon" class="col-sm-3 control-label">Telepon</label>
                                    <div class="col-sm-9">
                                        <input name="telepon" type="text" class="form-control" id="telepon" placeholder="Telepon" value="{!! $anggota->telepon !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tempat_lahir" class="col-sm-3 control-label">Tempat Lahir</label>
                                    <div class="col-sm-9">
                                        <input name="tempat_lahir" type="text" class="form-control" id="tempat_lahir" placeholder="Tempat Lahir" value="{!! $anggota->tempat_lahir !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="col-sm-3 control-label">Tanggal Lahir</label>
                                    <div class="col-sm-9">
                                        <input name="tanggal_lahir" type="text" class="form-control datepicker" id="tanggal_lahir" placeholder="Tanggal Lahir" value="{!! $tgl !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin" class="col-sm-3 control-label">Jenis Kelamin</label>
                                    <div class="col-sm-9">
                                        <?php
                                            if ($anggota->jenis_kelamin == "L") {
                                                $rl = "checked";
                                                $rp = "";
                                            } else {
                                                $rp = "checked";
                                                $rl = "";
                                            }
                                        ?>
                                        <div class="radio">
                                            <label><input name="jenis_kelamin" type="radio" value="L" {!! $rl !!}>Laki-laki</label>&nbsp;
                                            <label><input name="jenis_kelamin" type="radio" value="P" {!! $rp !!}>Perempuan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_registrasi" class="col-sm-3 control-label">Tanggal Registrasi</label>
                                    <div class="col-sm-9">
                                        <input name="tanggal_registrasi" value="{!! $tgl2 !!}" type="text" class="form-control datepicker" id="tanggal_registrasi" placeholder="Tanggal Registrasi">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-9">
                                        <div class="radio">
                                            <label><input name="status" type="radio" value="AKTIF" {{$anggota->status == "AKTIF" ? 'checked' : ''}}>AKTIF</label>&nbsp;
                                            <label><input name="status" type="radio" value="NONAKTIF" {{$anggota->status == "NONAKTIF" ? 'checked' : ''}}>NONAKTIF</label>&nbsp;
                                            <label><input name="status" type="radio" value="BLOCK" {{$anggota->status == "BLOCK" ? 'checked' : ''}}>BLOCK</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cabang" class="col-sm-3 control-label">Cabang</label>
                                    <div class="col-sm-9">
                                        <input name="cabang" type="text" class="form-control" id="cabang" value="{!! $anggota->cabang !!}" placeholder="Cabang">
                                    </div>
                                </div>
                                <div class="form-group" id="rekni">
                                    <label for="norekening" class="col-sm-3 control-label">No. Rekening</label>
                                    <div class="col-sm-9">
                                        <input name="nomor_rekening" type="text" class="form-control" id="norekening" placeholder="No. Rekening" value="{!! $anggota->nomor_rekening !!}" onkeyup="validAngka(this)">
                                    </div>
                                </div>
                                <div class="form-group" id="rekni2">
                                    <label for="koderekening" class="col-sm-3 control-label">Kode Cabang Rekening</label>
                                    <div class="col-sm-5">
                                        <select name="kode_rekening" class="form-control" id="koderekening" data-placeholder="Pilih Kode Rekening Cabang" style="width: 100%">
                                            <option value=""></option>
                                            @foreach($recab as $item)
                                                <option value="{!! $item->id !!}" {{ $item->id == $anggota->kode_rekening ? 'selected' : ''}}>{!! $item->kode !!} - {!! $item->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4" id="namarecab">
                                        @if($anggota->kode_rekening != null || $anggota->kode_rekening != "")
                                            <input name="nama_rekening" type="text" class="form-control" id="namarekening" placeholder="Nama Cabang Rekening" value="{!! $anggota->recabid->nama !!}" readonly>
                                        @else
                                            <input name="nama_rekening" type="text" class="form-control" id="namarekening" placeholder="Nama Cabang Rekening" value="" readonly>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" id="bankni">
                                    <label for="bank" class="col-sm-3 control-label">Bank</label>
                                    <div class="col-sm-9">
                                        <select name="bank" style="width:100%;" id="bank" data-placeholder="Pilih Bank" class="chosen" required>
                                            <option value=""></option>
                                            @foreach($bank as $value)
                                                <option value="{!! $value->id !!}" {!! $anggota->id_bank == $value->id ? 'selected' : '' !!}>{!! $value->kode !!} - {!! $value->nama_bank !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="bankni2">
                                    <label for="namaakun" class="col-sm-3 control-label">Nama Akun Bank</label>
                                    <div class="col-sm-9">
                                        <input name="nama_akun" type="text" class="form-control" id="namaakun" value="{!! $anggota->nama_akun !!}" placeholder="Nama Akun">
                                    </div>
                                </div>
                                <div class="form-group" id="bankni3">
                                    <label for="nomorakunm" class="col-sm-3 control-label">Nomor Akun Bank</label>
                                    <div class="col-sm-9">
                                        <input name="nomor_akun" type="text" class="form-control" id="nomorakun" value="{!! $anggota->nomor_akun !!}" placeholder="Nomor Akun">
                                    </div>
                                </div>
                                <div class="form-group" id="deptni">
                                    <label for="departemen" class="col-sm-3 control-label">Departemen</label>
                                    <div class="col-sm-9">
                                        <input name="departemen" type="text" class="form-control" id="departemen" placeholder="Departemen" value="{!! $anggota->departemen !!}">
                                    </div>
                                </div>
                                <div class="form-group" id="jabni">
                                    <label for="jabatan" class="col-sm-3 control-label">Jabatan</label>
                                    <div class="col-sm-9">
                                        <input name="jabatan" type="text" class="form-control" id="jabatan" placeholder="Jabatan" value="{!! $anggota->jabatan !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_saudara" class="col-sm-3 control-label">Nama Saudara</label>
                                    <div class="col-sm-9">
                                        <input name="nama_saudara" type="text" class="form-control" id="nama_saudara" placeholder="Nama Saudara" value="{!! $anggota->nama_saudara !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_saudara" class="col-sm-3 control-label">Alamat Saudara</label>
                                    <div class="col-sm-9">
                                        <textarea name="alamat_saudara" type="text" class="form-control" id="alamat_saudara" placeholder="Alamat Saudara">{!! $anggota->alamat_saudara !!}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telepon_saudara" class="col-sm-3 control-label">Telepon Saudara</label>
                                    <div class="col-sm-9">
                                        <input name="telepon_saudara" type="text" class="form-control" id="telepon_saudara" placeholder="Telepon Saudara" value="{!! $anggota->telepon_saudara !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="hubungan" class="col-sm-3 control-label">Hubungan</label>
                                    <div class="col-sm-9">
                                        <input name="hubungan" type="text" class="form-control" id="hubungan" placeholder="Hubungan" value="{!! $anggota->hubungan !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="foto" class="col-sm-3 control-label">Foto</label>
                                    <input type="hidden" name="gambar" value="{{ $anggota->foto }}">
                                    <div class="col-sm-9">
                                        @if($anggota->foto == "")
                                            <img id="imgfoto" src="{{asset('foto/default-avatar-user.png')}}" alt="your image" width="100" height="200"/>
                                        @else
                                            <img id="imgfoto" src="{{asset('foto/anggota'.'/'.$anggota->foto)}}" alt="your image" width="100" height="200"/>
                                        @endif
                                        <input name="foto" type="file" id="foto" placeholder="Foto">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nokartu" class="col-sm-3 control-label">Nomor Kartu</label>
                                    <div class="col-sm-9">
                                        <input name="nomor_kartu" type="text" class="form-control" value="{!! $anggota->account_card !!}" id="nokartu" placeholder="Nomor Kartu" onkeyup="validAngka(this)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pin" class="col-sm-3 control-label">PIN</label>
                                    <div class="col-sm-9">
                                        <input name="pin" type="password" class="form-control" id="pin" placeholder="PIN" value="{!! $anggota->pin !!}" onkeyup="validAngka(this)">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="limit" class="col-sm-3 control-label">Limit Transaksi</label>
                                    <div class="col-sm-9">
                                        <input name="limit_transaksi" type="text" class="form-control" style="text-align:right" id="limit" value="{!! number_format($anggota->limit_transaksi, 2, '.', ',') !!}" placeholder="0.00" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <textarea rows="4" name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan">{!! $anggota->keterangan !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <button id="btnsave" type="button" class="btn btn-primary btn-block" name="save">Save</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('master/customer') !!}" class="btn btn-danger btn-block">Cancel</a>
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

        $('#koderekening').change(function() {
            $.ajax({
                url: "{!! url('master/customer/recab') !!}/"+ $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#namarekening').val(data[0]["nama"]).selected;
                }
            });
        });

        $('#limit').maskMoney();
        $("#bank").removeAttr('class');
        $("#bank").select2();
        $("#koderekening").removeAttr('class');
        $("#koderekening").select2();

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
            if ($('#nama').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama Customer</h4>');
                $('#mess').html('<p id="mess">Nama Customer tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                if ($('#jenis_nasabah').val() != "UMUM") {
                    if ($('#norekening').val() == "") {
                        $('#judul').html('<h4 class="modal-title" id="judul">Nomor Rekening</h4>');
                        $('#mess').html('<p id="mess">Nomor Rekening tidak boleh kosong.</p>');
                        $('#rejectModal').modal();
                    } else {
                        FunctionLoading();
                        $('#fcus').submit();
                    }
                } else {
                    if ($('#bank').val() == "") {
                        $('#judul').html('<h4 class="modal-title" id="judul">Bank</h4>');
                        $('#mess').html('<p id="mess">Bank tidak boleh kosong.</p>');
                        $('#rejectModal').modal();
                    } else if ($('#norekening').val() == "") {
                        $('#judul').html('<h4 class="modal-title" id="judul">Nomor Rekening</h4>');
                        $('#mess').html('<p id="mess">Nomor Rekening tidak boleh kosong.</p>');
                        $('#rejectModal').modal();
                    } else if ($('#namaakun').val() == "") {
                        $('#judul').html('<h4 class="modal-title" id="judul">Nama Akun Bank</h4>');
                        $('#mess').html('<p id="mess">Nama Akun Bank tidak boleh kosong.</p>');
                        $('#rejectModal').modal();
                    }else if ($('#nomorakun').val() == "") {
                        $('#judul').html('<h4 class="modal-title" id="judul">Nomor Akun Bank</h4>');
                        $('#mess').html('<p id="mess">Nomor Akun Bank tidak boleh kosong.</p>');
                        $('#rejectModal').modal();
                    } else {
                        FunctionLoading();
                        $('#fcus').submit();
                    }
                }
            }

        });

        if ($('#jenis_nasabah').val() != "UMUM") {
            $('#npkni').removeClass('hide');
            $('#npkni').show();
//            $('#rekni').removeClass('hide');
//            $('#rekni').show();

            $('#bankni').hide();
            $('#bankni2').hide();
            $('#bankni3').hide();

            $('#deptni').removeClass('hide');
            $('#deptni').show();
            $('#jabni').removeClass('hide');
            $('#jabni').show();
        } else {
            $('#npkni').hide();
//            $('#rekni').hide();
            $('#bankni').removeClass('hide');
            $('#bankni').show();
            $('#bankni2').removeClass('hide');
            $('#bankni2').show();
            $('#bankni3').removeClass('hide');
            $('#bankni3').show();

            $('#cabangni').hide();
            $('#deptni').hide();
            $('#jabni').hide();
        }

        $('#jenis_nasabah').on('change', function() {
            if ($(this).val() != "UMUM") {
                $('#npkni').removeClass('hide');
                $('#npkni').show();
//                $('#rekni').removeClass('hide');
//                $('#rekni').show();

                $('#bankni').hide();
                $('#bankni2').hide();
                $('#bankni3').hide();

                $('#deptni').removeClass('hide');
                $('#deptni').show();
                $('#jabni').removeClass('hide');
                $('#jabni').show();
            } else {
                $('#npkni').hide();
//                $('#rekni').hide();

                $('#bankni').removeClass('hide');
                $('#bankni').show();
                $('#bankni2').removeClass('hide');
                $('#bankni2').show();
                $('#bankni3').removeClass('hide');
                $('#bankni3').show();

                $('#deptni').hide();
                $('#jabni').hide();
            }
        });

        function validAngka(a)
        {
            if(!/^[0-9.]+$/.test(a.value))
            {
                a.value = a.value.substring(0,a.value.length-1000);
            }
        }
    </script>
@stop
