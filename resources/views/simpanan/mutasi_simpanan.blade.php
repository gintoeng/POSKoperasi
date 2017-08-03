@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Simpanan</a>
        </li>
        <li class="active">Mutasi Simpanan</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal" role="form" method="post">
                                <div class="form-group">
                                    <label for="nomor_simpanan" class="col-sm-2 control-label">Nomor Simpanan</label>
                                    <div class="col-sm-6">
                                        <select name="nomor_simpanan" class="form-control" style="width:100%;" id="nomor_simpanan" data-placeholder="Pilih Nomor Simpanan">
                                            <option value=""></option>
                                            @foreach($simpanan as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nomor_simpanan !!} - {!! $value->anggotaid->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_simpanan2" class="col-sm-2 control-label">NPK</label>
                                    <div class="col-sm-6">
                                        <select name="nomor_simpanan2" class="form-control" style="width:100%;" id="nomor_simpanan2" data-placeholder="Pilih NPK">
                                            <option value=""></option>
                                            @foreach($simpanan as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nomor_simpanan !!} - {!! $value->anggotaid->npk !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_anggota" class="col-sm-2 control-label">Nama Anggota</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="nama_anggota" value="" class="form-control" id="nama_anggota" placeholder="Nama Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_anggota" class="col-sm-2 control-label">Alamat Anggota</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="alamat_anggota" value="" class="form-control" id="alamat_anggota" placeholder="Alamat Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group" id="search_form">
                                    <label for="datepicker" class="col-sm-2 control-label">Tanggal</label>
                                    <div class="col-md-6">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input id="datefrom" type="text" class="input-sm form-control datepicker" name="datefrom" value="{!! $datefrom !!}"/>
                                            <span class="input-group-addon">to</span>
                                            <input id="dateto" type="text" class="input-sm form-control datepicker" name="dateto" value="{!! $dateto !!}"/>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="cari" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="cari" value="1">
                                        <button id="sub" type="submit" class="btn btn-sm btn-primary"><i class="ti-search mr5"></i>Cari</button>
                                    </div>
                                </div>-->
                            </form>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6">
                            <a id="pdf" target="_blank" class="btn btn-sm btn-danger mb5"><i class="fa fa-file-pdf-o mr5"></i>PDF</a>
                            <a id="cetak" target="_blank" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
                        </div>
                    </div>
                    <div class="pull-right" id="jml">
                        Total data ditemukan : 0
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mg-t editable-datatable" id="table">
                            <thead>
                            <tr class="bg-color">
                                <th class="text-center">No</th>
                                <th class="text-center">No.Transaksi</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">NPK</th>
                                <th class="text-center">Kode Anggota</th>
                                <th class="text-center">Tipe</th>
                                <th class="text-center">Info</th>
                                <th class="text-right">Debet</th>
                                <th class="text-right">Kredit</th>
                                <th class="text-right">Saldo</th>
                                <th class="text-center">Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-center"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="judul">Pilih Nomor Simpanan</h4>
                </div>
                <div class="modal-body">
                    <p id="mess">Nomor Simpanan harus diisi lebih dulu</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#nomor_simpanan").removeAttr('class');
        $("#nomor_simpanan").select2();

        $("#nomor_simpanan2").removeAttr('class');
        $("#nomor_simpanan2").select2();

        $('#nomor_simpanan').on('change', function () {
            $.ajax({
                url: "{!! url('simpanan/transaksi/ajax/') !!}/" + $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#nama_anggota').val(data[0]["nama"]);
                    $('#alamat_anggota').val(data[0]["alamat"]);
                }

            });

            document.getElementById("nomor_simpanan2").value = $(this).val();

            $("#nomor_simpanan").removeAttr('class');
            $("#nomor_simpanan").select2();

            $("#nomor_simpanan2").removeAttr('class');
            $("#nomor_simpanan2").select2();
            var df = $('#datefrom').val();
            var dt = $('#dateto').val();
            df = df.split('/');
            dt = dt.split('/');
            var dfrom = df[2] + "-" + df[0] + "-" + df[1];
            var dto = dt[2] + "-" + dt[0] + "-" + dt[1];

            $('#table').load("{!! url('simpanan/mutasi/search') !!}/"+ $(this).val() + "/" + dfrom + "/" + dto);
            $('#jml').load("{!! url('simpanan/mutasi/search2') !!}/"+ $(this).val() + "/" + dfrom + "/" + dto);
        });

        $('#nomor_simpanan2').on('change', function () {
            $.ajax({
                url: "{!! url('simpanan/transaksi/ajax/') !!}/" + $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#nama_anggota').val(data[0]["nama"]);
                    $('#alamat_anggota').val(data[0]["alamat"]);
                }

            });

            document.getElementById("nomor_simpanan").value = $(this).val();
            $("#nomor_simpanan").removeAttr('class');
            $("#nomor_simpanan").select2();

            $("#nomor_simpanan2").removeAttr('class');
            $("#nomor_simpanan2").select2();
            var df = $('#datefrom').val();
            var dt = $('#dateto').val();
            df = df.split('/');
            dt = dt.split('/');
            var dfrom = df[2] + "-" + df[0] + "-" + df[1];
            var dto = dt[2] + "-" + dt[0] + "-" + dt[1];

            $('#table').load("{!! url('simpanan/mutasi/search') !!}/"+ $(this).val() + "/" + dfrom + "/" + dto);
            $('#jml').load("{!! url('simpanan/mutasi/search2') !!}/"+ $(this).val() + "/" + dfrom + "/" + dto);
        });

        $('#datefrom').on('change', function () {
            var df = $('#datefrom').val();
            var dt = $('#dateto').val();
            df = df.split('/');
            dt = dt.split('/');
            var dfrom = df[2] + "-" + df[0] + "-" + df[1];
            var dto = dt[2] + "-" + dt[0] + "-" + dt[1];
            $('#table').load("{!! url('simpanan/mutasi/search') !!}/"+ $('#nomor_simpanan').val() + "/" + dfrom + "/" + dto);
        });

        $('#dateto').on('change', function () {
            var df = $('#datefrom').val();
            var dt = $('#dateto').val();
            df = df.split('/');
            dt = dt.split('/');
            var dfrom = df[2] + "-" + df[0] + "-" + df[1];
            var dto = dt[2] + "-" + dt[0] + "-" + dt[1];
            $('#table').load("{!! url('simpanan/mutasi/search') !!}/"+ $('#nomor_simpanan').val() + "/" + dfrom + "/" + dto);
        });

        $('#cetak').on('click', function() {
           if ($('#nomor_simpanan').val() == "") {

               $('#rejectModal').modal();
           } 
           else 
           {
               var df = $('#datefrom').val();
               var dt = $('#dateto').val();
               df = df.split('/');
               dt = dt.split('/');
               var dfrom = df[2] + "-" + df[0] + "-" + df[1];
               var dto = dt[2] + "-" + dt[0] + "-" + dt[1];

               window.open("{!! url('simpanan/mutasi/cetak') !!}/" + $('#nomor_simpanan').val() + "/" + dfrom + "/" + dto + "/print");
           }
        });

        $('#pdf').on('click', function() {
            if ($('#nomor_simpanan').val() == "") {

                $('#rejectModal').modal();

            } 
            else 
            {
                var df = $('#datefrom').val();
                var dt = $('#dateto').val();
                df = df.split('/');
                dt = dt.split('/');
                var dfrom = df[2] + "-" + df[0] + "-" + df[1];
                var dto = dt[2] + "-" + dt[0] + "-" + dt[1];

                window.open("{!! url('simpanan/mutasi/cetak') !!}/" + $('#nomor_simpanan').val() + "/" + dfrom + "/" + dto + "/pdf");
            }
        });

    </script>

@stop
