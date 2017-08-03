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

    <title>Laporan Stok Barang</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <div style="margin-top:2%;">
        <p ><b>{!! $koperasi->nama_koperasi !!} / Cabang : {!! $cbnya !!}</b> <br>{!! $koperasi->alamat_koperasi !!}
            <br> {!! $koperasi->telepon !!}
            <br> <br>
        </p>
    </div>
    <p style="padding-left:38%; padding-right:38%;"><b>LAPORAN STOK BARANG</b>
        <br>
    <table style="position:absolute;margin-top: 4%; margin-left:350%;">


    </table>
    </p>
</header>
<br><br><br>
<table width="100%" style="margin-top:3%;">
    <thead>
    <tr>
        <th class="text-center" width="10%">No</th>
        <th class="text-center" width="20%">Produk</th>
        <th class="text-center" width="20%">Harga Beli</th>
        <th class="text-center" width="25%">Harga Jual</th>
        <th class="text-center" width="25%">Expired</th>
        <th class="text-center" width="25%">Stok</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    ?>
    @foreach ($detail as $value)
        <tr><?php
            { $stok = \App\Model\Master\Mappingbarang::where('id_cabang', Auth::user()->cabang)->where('id_produk', $value->id)->first();}?>
            <td><center>{!! $i++ !!}.</center></td>
            <td><center>{!! $value->nama !!}</center></td>
            <td><center>{!! $value->harga_beli !!}</center></td>
            <td><center>{!! $value->harga_jual !!}</center></td>
            <td><center>{!! $value->expired !!}</center></td>
            <td><center>{{ $stok->stok  }}</center></td>
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
