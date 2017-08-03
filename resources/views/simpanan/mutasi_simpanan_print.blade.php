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

    <title>Mutasi-Simpanan</title>
</head>

<?php $profil = \App\Model\Pengaturan\Profil::findOrNew(1); $i = 1;?>
<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN MUTASI SIMPANAN</b>
        <br>
        <table style="position:absolute;margin-left: 260%;margin-top: 2%;">
            <tr>
                <td width="50">No. Simpanan</td>
                <td width="1">:</td>
                <td>{!! $simpanan->nomor_simpanan !!}</td>
            </tr>
            <tr style="font-size: 10pt">
                <td width="20">Nama</td>
                <td width="1">:</td>
                <td>{!! $simpanan->anggotaid->nama !!}</td>
            </tr>
            <tr style="font-size: 10pt">
                <td width="20">Tanggal</td>
                <td width="1">:</td>
                <td width="100">{!! $df !!} s/d {!! $dt !!}</td>
            </tr>
        </table>
    </p>
</header>
<br><br/><br><br/><br><br/>
<table width="100%">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">No.Transaksi</th>
        <th class="text-center">Tanggal</th>
        <th class="text-center">NPK</th>
        <th class="text-center">Kode Anggota</th>
        <th class="text-center">Tipe</th>
        <th class="text-center">Info</th>
        <th align="right">Debet</th>
        <th align="right">Kredit</th>
        <th align="right">Saldo</th>
        <th class="text-center">Keterangan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mutasi as $value)
    <tr>
        <td align="center">{!! $i++ !!}</td>
        <td>{!! $value->kode !!}</td>
        <td align="center">{!! $value->tanggal !!}</td>
        <td>{!! $value->simpananid->anggotaid->npk !!}</td>
        <td>{!! $value->simpananid->anggotaid->kode !!}</td>
        <td>{!! $value->tipe !!}</td>
        <td>{!! $value->info !!}</td>
        <td align="right">{!! number_format($value->debet, 2, '.', ',') !!}</td>
        <td align="right">{!! number_format($value->kredit, 2, '.', ',') !!}</td>
        <td align="right">{!! number_format($value->saldo_akhir, 2, '.', ',') !!}</td>
        <td>{!! $value->keterangan !!}</td>
        </tr>
    @endforeach
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
