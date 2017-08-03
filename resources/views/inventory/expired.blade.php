<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset ('assets/templateinventory/inventory.ico') }}">
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

    <title>Produk Expired</title>
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
                    <li><a href="{{url('/inventory/expired')}}"> <span class="mif-warning"></span> &nbsp;Produk Expired</a></li>
                    {{--<li><a href="{{url('/masterproduk')}}">  <span class="mif-database"></span> &nbsp;Master Produk</a></li>--}}
                    {{--<li><a href="{{url('/masterkonfigurasi')}}'">  <span class="mif-tools"></span> &nbsp;Master Konfigurasi</a></li>--}}
                </ul>

            </li>
    </div>

</head>

<body id="">



<h1 style="margin-left:4%; margin-top:5%;"><a href="{!! url('/inventory') !!}" class="nav-button transform"><span></span></a>&nbsp;Produk Expired</h1>


<div class="cell">
    <div class="cell colspan10" style="padding-left:5%; padding-right:5%;">
        <div class="cell">
        </div>
        <hr>
        <form action="{{ url('expired/pdf/cetak')  }}" target="_blank" method="get">
        <table class="dataTable border bordered" data-role="datatable" data-searching="true" role="grid" style="margin-right:100px;background-color:#fff; padding:12px; margin-top:40%;">
            <thead>
            <tr>
                <th class="ribbed-cyan fg-white padding10 text-shadow">No</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Nama Produk</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Harga Beli</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow">Stok</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow" align="center">Expired</th>
            </tr>
            </thead>

            <?php
            $i = 1;
            ?>
            <tbody>
            @foreach($stok as $value)
                <tr>
                            <td>{!! $i++ !!}</td>
                            <td>{!! $value->produk !!}</td>
                            <td>{!! $value->harga_beli !!}</td>
                            <td align="center">{!! $value->stok_awal !!}</td>
                            <td align="center">{!! $value->tanggal_expired !!}</td>
                        </tr>

            @endforeach
            </tbody>

        </table>
            <div>
                <button class="button success medium-button" style="margin-left:93.2%;margin-bottom:10%;"><span class="mif-printer">&nbsp;Print!</span></button>
            </div>
        </form>
    </div>


</div>


</body>
</html>
