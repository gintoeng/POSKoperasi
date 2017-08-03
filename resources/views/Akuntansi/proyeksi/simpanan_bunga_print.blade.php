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
    <p style="margin-left: 70%"><b>Proyeksi Bunga</b>
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
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Bunga</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Tgl. Pembuatan</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Sistem Bunga</th>
        <th rowspan="2" class="text-center" style="vertical-align: middle;">Saldo Sekarang</th>
        @for($j=date('m'); $j<=12; $j++)
            <th colspan="2" class="text-center">{{$j}}</th>
        @endfor
    </tr>
    <tr class="bg-color">
        @for($j=date('m'); $j<=12; $j++)
            <th class="text-center">Bunga</th>
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
                <td class="text-right">{!! $value->pengaturanid->suku_bunga !!} %</td>
                <td class="text-center">{!! $value->tanggal_pembuatan !!}</td>
                <td>{!! $value->pengaturanid->sbunga->sistem !!}</td>
            @if($cektr == null)
                <td class="text-right">{!! number_format($value->akumulasiid->saldo, 2, '.', ',') !!}</td>
                <?php $sld = 0; $asaldo = $value->akumulasiid->saldo; ?>
                    <?php
                    $saldonya2 = $value->akumulasiid->saldo;
                    $saldor2 = $value->akumulasiid->saldo + $value->setoran_bulanan;
                    ?>
                @for($k=date('m'); $k<=12; $k++)
                        <?php
                        $id = $value->id;
                        $saldonya = $saldonya2;
                        $saldor = $saldor2;
                            $setr = $value->setoran_bulanan;
                        ?>

                        <?php

                        date_default_timezone_set('Asia/Jakarta');
                        $jumHari = date('t');
                        $simp = \App\Model\Simpanan\Simpanan::findOrNew($id);

                        $sistembunga = $simp->pengaturanid->sistem_bunga;
                        $sbunga = $simp->pengaturanid->suku_bunga;
                        $minbunga = $simp->pengaturanid->saldo_minimum_bunga;

                        $akarsaldo = $saldonya;

                        $cektr = \App\Model\Simpanan\Transaksi::where('id_simpanan', $id)->where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('tipe', 'SETOR')->where('kredit' , $simp->setoran_bulanan)->first();

                        if ($akarsaldo >= $minbunga) {
                            if ($sistembunga == "1") {
                                $transaksi = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->min('saldo_akhir');
                                if ($cektr == null) {
                                    if ($simp->setoran_bulanan < $transaksi) {
                                        $saldo = $simp->setoran_bulanan;
                                    } else {
                                        $saldo = $transaksi;
                                    }
                                } else {
                                    $saldo = $transaksi;
                                }
                                $bunga = $saldo * $sbunga / 100 * $jumHari / 365;
                            } else if ($sistembunga == "2") {
                                $i = 0;
                                $t = 0;
                                $transaksi = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->get();
                                $transaksi2 = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->orderBy('id', 'desc')->first();
                                $trcount = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->count();
                                foreach ($transaksi as $ts) {
                                    $a = $i++;
                                    $b = $a + 1;

                                    if ($b == $trcount) {
                                        $ddt = date('Y-m-t');
                                        $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($ddt))) / (60 * 60 * 24));
                                        $nominal = $transaksi[$a]['saldo_akhir'];
                                        $total = $nominal * $hari;
                                    } else {
                                        $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($transaksi[$b]['tanggal']))) / (60 * 60 * 24));
                                        $nominal = $transaksi[$a]['saldo_akhir'];
                                        $total = $nominal * $hari;
                                    }
                                    $t += $total;
                                }
                                if ($cektr == null) {
                                    $ddt = date('Y-m-t');
                                    $harinya = ((abs(strtotime($transaksi2->tanggal) - strtotime($ddt))) / (60 * 60 * 24));
                                    $saldo = ($t / $jumHari) + ($simp->setoran_bulanan * $harinya);
                                } else {
                                    $saldo = $t / $jumHari;
                                }
                                $bunga = $saldo * $sbunga / 100 * $jumHari / 365;
                            } else {
                                $i = 0;
                                $y = 0;
                                $z = 0;
                                $transaksi = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->get();
                                $transaksi2 = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->orderBy('id', 'desc')->first();
                                $trcount = \App\Model\Simpanan\Transaksi::where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('id_simpanan', $id)->count();
                                foreach ($transaksi as $gg) {
                                    $a = $i++;
                                    $b = $a + 1;

                                    if ($b == $trcount) {
                                        $ddt = date('Y-m-t');
                                        $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($ddt))) / (60 * 60 * 24));
                                        $nominal = $transaksi[$a]['saldo_akhir'];
                                        $total = $nominal * $simp->suku_bunga / 100 * ($hari / 365);
                                    } else {
                                        $hari = ((abs(strtotime($transaksi[$a]['tanggal']) - strtotime($transaksi[$b]['tanggal']))) / (60 * 60 * 24));
                                        $day = $transaksi[$a]['tanggal'];
                                        $day2 = $transaksi[$b]['tanggal'];
                                        $nominal = $transaksi[$a]['saldo_akhir'];
                                        $total = $nominal * $simp->suku_bunga / 100 * ($hari / 365);
                                    }
                                    $y += $total;
                                    $z += $nominal;
                                }
                                $saldo = $z;
                                if ($cektr == null) {
                                    $ddt = date('Y-m-t');
                                    $harinya = ((abs(strtotime($transaksi2->tanggal) - strtotime($ddt))) / (60 * 60 * 24));
                                    $bunga = $y + ($simp->setoran_bulanan * $simp->suku_bunga / 100 * ($harinya / 365));
                                } else {
                                    $bunga = $y;
                                }
                            }
                            $bunganya = $bunga;
                        } else {
                            $bunganya = 0;
                        }

                        $sldnya = $asaldo + $setr + $bunganya;
                        echo '<td align="right">' . number_format($bunganya, 2, '.', ',') . '</td>';
                        echo '<td class="text-right">' . number_format($sldnya, 2, '.', ',') . '</td>';
                        $asaldo = $sldnya; $saldonya2 = $sldnya; $saldor2 = $sldnya;
                    ?>
                @endfor
            @else
                <td class="text-right">{!! number_format($value->akumulasiid->saldo - $value->setoran_bulanan, 2, '.', ',') !!}</td>
                    <?php
                    $id = $value->id;
                    $saldonya = $value->akumulasiid->saldo - $value->setoran_bulanan;
                    $saldor = $value->akumulasiid->saldo;
                    ?>
                    @include('Akuntansi.proyeksi.proyeksi_print_js')
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
