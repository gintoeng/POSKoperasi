<!DOCTYPE html>
<html>
<head>
    <script language="JavaScript">

        <!--
        // please keep these lines on when you copy the source
        // made by: Nicolas - http://www.javascript-page.com

        var clockID = 0;

        function StartClock() {
            clockID = setTimeout("KillClock()", 100);
        }

        function KillClock() {
            if(clockID) {
                clearTimeout(clockID);
                window.print();
                history.back(-1);
                clockID  = 0;
            }
        }
        $(document).ready(function() {
            UpdateClock();
            StartClock();
            KillClock();
        });

        //-->

    </script>

    <style type="text/css">
        table, td {
            border: 0px solid black;
            border-collapse: collapse;
            font-size:8.3pt;
        }
        th {
            background: #d8d8d8;
            border-top: 1px solid black;
            border-collapse: collapse;
            font-size:10pt;
        }
        th {
            border-bottom: 1px solid;
            vertical-align: middle;
        }
        p {
            margin-top: auto;
            margin-left: 3%;
            font-size:10pt;
            position: absolute;
        }
    </style>

    <title>Laporan Fast&Slow Moving</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <div style="margin-top:2%;">
        <p ><b>{!! $koperasi->nama_koperasi !!} / Cabang : {{ $cbnya }}</b> <br>{!! $koperasi->alamat_koperasi !!}
            <br> {!! $telepon_koperasi !!}
            <br> - <br>NPK : {{ $namanya }}
        </p>
    </div>
    <p style="padding-left:30%; padding-right:30%;"><b>LAPORAN FAST&SLOW MOVING</b>
        <br>
    <table style="position:absolute;margin-top: 4%; margin-left:350%;">
        <tr>
            <td width="40">Periode</td>
            <td width="1">:</td>
            <td>{!! $df !!}</td>
        </tr>
        <tr style="font-size: 5pt">
            <td width="20">Jenis Produk</td>
            <td width="1">:</td><td width="100">{{ $namanya  }}</td>
        </tr>
        <tr style="font-size: 5pt">
            <td width="20">Jenis Trs</td>
            <td width="1">:</td><td width="100">{{ $jenis }}</td>
        </tr>
    </table>
    </p>
</header>
<br><br><br>
<table width="100%" style="margin-top:3%;">
    <thead>
    <tr>
        <th class="text-center" width="10%">No</th>
        <th class="text-center" width="20%">Produk</th>
        <th class="text-center" width="20%">Barcode</th>
        <th class="text-center" width="25%">Expired</th>
        <th class="text-center" width="25%">Stok Out</th>
        <th class="text-center" width="25%">Jenis Transaksi</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    ?>
    @foreach ($pendapatan as $value)
        <tr>
            <td><center>{!! $i++ !!}.</center></td>
            <td><center>{!! $value->nama !!}</center></td>
            <td><center>{!! $value->barcode !!}</center></td>
            <td><center>{!! $value->expired !!}</center></td>
            <td><center>{!! $value->jumlah_qty !!}</center></td>
            <td><center>{{ $value->jenis_pembayaran }}</center></td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="right"></th>
        <th colspan="" align="center"></th>
    </tr>
    </tfoot>
</table>
<br>

</body>
</html>
