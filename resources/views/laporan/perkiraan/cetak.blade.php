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
        .center{

        }
        p {
            margin-top: auto;
            margin-left: 3%;
            font-size:10pt;
            position: absolute;
        }
    </style>

    <title>Data-Perkiraan</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN AKUN PERKIRAAN</b>
        <br>
        {{$tipe}}
    </p>
</header>
<br><br><br><br><br><br>
<table width="100%">
    <thead>
    <tr>
        <th class="text-center" width="5%">No</th>
        <th class="text-center" width="25%">Kode</th>
        <th class="text-center" width="50%">Nama</th>
        <th class="text-center" width="8%">Tipe</th>
        <th class="text-center" width="12%">Kas/Bank</th>
    </tr>
    </thead>
    <tbody>
        @if($tipe=="Semua Kelompok")
            @foreach($kelompok as $row)
            <tr>
                <td class="text-center"><center><b>{{$i++}}.</b></center></td>
                <td colspan="4"><b>{{$row->nama_akun}}</b></td>
            </tr>
                <?php $akunperkelompok = App\Model\Akuntansi\Perkiraan::where('kelompok', $row->id)->orderBy($urut,$urutan)->get(); ?>
                @foreach($akunperkelompok as $akuns)
                    <tr>
                    <td class="text-center"></td>
                    <td>{{$akuns->kode_akun}}</td>
                    <td class="text-center">{{$akuns->nama_akun}}</td>
                    <td>@if($akuns->tipe_akun=="header") <center>H</center> @else <center>D</center> @endif</td>
                    <td><center>@if($akuns->kas=="1") <center>Y</center> @else  @endif</center></td>
                </tr>
                @endforeach()
            @endforeach
        @elseif($tipe=="Kelompok")
            <tr>
                <td class="text-center"><center><b>{{$i++}}.</b></center></td>
                <td colspan="4"><b>{{$kelompok->nama_akun}}</b></td>
            </tr>
            <?php $akunperkelompok = App\Model\Akuntansi\Perkiraan::where('kelompok', $kelompok->id)->orderBy($urut,$urutan)->get(); ?>
            @foreach($akunperkelompok as $akuns)
                <tr>
                    <td class="text-center"></td>
                    <td>{{$akuns->kode_akun}}</td>
                    <td class="text-center">{{$akuns->nama_akun}}</td>
                    <td>@if($akuns->tipe_akun=="header") <center>H</center> @else <center>D</center> @endif</td>
                    <td><center>@if($akuns->kas=="1") <center>Y</center> @else  @endif</center></td>
                </tr>
            @endforeach()
        @endif
    </tbody>
    <tfoot>
    <tr>
        <th colspan="11" align="right"> </th>
    </tr>
    </tfoot>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
