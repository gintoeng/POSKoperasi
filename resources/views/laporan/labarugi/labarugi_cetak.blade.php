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
        p {
            margin-top: auto;
            margin-left: 3%;
            font-size:10pt;
            position: absolute;
        }
    </style>

    <title>Laporan-Neraca</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN NERACA</b>
        <br>
        <table style="position:absolute;margin-left: 315%;margin-top: 2%;">
            <tr>
                <td width="50">Periode</td>
                <td width="1">:</td>
                <td width="100">{!! $bulan !!} - {{ $tahun }}</td>
            </tr>
        </table>
    </p>
</header>
<br><br><br><br><br><br><hr>
        <table width="100%" style="padding-top:50px;">
                    <tr>
                        <td><i>Total Pemasukan</i></td>
                    </tr>
                    <tr>
                        <td style="text-align:right">{{$akunpemasukan->nama_akun}}</td>
                        <td style="text-align:right"><b>Rp. {{number_format($pemasukancount, '2')}}</b></td>
                    </tr>
                    <tr>
                        <td><i>Total Pengeluaran</i></td>
                    </tr>
                    <tr>
                        <td style="text-align:right">{{$akunpengeluaran->nama_akun}}</td>
                        <td style="text-align:right"><b>Rp. {{number_format($pengeluarancount, '2')}}</b></td>
                    </tr>
                    <tr>
                        <td>----------------------------------------------------------------------------------------------------------------------------------</td>
                    </tr>
                    <tr>
                        <td><i>Laba Rugi</i></td>
                    </tr>
                    <tr>
                        <td style="text-align:right">Total</td>
                        <td style="text-align:right"><b>Rp. {{number_format($labarugi, '2')}}</b></td>
                    </tr>
        </table><br>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>
</body>
</html>
