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
            background: #d8d8d8;
            border-top: 1px solid black;
            border-collapse: collapse;
            font-size:10pt;
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

    <title>Laporan-Barang-Keluar</title>
</head>

<body class="metro" onload="StartClock()" onunload="KillClock()">
<header> 
    <div style="margin-top:2%;">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p> 
    </div>    
    <p style="padding-left:25%; padding-right:25%;"><b>LAPORAN BARANG BERDASAR JENIS</b>
        <br>
        <table style="position:absolute;margin-top: 3%; margin-left:350%;">
            <tr>
                <td width="50">Tanggal</td>
                <td width="1">:</td>
                <td>{!!$tanggal!!}</td>                
            </tr>
            <tr style="font-size: 5pt">
                <td width="20">Jenis</td>
                <td width="1">:</td><td width="100">BARANG KELUAR</td>
            </tr>
        </table>
    </p>
</header>
<br><br><br>
<table width="100%" style="margin-top:3%;">
    <thead>
    <tr>
        <th class="text-center" width="5%">No</th>
        <th class="text-center" width="15%">Barang</th>
        <th class="text-center" width="15%">Jumlah</th>
        <th class="text-center" width="15%">Total</th>
        <th class="text-center" width="15%">Barcode</th>
        <th class="text-center" width="15%">Kasir</th>
        <th class="text-center" width="15%">No REF</th>
        <th class="text-center" width="15%">Tanggal</th>
    </tr>
    </thead>
    <tbody> 
    <?php
                        $i = 1;
                        ?> 
                        @foreach ($transaksi_detail as $value)
                    <tr>
                        <td>{!! $i++ !!}</td>
                        <td>{!! $value->produk !!}</td>
                        <td>{!! $value->qty !!}</td>
                        <td>{!! number_format($value->sub_total, 2, '.',',') !!}</td>
                        <td>{!! $value->barcode !!}</td>
                        <td>{!! $value->kasir !!}</td>
                        <td>{!! $value->no_ref !!}</td>                     
                        <td>{!! $value->created_at !!}</td>
                    </tr>
                @endforeach       
    </tbody>
    <tfoot>
    <tr>
        <th colspan="11" align="right"> </th>
    </tr>
    </tfoot>
</table>
<br>

</body>
</html>
