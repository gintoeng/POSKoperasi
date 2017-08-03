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

    <title>Data-Customer</title>
</head>

<?php $profil = \App\Model\Pengaturan\Profil::findOrNew(1); $i = 1;?>
<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN PENJUALAN</b>
        <br>
    <table style="position:absolute;margin-left: 260%;margin-top: 2%;">
        <tr>
            <td width="1">Status</td>
            <td width="1">:</td>
            <td width="1000">{!! $stnya !!}</td>
        </tr>
        <tr>
            <td width="1">Tanggal</td>
            <td width="1">:</td>
            <td width="1000">{!! $datenya !!}</td>
        </tr>
        <tr>
            <td width="1">Cabang</td>
            <td width="1">:</td>
            <td>{!! $cbnya  !!}</td>
        </tr>
        <tr>
            <td width="1">Kasir</td>
            <td width="1">:</td>
            <td>{!! $ksnya  !!}</td>
        </tr>
    </table>
    </p>
</header>
<br><br/><br><br/><br><br/><br>
<table width="100%">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Noref</th>
        <th class="text-center">Tanggal</th>
        <th class="text-center">Jumlah</th>
        <th class="text-center">Tipe</th>
        <th class="text-center">Cabang</th>
    </tr>
    </thead>
    <tbody>
    <?php $s = 0; $t = 0;?>
    @foreach($user as $item)
        <tr>
            <td colspan="6" style="background: #eaeaea">{!! $item->username !!}</td>
        </tr>
        @foreach($transaksi as $value)
            @if($value->kasir == $item->id)
                <?php $s+=$value->jumlah; ?>
                <tr>
                    <td align="center">{!! $i++ !!}</td>
                    <td>{!! $value->noref !!}</td>
                    <td>{!! $value->tanggal !!}</td>
                    <td align="right">{!! number_format($value->jumlah, 2, '.',',') !!}</td>
                    <td>{!! $value->type_pembayaran !!}</td>
                    <td>{!! $value->cabangid->nama !!}</td>
                </tr>
            @endif
        @endforeach
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3" align="right"> </th>
        <th align="right">{!! number_format($s, 2, '.',',') !!}</th>
        <th colspan="2"></th>
    </tr>
    </tfoot>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
