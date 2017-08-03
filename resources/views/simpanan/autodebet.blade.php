@extends('layouts.master')

@section('content')

    <style>
        #table-wrapper {
            position:relative;
        }
        #table-scroll {
            height:750px;
            overflow:auto;
            margin-top:20px;
        }
        #table-wrapper table {
            width:100%;

        }

        #table-wrapper table thead th .text {
            position:absolute;
            top:-20px;
            z-index:2;
            height:20px;
            width:35%;
            border:1px solid red;
        }
    </style>

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Akuntansi</a>
        </li>
        <li class="active">Autodebet Simpanan</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    @if(session('alert'))
                        <br/><br/>
                        {!! session('alert') !!}
                    @endif
                    <input type="hidden" value="{!! $mod !!}" id="mod">
                    <form method="post" action="{!! url('akuntansi/autodebet/simpanan') !!}" id="fauto" enctype="multipart/form-data">
                        <section class="panel">
                            <!-- <header class="panel-heading">Test Panel</header>-->
                            <div class="panel-body">
                                <center><font size="5">AUTODEBET</font></center>
                                <br><br/>
                                <div class="alert alert-info">
                                    <br>
                                    <p>AUTODEBET berfungsi untuk memotong : </p>
                                    <br>
                                    <p>Saldo tabungan CUSTOMER yang berada di BANK.Proses ini dapat dilakukan sebulan sekali</p>
                                    <p>Apabila ingin diulangi maka anda dapat melakukan Proses ini kembali.</p>
                                    <br>
                                    <p>AUTODEBET ini akan tercatat pada tanggal terakhir pada bulan yang diproses.</p>
                                    <br>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="shu" class="col-sm-2 control-label">SHU</label>
                                    <div class="col-sm-9">
                                        <select name="shu" style="width:100%;" id="shu" data-placeholder="Pilih SHU"  class="form-control" required>
                                            {{--<option value=""></option>--}}
                                            @foreach($shu as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br><br/>
                                <div class="form-group">
                                    <label for="shu" class="col-sm-2 control-label">Tanggal</label>
                                    <div class="col-sm-4">
                                        <select name="bulan" type="text" class="form-control chosen" id="bulan" placeholder="Bulan" style="width: 100%" required>
                                            <option value="01" {!! $bln == "01" ? 'selected' : '' !!}>Januari</option>
                                            <option value="02" {!! $bln == "02" ? 'selected' : '' !!}>Februari</option>
                                            <option value="03" {!! $bln == "03" ? 'selected' : '' !!}>Maret</option>
                                            <option value="04" {!! $bln == "04" ? 'selected' : '' !!}>April</option>
                                            <option value="05" {!! $bln == "05" ? 'selected' : '' !!}>Mei</option>
                                            <option value="06" {!! $bln == "06" ? 'selected' : '' !!}>Juni</option>
                                            <option value="07" {!! $bln == "07" ? 'selected' : '' !!}>Juli</option>
                                            <option value="08" {!! $bln == "08" ? 'selected' : '' !!}>Agustus</option>
                                            <option value="09" {!! $bln == "09" ? 'selected' : '' !!}>September</option>
                                            <option value="10" {!! $bln == "10" ? 'selected' : '' !!}>Oktober</option>
                                            <option value="11" {!! $bln == "11" ? 'selected' : '' !!}>November</option>
                                            <option value="12" {!! $bln == "12" ? 'selected' : '' !!}>Desember</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="spinner input-group">
                                            <input name="tahun" type="text" class="form-control input-sm spinner-input" id="tahun" placeholder="Tahun" value="{!! $th !!}" required>
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
                                    <div class="col-sm-2"></div>
                                </div>
                                <br><br/>
                                <div class="form-group">
                                    <label for="tgl" class="col-sm-2 control-label">Periode</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input name="dari" type="text" class="form-control datepicker" id="dari" value="01/01/2015">
                                            <span class="input-group-addon">s/d</span>
                                            <input name="ke" type="text" class="form-control datepicker" id="ke" value="{!! $today !!}">
                                        </div>
                                    </div>
                                </div>
                                <br><br/>
                                <div class="form-group">
                                    <label for="shu" class="col-sm-2 control-label">File</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="file" name="excelauto" id="file" required>
                                    </div>
                                    <div class="col-lg-2"></div>
                                </div>
                                <br><br/><hr>
                                <div class="form-group">
                                    <div class="col-sm-1"></div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="col-sm-5">
                                        <button id="btndown" type="button" class="btn btn-color btn-block btn-lg"><font size="3"><i class="fa fa-download"> Download</i></font></button>
                                    </div>
                                    <div class="col-sm-5">
                                        <button id="btnsub" type="button" class="btn btn-primary btn-block btn-lg"><font size="3"><i class="fa fa-upload"> Upload</i></font></button>
                                    </div>
                                    <div class="col-sm-1"></div>
                                </div>
                                <br><br>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-2 pull-left">
                                        <a href="javascript:void(0)" id="btnlihat" class="btn btn-success btn-block">Lihat</a>
                                    </div>
                                    <div class="col-lg-6"></div>
                                    <div class="col-sm-2 pull-right">
                                        <a href="{!! url('/') !!}" id="cancel" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" style="height: 100%">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="judul">AUTODEBET</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_simulasi" class="col-sm-3 control-label">SHU&nbsp;&nbsp;&nbsp;:</label>
                                <div class="col-sm-9">
                                    <label id="shunya" class="col-sm-12 control-label"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-12 control-label text-right">{{$tgl}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="table-wrapper">
                            <div class="table-responsive no-border" id="table-scroll">
                                <table id="tabauto" class="table table-bordered table-striped no-m scroll">
                                    <thead>
                                    <tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">
                                        <th class="text-center" width="50">No.</th>
                                        <th class="text-center">Simpanan</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Debet</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody id="bodyauto" style="overflow-y: scroll;height: 700px;width: auto;position: absolute;">
                                    <?php $i = 1; ?>
                                    @foreach($auto as $tampil)
                                        <tr style="width: 100%;display: inline-table;table-layout: fixed;">
                                            <td class="text-center" width="50">{!! $i++ !!}</td>
                                            <td>{!! $tampil->simpananid->nomor_simpanan !!}</td>
                                            <td>{!! $tampil->simpananid->anggotaid->nama !!}</td>
                                            <td class="text-right">{!! number_format($tampil->debet, 2, '.', ',') !!}</td>
                                            <td class="text-center text-{!! $tampil->debet ==  "0" ? 'danger' : 'primary' !!}">{!! $tampil->debet ==  "0" ? 'GAGAL' : 'SUKSES'!!}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-2 pull-left">
                        <button type="button" onclick="cetak('auto')" id="btncetakauto" class="btn btn-success"><i class="ti-printer"> Cetak</i></button>
                    </div>
                    <div class="col-md-10 pull-right">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="judulll">Proses Simpanan</h4>
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

    <script>
        $('#btnlihat').on('click', function() {
            $.ajax({
                url: "{!! url('akuntansi/autodebet/cekshu') !!}/" + $('#shu').val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#shunya').html('<label id="shunya" class="col-sm-12 control-label">'+ data[0]["shuname"] +'</label>');
                }

            });
            $('#tabauto').load("{!! url('akuntansi/autodebet/simpanan/show') !!}/" + $('#bulan').val() + "/" + $('#tahun').val()  + "/" + $('#shu').val());
            $("#rejectModal").modal();
        });

        function cetak(cce) {
            window.open("{!! url('akuntansi/autodebet/simpanan/cetak') !!}/" + $('#bulan').val() + "/" + $('#tahun').val());
        }

        if ($('#mod').val() == "mod") {
            $("#rejectModal").modal();
        }

        $("#bulan").removeAttr('class');
        $("#bulan").select2();

        $("#shu").removeAttr('class');
        $("#shu").select2();

        $('#btnsub').on('click', function() {
            $.ajax({
                url: "{!! url('akuntansi/autodebet/simpanan/cek') !!}",
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    if (data[0]["stat"] == "FAIL") {
                        var judul = data[0]["title"];
                        var pesan = data[0]["psg"];
                        $('#judulll').html("<h4 class='modal-title' id='judulll'>" + judul + "</h4>");
                        $('#mess').html("<p id='mess'>" + pesan + "<p>");
                        $('#reModal').modal();
                    } else {
                        if ($('#file').val() == "") {

                            $('#judulll').html("<h4 class='modal-title' id='judulll'>File</h4>");
                            $('#mess').html("<p id='mess'>File Tidak Boleh Kosong<p>");
                            $('#reModal').modal();
                        } else {
                            FunctionLoading();
                            $('#fauto').submit();
                        }
                    }
                }

            });
        });

        $('#btndown').on('click', function () {
            var shu = $('#shu').val();
            var convertDate = function(usDate) {
                var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
                return dateParts[3] + "-" + dateParts[1] + "-" + dateParts[2];
            };

            var df = convertDate($('#dari').val());
            var dt = convertDate($('#ke').val());

            var b = $('#bulan').val();
            var t = $('#tahun').val();

            if ($('#shu').val() == "") {
                $('#judulll').html("<h4 class='modal-title' id='judulll'>SHU</h4>");
                $('#mess').html("<p id='mess'>SHU Tidak Boleh Kosong<p>");
                $('#reModal').modal();
            } else {
                location.href = "{!! url('akuntansi/autodebet/simpanan/download') !!}/" + b + "/" + t + "/" + shu + "/" + df + "/" + dt;
            }
        });
    </script>

@stop
