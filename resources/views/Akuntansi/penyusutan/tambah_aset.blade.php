@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Penyusutan</a>
        </li>
        <li class="active"><a href="{!! url('akuntansi/penyusutan') !!}">Daftar Aset Penyusutan</a></li>
        <li class="active">Tambah</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('akuntansi/penyusutan') !!}" id="fas">
                        <div class="box-tab">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#umum" data-toggle="tab">Umum</a>
                                </li>
                                <li><a href="#akuntansi" data-toggle="tab">Akuntansi</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="umum">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Kode" class="col-sm-3 control-label">Kode Aset</label>
                                                <div class="col-sm-9">
                                                    <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode Aset" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama" class="col-sm-3 control-label">Nama Aset</label>
                                                <div class="col-sm-9">
                                                    <input name="nama" type="text" class="form-control" id="nama" placeholder="Nama Aset" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga" class="col-sm-3 control-label">Harga</label>
                                                <div class="col-sm-9">
                                                    <input name="harga" type="text" class="form-control" id="harga" style="text-align:right" value="0.00" placeholder="0.00" onkeyup="susut()">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="bulansusut" class="col-sm-3 control-label">Bulan Penyusutan</label>
                                                <div class="col-sm-9">
                                                    <div class="spinner input-group">
                                                        <input name="bulan_penyusutan" type="text" class="form-control input-sm spinner-input" id="bulansusut" value="0" placeholder="0" onkeyup="susut()">
                                                        <span class="input-group-addon">Bulan</span>
                                                        <div class="spinner-buttons input-group-btn">
                                                            <button type="button" onclick="susut()" class="btn btn-warning btn-sm spinner-down">
                                                                <i class="ti-minus"></i>
                                                            </button>
                                                            <button type="button" onclick="susut()" class="btn btn-success btn-sm spinner-up">
                                                                <i class="ti-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="penyusutan" class="col-sm-3 control-label">Penyusutan</label>
                                                <div class="col-sm-9">
                                                    <input name="penyusutan" type="text" class="form-control" id="penyusutan" style="text-align:right" value="0.00" placeholder="0.00" readonly>
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
                                                            <option style="width: 100%" value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-aset" class="col-sm-3 control-label">Akun Aset</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_aset" style="width:100%;" id="akun-aset" data-placeholder="Pilih Akun Aset" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-biaya" class="col-sm-3 control-label">Akun Biaya Penyusutan</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_biaya" style="width:100%;" id="akun-biaya" data-placeholder="Pilih Akun Biaya Penyusutan" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-akumulasi" class="col-sm-3 control-label">Akun Akumulasi Penyusutan</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_akumulasi" style="width:100%;" id="akun-akumulasi" data-placeholder="Pilih Akun Akumulasi Penyusutan" class="form-control" required>
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
                                                <label for="akun-keuntungan" class="col-sm-3 control-label">Akun Keuntungan Aset</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_keuntungan" style="width:100%;" id="akun-keuntungan" data-placeholder="Pilih Akun Keuntungan Aset" class="form-control" required>
                                                        <!--<option value=""></option>-->
                                                        @foreach($perkiraan as $value)
                                                            <option value="{!! $value->id !!}">{!! $value->kode_akun !!} - {!! $value->nama_akun !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="akun-kerugian" class="col-sm-3 control-label">Akun Kerugian Aset</label>
                                                <div class="col-sm-9">
                                                    <select name="akun_kerugian" style="width:100%;" id="akun-kerugian" data-placeholder="Pilih Akun Kerugian Aset" class="form-control" required>
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
                                        <a href="{!! url('akuntansi/penyusutan') !!}" class="btn btn-danger btn-block">Cancel</a>
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
        $('#harga').maskMoney();
        $('#penyusutan').maskMoney();

        $("select").removeAttr('class');
        $("select").select2();

        $('#btnsave').on('click', function() {
            if ($('#kode').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kode Aset</h4>');
                $('#mess').html('<p id="mess">Kode Aset tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#nama').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama Aset</h4>');
                $('#mess').html('<p id="mess">Nama Aset tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            }  else {
                $.ajax({
                    url: "{!! url('akuntansi/penyusutan/cekjurnal') !!}",
                    data: {},
                    dataType: "json",
                    type: "get",
                    success:function(data)
                    {
                        if (data[0]["stat"] == "FAIL") {
                            var judul = data[0]["title"];
                            var pesan = data[0]["psg"];
                            $('#judul').html("<h4 class='modal-title' id=''judul'>" + judul + "</h4>");
                            $('#mess').html("<p id='mess'>" + pesan + "<p>");
                            $('#rejectModal').modal();
                        } else {
                            FunctionLoading();
                            $('#fas').submit();
                        }
                    }

                });
            }

        });

        function validAngka(a)
        {
            if(!/^[0-9.]+$/.test(a.value))
            {
                a.value = a.value.substring(0,a.value.length-1000);
            }
        }

        function susut() {
            $.ajax({
                url: "{!! url('akuntansi/penyusutan/ajax') !!}/" + $('#bulansusut').val() + "/" + $('#harga').val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#penyusutan').val(data[0]["susut"]);
                }

            });
        }
    </script>
@stop
