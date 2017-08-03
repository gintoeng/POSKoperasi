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
        <li class="active">Ubah</li>
        <li class="active">{!! $nomor->id !!}</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('pengaturan/nomor/'.$nomor->id.'/update') !!}" id="fnomed">
                        <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="modul" class="col-sm-1 control-label">Modul</label>
                                    <div class="col-sm-5">
                                        <select name="modul" class="form-control" id="modul" style="width: 100%" data-placeholder="Pilih modul">
                                            <!--<option value="{!! $nomor->modul !!}">{!! $nomor->modul !!}</option>-->
                                            <option value="Master Customer" {!! $nomor['selected_no1'] !!}>Master Customer</option>
                                            <option value="Master Vendor" {!! $nomor['selected_no10'] !!}>Master Vendor</option>
                                            <option value="Simpanan" {!! $nomor['selected_no2'] !!}>Simpanan</option>
                                            <option value="Pinjaman" {!! $nomor['selected_no3'] !!}>Pinjaman</option>
                                            <option value="Kas Masuk" {!! $nomor['selected_no4'] !!}>Kas Masuk</option>
                                            <option value="Kas Keluar" {!! $nomor['selected_no5'] !!}>Kas Keluar</option>
                                            <option value="Kas Transfer" {!! $nomor['selected_no6'] !!}>Kas Transfer</option>
                                            <option value="Jurnal Manual" {!! $nomor['selected_no7'] !!}>Jurnal Manual</option>
                                            <option value="Jurnal Otomatis" {!! $nomor['selected_no8'] !!}>Jurnal Otomatis</option>
                                            <option value="POS" {!! $nomor['selected_no9'] !!}>POS</option>
                                            <option value="Saldo Awal Akuntansi" {!! $nomor['selected_no11'] !!}>Saldo Awal Akuntansi</option>
                                                <option value="Pembelian Barang Vendor" {!! $nomor['selected_no12'] !!}>Pembelian Barang Vendor</option>
                                                <option value="Penerimaan Barang Vendor" {!! $nomor['selected_no13'] !!}>Penerimaan Barang Vendor</option>
                                                <option value="Retur Barang Vendor" {!! $nomor['selected_no14'] !!}>Retur Barang Vendor</option>
                                                <option value="Pengiriman Barang Cabang" {!! $nomor['selected_no15'] !!}>Pengiriman Barang Cabang</option>
                                                <option value="Penerimaan Barang Cabang" {!! $nomor['selected_no16'] !!}>Penerimaan Barang Cabang</option>
                                                <option value="Stock Opname" {!! $nomor['selected_no17'] !!}>Stock Opname</option>
                                                <option value="Jurnal Transaksi POS" {!! $nomor['selected_no17'] !!}>Jurnal Transaksi POS</option>
                                                <option value="Penyusutan Aset">Penyusutan Aset</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group alert-info">
                                    <br>
                                    <label for="kode_awal" class="col-sm-1 control-label">Format</label>
                                    <div class="col-sm-2">
                                        <select name="frmt" class="form-control" id="frmt" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value="" {!! $nomor->kode_awal == "" ? 'selected' : '' !!}></option>
                                            <option id="cab" value="kdcab" {!! $nomor->kode_awal == "kdcab" ? 'selected' : '' !!}>[KDCAB]</option>
                                            <option value="kode" {!! $nomor->kode_awal == "kode" ? 'selected' : '' !!}>[KODE]</option>
                                            <option value="digit" {!! $nomor->kode_awal == "digit" ? 'selected' : '' !!}>[DGT]</option>
                                            <option value="bulan" {!! $nomor->kode_awal == "bulan" ? 'selected' : '' !!}>[BLN]</option>
                                            <option value="tahun" {!! $nomor->kode_awal == "tahun" ? 'selected' : '' !!}>[THN]</option>
                                            <option value="bulantahun" {!! $nomor->kode_awal == "bulantahun" ? 'selected' : '' !!}>[BLNTHN]</option>
                                            <option value="tahunbulan" {!! $nomor->kode_awal == "tahunbulan" ? 'selected' : '' !!}>[THNBLN]</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <select name="spa" class="form-control" id="spa" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value="" {!! $nomor->pemisah == "" ? 'selected' : '' !!}></option>
                                            <option value="/" {!! $nomor->pemisah == "/" ? 'selected' : '' !!}>/</option>
                                            <option value="-" {!! $nomor->pemisah == "-" ? 'selected' : '' !!}>-</option>
                                            <option value="." {!! $nomor->pemisah == "." ? 'selected' : '' !!}>.</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="frmt2" class="form-control chosen" id="frmt2" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value="" {!! $nomor->kode_awal2 == "" ? 'selected' : '' !!}></option>
                                            <option id="cab2" value="kdcab" {!! $nomor->kode_awal2 == "kdcab" ? 'selected' : '' !!}>[KDCAB]</option>
                                            <option value="kode" {!! $nomor->kode_awal2 == "kode" ? 'selected' : '' !!}>[KODE]</option>
                                            <option value="digit" {!! $nomor->kode_awal2 == "digit" ? 'selected' : '' !!}>[DGT]</option>
                                            <option value="bulan" {!! $nomor->kode_awal2 == "bulan" ? 'selected' : '' !!}>[BLN]</option>
                                            <option value="tahun" {!! $nomor->kode_awal2 == "tahun" ? 'selected' : '' !!}>[THN]</option>
                                            <option value="bulantahun" {!! $nomor->kode_awal2 == "bulantahun" ? 'selected' : '' !!}>[BLNTHN]</option>
                                            <option value="tahunbulan" {!! $nomor->kode_awal2 == "tahunbulan" ? 'selected' : '' !!}>[THNBLN]</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <select name="spa2" class="form-control chosen" id="spa2" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value="" {!! $nomor->pemisah == "" ? 'selected' : '' !!}></option>
                                            <option value="/" {!! $nomor->pemisah2 == "/" ? 'selected' : '' !!}>/</option>
                                            <option value="-" {!! $nomor->pemisah2 == "-" ? 'selected' : '' !!}>-</option>
                                            <option value="." {!! $nomor->pemisah2 == "." ? 'selected' : '' !!}>.</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="frmt3" class="form-control chosen" id="frmt3" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value="" {!! $nomor->kode_awal3 == "" ? 'selected' : '' !!}></option>
                                            <option id="cab3" value="kdcab" {!! $nomor->kode_awal3 == "kdcab" ? 'selected' : '' !!}>[KDCAB]</option>
                                            <option value="kode" {!! $nomor->kode_awal3 == "kode" ? 'selected' : '' !!}>[KODE]</option>
                                            <option value="digit" {!! $nomor->kode_awal3 == "digit" ? 'selected' : '' !!}>[DGT]</option>
                                            <option value="bulan" {!! $nomor->kode_awal3 == "bulan" ? 'selected' : '' !!}>[BLN]</option>
                                            <option value="tahun" {!! $nomor->kode_awal3 == "tahun" ? 'selected' : '' !!}>[THN]</option>
                                            <option value="bulantahun" {!! $nomor->kode_awal3 == "bulantahun" ? 'selected' : '' !!}>[BLNTHN]</option>
                                            <option value="tahunbulan" {!! $nomor->kode_awal3 == "tahunbulan" ? 'selected' : '' !!}>[THNBLN]</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <select name="spa3" class="form-control chosen" id="spa3" style="width: 100%" data-placeholder="">
                                            <option value=""></option>
                                            <option value="" {!! $nomor->pemisah == "" ? 'selected' : '' !!}></option>
                                            <option value="/" {!! $nomor->pemisah3 == "/" ? 'selected' : '' !!}>/</option>
                                            <option value="-" {!! $nomor->pemisah3 == "-" ? 'selected' : '' !!}>-</option>
                                            <option value="." {!! $nomor->pemisah3 == "." ? 'selected' : '' !!}>.</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="frmt4" class="form-control chosen" id="frmt4" style="width: 100%" >
                                            <option value=""></option>
                                            <option value="" {!! $nomor->kode_awal4 == "" ? 'selected' : '' !!}></option>
                                            <option id="cab4" value="kdcab" {!! $nomor->kode_awal4 == "kdcab" ? 'selected' : '' !!}>[KDCAB]</option>
                                            <option value="kode" {!! $nomor->kode_awal4 == "kode" ? 'selected' : '' !!}>[KODE]</option>
                                            <option value="digit" {!! $nomor->kode_awal4 == "digit" ? 'selected' : '' !!}>[DGT]</option>
                                            <option value="bulan" {!! $nomor->kode_awal4 == "bulan" ? 'selected' : '' !!}>[BLN]</option>
                                            <option value="tahun" {!! $nomor->kode_awal4 == "tahun" ? 'selected' : '' !!}>[THN]</option>
                                            <option value="bulantahun" {!! $nomor->kode_awal4 == "bulantahun" ? 'selected' : '' !!}>[BLNTHN]</option>
                                            <option value="tahunbulan" {!! $nomor->kode_awal4 == "tahunbulan" ? 'selected' : '' !!}>[THNBLN]</option>
                                        </select>
                                    </div>
                                    <hr><br>
                                </div>
                                <br><hr>
                                <div class="form-group">
                                    <label for="kode_awal" class="col-sm-2 control-label">Kode</label>
                                    <div class="col-sm-4">
                                        <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode" value="{!! $nomor->kode !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_digit" class="col-sm-2 control-label">Jumlah Digit</label>
                                    <div class="col-sm-4">
                                        <div class="spinner input-group">
                                            <input name="jumlah_digit" type="text" class="form-control input-sm spinner-input" id="jumlah_digit" value="{!! $nomor->jumlah_digit !!}" placeholder="Jumlah Digit">
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
                                            <input name="nomor_akhir" type="text" class="form-control input-sm spinner-input" id="no_akhir" value="{!! $nomor->nomor_akhir !!}" placeholder="No Terakhir">
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
        @if($nomor->modul == "POS") {
            $('#frmt').showOption('kdcab');
            $('#frmt2').showOption('kdcab');
            $('#frmt3').showOption('kdcab');
            $('#frmt4').showOption('kdcab');
        @else
            @if($nomor->modul == "Master Customer")
                $("#frmt").val("digit").change();
                $('#frmt').attr("disabled", true);
            @endif
            $('#frmt').hideOption('kdcab');
            $('#frmt2').hideOption('kdcab');
            $('#frmt3').hideOption('kdcab');
            $('#frmt4').hideOption('kdcab');
        @endif

    </script>
    <script>
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
                $('#fnomed').submit();
            }
        });
    </script>
@stop
