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
            font-size:8pt;
        }
        th {
            background: #d8d8d8;
            border-top: 1px solid black;
            border-collapse: collapse;
            font-size:10pt;
        }
        th, td {
            padding: 5px;
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

    <title>Data-Customer</title>
</head>

<?php $profil = \App\Model\Pengaturan\Profil::findOrNew(1); $i = 1;?>
<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN PENJUALAN HPP</b>
        <br>
    <table style="position:absolute;margin-left: 260%;margin-top: 2%;">
        <tr>
            <td width="1">Produk</td>
            <td width="1">:</td>
            <td width="1000">{!! $brnya !!}</td>
        </tr>
        <tr>
            <td width="1">Cabang</td>
            <td width="1">:</td>
            <td width="1000">{!! $cbnya !!}</td>
        </tr>
        <tr>
            <td width="1">Tanggal</td>
            <td width="1">:</td>
            <td width="1000">{!! $datenya !!}</td>
        </tr>
    </table>
    </p>
</header>
<br><br/><br><br/><br><br/><br>
<table width="100%">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Produk</th>
        <th class="text-center">Tanggal</th>
        <th class="text-center">Qty Persediaan</th>
        <th class="text-center">Qty Pembelian</th>
        <th class="text-center">Qty Penjualan</th>
        <th class="text-center">Stok Akhir</th>
        <th class="text-center">HPP</th>
        {{--<th class="text-center">Cabang</th>--}}
    </tr>
    </thead>
    <tbody>
    <?php $s = 0;?>
    @foreach($hpp as $value)
        <?php $s+=$value->hpp_asli;?>
        <tr>
            <td align="center">{!! $i++ !!}</td>
            <td>{!! $value->produk !!}</td>
            <td>{!! $value->tanggal !!}</td>
            <td align="center">{!! $value->qty_persediaan !!}</td>
            <td align="center">{!! $value->qty_pembelian !!}</td>
            <td align="center">{!! $value->qty_penjualan !!}</td>
            <td align="center">{!! $value->stok_akhir !!}</td>
            <td align="right">{!! number_format($value->hpp_asli, 2, '.',',') !!}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="7" align="right"> </th>
        <th align="right">{!! number_format($s, 2, '.',',') !!}</th>
    </tr>
    </tfoot>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
