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
        <?php $details = App\Model\Akuntansi\Perkiraan::where('parent', $row->id)->where('tipe_akun', 'detail')->get(); $total= "";?>
        <?php $countdetails = App\Model\Akuntansi\Perkiraan::where('parent', $row->id)->count();?>
        @if($countdetails != null)
            <tr>
                <td colspan="8" style="background: #979797">{{$row->nama_akun}}</td>
            </tr>
            @foreach($details as $detail)
                <?php $jurnaldetail = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail->id)->whereHas('header', function($q) use($tanggal){
                    $q->where('tanggal', '<=', $tanggal);
                })->sum('nominal'); $total+=$jurnaldetail; ?>
                @if($jurnaldetail==0)
                @else
                    <tr>
                        <td></td>
                        <td colspan="6">{{$detail->kode_akun}} - {{$detail->nama_akun}}</td>
                        <td align="right">{{number_format($jurnaldetail, '2')}}</td>
                    </tr>

                @endif
            @endforeach



            <?php $headers2 = App\Model\Akuntansi\Perkiraan::where('parent', $row->id)->where('tipe_akun', 'header')->get();?>

            @foreach($headers2 as $header2)
                <?php $details2 = App\Model\Akuntansi\Perkiraan::where('parent', $header2->id)->where('tipe_akun', 'detail')->get(); $total2= "";?>
                <?php $countdetails2 = App\Model\Akuntansi\Perkiraan::where('parent', $header2->id)->count();?>

                @if($countdetails2 != null)
                    <tr>
                        <td></td>
                        <td colspan="7" style="background-color: #c0c0c0">{{$header2->nama_akun}}</td>
                    </tr>
                    @foreach($details2 as $detail2)
                        <?php $jurnaldetail2 = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail2->id)->whereHas('header', function($q) use($tanggal){
                            $q->where('tanggal', '<=', $tanggal);
                        })->sum('nominal'); $total2+=$jurnaldetail2; ?>
                        @if($jurnaldetail2==0)
                        @else
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="5">{{$detail2->kode_akun}} - {{$detail2->nama_akun}}</td>
                                <td align="right">{{number_format($jurnaldetail2, '2')}}</td>
                            </tr>

                        @endif
                    @endforeach



                    <?php $headers3 = App\Model\Akuntansi\Perkiraan::where('parent', $header2->id)->where('tipe_akun', 'header')->get();?>

                    @foreach($headers3 as $header3)
                        <?php $details3 = App\Model\Akuntansi\Perkiraan::where('parent', $header3->id)->where('tipe_akun', 'detail')->get(); $total3[$header3->id]= ""; ?>
                        <?php $countdetails3 = App\Model\Akuntansi\Perkiraan::where('parent', $header3->id)->count(); $cektotal3[$header3->id]= "";?>
                        @foreach($details3 as $detail3)
                            <?php $jurnaldetail3 = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail3->id)->whereHas('header', function($q) use($tanggal){
                                $q->where('tanggal', '<=', $tanggal);
                            })->sum('nominal'); $cektotal3[$header3->id]+=$jurnaldetail3; ?>
                        @endforeach

                        @if($countdetails3 != null)
                            <?php $ck = $cektotal3[$header3->id];?>
                            @if($ck != 0)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="6" >{{$header3->nama_akun}}</td>
                                </tr>
                                @foreach($details3 as $detail3)
                                    <?php $jurnaldetail3 = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail3->id)->whereHas('header', function($q) use($tanggal){
                                        $q->where('tanggal', '<=', $tanggal);
                                    })->sum('nominal'); $total3[$header3->id]+=$jurnaldetail3; ?>
                                    @if($jurnaldetail3==0)
                                    @else
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan="4">{{$detail3->kode_akun}} - {{$detail3->nama_akun}}</td>
                                            <td align="right">{{number_format($jurnaldetail3, '2')}}</td>
                                        </tr>

                                    @endif
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td align="right" colspan="6" >-------------------------------------------------</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td align="right" colspan="5" >Total</td>
                                    <?php $st = $total3[$header3->id];?>
                                    <td align="right">{{number_format($st, '2')}}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    <tr>
                        <td></td>
                        <td colspan="6" style="background-color: #c0c0c0">Total {{$header2->nama_akun}}</td>
                        <td align="right" style="background-color: #c0c0c0">200.000</td>
                    </tr>
                    <tr><td></td><td>--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>
                @endif
            @endforeach
            <tr>
                <td colspan="7" style="background: #979797">Total {{$row->nama_akun}}</td>
                <td align="right" style="background: #979797">100.000.000</td>
            </tr>

        @endif
        <tr>
            <td colspan="8">==================================================================================================================================</td>
        </tr>
        <tr><td colspan="8"></td></tr>
    @endforeach
</table><br>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>
</body>
</html>
