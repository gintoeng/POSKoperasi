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
    <p style="margin-left: 70%"><b>CETAK DATA JURNAL</b>
        <br>
    <table style="position:absolute;margin-left: 555%;margin-top: 2%;">
        <tr>
            <td width="20">TIPE</td>
            <td width="1">:</td>
            <td width="79">{!! $tipe !!}</td>
        </tr>
    </table>
    </p>
</header>
<br><br><br><br><br><br>
<table width="100%">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">No. Transaksi</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Status</th>
            <th class="text-center">Akun</th>
            <th class="text-center">Nama Akun</th>
            <th class="text-center">Keterangan</th>
            <th class="text-center">Debet</th>
            <th class="text-center">Kredit</th>
        </tr>
    </thead>
    <tbody>
        @if($JurnalHeader->isEmpty())
            <tr>
                <td class="padd" colspan="10"><center>Data Tidak Ada</center></td>
            </tr>
            <tr>
                <td colspan="9">------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
            </tr>
        @else
            <?php $i = 1; $prev_kode_jurnalManual = '';?>
            @foreach($JurnalHeader as $header)
                @if($akun_perkiraan=="semua" || $akun_perkiraan=="")
                    @foreach($header->detail as $detail)
                        <tr>
                                @if($header['kode_jurnal'] != $prev_kode_jurnalManual)
                                    <td class="padd" rowspan="<?php $header->detail->count();?>"><center>{{$i++}}</center></td>
                                    <td class="padd" rowspan="<?php $header->detail->count();?>">{{$header['kode_jurnal']}}</td>
                                @else
                                    <td></td><td></td>
                                @endif
                            <td class="padd"><center><?php echo substr($header['tanggal'], 0,10); ?></center></td>
                            @if($detail->posting==1)
                            <td class="padd" style="color:blue;"><center> Sudah diposting </center></td>
                            @else
                            <td class="padd" style="color:red;"><center> Blm diposting </center></td>
                            @endif
                            <td class="padd">{{ $detail->perkiraan['kode_akun'] }}</td>
                            <td class="padd">{!! $detail->perkiraan['nama_akun'] !!}</td>
                            <td class="padd">{!! $header->keterangan !!}</td>
                            <td class="right padd">Rp. <?php echo number_format($detail->debet, '2');?></td>
                            <td class="right padd">Rp. <?php echo number_format($detail->kredit, '2');?></td>
                            <?php $prev_kode_jurnalManual = $header['kode_jurnal']; ?>
                        </tr>
                    @endforeach
                @else
                    @foreach($header->detail->where('id_akun', $akun_perkiraan) as $detail)
                        <tr>
                            <?php
                                if($header['kode_jurnal'] != $prev_kode_jurnalManual){
                                    echo '<td class="padd" rowspan="'.$header->detail->where('id_akun', $akun_perkiraan)->count().'"><center>'.$i++.'.</center></td>';
                                    echo '<td class="padd" rowspan="'.$header->detail->where('id_akun', $akun_perkiraan)->count().'">'.$header['kode_jurnal'].'</td>';
                                }
                            ?>
                            <td class="padd"><center><?php echo substr($header['tanggal'], 0,10); ?></center></td>
                            @if($detail->posting==1)
                            <td class="padd" style="color:blue;"><center> Sudah diposting </center></td>
                            @else
                            <td class="padd" style="color:red;"><center> Blm diposting </center></td>
                            @endif
                            <td class="padd">{{ $detail->perkiraan['kode_akun'] }}</td>
                            <td class="padd">{!! $detail->perkiraan['nama_akun'] !!}</td>
                            <td class="padd">{!! $header->keterangan !!}</td>
                            <td class="right padd">Rp. <?php echo number_format($detail->debet, '2');?></td>
                            <td class="right padd">Rp. <?php echo number_format($detail->kredit, '2');?></td>
                            <?php $prev_kode_jurnalManual = $header['kode_jurnal']; ?>
                        </tr>
                    @endforeach
                @endif
                    <tr>
                        <td colspan="9">------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
                    </tr>
            @endforeach
        @endif
    </tbody>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
