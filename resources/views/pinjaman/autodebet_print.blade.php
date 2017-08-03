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

    <title>AUTODEBET-Simpanan</title>
</head>

<?php $profil = \App\Model\Pengaturan\Profil::findOrNew(1); $i = 1;?>
<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN AUTODEBET PINJAMAN</b>
        <br>
    <table style="position:absolute;margin-left: 260%;margin-top: 2%;">
        <tr style="font-size: 10pt">
            <td width="20">Bulan</td>
            <td width="1">:</td>
            <td>{!! $bulan !!}</td>
        </tr>
        <tr style="font-size: 10pt">
            <td width="20">Tahun</td>
            <td width="1">:</td>
            <td width="100">{!! $thn !!}</td>
        </tr>
    </table>
    </p>
</header>
<br><br/><br><br/><br>
<table width="100%">
    <thead>
    <tr>
        <th class="text-center" width="50">No.</th>
        <th class="text-center">No. Pinjaman</th>
        <th class="text-center">Nama</th>
        <th class="text-center">Bulan Ke</th>
        <th align="right">Debet</th>
        <th class="text-center">Status</th>
    </tr>
    </thead>
    <tbody>
    <?php $d = 0;?>
    @foreach($autop as $value)
        <tr>
            <td align="center">{!! $i++ !!}</td>
            <td>{!! $value->pinjamanid->nomor_pinjaman !!}</td>
            <td>{!! $value->pinjamanid->anggotaid->nama !!}</td>
            <td>{!! $value->bayarid->bulan_ke !!}</td>
            <td align="right">{!! number_format($value->debet, 2, '.', ',') !!}</td>
            @if($value->debet == 0)
                <td align="center" style="color: red">GAGAL</td>
            @else
                <td align="center" style="color: blue">SUKSES</td>
            @endif
            <?php $d+=$value->debet; ?>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3" align="right"> </th>
        <th align="right">{!! number_format($d, 2, '.', ',') !!}</th>
        <th></th>
    </tr>
    </tfoot>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
