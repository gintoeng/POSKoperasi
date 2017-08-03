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

    <title>Data-Jurnal</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN DATA JURNAL</b>
        <br>
        <table style="position:absolute;margin-left: 260%;margin-top: 2%;">
            <tr>
                <td width="50">Tanggal</td>
                <td width="1">:</td>
                <td width="100">{!! $tanggal !!}</td>
            </tr>
            <tr style="font-size: 10pt">
                <td width="20">Jenis</td>
                <td width="1">:</td><td width="100">{!! $jenis !!}</td>
            </tr>
        </table>
    </p>
</header>
<br><br><br><br><br><br>
<table width="100%">
    <thead>
    <tr>
        <th class="text-center" width="3%">No</th>
        <th class="text-center" width="15%">No Transaksi</th>
        <th class="text-center" width="10%">Tanggal</th>
        <th class="text-center" width="8%">Modul</th>
        <th class="text-center" width="34%">Nama Akun Perkiraan</th>
        <th class="text-center" width="15%">Debet</th>
        <th width="15%">Kredit</th>
    </tr>
    </thead>
    <tbody>
        @foreach($Jurnalheader as $header)
        <tr>
            <td><center><b>{{$i++}}.</b></center></td>
            <td><b>{{$header->kode_jurnal}}</b></td>
            <td><center><b>{{substr($header['tanggal'], 0,10)}}</b></center></td>
            <td colspan="4"></td>
        </tr>
            @foreach($header->detail as $row)
            <tr>
                <td colspan="3"></td>
                <td>{{$header->tipe}}</td>
                <td>{{$row->perkiraan->kode_akun}} - {{$row->perkiraan->nama_akun}}</td>
                <td style="text-align:right">Rp. {{number_format($row->debet, '2')}}</td>
                <td style="text-align:right">Rp. {{number_format($row->kredit, '2')}}</td>
            </tr>
            @endforeach
        <tr>
            <td colspan="5"></td>
            <td colspan="2">----------------------------------------------------------</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td style="text-align:right">Rp. {{number_format($header->detail->sum('debet'), '2')}}</td>
            <td style="text-align:right">Rp. {{number_format($header->detail->sum('kredit'), '2')}}</td>
        </tr>
        <tr>
            <td colspan="7">---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4"></td>
            <td style="text-align:right">Total Akhir</td>
            <td style="text-align:right">Rp. {{number_format($Debetsum, '2')}}</td>
            <td style="text-align:right">Rp. {{number_format($Kreditsum, '2')}}</td>
        </tr>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="11" align="right"> </th>
    </tr>
    </tfoot>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
