@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="{!! url('pinjaman') !!}">Pinjaman</a>
        </li>
        <li class="active">Realisasi Pinjaman</li>
    </ol>
    <div class="row hide" id="psimulasi">
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-heading">
                    <h3 class="text-center">SIMULASI</h3>
                </div>
                <div id="simulasi" class="panel-body"></div>
                <div class="panel-footer">
                    <a href="javascript:void(0)" id="btnclose" class="btn btn-danger">Close</a>
                </div>
            </section>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('pinjaman/realisasi') !!}" id="freal">
                        <input type="hidden" name="id_pinjaman" id="id_pinjaman">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nomor_pinjaman" class="col-sm-3 control-label">Nomor Pinjaman</label>
                                    <div class="col-sm-9">
                                        <select name="nomor_pinjaman" style="width: 100%;" type="text" class="chosen" id="nomor_pinjaman" data-placeholder="Pilih Nomor Pinjaman">
                                            <option value=""></option>
                                            @foreach($pinjaman as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nomor_pinjaman !!} - {!! $value->anggotaid->nama !!} ( {!! $value->kolektibilitasid->kode !!} )</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_pinjaman" class="col-sm-3 control-label">Jenis Pinjaman</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="jenis_pinjaman" placeholder="Jenis Pinjaman" readonly>
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
                                    <label for="jumlah_pengajuan" class="col-sm-3 control-label">Jumlah Pengajuan</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="jumlah_pengajuan" type="text" class="form-control right" id="jumlah_pengajuan" style="text-align:right" placeholder="0.00" value="0.00" readonly>
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_pengajuan" class="col-sm-3 control-label">Tanggal Pengajuan</label>
                                    <div class="col-sm-9">
                                        <input name="tanggal_pengajuan" type="date" class="form-control datepicker" id="tanggal_pengajuan" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_realisasi" class="col-sm-3 control-label">Tanggal Realisasi</label>
                                    <div class="col-sm-9">
                                        <input name="tanggal_realisasi" type="date" class="form-control datepicker" id="tanggal_realisasi" value="{!! $today !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jatuh_tempo" class="col-sm-3 control-label">Jatuh Tempo</label>
                                    <div class="col-sm-9">
                                        <input name="jatuh_tempo" type="date" class="form-control datepicker" id="jatuh_tempo" value="{!! $today !!}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="suku_bunga" class="col-sm-3 control-label">Suku Bunga</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="suku_bunga" type="text" class="form-control right" id="suku_bunga" style="text-align:right" placeholder="Suku Bunga" value="0" readonly>
                                            <span class="input-group-addon">% PA</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jangka_waktu" class="col-sm-3 control-label">Jangka Waktu</label>
                                    <div class="col-sm-9">
                                        <div class="spinner input-group" id="nomor_kredit">
                                            <input name="jangka_waktu" onchange="minmax()" value="0" type="text" class="form-control input-sm spinner-input" id="jangka_waktu" placeholder="Jangka Waktu">
                                            <span class="input-group-addon">Bulan</span>
                                            <div class="spinner-buttons input-group-btn">
                                                <button type="button" onclick="minmax()" class="btn btn-warning btn-sm spinner-down">
                                                    <i class="ti-minus"></i>
                                                </button>
                                                <button type="button" onclick="minmax()" class="btn btn-success btn-sm spinner-up">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="form-group">
                                    <label for="realisasi" class="col-sm-3 control-label">Realisasi</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="realisasi" onkeyup="realhitung()" type="text" class="form-control right" id="realisasi" style="text-align:right" placeholder="0.00" value="0.00">
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="biaya_administrasi" class="col-sm-3 control-label">Biaya Administrasi</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="biaya_administrasi" onkeyup="realhitung()" type="text" class="form-control right" id="biaya_administrasi" style="text-align:right" placeholder="0.00" value="0.00" readonly>
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="biaya_administrasi_bank" class="col-sm-3 control-label">Biaya Administrasi Bank</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="biaya_administrasi_bank" onkeyup="realhitung()" type="text" class="form-control right" id="biaya_administrasi_bank" style="text-align:right" placeholder="0.00" value="0.00" readonly>
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="biaya_administrasi_tambahan" class="col-sm-3 control-label">Biaya Administrasi Tambahan</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="biaya_administrasi_tambahan" onkeyup="realhitung()" type="text" class="form-control right" id="biaya_administrasi_tambahan" style="text-align:right" placeholder="0.00" value="0.00" readonly>
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="biaya_provinsi" class="col-sm-3 control-label">Biaya Provisi</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="biaya_provinsi" onkeyup="realhitung()" type="text" class="form-control right" id="biaya_provinsi" style="text-align:right" placeholder="0.00" value="0.00">
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="biaya_lain" class="col-sm-3 control-label">Biaya Lain-Lain</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="biaya_lain" onkeyup="realhitung()" type="text" class="form-control right" id="biaya_lain" style="text-align:right" placeholder="0.00" value="0.00">
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="uang_diterima" class="col-sm-3 control-label">Uang Diterima</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="uang_diterima" type="text" class="form-control right" id="uang_diterima" style="text-align:right" placeholder="Uang Diterima" value="0.00" readonly>
                                            <span class="input-group-addon">,-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="angsuran" class="col-sm-3 control-label">Angsuran</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input name="angsuran" type="text" class="form-control right" id="angsuran" style="text-align:right" placeholder="0.00" value="0.00" readonly>
                                            <span class="input-group-addon">,-</span>
                                            <input type="hidden" id="angsur" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input name="keterangan" type="text" class="form-control" id="keterangan" placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="hidden" name="sisbungaid" id="sisbungaid" value="">
                                    <label for="sisbunga" class="col-sm-3 control-label">Sistem Bunga</label>
                                    <div class="col-sm-9">
                                        <input name="sistem_bunga" id="sisbunga" type="text" class="form-control" placeholder="Sistem Bunga" readonly>
                                    </div>
                                </div>
                                <br>
                                <section class="panel panel-success">
                                    <header class="panel-heading" style="background-color: #00ae00; color: white">Jaminan</header>
                                    <div class="panel-body">
                                        <table class="table table-hover" id="tjamin">

                                        </table>
                                    </div>
                                </section>
                                <section class="panel panel-warning">
                                    <header class="panel-heading" style="background-color: #f24400; color: white">Keterangan</header>
                                    <div class="panel-body">
                                        <table class="table table-hover" id="tket">

                                        </table>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <input id="btns" type="button" class="btn btn-primary btn-block" name="save" value="Save">
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:void(0)" id="btnsimulasi" class="btn btn-success btn-block">Simulasi</a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('/') !!}" class="btn btn-danger btn-block">Cancel</a>
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
                    <p id="mess">Pilih nomor pinjaman terlebih dahulu untuk melihat simulasi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="simulasiModal" tabindex="-1" role="dialog" aria-labelledby="simulasiModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Simulasi Pembayaran</h4>
                </div>
                <div class="modal-body">
                    <div class="row"'>
                        <div class="col-sm-12">
                            <input type="hidden" name="id_simulasi" id="id_simulasi">
                            <div class="form-group" style="margin-bottom:50px">
                                <label for="nama_simulasi" class="col-sm-2 control-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nama" class="form-control" id="nama_simulasi" readonly>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:50px">
                                <label for="sistem_bungasim" class="col-sm-2 control-label">Sistem Bunga</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="sistem_bungasim" id="sistem_bungasim" readonly>
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label for="sistem_bunga" class="col-sm-2 control-label">Sistem Bunga</label>--}}
                                {{--<div class="col-sm-10">--}}
                                    {{--<select class="form-control" name="sistem_bunga" id="sistem_bunga" style="width: 100%">--}}
                                        {{--<option value="">Pilih Sistem Bunga</option>--}}
                                        {{--@foreach($sistem_bunga as $value)--}}
                                            {{--<option value="{{ $value->id }}">{{ $value->sistem }}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="row">
                                <div class="col-xs-4 col-sm-6">
                                    <div class="form-group" style="margin-top:15px">
                                        <label for="bunga_simulasi" class="col-sm-5 control-label">Suku Bunga</label>
                                        <div class="input-group">
                                            <input name="suku_bunga" type="text" class="form-control right" id="bunga_simulasi" style="text-align:right" readonly="">
                                            <span class="input-group-addon">% PA</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="jangkawaktu_simulasi" class="col-sm-5 control-label">Jangka Waktu</label>
                                        <div class="input-group">
                                            <input name="jangka_waktu" type="text" class="form-control right" id="jangkawaktu_simulasi" style="text-align:right" readonly="">
                                            <span class="input-group-addon">BULAN</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="jmlpengajuan_simulasi" class="col-sm-4 control-label">Jml Pengajuan</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="jumlah_pengajuan" class="form-control" id="jmlpengajuan_simulasi" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-6">
                                    <div class="form-group" style="margin-top:15px">
                                        <label for="tgl_pengajuan" class="col-sm-4 control-label">Tgl Pengajuan</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="tgl_pengajuan" class="form-control" id="tgl_pengajuan" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-top:65px">
                                        <label for="jth_tempo" class="col-sm-4 control-label">Jatuh Tempo</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="jatuh_tempo" class="form-control" id="jth_tempo" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-top:115px">
                                        <label for="angsuran_simulasi" class="col-sm-4 control-label">Angsuran</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="angsuran_simulasi" class="form-control" id="angsuran_simulasi" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px">
                        <div class="col-md-12">
                            <div class="table-responsive no-border" id="table-simulasi">
                                <table class="table table-bordered table-striped no-m">
                                    <thead>
                                    <tr class="bg-color">
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Saldo</th>
                                        <th class="text-center">Pokok</th>
                                        <th class="text-center">Bunga</th>
                                        <th class="text-center">Angsuran</th>
                                    </tr>
                                    </thead>
                                    <tbody id="bodybunga">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#btns').on('click', function() {
            if ($('#nomor_pinjaman').val()=='') {
                $('#mtest').html('<p id="mess">Pilih nomor pinjaman terlebih dahulu untuk Save.</p>');
                $('#rejectModal').modal();
            }else {
                $.ajax({
                    url: "{!! url('pinjaman/realisasi/cek') !!}",
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
                            $('#freal').submit();
                        }
                    }

                });
                FunctionLoading();
                $('#freal').submit();
            }
        });

        $('#jumlah_pengajuan').maskMoney();
        $('#realisasi').maskMoney();
        $('#biaya_administrasi').maskMoney();
        $('#biaya_provinsi').maskMoney();
        $('#biaya_lain').maskMoney();
        $('#uang_diterima').maskMoney();
        $('#angsuran').maskMoney();

        $("#sistem_bunga").removeAttr('class');
        $("#sistem_bunga").select2();

        $('#btnsimulasi').on('click', function(){
          if ($('#nomor_pinjaman').val()=='') {
            $('#rejectModal').modal();
          }

          else {
            $('.bungatr').remove();
            $('#id_simulasi').val($('#id_pinjaman').val());
            $('#nama_simulasi').val($('#nama_anggota').val());
            $('#bunga_simulasi').val($('#suku_bunga').val());
            $('#jangkawaktu_simulasi').val($('#jangka_waktu').val());
//            $('#jmlpengajuan_simulasi').val($('#jumlah_pengajuan').val());
            $('#jmlpengajuan_simulasi').val($('#realisasi').val());
            $('#tgl_pengajuan').val($('#tanggal_pengajuan').val());
            $('#jth_tempo').val($('#jatuh_tempo').val());
            $('#angsuran_simulasi').val($('#angsuran').val());
              $('#sistem_bungasim').val($('#sisbunga').val());
            $('#simulasiModal').modal();
              $.ajax({
                  url: "{{ url('pinjaman/sistembunga') }}/"+$('#sisbungaid').val()+"/"+$('#id_simulasi').val()+"/"+$('#realisasi').val(),
                  data: {},
                  type: "get",
                  success:function(data)
                  {
                      $('#bodybunga').html($('#bodybunga').html()+data);
                  }
              });
          }
        })

        function minmax() {
            var formData = {
                'jml'   : $('#realisasi').val(),
                'waktu' : $('#jangka_waktu').val(),
                'idp'   : $('#nomor_pinjaman').val()
            };

            $.ajax({
                url: "{!! url('pinjaman/real/ajax') !!}",
                data: formData,
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#angsuran').val(data[0]["angsuran"]);
                    $('#jangka_waktu').val(data[0]["hs"]);
                }
            });
        }

        function realhitung() {
            var formData = {
                'waktu' : $('#jangka_waktu').val(),
                'real'  : $('#realisasi').val(),
                'ad'    : $('#biaya_administrasi').val(),
                'adb'    : $('#biaya_administrasi_bank').val(),
                'adt'    : $('#biaya_administrasi_tambahan').val(),
                'pro'   : $('#biaya_provinsi').val(),
                'lain'  : $('#biaya_lain').val(),
                'ud'    : $('#uang_diterima').val(),
                'idp'   : $('#nomor_pinjaman').val()
            };

            $.ajax({
                url: "{!! url('pinjaman/biaya/ajax') !!}",
                data: formData,
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#uang_diterima').val(data[0]["uangd"]);
                    $('#realisasi').val(data[0]["uangr"]);
                    $('#angsuran').val(data[0]["angsuran"]);
                    $('#jangka_waktu').val(data[0]["hs"]);
                }
            });
        }

        $('#nomor_pinjaman').on('change', function () {
            $.ajax({
                url: "{!! url('pinjaman/realisasi/ajax/') !!}/" + $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#id_pinjaman').val(data[0]["id"]);
                    $('#jenis_pinjaman').val(data[0]["jenis"]);
                    $('#nama_anggota').val(data[0]["nama"]);
                    $('#alamat_anggota').val(data[0]["alamat"]);
                    $('#jumlah_pengajuan').val(data[0]["jml"]);
                    $('#tanggal_pengajuan').val(data[0]["tgl"]);
                    $('#jatuh_tempo').val(data[0]["tempo"]);
                    $('#realisasi').val(data[0]["realisasi"]);
                    $('#uang_diterima').val(data[0]["diterima"]);
                    $('#suku_bunga').val(data[0]["bunga"]);
                    $('#jangka_waktu').val(data[0]["waktu"]);
                    $('#angsuran').val(data[0]["angsuran"]);
                    $('#sisbunga').val(data[0]["sisbunga"]);
                    $('#sisbungaid').val(data[0]["sisbungaid"]);
                    // $('#akun_kas_bank').val(data[0]["akun"]);
                    $('#jangka_waktu_tipe').text(data[0]["tipe"]);
                    $('#biaya_administrasi').val(data[0]["badmin"]);
                    $('#biaya_administrasi_bank').val(data[0]["badminbank"]);
                    $('#biaya_administrasi_tambahan').val(data[0]["badmintambah"]);

                }

            });
            $('#tjamin').load("{!! url('pinjaman/realisasi/tjamin') !!}/" + $(this).val());
            $('#tket').html('<table class="table table-hover" id="tket"></table>');
        });

        function ket(idj) {
            $('#tket').load("{!! url('pinjaman/realisasi/tket') !!}/" + idj);
        }

        $('#sistem_bunga').on('change',function() {
          if ($(this).val()=='') {
            $('.bungatr').remove();
          }

          else {
            $('.bungatr').remove();
            $.ajax({
              url: "{{ url('pinjaman/sistembunga') }}/"+$(this).val()+"/"+$('#id_simulasi').val()+"/"+$('#realisasi').val(),
              data: {},
              type: "get",
              success:function(data)
              {
                $('#bodybunga').html($('#bodybunga').html()+data);
              }
            });
          }
        });

    </script>
@stop
