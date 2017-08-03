<html>
<head>
    <title>Point Of Sale</title>
</head>
<body>
<label style="width: 100%;margin-left: 0%;margin-top:0pt;font-size:12pt;position:absolute;text-align: center;"><b>{!! $koperasi->nama_koperasi !!}</b></label>
<label style="background:;height:5%;width:100%;margin-top:10%;text-align:center;position:absolute;font-size:9pt"><b>{!! $koperasi->alamat_koperasi !!}</b></label>
<label style="position:absolute;margin-top:15%;margin-left:-18%">-----------------------------------------------------------------------</label>
<div style="background:;height:5%;width:100%;margin-top:20%;margin-left:60%;position:absolute;font-size:8pt">Tanggal&nbsp;:</div>
<div style="background:;height:5%;width:100%;margin-top:20%;margin-left:79%;position:absolute;font-size:8pt"><?php echo date("Y-m-d");?></div>
<div style="background:;height:5%;width:100%;margin-top:25%;margin-left:5%;position:absolute;font-size:8pt">No. Ref : {!! $noref !!}</div>
<div style="background:;height:5%;width:100%;margin-top:30%;margin-left:5%;position:absolute;font-size:8pt">Kasir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {!! $namakasir !!}</div>
<div style="background:;height:5%;width:100%;margin-top:37%;margin-left:5%;position:absolute;font-size:8pt">Jenis Pembayaran&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Tunda</div>

<div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:45%; margin-left:0%; width:100%;height:5%;">
    <!--     <div class="x_panel" style="background:#FFF;margin-top:-40px;height:35%;">-->
    <table border="1" class="display dataTable table table-hover" cellspacing="0" style="margin-top:0px; margin-left:0px;width:100%;position:relative;">
        <thead>
        </thead>
        <tbody style="height: 5%;">
        @foreach ( $produk as $value )
            <tr style="border-solid:1px;font-size:8pt; color:black;">
                <td align="center">{!! $value->produk !!}</td>
                <td align="center">{!! $value->qty !!}</td>
                <td align="center">Rp. {!! number_format($value->harga ,2,",",".") !!}</td>
                <td align="center">Rp. {!! number_format($value->sub_total ,2,",",".") !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- </div>-->
    <div style="position:absolute;margin-top:10%;margin-left:-18%">------------------------------------------------------------------------------</div>
    <div style="position:absolute;margin-top:33%;margin-left:-18%">------------------------------------------------------------------------------</div>
    <div style="margin-top:0%;margin-left:50%;position:absolute;font-size:8pt">Total &nbsp;&nbsp;:</div>
    <div style="margin-top:7%;margin-left:50%;position:absolute;font-size:8pt">Hemat :</div>
    <div style="margin-top:0%;margin-left:67%;position:absolute;font-size:8pt">Rp. {!! number_format($totalnya ,2,",",".") !!}</div>
    <div style="margin-top:7%;margin-left:67%;position:absolute;font-size:8pt">Rp. {!! number_format($diskon ,2,",",".") !!}</div>
    <div style="margin-top:20%;margin-left:0%;position:absolute;font-size:8pt">NPK&nbsp;&nbsp;&nbsp;:</div>
    <div style="margin-top:20%;margin-left:15%;position:absolute;font-size:8pt">{{ $getanggota->npk }}</div>

    <div style="margin-top:30%;margin-left:0%;position:absolute;font-size:8pt">Total Transaksi yang digunakan&nbsp;&nbsp;&nbsp;:</div>
    <div style="margin-top:30%;margin-left:65%;position:absolute;font-size:8pt">Rp. {!! number_format($total_bersih ,2,",",".") !!}</div>
</div>

</body>
</html>
