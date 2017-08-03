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
        table, td {
            border: 0px solid black;
            border-collapse: collapse;
            font-size:9pt;
        }
        th {
            padding: 8px;
        }

        .padd {
            padding-left: 8px;
            padding-right: 8px;
            padding-top: 8px;
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

        .right {
            text-align: right;
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

    <title>Data-Pinjaman</title>
</head>

<?php $profil = \App\Model\Pengaturan\Profil::findOrNew(1); $i = 1;?>
<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="6%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 70%"><b>CETAK NERACA LAJUR</b>
        <br>
    <table style="position:absolute;margin-left: 670%;margin-top: 2%;">
        <tr>
            <td width="20">TANGGAL</td>
            <td width="1">:</td>
            <td width="100">{!! $tanggal !!}</td>
        </tr>
    </table>
    </p>
</header>
<br><br><br><br><br><br>
<table width="100%">
    <thead>
        <tr>
            <th class="text-center" rowspan="2">No</th>
            <th class="text-center" rowspan="2">Kode</th>
            <th class="text-center" rowspan="2">Nama Akun</th>
            <th class="text-center" colspan="2">Neraca Saldo</th>
            <th class="text-center" colspan="2">Penyesuaian</th>
            <th class="text-center" colspan="2">Setelah Penyesuaian</th>
            <th class="text-center" colspan="2">Laba Rugi</th>
            <th class="text-center" colspan="2">Neraca</th>
        </tr>
        <tr>
            <th class="text-center">Debet</th>
            <th class="text-center">Kredit</th>
            <th class="text-center">Debet</th>
            <th class="text-center">Kredit</th>
            <th class="text-center">Debet</th>
            <th class="text-center">Kredit</th>
            <th class="text-center">Debet</th>
            <th class="text-center">Kredit</th>
            <th class="text-center">Debet</th>
            <th class="text-center">Kredit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($perkiraan as $perkiraans)
        <tr>
            <td>{{$i++}}.</td>
            <td>{{$perkiraans->kode_akun}}</td>
            <td>{{$perkiraans->nama_akun}}</td>
            <?php
                $debet = App\Model\Akuntansi\JurnalDetail::where('id_akun', $perkiraans->id)->whereHas('header', function($q) use($dari, $ke){
                            $q->where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00");
                        })->sum('debet'); ?>

            <?php $kredit = App\Model\Akuntansi\JurnalDetail::where('id_akun', $perkiraans->id)->whereHas('header', function($q) use($dari, $ke){
                        $q->where('tanggal', '>=', $dari." 00:00:00")->where('tanggal', '<=', $ke." 23:59:00");
                    })->sum('kredit'); ?>
            <td>Rp. {{number_format($debet, '2')}}</td>
            <td>Rp. {{number_format($kredit, '2')}}</td>
            <td>Rp. 0,00</td>
            <td>Rp. 0,00</td>
            <td>Rp. {{number_format($debet, '2')}}</td>
            <td>Rp. {{number_format($kredit, '2')}}</td>
            <td>Rp. 0,00</td>
            <td>Rp. 0,00</td>
            <td>Rp. {{number_format($debet, '2')}}</td>
            <td>Rp. {{number_format($kredit, '2')}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
