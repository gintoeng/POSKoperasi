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
        <li class="active">Tambah</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    @if(session('msg'))
                        <div class="alert alert-{!! session('msgclass') !!}">
                            {!! session('msg') !!}
                        </div>
                    @endif
                    <br>
                    <form role="form" class="form-horizontal" method="post" action="{!! url('simpanan/transaksi') !!}" id="ftran">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaksi" class="col-sm-3 control-label">Transaksi</label>
                                    <div class="col-sm-9">
                                        <select name="tipe" type="text" class="form-control" id="transaksi" placeholder="Transaksi" style="width: 100%">
                                            <option value="SETOR">Setoran</option>
                                            <option value="TARIK">Penarikan</option>
                                            <option value="TRANSFER">Transfer/Pindah Buku</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_simpanan" class="col-sm-3 control-label">Nomor Simpanan</label>
                                    <div class="col-sm-9">
                                        <select name="nomor_simpanan" style="width: 100%;" type="text" class="chosen" id="nomor_simpanan" data-placeholder="Pilih Nomor Simpanan" required>
                                            <option value=""></option>
                                            @foreach($simpanan as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nomor_simpanan !!} - {!! $value->anggotaid->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_simpanan" class="col-sm-3 control-label">Jenis Simpanan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="jenis_simpanan" placeholder="Jenis Simpanan" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="npk" class="col-sm-3 control-label">NPK</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="npk" placeholder="NPK" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kode_anggota" class="col-sm-3 control-label">Kode Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="kode_anggota" placeholder="Kode Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_anggota" class="col-sm-3 control-label">Nama Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama_anggota" placeholder="Nama Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_anggota" class="col-sm-3 control-label">Alamat Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="alamat_anggota" placeholder="Alamat Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="setoran-bulanan" class="col-sm-3 control-label">Setoran Bulanan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="setoran-bulanan" placeholder="Setoran Bulanan" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="saldo" class="col-sm-3 control-label">Saldo</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="saldo" placeholder="Saldo" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nominal" class="col-sm-3 control-label">Nominal</label>
                                    <div class="col-sm-9">
                                        <input name="nominal" type="text" class="form-control" style="text-align: right" id="nominal" value="0.00" placeholder="0.00">
                                        <input type="hidden" name="akun_kas" id="akun_kas">
                                        <input type="hidden" name="akun_setoran" id="akun_setoran">
                                        <input type="hidden" name="akun_penarikan" id="akun_penarikan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ket" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="ket" name="keterangan" placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 hide" id="transfer">
                                <div class="form-group">
                                    <h3 class="col-sm-4 mb0">Tujuan Transfer</h3>

                                </div>
                                <div class="form-group">
                                    <label for="nomor_simpanan_to" class="col-sm-3 control-label">Nomor Simpanan</label>
                                    <div class="col-sm-9">
                                        <select name="nomor_simpanan_to" style="width: 100%;" class="form-control" id="nomor_simpanan_to" data-placeholder="Pilih Nomor Simpanan" required>
                                            <option value=""></option>
                                            @foreach($simpanan as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nomor_simpanan !!} - {!! $value->anggotaid->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_simpanan_to" class="col-sm-3 control-label">Jenis Simpanan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="jenis_simpanan_to" placeholder="Jenis Simpanan" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="npk_to" class="col-sm-3 control-label">NPK</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="npk_to" placeholder="NPK" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kode_anggota_to" class="col-sm-3 control-label">Kode Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="kode_anggota_to" placeholder="Kode Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_anggota_to" class="col-sm-3 control-label">Nama Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama_anggota_to" placeholder="Nama Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_anggota_to" class="col-sm-3 control-label">Alamat Anggota</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="alamat_anggota_to" placeholder="Alamat Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="setoran-bulanan_to" class="col-sm-3 control-label">Setoran Bulanan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="setoran-bulanan_to" placeholder="Setoran Bulanan" readonly>
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
                                        <input type="button" id="btnsave" class="btn btn-primary btn-block" name="save" value="Save">
                                    </div>
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

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="judul">Pilih nomor pinjaman</h4>
                </div>
                <div class="modal-body">
                    <p id="mess">Anda TIDAK bisa melakukan PENARIKAN atau TRANSFER</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#transaksi").removeAttr('class');
        $("#transaksi").select2();

        $("#nomor_simpanan").removeAttr('class');
        $("#nomor_simpanan").select2();
        $("#nomor_simpanan_to").removeAttr('class');
        $("#nomor_simpanan_to").select2();

        $('#nominal').maskMoney();

        $("#transaksi").change(function  () {
            if($(this).val() == "TRANSFER"){
                $("#transfer").removeClass('hide');
                $("#transfer").show();
            }else{
                $("#transfer").hide();
            }
        });

        $('#nomor_simpanan').on('change', function () {

            var jenis = $('#transaksi').val();
            $.ajax({
                url: "{!! url('simpanan/transaksi/ajax/') !!}/" + $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#jenis_simpanan').val(data[0]["jenis_simpanan"]);
                    $('#nama_anggota').val(data[0]["nama"]);
                    $('#alamat_anggota').val(data[0]["alamat"]);
                    $('#saldo').val(data[0]["saldo"]);
                    $('#akun_kas').val(data[0]["akun_kas"]);
                    $('#akun_setoran').val(data[0]["akun_setoran"]);
                    $('#akun_penarikan').val(data[0]["akun_penarikan"]);
                    $('#nominal').val(data[0]["setoran_minimum"]);
                    $('#npk').val(data[0]["npk"]);
                    $('#kode_anggota').val(data[0]["kode"]);
                    $('#setoran-bulanan').val(data[0]["kode"]);

                    if (data[0]["stat"] == "FAIL") {
                        var judul = data[0]["title"];
                        var pesan = data[0]["psg"];
                        $('#judul').html("<h4 class='modal-title' id=''judul'>" + judul + "</h4>");
                        $('#mess').html("<p id='mess'>" + pesan + "<p>");
                        $('#rejectModal').modal();
                    }
                }

            });
        });

        $('#nomor_simpanan_to').on('change', function () {
            $.ajax({
                url: "{!! url('simpanan/transaksi/ajax/') !!}/" + $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#jenis_simpanan_to').val(data[0]["jenis_simpanan"]);
                    $('#nama_anggota_to').val(data[0]["nama"]);
                    $('#alamat_anggota_to').val(data[0]["alamat"]);
                    $('#npk_to').val(data[0]["npk"]);
                    $('#kode_anggota_to').val(data[0]["kode"]);
                    $('#setoran-bulanan_to').val(data[0]["kode"]);

                    if (data[0]["stat"] == "FAIL") {
                        var judul = data[0]["title"];
                        var pesan = data[0]["psg"];
                        $('#judul').html("<h4 class='modal-title' id=''judul'>" + judul + "</h4>");
                        $('#mess').html("<p id='mess'>" + pesan + "<p>");
                        $('#rejectModal').modal();
                    }
                }

            });
        });

        $('#btnsave').on('click', function() {

            if ($('#nomor_simpanan').val() == "") {
                $('#judul').html("<h4 class='modal-title' id=''judul'>Pilih Nomor Simpanan</h4>");
                $('#mess').html("<p id='mess'>Nomor Simpanan harus diisi lebih dahulu<p>");
                $('#rejectModal').modal();
            }else if ($('#transaksi').val() == "TRANSFER") {
                if ($('#nomor_simpanan_to').val() == "") {
                    $('#judul').html("<h4 class='modal-title' id=''judul'>Pilih Nomor Simpanan</h4>");
                    $('#mess').html("<p id='mess'>Nomor SImpanan yang dituju harus diisi lebih dahulu<p>");
                    $('#rejectModal').modal();
                } else {
                    var no = $('#nomor_simpanan_to').val();
                    $.ajax({
                        url: "{!! url('simpanan/transaksi/cek/') !!}/" + $('#nomor_simpanan').val() + "/" + no + "/" + $('#nominal').val() + "/" + $('#transaksi').val(),
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
                                //alert("VALI");
                                FunctionLoading();
                                $('#ftran').submit();
                            }
                        }

                    });
                }
            } else {
                var no = 0;
                $.ajax({
                    url: "{!! url('simpanan/transaksi/cek/') !!}/" + $('#nomor_simpanan').val() + "/" + no + "/" + $('#nominal').val() + "/" + $('#transaksi').val(),
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
                            //alert("VALI");
                            FunctionLoading();
                            $('#ftran').submit();
                        }
                    }

                });
            }
        });
    </script>

@stop
