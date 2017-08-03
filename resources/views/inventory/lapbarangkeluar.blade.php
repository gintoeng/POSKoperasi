<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{asset('assets/poscss/css/bootstrap.min.css')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset ('assets/templateinventory/inventory.ico') }}">
    <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datepicker/datepicker.css')}}"/>

    <script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenLite.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenMax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/gerak.js') }}"></script>
    <script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>

    <title>Laporan Barang Keluar</title>
    <style>
        body{
            margin:0;
            background-color:#fff;
            overflow:auto;
        }
    </style>

    <div class="app-bar navy" data-role="appbar">
        <a class="app-bar-element" href="{!! url('/inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
        <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
        <span class="app-bar-divider"></span>
        <ul class="app-bar-menu">
            <li>
                <a href="" class="dropdown-toggle"> <span class="mif-enter"></span> Pindah Ke</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="{{url('/lapbarangmasuk')}}">  <span class="mif-file-excel"></span> &nbsp;Laporan Barang Masuk</a></li>
                    <li><a href="{{url('/stokminimum')}}"> <span class="mif-warning"></span> &nbsp;Stok Minimum</a></li>
                    {{--<li><a href="{{url('/masterproduk')}}">  <span class="mif-database"></span> &nbsp;Master Produk</a></li>--}}
                    {{--<li><a href="{{url('/masterkonfigurasi')}}">  <span class="mif-tools"></span> &nbsp;Master Konfigurasi</a></li>--}}
                </ul>

            </li>
        </ul>
    </div>

</head>

<body id="">



<h1 style="margin-left:4%; margin-top:5%;"><a href="{!! url('/inventory') !!}" class="nav-button transform"><span></span></a>&nbsp;Laporan Barang Keluar</h1>

<div class="cell">
    <div class="cell colspan10" style="padding-left:5%; padding-right:5%;">
        <div class="cell">
        </div>

        {{--<div style="color:black;font-size:16px;position:absolute;margin-left:15%;margin-top:2.6%">Range Tanggal</div>--}}
        {{--<div id="hide1" style="color:black;font-size:15px;position:absolute;margin-left:28%;margin-top:2.6%">TO</div>--}}
        {{----}}
        {{--<button id="btnok" style="position:absolute;margin-top:2.6%;margin-left:48%;color:#FFF;border:none;background:#3498db;width:4%;height:25px;font-size:10px;cursor:pointer">OK</button>--}}

        {{--<input id="datepicker" type="text" style="position:absolute;width:7%;font-size:12px;color:#000;text-align:center;margin-left:32%;margin-top:2.6%"/>--}}

        {{--<input id="datepicker1" type="text" style="position:absolute;width:7%;font-size:12px;color:#000;margin-left:40%;text-align:center;margin-top:2.6%"/>  --}}

        <hr>
        <table class="dataTable border bordered" data-role="datatable" data-searching="true" role="grid" style="margin-right:100px;background-color:#fff; padding:12px; margin-top:40%;">
            <thead>
            <tr>
                <th class="ribbed-cyan fg-white padding10 text-shadow">No</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Barang</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Jumlah</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Total</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Barcode</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Kasir</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">No REF</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Tanggal</th>
            </tr>
            </thead>

            <?php
            $i = 1;
            ?>
            <tbody overflow:auto;>
            @foreach ($transaksi_detail as $value)
                <tr>
                    <td>{!! $i++ !!}</td>
                    <td>{!! $value->produk !!}</td>
                    <td>{!! $value->qty !!}</td>
                    <td>{!! number_format($value->sub_total, 2, '.',',') !!}</td>
                    <td>{!! $value->barcode !!}</td>
                    <td>{!! $value->kasir !!}</td>
                    <td>{!! $value->no_ref !!}</td>
                    <td>{!! $value->created_at !!}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
        <div>
            <a href="{!! url('/pdf2') !!}" target="_blank"><button class="button success medium-button" style="margin-left:93.2%;margin-bottom:10%;"><span class="mif-printer">&nbsp;Print!</span></button></a>
        </div>
    </div>


</div>

<script>
    $("#datepicker").datepicker({
        dateFormat: "yyyy-MM-dd",
        autoclose :true
    });
    $("#datepicker1").datepicker({
        dateFormat: "yyyy-MM-dd",
        autoclose :true
    });
</script>


</body>
</html>
