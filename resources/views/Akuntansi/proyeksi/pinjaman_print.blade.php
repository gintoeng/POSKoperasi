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
            border: 0.5px solid black;
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
            padding: 8px;
        }

        .padd {
            padding-left: 8px;
            padding-right: 8px;
            padding-top: 8px;
        }

        th {
            border-bottom: 1px solid;
            border-left: 0.5px solid;
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
    <p style="margin-left: 70%"><b>Proyeksi Pinjaman</b>
    </p>
</header>
<br><br><br><br><br><br>
<table width="100%">
    <?php $i = 1; date_default_timezone_set('Asia/Jakarta'); $idanggota=""; ?>
    <thead>
    <tr class="bg-color">
        <th rowspan="2" class="text-center" style="vertical-align: middle;">No</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Kode Anggota</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Nama Anggota</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">NPK</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Pinjaman</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Bunga</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Tgl. Awal</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Tgl. Akhir</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Total Bulan</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Sistem Bunga</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Pengajuan</th>
        @for($j=date('m'); $j<=12; $j++)
            <th colspan="2" class="text-center">{{$j}}</th>
        @endfor
    </tr>
    <tr class="bg-color">
        @for($j=date('m'); $j<=12; $j++)
            <th class="text-center">Outstanding</th>
            <th class="text-center">Bunga</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @foreach($pinjaman as $value)
        <?php
        $maxtgl = \App\Model\Pinjaman\Pembayaran::where('id_pinjaman', $value->id)->orderBy('bulan_ke', 'desc')->first();
        $mintgl = \App\Model\Pinjaman\Pembayaran::where('id_pinjaman', $value->id)->orderBy('bulan_ke', 'asc')->first();
        $cekang = \App\Model\Pinjaman\Pinjaman::where('anggota', $value->anggota)->count();
        ?>
        <tr>
            @if($value->anggota != $idanggota)
                <td rowspan="{{$cekang}}" class="text-center">{!! $i++ !!}</td>
                <td rowspan="{{$cekang}}">{!! $value->anggotaid->kode !!}</td>
                <td rowspan="{{$cekang}}">{!! $value->anggotaid->nama !!}</td>
                <td rowspan="{{$cekang}}">{!! $value->anggotaid->npk !!}</td>
            @endif
            <td>{!! $value->pengaturanid->nama_pinjaman !!}</td>
            <td class="text-right">{!! $value->pengaturanid->suku_bunga !!} %</td>
            <td class="text-center">{!! $mintgl->tanggal !!}</td>
            <td class="text-center">{!! $maxtgl->tanggal !!}</td>
            <td class="text-center">{!! $value->jangka_waktu !!}</td>
            <td>{!! $value->pengaturanid->sbunga->sistem !!}</td>
            <td class="text-right">{!! number_format($value->jumlah_pengajuan, 2, '.', ',') !!}</td>
                @for($k=date('m'); $k<=12; $k++)
                    <?php
                        $tgawal = date('Y')."-".$k."-01";
                        $tgakhir = date('Y')."-".$k."-".date('t', mktime(0, 0, 0, $k, 1, date('Y')));
                    $cektr = \App\Model\Pinjaman\Pembayaran::where('id_pinjaman', $value->id)->where('tanggal', '>=', $tgawal)->where('tanggal', '<=', $tgakhir)->first();
                    ?>
                    @if($cektr == null)
                        <td class="text-right">{!! number_format(0, 2, '.', ',') !!}</td>
                        <td class="text-right">{!! number_format(0, 2, '.', ',') !!}</td>
                        @else
                            <td class="text-right">{!! number_format($cektr->saldo, 2, '.', ',') !!}</td>
                            <td class="text-right">{!! number_format($cektr->bunga, 2, '.', ',') !!}</td>
                        @endif
                    @endfor
        </tr>
        <?php $idanggota = $value->anggota;?>
    @endforeach
    </tbody>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
