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

    <title>Transaksi-Simpanan</title>
</head>

<?php $profil = \App\Model\Pengaturan\Profil::findOrNew(1); $i = 1;?>
<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN TRANSAKSI SIMPANAN</b>
        <br>
    <table style="position:absolute;margin-left: 260%;margin-top: 2%;">
        <tr>
            <td width="50">No. Transkasi</td>
            <td width="1">:</td>
            <td width="100">{!! $trannya !!}</td>
        </tr>
        <tr style="font-size: 10pt">
            <td width="20">No. Simpanan</td>
            <td width="1">:</td>
            <td width="100">{!! $simpnya !!}</td>
        </tr>
        <tr style="font-size: 10pt">
            <td width="20">Tanggal</td>
            <td width="1">:</td>
            <td width="100">{!! $datenya !!}</td>
        </tr>
        <tr style="font-size: 10pt">
            <td width="20">Jns. Simpanan</td>
            <td width="1">:</td>
            <td width="100">{!! $js !!}</td>
        </tr>
        <tr style="font-size: 10pt">
            <td width="20">Jns. Customer</td>
            <td width="1">:</td>
            @if($jc != "")
                <td width="100">{!! $jc !!}</td>
            @endif
        </tr>
    </table>
    </p>
</header>
<br><br><br><br><br/><br><br/><br>
<table width="100%">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Tipe</th>
        <th class="text-center">Keterangan</th>
        <th align="right">Jumlah</th>
        <th align="right">Sub Total</th>
    </tr>
    </thead>
    <tbody>
    <?php $s = 0; $t = 0; $x = 0; $y = 0;?>
    @foreach($aturan as $key => $item)
        <tr><td style="background: #eaeaea" colspan="5" align="left">{!! $item['jenis'] !!}</td></tr>
        @foreach($simpanan as $value)
            <tr style="display:none;"><td>{!! $value['tipe'] !!}</td></tr>
            @if($value['idj'] == $item['idj'])
                <?php $aturan[$key]['idp5']+=$value['sld']?>
                @if($value['tipe'] == "SETOR")
                    <?php $s = 1; $aturan[$key]['idp']+=$value['sld']?>
                @endif
                @if($value['tipe'] == "TARIK")
                    <?php $t = 1; $aturan[$key]['idp2']+=$value['sld']?>
                @endif
                @if($value['tipe'] == "TRANSFER")
                    <?php $x = 1; $aturan[$key]['idp3']+=$value['sld']?>
                @endif
                @if($value['tipe'] == "TPINJAMAN")
                    <?php $y = 1; $aturan[$key]['idp4']+=$value['sld']?>
                @endif
            @endif
        @endforeach

                @if($s != 0)
                    <tr>
                        <td align="center">1</td>
                        <td>SETOR</td>
                        <td>Penarikan</td>
                        <td align="right">{!! number_format($aturan[$key]['idp'] - $item['idj'], 2, '.', ',') !!}</td>
                    </tr>
                @endif
                @if($t != 0)
                    <tr>
                        <td align="center">2</td>
                        <td>TARIK</td>
                        <td>Penarikan</td>
                        <td align="right">{!! number_format($aturan[$key]['idp2'] - $item['idj'], 2, '.', ',') !!}</td>
                    </tr>
                @endif
                @if($x != 0)
                    <tr>
                        <td align="center">3</td>
                        <td>TRANSFER</td>
                        <td>Transfer / Pindah Buku</td>
                        <td align="right">{!! number_format($aturan[$key]['idp3'] - $item['idj'], 2, '.', ',') !!}</td>
                    </tr>
                @endif
                @if($y != 0)
                    <tr>
                        <td align="center">4</td>
                        <td>TPINJAMAN</td>
                        <td>Bayar Pinjaman</td>
                        <td align="right">{!! number_format($aturan[$key]['id4'] - $item['idj'], 2, '.', ',') !!}</td>
                    </tr>
                @endif
        <tr><td colspan="5" align="right">----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>
        <tr>
            <td colspan="5" align="right">{!! number_format($aturan[$key]['idp5'] - $item['idj'], 2, '.', ',') !!}</td>
        </tr>
    @endforeach

    </tbody>
    <tfoot>
    <tr>
        <th colspan="4" align="right">Total Akhir :</th>
        <th align="right">{!! number_format($sld['z'], 2, '.', ',') !!}</th>
    </tr>
    </tfoot>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
