<!DOCTYPE html>
<html>
<head>

    <style type="text/css">
        table, td {
            border: 0px solid black;
            border-collapse: collapse;
            font-size:9pt;
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

    <title>Laporan Retur Penjualan</title>
</head>

<body class="metro">
<header>
    <div style="margin-top:2%;">
        <p ><b>{!! $nama_koperasi !!} / Cabang : {{ $cbnya }}</b> <br>{!! $alamat_koperasi !!}
            <br> {!! $telepon_koperasi !!}
        </p>
    </div>
    <p style="padding-left:31%; padding-right:31%;"><b>LAPORAN RETUR PENJUALAN</b>
        <br>
    <table style="position:absolute;margin-top: 3%; margin-left:350%;">
        <tr>
            <td width="50">Tanggal</td>
            <td width="1">:</td>
            <td>{!! $df !!}</td>
        </tr>
        <tr style="font-size: 5pt">
            <td width="20">Jenis Trs</td>
            <td width="1">:</td><td width="100">{{ $jenis }}</td>
        </tr>
    </table>
    </p>
</header>
<br><br><br>
<table width="100%" style="margin-top:3%;">
    <thead>
    <tr>
        <th class="text-center" width="10%">No</th>
        <th class="text-center" width="20%">No Ref</th>
        <th class="text-center" width="20%">Produk</th>
        <th class="text-center" width="20%">Tanggal</th>
        <th class="text-center" width="20%">Harga</th>
        <th class="text-center" width="25%">Qty</th>
        <th class="text-center" width="25%">Jumlah</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    ?>
    @foreach ($pendapatan as $value)
        <tr>
            <td><center>{!! $i++ !!}.</center></td>
            <td><center>{!! $value->no_ref !!}</center></td>
            <td><center>{!! $value->produk !!}</center></td>
            <td><center>{!!$value->tanggal!!}</center></td>
            <td><center>Rp. {!! number_format($value->harga ,2,",",".") !!}</center></td>
            <td><center>{!!$value->qty!!}</center></td>
            <td><center>Rp. {!! number_format($value->sub_total ,2,",",".") !!}</center></td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="center"></th>
        <th colspan="" align="right">Total</th>
        <th colspan="" align="center">Rp. {!! number_format($jumlah ,2,",",".") !!}</th>
    </tr>
    </tfoot>
</table>
<br>

</body>
</html>
