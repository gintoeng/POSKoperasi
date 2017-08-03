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
            font-size:10pt;
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

    <title>Laporan Stok Minimum</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <div style="margin-top:2%;">
        <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
            <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
            <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
        </p>
    </div>
    <p style="padding-left:33%; padding-right:33%;"><b>LAPORAN STOK MINIMUM</b>
        <br>
    <table style="position:absolute;margin-top: 3%; margin-left:350%;">
        <tr>
            <td width="50">Tanggal</td>
            <td width="1">:</td>
            <td>{!!$date!!}</td>
        </tr>
        <tr style="font-size: 5pt">
            <td width="20">Jenis</td>
            <td width="1">:</td><td width="100">STOK MINIMUM</td>
        </tr>
    </table>
    </p>
</header>
<br><br><br>
<table width="100%" style="margin-top:3%;">
    <thead>
    <tr>
        <th class="text-center" width="5%">No</th>
        <th class="text-center" width="15%">Produk</th>
        <th class="text-center" width="15%">Barcode</th>
        <th class="text-center" width="15%">Klasifikasi</th>
        <th class="text-center" width="15%">Stok</th>
        <th class="text-center" width="15%">Unit</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    ?>
    @foreach ($transaksi_detail as $value)
        <?php $mapro = \App\Model\Master\Mappingbarang::where('id_produk', $value->id)->where('id_cabang', \Illuminate\Support\Facades\Auth::user()->cabang)->first();?>
        @if($mapro != null)
            @if($mapro->stok <= $value->stok_minimum)
        <tr>
            <td align="center">{!! $i++ !!}</td>
            <td align="center">{!! $value->barcode !!}</td>
            <td align="center">{!! $value->nama !!}</td>
            <td align="center">{!! $value->classification !!}</td>
            <td align="center">{!! $mapro->stok !!}</td>
            <td align="center">{!! $value->unitid->nama !!}</td>
        </tr>
            @endif
        @endif
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="" align="right"></th>
        <th colspan="" align="right"></th>
        <th colspan="" align="right"></th>
        <th colspan="" align="right"></th>
        <th colspan="" align="right"></th>
        <th colspan="" align="right"></th>
    </tr>
    </tfoot>
</table>
<br>

</body>
</html>
