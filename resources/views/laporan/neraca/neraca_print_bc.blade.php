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
                <td width="50">Tanggal</td>
                <td width="1">:</td>
                <td width="100">{!! $tanggal !!}</td>
            </tr>
        </table>
    </p>
</header>
<br><br><br><br><br><br><hr>
        <table width="100%">
                @foreach($akunheader as $row)
                    <tr>
                        <td></td>
                        <td colspan="8">{{$row->nama_akun}}</td>
                    </tr>
                    <?php $details = App\Model\Akuntansi\Perkiraan::where('kelompok', $row->id)->get(); $total = "";?>
                    @foreach($details as $detail)
                        <?php $jurnaldetail = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail->id)->whereHas('header', function($q) use($tanggal){
//                                    $q->where('tanggal', 'LIKE', '%'.$tanggal."%");
                                    $q->where('tanggal', '<=', $tanggal);
                                })->sum('nominal'); $total+=$jurnaldetail; ?>
                        @if($jurnaldetail==0)
                        @else
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="6">{{$detail->nama_akun}}</td>
                                    <td>Rp.{{number_format($jurnaldetail, '2')}}</td>
                                </tr>

                        @endif
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="6" style="text-align:right;padding-right:10px;">Total</td>
                        <td><b>Rp.{{number_format($total,'2')}}</b></td>
                    </tr>
                    <tr>
                        <td colspan="9">----------------------------------------------------------------------------------------------------------------------------------</td>
                    </tr>
                    <tr><td colspan="9"></td></tr>
                @endforeach
        </table><br>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>
</body>
</html>
