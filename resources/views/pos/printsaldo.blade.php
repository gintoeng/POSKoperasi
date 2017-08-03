<!DOCTYPE html>
<html>
<head>
    <title>Point Of Sale</title>
</head>
<body onload="window.print()">
<div style="width:100%;margin-left:0%;margin-top:0pt;font-size:12pt;position:absolute;text-align:center"><b></b>{{ $koperasi->nama_koperasi  }}</div>
<label style="height:5%;width:100%;margin-top:10%;text-align:center;position:absolute;font-size:9pt"><b>{{ $koperasi->alamat_koperasi  }}</b></label>
<label style="position:absolute;margin-top:15%;margin-left:-18%">-----------------------------------------------------------------------</label>
<div style="height:5%;width:100%;margin-top:23%;margin-left:60%;position:absolute;font-size:8pt">Tanggal&nbsp;:</div>
<div style="height:5%;width:100%;margin-top:23%;margin-left:79%;position:absolute;font-size:8pt"><?php echo date("Y-m-d");?></div>
<div style="height:5%;width:100%;margin-top:30%;margin-left:0%;position:absolute;font-size:8pt">NPK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $getsaldo->npk  }}</div>
<div style="height:5%;width:100%;margin-top:37%;margin-left:0%;position:absolute;font-size:8pt">Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $getsaldo->nama  }}</div>
<div style="height:5%;width:100%;margin-top:44%;margin-left:0%;position:absolute;font-size:8pt">Kode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $getsaldo->kode  }}</div>

    <div style="position:absolute;margin-top:57%;margin-left:-18%">------------------------------------------------------------------------------</div>
    <div style="margin-top:50%;margin-left:44.5%;position:absolute;font-size:8pt">Saldo &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</div>
    <div style="margin-top:50%;margin-left:66%;position:absolute;font-size:8pt">Rp. {!! number_format($saldo ,2,",",".") !!}</div>
<div style="margin-top:56%;margin-left:0%;position:absolute;font-size:8pt">Total Transaksi yang digunakan &nbsp;&nbsp;&nbsp;:</div>
<div style="margin-top:56%;margin-left:66%;position:absolute;font-size:8pt">Rp. {!! number_format($totaltrs ,2,",",".") !!}</div>


</body>
</html>
