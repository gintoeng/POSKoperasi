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
        p {
            margin-top: auto;
            margin-left: 3%;
            font-size:10pt;
            position: absolute;
        }
    </style>

    <title>Data-Customer</title>
</head>

<?php $profil = \App\Model\Pengaturan\Profil::findOrNew(1); $i = 1;?>
<body class="metro" onload="StartClock()" onunload="KillClock()">
<header>
    <img src="{{ public_path('foto/profil/'.$profil->foto) }}" alt="" width="10%" style="float: left">
    <p ><b>{!! $profil->nama_koperasi !!}</b> <br>{!! $profil->alamat_koperasi !!}
        <br> {!! $profil->telepon !!} / {!! $profil->kode_pos !!}
        <br> - <br>User : {!! \Illuminate\Support\Facades\Auth::user()->username !!}
    </p>
    <p style="margin-left: 50%"><b>LAPORAN STOK BARANG</b>
        <br>
    <table style="position:absolute;margin-left: 260%;margin-top: 2%;">
        <tr>
            <td width="1">Status</td>
            <td width="1">:</td>
            <td width="1000">{!! $stnya !!}</td>
        </tr>
        <tr>
            <td width="1">Cabang</td>
            <td width="1">:</td>
            <td width="1000">{!! $cbnya  !!}</td>
        </tr>
        <tr>
            <td width="1">Unit</td>
            <td width="1">:</td>
            <td>{!! $unnya  !!}</td>
        </tr>
        <tr>
            <td width="1">Kategori</td>
            <td width="1">:</td>
            <td>{!! $ktnya  !!}</td>
        </tr>
    </table>
    </p>
</header>
<br><br/><br><br/><br><br/><br>
<table width="100%">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Barcode</th>
        <th class="text-center">Nama</th>
        <th class="text-center">Merk</th>
        <th class="text-center">Kategori</th>
        <th class="text-center">Harga Beli</th>
        <th class="text-center">Harga Jual</th>
        <th class="text-center">Cabang</th>
        <th class="text-center">Stok</th>
        <th class="text-center">Unit</th>
    </tr>
    </thead>
    <tbody>
    <?php $s = 0; $prod = "";?>
    @foreach($produk as $value)
        <?php $s+=$value->stok; ?>

            <tr>
                @if($prod != $value->id_produk)
                    <td align="center">{!! $i++ !!}</td>
                    <td>{!! $value->produkid->barcode !!}</td>
                    <td>{!! $value->produkid->nama !!}</td>
                    <td>{!! $value->produkid->classification !!}</td>
                    <td>{!! $value->produkid->kategoriid->nama !!}</td>
                    <td align="right">{!! number_format($value->produkid->harga_beli, 2, '.',',') !!}</td>
                    <td align="right">{!! number_format($value->produkid->harga_jual, 2,'.',',') !!}</td>
                @else
                    <td colspan="7"></td>
                @endif
                <td>{!! $value->cabangid->nama !!}</td>
                <td align="center">{!! $value->stok !!}</td>
                <td>{!! $value->produkid->unitid->nama !!}</td>
            </tr>
            @if($prod == $value->id_produk)
                <?php $mapro = \App\Model\Master\Mappingbarang::where('id_produk', $value->id_produk)->sum('stok');?>
                <tr><td colspan="8"></td><td>-------------------------------</td></tr>
                <tr>
                    <td colspan="8"></td>
                    <td align="center">{!! $mapro !!}</td>
                    <td>{!! $value->produkid->unitid->nama !!}</td>
                </tr>
                <tr>
                    {{--<td colspan="10">---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>--}}
                    <td colspan="10">=======================================================================================================================</td>
                </tr>
            @endif
        <?php $prod = $value->id_produk; ?>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="10" align="right"> </th>
    </tr>
    </tfoot>
</table>
<br>
<div style="text-align: right">
    <?php date_default_timezone_set('Asia/Jakarta'); ?>     {{date('r')}}
</div>


</body>
</html>
