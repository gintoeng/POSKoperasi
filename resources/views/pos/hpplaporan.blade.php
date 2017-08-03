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
            font-size:8pt;
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

    <title>Laporan HPP</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <div style="margin-top:2%;">
        <p ><b>{!! $koperasi->nama_koperasi !!} / Cabang : {{ $cbnya }}</b> <br>{!! $koperasi->alamat_koperasi !!}
            <br> {!! $telepon_koperasi !!}
            <br> - <br>NPK : {{ $namanya }}
        </p>
    </div>
    <p style="padding-left:38%; padding-right:38%;"><b>LAPORAN HPP</b>
        <br>
    <table style="position:absolute;margin-top: 4%; margin-left:350%;">
        <tr>
            <td width="20">Periode</td>
            <td width="1">:</td>
            <td>{!! $df !!}</td>
        </tr>
        <tr style="font-size: 5pt">
            <td width="20"></td>
            <td width="1"></td><td  width="100">{{ $idnya }} {{ $namanya  }}</td>
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
        <th class="text-center" width="20%">Tanggal</th>
        <th class="text-center" width="25%">Persediaan</th>
        <th class="text-center" width="25%">Qty Persediaan</th>
        <th class="text-center" width="25%">Pembelian</th>
        <th class="text-center" width="25%">Qty Pembelian</th>
        <th class="text-center" width="25%">Penjualan</th>
        <th class="text-center" width="25%">Qty Penjualan</th>
        <th class="text-center" width="25%">Stok Akhir</th>
        <th class="text-center" width="25%">HPP</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    ?>
    @foreach ($pendapatan as $value)
        <tr>
            <td><center>{!! $i++ !!}.</center></td>
            <td><center>{!! $value->produk !!}</center></td>
            <td><center>{!!$value->tanggal!!}</center></td>
            <td><center>Rp. {!! number_format($value->persedian_awal ,2,",",".") !!}</center></td>
            <td><center>{!!$value->qty_persediaan!!}</center></td>
            <td><center>Rp. {!! number_format($value->pembelian ,2,",",".") !!}</center></td>
            <td><center>{!!$value->qty_pembelian!!}</center></td>
            <td><center>Rp. {!! number_format($value->penjualan ,2,",",".") !!}</center></td>
            <td><center>{{ $value->qty_penjualan }}</center></td>
            <td><center>{{ $value->stok_akhir }}</center></td>
            <td><center>Rp. {!! number_format($value->hpp_asli ,2,",",".") !!}</center></td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="right">Total</th>
        <th colspan="" align="center">Rp. {!! number_format($jumlah ,2,",",".") !!}</th>
    </tr>
    </tfoot>
</table>
<br>

</body>
</html>
