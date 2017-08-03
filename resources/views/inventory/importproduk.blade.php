<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset ('assets/templateinventory/inventory.ico') }}">
    <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datepicker/datepicker.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenLite.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenMax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery-1.8.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/gerak.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery.maskMoney.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery.maskMoney.min.js') }}"></script>

    <script language="JavaScript">
        <!--

        function enable_text(status)
        {
            status=!status;
            document.f1.disc.disabled = true;
        }

        $("#tanggalan").datepicker({
            dateFormat: "yyyy-MM-dd",
            autoclose :true
        });
        //-->
    </script>

    <title>Import Produk</title>

    <div class="app-bar navy" data-role="appbar">
        <a class="app-bar-element" href="{!! url('/inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
        <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
        <span class="app-bar-divider"></span>
        <ul class="app-bar-menu">
            <li>
                <a href="" class="dropdown-toggle"> <span class="mif-enter"></span> Pindah Ke</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="/lapbarangmasuk">  <span class="mif-file-excel"></span> &nbsp;Laporan Barang Masuk</a></li>
                    <li><a href="/lapbarangkeluar">  <span class="mif-file-excel"></span> &nbsp;Laporan Barang Keluar</a></li>
                    <li><a href="/masterproduk">  <span class="mif-database"></span> &nbsp;Master Produk</a></li>
                    <li><a href="/masterkonfigurasi">  <span class="mif-tools"></span> &nbsp;Master Konfigurasi</a></li>
                    </li>
    </div>

</head>

<body>
<div style="margin-top: 2%;">
    <h1><a href="{!! url('/inventory') !!}" class="nav-button transform" style="margin-left: 5%;"><span></span></a>Import Produk</h1>
    <hr style="margin-left: 5%; margin-right: 5%;">
</div>

<div class="cell colspan10">
    <div class="panel" style="padding-left:5%; padding-right:5%;">
        <div class="heading" >
            <span class="icon mif-pencil"></span>
            <span class="title">Import Produk</span>
        </div>
        <div class="content">
<form action="{{ url('inventory/import/barang/importnya')  }}" method="POST" enctype="multipart/form-data">
                <div class="grid" style="padding-left:2%; padding-right:2%; padding-top:2%; padding-bottom:2%;">
                <div><b>Excel File</b></div>
                    <input required type="file" name="import" style="position:absolute;margin-left: 10%;margin-top:-1.5%" >
                    <div style="margin-top:3%"><b>Format</b></div>
                    <div style="background:#369;width:56%;height:8%;position:absolute;margin-left:10%;margin-top: -1.5%;color:#FFF;text-align: left;font-size:17px;padding-top:0.5%">&nbsp;&nbsp;&nbsp;Sheet 1 : NAMA | CLASSIFICATION | HARGA_JUAL | HARGA_BELI | DISC | STOK | UNIT_ID |</div>
                    <div style="background:#369;width:56%;height:8%;position:absolute;margin-left:10%;margin-top: 2%;color:#FFF;text-align: left;font-size:17px;padding-top:0.5%">&nbsp;&nbsp;&nbsp; KAT_ID | UNTUNG | EXPIRED | BARCODE | VENDOR_ID | CAB_ID</div>
                <div style="color:#ecf0f1">test</div>
                    <div style="color:#ecf0f1">test</div><div style="color:#ecf0f1">test</div><div style="color:#ecf0f1">test</div>
                    <div style="color:#ecf0f1">test</div>
                    <div style="color:#ecf0f1">test</div>
                    <div style="color:#ecf0f1">test</div>

                    <div><b>Keterangan</b></div>

                    <ul>
                        <li>HARGA/UNTUNG/DISC/STOK : contoh 20000</li>
                        <li>EXPIRED : Format YYYY-MM-DD</li>
                        <li>KAT_ID : id kategori dari barang</li>
                        <li>UNIT_ID : id unit dari barang</li>
                        <li>VENDOR_ID : id vendor dari barang</li>
                        <li>CAB_ID : id vendor dari cabang</li>
                    </ul>
                </div>
    <input type="hidden" name="_token" value="{{ csrf_token()  }}">
        <button class="ti-upload mr5" type="submit" style="position: absolute;margin-top:-10%;margin-left:35%;background: #3498db;color:#FFF;border:none;height: 9%;width:10%">Upload</button>
</form>
            <a href="{{ url('inventory/import/barang/sample')  }}"><button class="ti-download mr5" style="position: absolute;margin-top:-10%;margin-left:48%;background: #daac16;color:#FFF;border:none;height: 9%;width:10%">Sample</button></a>

        </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenLite.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenMax.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/gerak.js') }}"></script>
<script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
<script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
<script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>
<script src="{{ asset('assets/templateinventory/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/templateinventory/js/sweetalert.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
