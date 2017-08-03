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

        .center {
            text-align: center;
        }
    </style>

    <title>Data-Pinjaman</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="6%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 70%"><b>CETAK DATA BUKU BESAR</b>
        <br>
    <table style="position:absolute;margin-left: 612%;margin-top: 2%;">
        <tr>
            <td width="45">Nomor Akun</td>
            <td width="1">:</td>
            <td width="200">{!! $akun_perkiraan['id'] !!}</td>
        </tr>
        <tr>
            <td width="45">Nama Akun</td>
            <td width="1">:</td>
            <td width="200">{!! $akun_perkiraan['nama_akun'] !!}</td>
        </tr>
    </table>
    </p>
</header>
<br><br><br>
<table width="100%">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">No. Transaksi</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Tipe</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Akun</th>
            <th class="text-center">Debet</th>
            <th class="text-center">Kredit</th>
            <th class="text-center">Saldo</th>
        </tr>
    </thead>
    <tbody>
        @if($JurnalDetail->isEmpty())
            <tr>
                <td class="padd" colspan="9"><center>Data Tidak Ada</center></td>
            </tr>
            <tr>
                <td class="padd right" colspan="9"></td>
            </tr>
            <tr>
                <th colspan="9"></th>
            </tr>
        @else
            <?php $i = 1;?>
            @foreach($JurnalDetail as $detail)
                        <tr>
                            <td class="padd center"><center>{{$i++}}.</center></td>
                            <td class="padd">{{$detail->header->kode_jurnal}}</td>
                            <td class="padd center">{{ substr($detail->header->tanggal, 0, 10)}}</td>
                            <td class="padd center">{{$detail->header->tipe}}</td>
                            <td class="padd">{{$detail->header->keterangan}}</td>
                            <td class="padd">{{$detail->perkiraan->nama_akun}}</td>
                            <td class="padd right">Rp. {{ number_format($detail->debet, '2')}}</td>
                            <td class="padd right">Rp. {{ number_format($detail->kredit, '2')}}</td>
                            <td class="padd right">Rp. {{ number_format($detail->nominal, '2')}}</td>
                        </tr>
            @endforeach
                <tr>
                    <td class="padd right" colspan="9"></td>
                </tr>
                <tr>
                    <th colspan="9"></th>
                </tr>
        @endif
    </tbody>

</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
