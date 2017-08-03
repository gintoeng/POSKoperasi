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

    <title>Invoice</title>
</head>

<?php $profil = \App\Model\Pengaturan\Profil::findOrNew(1); $i = 1;?>
<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p><center><b><label style="font-size: 20px">{{$profil->nama_koperasi}}</label></b> <br>{{$profil->alamat_koperasi}}
        <br> {{$profil->telepon}} - {{$profil->kode_pos}}
    </center></p>
</header>
<br><hr>
<header>

    <div style="margin-top:2%;">
        <p>
            <br>{{$header->vendor->nama_vendor}}

            <br>Alamat &nbsp;&nbsp;: {{$header->vendor->alamat1}}
            <br>Telepon &nbsp;&nbsp;: {{$header->vendor->phone}}
        </p>
    </div>
    <p style="padding-left:25%; padding-right:25%;"><b></b>
        <br>
    </p>

    <div style="margin-left:60%;margin-top: 2%">
        <p>
            <br><label style="font-size: 20px"><b>Purchase Order (P.O)</b></label>
            <br>
            <br>Tanggal &nbsp;&nbsp;: {{$header->tanggal}}
        </p>
    </div>

</header>
<br><br><br>
<table width="100%" style="margin-top:6%;">
    <thead>
    <tr>
        <th class="text-center" width="10%">No</th>
        <th class="text-center" width="20%">Produk</th>
        <th class="text-center" width="20%">Qty</th>
        <th class="text-center" width="25%">Satuan</th>
        <th class="text-center" width="25%">Harga Satuan</th>
        <th class="text-center" width="25%">Total Harga</th>
    </tr>
    </thead>
    <tbody>
    @foreach($detail as $details)
        <tr>
            <td align="center">{{$i++}}</td>
            <td>{{$details->barang->nama}}</td>
            <td align="center">{{$details->qty}}</td>
            <td align="center">{{$details->barang->unitid->nama}}</td>
            <td align="right">{{$details->barang->harga_beli}}</td>
            <td align="right">{{number_format($details->sub_total, '2')}}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="11" align="right"></th>
    </tr>
    </tfoot>
</table>
<br>

</body>
</html>
