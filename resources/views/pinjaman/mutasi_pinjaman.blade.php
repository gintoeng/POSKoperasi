@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pinjaman</a>
        </li>
        <li class="active">Mutasi Pinjaman</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal" role="form" method="post">
                                <div class="form-group">
                                    <label for="nomor_pinjaman" class="col-sm-2 control-label">Nomor Simpanan</label>
                                    <div class="col-sm-6">
                                        <select name="nomor_pinjaman" class="chosen" style="width:100%;" id="nomor_pinjaman" data-placeholder="Pilih Nomor Pinjaman">
                                            <option value=""></option>
                                            @foreach($pinjaman as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nomor_pinjaman !!} - {!! $value->anggotaid->nama !!} ( {!! $value->kolektibilitasid->kode !!} )</option>
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
                                <!--<div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="cari" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-2">
                                        <input type="hidden" name="cari" value="1">
                                        <button id="sub" type="submit" class="btn btn-sm btn-primary"><i class="ti-search mr5"></i>Cari</button>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label for="tgl_realisasi" class="col-sm-2 control-label">Tgl Realisasi</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="tgl_realisasi" value="" class="form-control" id="tgl_realisasi" placeholder="Tanggal Realisasi" readonly>
                                    </div>
                                    <label for="jm_realisasi" class="col-sm-2 control-label">Jml Realisasi</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="jml_realisasi" value="" class="form-control" id="jml_realisasi" placeholder="0.00" style="text-align: right" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6">
                            <a id="cetak" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
                            <a id="pdf" class="btn btn-sm btn-danger mb5"><i class="fa fa-file-pdf-o mr5"></i>PDF</a>
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
                                <th class="text-center">Keterangan</th>
                                <th class="text-right">Pokok</th>
                                <th class="text-right">Bunga</th>
                                <th class="text-right">Denda</th>
                                <th class="text-right">Saldo</th>
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
                                <td align="right"></td>
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
                    <h4 class="modal-title" id="judul">Pilih Nomor Pinjaman</h4>
                </div>
                <div class="modal-body">
                    <p id="mess">Nomor Pinjaman harus diisi lebih dulu</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#nomor_pinjaman').on('change', function () {
            $.ajax({
                url: "{!! url('pinjaman/mutasi/ajax/') !!}/" + $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#nama_anggota').val(data[0]["nama"]);
                    $('#alamat_anggota').val(data[0]["alamat"]);
                    $('#tgl_realisasi').val(data[0]["tglrealisasi"]);
                    $('#jml_realisasi').val(data[0]["realisasi"]);
                }

            });

            $('#table').load("{!! url('pinjaman/mutasi/ajax/table') !!}/"+ $('#nomor_pinjaman').val());
            $('#jml').load("{!! url('pinjaman/mutasi/ajax/table2') !!}/"+ $('#nomor_pinjaman').val());
        });

        $('#cetak').on('click', function() {
            if ($('#nomor_pinjaman').val() == "") {
                $('#rejectModal').modal();
            } else {
                window.open("{!! url('pinjaman/mutasi/cetak') !!}/" + $('#nomor_pinjaman').val() + "/print");
            }
        });

        $('#pdf').on('click', function() {
            if ($('#nomor_pinjaman').val() == "") {
                $('#rejectModal').modal();
            } else {
                window.open("{!! url('pinjaman/mutasi/cetak') !!}/" + $('#nomor_pinjaman').val() + "/pdf");
            }
        });
    </script>

@stop
