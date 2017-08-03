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

    <title>Laporan Kasir</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <div style="margin-top:2%;">
    <p ><b>{!! $koperasi->nama_koperasi !!} / Cabang : {{ $cbnya }}</b> <br>{!! $koperasi->alamat_koperasi !!}
        <br> {!! $koperasi->telepon_koperasi !!}
        <br> - <br>User : {{ $namanya }}
    </p>
    </div>
    <p style="padding-left:38%; padding-right:38%;"><b>LAPORAN KASIR</b>
        <br>
        <table style="position:absolute;margin-top: 4%; margin-left:350%;">
            <tr>
                <td width="40">Periode</td>
                <td width="1">:</td>
                <td>{!! $df !!}</td>
            </tr>
            <tr style="font-size: 5pt">
                <td width="20">Nama Kasir</td>
                <td width="1">:</td><td width="100">{{ $namanya }}</td>
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
        <th class="text-center" width="20%">No Ref</th>
        <th class="text-center" width="20%">Tanggal</th>
        <th class="text-center" width="25%">Type Pembayaran</th>
        <th class="text-center" width="25%">NPK</th>
        <th class="text-center" width="25%">Jumlah</th>
    </tr>
    </thead>
    <tbody>
    <?php
                        $i = 1;
                        ?>
                        @foreach ($pendapatan as $value)
                    <tr>
                        <td><center>{!! $i++ !!}.</center></td>
                        <td><center>{!! $value->noref !!}</center></td>
                        <td><center>{!!$value->tanggal!!}</center></td>
                        <td><center>{!!$value->type_pembayaran!!}</center></td>
                        <td><center>{!!$value->no_kartu!!}</center></td>
                        <td><center>Rp. {!! number_format($value->jumlah ,2,",",".") !!}</center></td>
                    </tr>
                @endforeach
    </tbody>
    <tfoot>
    <tr>
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
