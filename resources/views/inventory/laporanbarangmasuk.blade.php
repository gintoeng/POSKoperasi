<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/templateinventory/inventory.ico') }}">
    <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/jquery.dataTables.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenLite.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenMax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery-1.8.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('assets/templateinventory/js/gerak.js') }}"></script>

    <title>Laporan Barang Masuk</title>
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
        <span class="app-baxr-divider"></span>
        <ul class="app-bar-menu">
            <li>
                <a href="" class="dropdown-toggle"> <span class="mif-enter"></span> Pindah Ke</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="{{url('/lapbarangkeluar')}}">  <span class="mif-file-excel"></span> &nbsp;Laporan Barang Keluar</a></li>
                    <li><a href="{{url('/stokminimum')}}"> <span class="mif-warning"></span> &nbsp;Stok Minimum</a></li>
                    {{--<li><a href="{{url('/masterproduk')}}">  <span class="mif-database"></span> &nbsp;Master Produk</a></li>--}}
                    {{--<li><a href="{{url('/masterkonfigurasi')}}">  <span class="mif-tools"></span> &nbsp;Master Konfigurasi</a></li></ul>--}}
            </ul>
                    </li>
            </ul>
    </div>

</head>

<body id="">


<div style="height:80px; margin-left:20px; margin-top:80px;float:left; margin-right:40px; position:absolute">
    <h1 style="margin-left:4%; margin-top:5%; width:100%"><a href="{!! url('/inventory') !!}" class="nav-button transform"><span></span></a>&nbsp;Laporan Barang Masuk</h1>
</div>



<br>
<div class="cell">
    <div class="cell colspan10" style="padding-left:5%; padding-right:5%;margin-top:10%;">
        <div class="cell">
        </div>
        <hr>
        <table align="center" class="dataTable border bordered" data-role="datatable" data-searching="true" role="grid" style="margin-top:20px;margin-right:100px;background-color:#fff; padding:12px;">
            <thead>
            <tr>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">No</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Barcode</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Produk</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Tanggal</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Qty</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Harga</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Total Harga</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Expired</th>
            </tr>
            </thead>

            <?php
            $i = 1;
            ?>
            <tbody>
            @foreach ($beli as $value)
                <tr>
                    <td>{!! $i++ !!}</td>
                    <td>{!! $value->barcode !!}</td>
                    <td>{!! $value->nama !!}</td>
                    <td>{!! $value->tanggal !!}</td>
                    <td>{!! $value->qty !!}</td>
                    <td>Rp. {!! number_format($value->harga, 2, '.',',') !!}</td>
                    <td>Rp. {!! number_format($value->sub_harga, 2, '.',',') !!}</td>
                    <td>{!! $value->expired !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{!! url('/pdf') !!}" target="_blank"> <button class="button success medium-button" style="margin-left:93.2%;"><span class="mif-printer">&nbsp;Print!</span></button></a>
    </div>


</div>

</body>
</html>
