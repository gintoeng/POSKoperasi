<!DOCTYPE html>
<html>
<head>

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
        <?php $details = App\Model\Akuntansi\Perkiraan::where('parent', $row->id)->where('tipe_akun', 'detail')->get(); $total[$row->id]= 0; $stot = 0;?>
        <?php $countdetails = App\Model\Akuntansi\Perkiraan::where('parent', $row->id)->count(); $cektotalnya[$row->id]=0;?>
        @foreach($details as $detail)
            <?php $jurnaldetail = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail->id)->whereHas('header', function($q) use($tanggal){
                $q->where('tanggal', '<=', $tanggal);
            })->sum('nominal'); $cektotalnya[$row->id]+=$jurnaldetail; ?>
        @endforeach
        @if($countdetails != null)

            <?php $headers2 = App\Model\Akuntansi\Perkiraan::where('parent', $row->id)->where('tipe_akun', 'header')->get(); $statas2[$row->id] = 0; $ckk[$row->id]=0;?>

            @foreach($headers2 as $key => $header2)
                <?php $details2 = App\Model\Akuntansi\Perkiraan::where('parent', $header2->id)->where('tipe_akun', 'detail')->get(); $total2[$header2->id]= 0;?>
                <?php $countdetails2 = App\Model\Akuntansi\Perkiraan::where('parent', $header2->id)->count(); $cektotal2[$header2->id]=0; ?>
                @foreach($details2 as $detail2)
                    <?php $jurnaldetail2 = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail2->id)->whereHas('header', function($q) use($tanggal){
                        $q->where('tanggal', '<=', $tanggal);
                    })->sum('nominal'); $cektotal2[$header2->id]+=$jurnaldetail2; ?>
                @endforeach

                <?php $headers3 = App\Model\Akuntansi\Perkiraan::where('parent', $header2->id)->where('tipe_akun', 'header')->get(); $ckatas[$header2->id] = 0;?>

                @foreach($headers3 as $header3)
                    <?php $details3 = App\Model\Akuntansi\Perkiraan::where('parent', $header3->id)->where('tipe_akun', 'detail')->get(); $total3[$header3->id]= 0; ?>
                    <?php $countdetails3 = App\Model\Akuntansi\Perkiraan::where('parent', $header3->id)->count(); $cektotal3[$header3->id]= 0;?>
                    @foreach($details3 as $detail3)
                        <?php $jurnaldetail3 = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail3->id)->whereHas('header', function($q) use($tanggal){
                            $q->where('tanggal', '<=', $tanggal);
                        })->sum('nominal'); $cektotal3[$header3->id]+=$jurnaldetail3; ?>
                    @endforeach
                    <?php $ck = $cektotal3[$header3->id];?>
                    <?php $ckatas[$header2->id]+=$ck;?>
                @endforeach
                <?php $ck2 = $cektotal2[$header2->id] + $ckatas[$header2->id];?>
                <?php $ckk[$row->id]+=$ck2;?>
            @endforeach
            <?php $cknya = $cektotalnya[$row->id] + $ckk[$row->id];?>
            @if($cknya > 0)

                <tr>
                    <td colspan="8" style="background: #979797">{{$row->nama_akun}}</td>
                </tr>
                @foreach($details as $detail)
                    <?php $jurnaldetail = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail->id)->whereHas('header', function($q) use($tanggal){
                        $q->where('tanggal', '<=', $tanggal);
                    })->sum('nominal'); $total[$row->id]+=$jurnaldetail; ?>
                    @if($jurnaldetail==0)
                    @else
                        <tr>
                            <td></td>
                            <td colspan="6">{{$detail->kode_akun}} - {{$detail->nama_akun}}</td>
                            <td align="right">{{number_format($jurnaldetail, '2')}}</td>
                        </tr>

                    @endif
                @endforeach



                <?php $headers2 = App\Model\Akuntansi\Perkiraan::where('parent', $row->id)->where('tipe_akun', 'header')->get(); $statas2[$row->id] = 0;?>

                @foreach($headers2 as $key => $header2)
                    <?php $details2 = App\Model\Akuntansi\Perkiraan::where('parent', $header2->id)->where('tipe_akun', 'detail')->get(); $total2[$header2->id]= 0;?>
                    <?php $countdetails2 = App\Model\Akuntansi\Perkiraan::where('parent', $header2->id)->count(); $cektotal2[$header2->id]=0; ?>
                    @foreach($details2 as $detail2)
                        <?php $jurnaldetail2 = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail2->id)->whereHas('header', function($q) use($tanggal){
                            $q->where('tanggal', '<=', $tanggal);
                        })->sum('nominal'); $cektotal2[$header2->id]+=$jurnaldetail2; ?>
                    @endforeach
                    @if($countdetails2 != null)

                        <?php $headers3 = App\Model\Akuntansi\Perkiraan::where('parent', $header2->id)->where('tipe_akun', 'header')->get(); $ckatas[$header2->id] = 0;?>

                        @foreach($headers3 as $header3)
                            <?php $details3 = App\Model\Akuntansi\Perkiraan::where('parent', $header3->id)->where('tipe_akun', 'detail')->get(); $total3[$header3->id]= 0; ?>
                            <?php $countdetails3 = App\Model\Akuntansi\Perkiraan::where('parent', $header3->id)->count(); $cektotal3[$header3->id]= 0;?>
                            @foreach($details3 as $detail3)
                                <?php $jurnaldetail3 = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail3->id)->whereHas('header', function($q) use($tanggal){
                                    $q->where('tanggal', '<=', $tanggal);
                                })->sum('nominal'); $cektotal3[$header3->id]+=$jurnaldetail3; ?>
                            @endforeach
                            <?php $ck = $cektotal3[$header3->id];?>
                            <?php $ckatas[$header2->id]+=$ck;?>
                        @endforeach
                        <?php $ck2 = $cektotal2[$header2->id] + $ckatas[$header2->id];?>

                        @if($ck2 > 0)
                            <tr id="tratas{{$row->id}}{{$key}}">
                                <td></td>
                                <td colspan="7" style="background-color: #d7d7d7">{{$header2->nama_akun}}</td>
                            </tr>
                            @foreach($details2 as $detail2)
                                <?php $jurnaldetail2 = App\Model\Akuntansi\JurnalDetail::where('id_akun', $detail2->id)->whereHas('header', function($q) use($tanggal){
                                    $q->where('tanggal', '<=', $tanggal);
                                })->sum('nominal'); $total2[$header2->id]+=$jurnaldetail2; ?>
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



                            <?php $headers3 = App\Model\Akuntansi\Perkiraan::where('parent', $header2->id)->where('tipe_akun', 'header')->get(); $statas[$header2->id] = 0;?>

                            @foreach($headers3 as $header3)
                                <?php $details3 = App\Model\Akuntansi\Perkiraan::where('parent', $header3->id)->where('tipe_akun', 'detail')->get(); $total3[$header3->id]= 0; ?>
                                <?php $countdetails3 = App\Model\Akuntansi\Perkiraan::where('parent', $header3->id)->count(); $cektotal3[$header3->id]= 0;?>
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
                                        <tr style="font-weight: bold">
                                            <td></td>
                                            <td></td>
                                            <td align="right" colspan="5" >Total</td>
                                            <?php $st = $total3[$header3->id];?>
                                            <?php $statas[$header2->id]+=$st;?>
                                            <td align="right">{{number_format($st, '2')}}</td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            <?php $stnya = $statas[$header2->id];?>
                            <?php $st2 = $total2[$header2->id];?>
                            <?php $sthasil = $stnya + $st2;?>
                            <?php $statas2[$row->id]+=$sthasil;?>
                            @if($sthasil > 0)
                                <tr>
                                    <td></td>
                                    <td colspan="6" style="background-color: #d7d7d7">Total {{$header2->nama_akun}}</td>
                                    <td align="right" style="background-color: #d7d7d7">{{number_format($sthasil, '2')}}</td>
                                </tr>
                                <tr><td></td><td>------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>
                            @endif
                        @endif

                    @endif
                @endforeach
                <?php $st3 = $total[$row->id];?>
                <?php $stot = $statas2[$row->id] + $st3;?>

                @if($stot > 0)
                    <tr>
                        <td colspan="7" style="background: #979797">Total {{$row->nama_akun}}</td>
                        <td align="right" style="background: #979797">{{number_format($stot, '2')}}</td>
                    </tr>
                @endif

            @endif

        @endif
        @if($cknya > 0)
            <tr>
                <td colspan="8">==================================================================================================================================</td>
            </tr>
            <tr><td colspan="8"></td></tr>
        @endif
    @endforeach
</table><br>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    {{date('r')}}
</div>
</body>
</html>
