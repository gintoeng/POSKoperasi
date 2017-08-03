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
            font-size:10pt;
        }
        th {
            border-bottom: 1px solid;
        }
        p {
            margin-top: auto;
            margin-left: 3%;
            font-size:10pt;
            position: absolute;
        }
    </style>

    <title>Laporan-Kas-Detail</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN KAS BERDASAR JENIS</b>
        <br>
        <table style="position:absolute;margin-left: 315%;margin-top: 2%;">
            <tr>
                <td width="50">Tanggal</td>
                <td width="1">:</td>
                <td width="100">{!! $tanggal !!}</td>
            </tr>
            <tr style="font-size: 10pt">
                <td width="20">Jenis</td>
                <td width="1">:</td><td width="100">{{$jenis}}</td>
            </tr>
        </table>
    </p>
</header>
<br><br><br><br><br><br><hr>
    @foreach($jurnalkas as $row)
        <table width="100%">
            <tr>
                <td style="padding-left:15%;" width="20%">No. Transaksi :</td>
                <td style="padding-left:15%;" width="20%">{{$row->kode_jurnal}}</td>
                <td style="padding-left:15%;" width="20%">Dari/Tujuan Akun :</td>
                <td style="padding-left:15%;" width="20%">{{$row->detail1->perkiraan->nama_akun}}</td>
            </tr>
            <tr>
                <td style="padding-left:15%;" width="20%">Tanggal :</td>
                <td style="padding-left:15%;" width="20%">{{$row->tanggal}}</td>
                <td style="padding-left:15%;" width="20%">Tipe Transaksi :</td>
                <td style="padding-left:15%;" width="20%">{{$jenis}}</td>
            </tr>
        </table><br>
        <?php $b=1; ?>
        <table width="100%">
            <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th style="text-align:left;padding-left:15%;" width="30%">Kode Akun</th>
                <th style="text-align:left;padding-left:15%;" width="40%">Nama Akun Perkiraan</th>
                <th style="text-align:right;" width="35%">Nominal</th>
            </tr>
            </thead>
            <tbody>
                @foreach($row->detail as $detail)
                <tr>
                    <td><center><b>{{$b++}}.</b></center></td>
                    <td style="padding-left:15%;" class="text-center">{{$detail->perkiraan->kode_akun}}</td>
                    <td style="padding-left:15%;" class="text-center">{{$detail->perkiraan->nama_akun}}</td>
                    <td style="text-align:right;padding-left:15%;">Rp. {{substr($detail->nominal, 0,10)}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="text-align:right;padding-left:15%;">-------------------</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:right;padding-left:15%;">Rp. {{substr($row->detail->sum('nominal'), 0,10)}}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <tr>
        ------------------------------------------------------------------------------------------------------------------------------------
        </tr>
    @endforeach
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>
</body>
</html>
