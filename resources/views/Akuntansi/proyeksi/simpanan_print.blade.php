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
    <p style="margin-left: 70%"><b>Proyeksi Simpanan</b>
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
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Simpanan</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Setoran Bulanan</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Tgl. Pembuatan</th>
        {{--<th rowspan="2" class="text-center" style="vertical-align: middle;">Total Bulan</th>--}}
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Saldo Sekarang</th>
        @for($j=date('m'); $j<=12; $j++)
            <th colspan="2" class="text-center">{{$j}}</th>
        @endfor
    </tr>
    <tr class="bg-color">
        @for($j=date('m'); $j<=12; $j++)
            <th class="text-center">Setoran</th>
            <th class="text-center">Saldo</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @foreach($simpanan as $value)
        <?php $cektr = \App\Model\Simpanan\Transaksi::where('id_simpanan', $value->id)->where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('tipe', 'SETOR')->where('kredit' , $value->setoran_bulanan)->first();
        $cekang = \App\Model\Simpanan\Simpanan::where('anggota', $value->anggota)->count();
        ?>
        <tr>
            @if($value->anggota != $idanggota)
                <td rowspan="{{$cekang}}" class="text-center">{!! $i++ !!}</td>
                <td rowspan="{{$cekang}}">{!! $value->anggotaid->kode !!}</td>
                <td rowspan="{{$cekang}}">{!! $value->anggotaid->nama !!}</td>
                <td rowspan="{{$cekang}}">{!! $value->anggotaid->npk !!}</td>
            @endif
            <td>{!! $value->pengaturanid->jenis_simpanan !!}</td>
            <td class="text-right">{!! number_format($value->setoran_bulanan, 2, '.', ',') !!}</td>
            <td class="text-center">{!! $value->tanggal_pembuatan !!}</td>
            @if($cektr == null)
                <td class="text-right">{!! number_format($value->akumulasiid->saldo, 2, '.', ',') !!}</td>
                <?php $sld = 0; $asaldo = $value->akumulasiid->saldo; ?>
                @for($k=date('m'); $k<=12; $k++)
                    <?php $sldnya = $asaldo + $value->setoran_bulanan; ?>
                    <td class="text-right">{!! number_format($value->setoran_bulanan, 2, '.', ',') !!}</td>
                    <td class="text-right">{!! number_format($sldnya, 2, '.', ',') !!}</td>
                    <?php $asaldo = $sldnya; ?>
                    @endfor
            @else
                <td class="text-right">{!! number_format($value->akumulasiid->saldo - $value->setoran_bulanan, 2, '.', ',') !!}</td>
                <td class="text-right">{!! number_format($value->setoran_bulanan, 2, '.', ',') !!}</td>
                <td class="text-right">{!! number_format($value->akumulasiid->saldo, 2, '.', ',') !!}</td>
            @endif
        </tr>
        <?php $idanggota = $value->anggota; ?>
    @endforeach
    </tbody>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
