@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pengaturan</a>
        </li>
        <li><a href="{!! url('pengaturan/nomor') !!}">Daftar Nomor</a></li>
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
                    <form role="form" class="form-horizontal" method="post" action="{!! url('pengaturan/nomor') !!}" id="fnom">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="modul" class="col-sm-1 control-label">Modul</label>
                                    <div class="col-sm-5">
                                        <select name="modul" class="form-control" id="modul" style="width: 100%" data-placeholder="Pilih Modul">
                                            <option value=""></option>
                                            <option value="Master Customer">Master Customer</option>
                                            <option value="Master Vendor">Master Vendor</option>
                                            <option value="Simpanan">Simpanan</option>
                                            <option value="Pinjaman">Pinjaman</option>
                                            <option value="Kas Masuk">Kas Masuk</option>
                                            <option value="Kas Keluar">Kas Keluar</option>
                                            <option value="Kas Transfer">Kas Transfer</option>
                                            <option value="Jurnal Manual">Jurnal Manual</option>
                                            <option value="Jurnal Otomatis">Jurnal Otomatis</option>
                                            <option value="POS">POS</option>
                                            <option value="Saldo Awal Akuntansi">Saldo Awal Akuntansi</option>
                                            <option value="Pembelian Barang Vendor">Pembelian Barang Vendor</option>
                                            <option value="Penerimaan Barang Vendor">Penerimaan Barang Vendor</option>
                                            <option value="Retur Barang Vendor">Retur Barang Vendor</option>
                                            <option value="Pengiriman Barang Cabang">Pengiriman Barang Cabang</option>
                                            <option value="Penerimaan Barang Cabang">Penerimaan Barang Cabang</option>
                                            <option value="Stock Opname">Stock Opname</option>
                                            <option value="Jurnal Transaksi POS">Jurnal Transaksi POS</option>
                                            <option value="Penyusutan Aset">Penyusutan Aset</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group alert-info">
                                    <br>
                                    <label for="kode_awal" class="col-sm-1 control-label">Format</label>
                                    <div class="col-sm-2">
                                        <select name="frmt" class="form-control chosen" id="frmt" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option id="cab" value="kdcab">[KDCAB]</option>
                                            <option value="kode">[KODE]</option>
                                            <option value="digit">[DGT]</option>
                                            <option value="bulan">[BLN]</option>
                                            <option value="tahun">[THN]</option>
                                            <option value="bulantahun">[BLNTHN]</option>
                                            <option value="tahunbulan">[THNBLN]</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <select name="spa" class="form-control chosen" id="spa" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option value="/">/</option>
                                            <option value="-">-</option>
                                            <option value=".">.</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="frmt2" class="form-control chosen" id="frmt2" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option id="cab2" value="kdcab">[KDCAB]</option>
                                            <option value="kode">[KODE]</option>
                                            <option value="digit">[DGT]</option>
                                            <option value="bulan">[BLN]</option>
                                            <option value="tahun">[THN]</option>
                                            <option value="bulantahun">[BLNTHN]</option>
                                            <option value="tahunbulan">[THNBLN]</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <select name="spa2" class="form-control chosen" id="spa2" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option value="/">/</option>
                                            <option value="-">-</option>
                                            <option value=".">.</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="frmt3" class="form-control chosen" id="frmt3" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option id="cab3" value="kdcab">[KDCAB]</option>
                                            <option value="kode">[KODE]</option>
                                            <option value="digit">[DGT]</option>
                                            <option value="bulan">[BLN]</option>
                                            <option value="tahun">[THN]</option>
                                            <option value="bulantahun">[BLNTHN]</option>
                                            <option value="tahunbulan">[THNBLN]</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <select name="spa3" class="form-control chosen" id="spa3" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option value="/">/</option>
                                            <option value="-">-</option>
                                            <option value=".">.</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="frmt4" class="form-control chosen" id="frmt4" style="width: 100%">
                                            <option value=""></option>
                                            <option value=""></option>
                                            <option id="cab4" value="kdcab">[KDCAB]</option>
                                            <option value="kode">[KODE]</option>
                                            <option value="digit">[DGT]</option>
                                            <option value="bulan">[BLN]</option>
                                            <option value="tahun">[THN]</option>
                                            <option value="bulantahun">[BLNTHN]</option>
                                            <option value="tahunbulan">[THNBLN]</option>
                                        </select>
                                    </div>
                                    <hr><br>
                                </div>
                                <br><hr>
                                <div class="form-group">
                                    <label for="kode_awal" class="col-sm-2 control-label">Kode</label>
                                    <div class="col-sm-4">
                                        <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_digit" class="col-sm-2 control-label">Jumlah Digit</label>
                                    <div class="col-sm-4">
                                        <div class="spinner input-group">
                                            <input name="jumlah_digit" type="text" class="form-control input-sm spinner-input" id="jumlah_digit" value="0" placeholder="Jumlah Digit">
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
                                </div>
                                <div class="form-group">
                                    <label for="no_akhir" class="col-sm-2 control-label">No Terakhir</label>
                                    <div class="col-sm-4">
                                        <div class="spinner input-group">
                                            <input name="nomor_akhir" type="text" class="form-control input-sm spinner-input" id="no_akhir" value="0" placeholder="No Terakhir">
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
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="tanggal_lahir" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <input type="button" id="btnsave" class="btn btn-primary btn-block" name="save" value="Save">
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('pengaturan/nomor') !!}" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    @include('pengaturan.nomor.nomor_js')
    @include('master.modal_js')
    <script>
        $('#frmt').hideOption('kdcab');
        $('#frmt2').hideOption('kdcab');
        $('#frmt3').hideOption('kdcab');
        $('#frmt4').hideOption('kdcab');

        $('#btnsave').on('click', function() {
            if ($('#modul').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Modul</h4>');
                $('#mess').html('<p id="mess">Modul tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#kode').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kode</h4>');
                $('#mess').html('<p id="mess">Kode tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#fnom').submit();
            }

        });
    </script>
@stop
