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

    <title>Laporan-Kas-Rekap</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN TRANSAKSI KAS REKAP</b>
        <br>
        <table style="position:absolute;margin-left: 315%;margin-top: 2%;">
            <tr>
                <td width="50">Tanggal</td>
                <td width="1">:</td>
                <td width="100">{!! $tanggal !!}</td>
            </tr>
            <tr style="font-size: 10pt">
                <td width="20">Jenis</td>
                <td width="1">:</td><td width="100">{{$jenis}}</td>
            </tr>
        </table>
    </p>
</header>
<br><br><br><br><br><br>
<table width="100%">
    <thead>
    <tr>
        <th class="text-center" width="5%">No</th>
        <th class="text-center" width="30%">Tanggal</th>
        <th class="text-center" width="40%">Tipe</th>
        <th class="text-center" width="35%">Nama Akun</th>
        <th class="text-center" width="35%">Nominal</th>
    </tr>
    </thead>
    <tbody>
        @foreach($kas as $row)
        <tr>
            <td><center>{{$i++}}.</center></td>
            <td style="padding-left:15%;">{{$row->tanggal}}</td>
            <td style="padding-left:15%;">{{$row->tipe}}</td>
            <td style="padding-left:15%;">{{$row->kperkiraan->nama_akun}}</td>
            <td style="padding-left:15%;">Rp. {{substr($row->sum('jumlah'), 0,10)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="5" align="right"> </th>
    </tr>
    </tfoot>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
