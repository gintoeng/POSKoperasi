<label style="width: 100%;margin-left: 0%;margin-top:0pt;font-size:12pt;position:absolute;text-align: center;">{{ $nama_koperasi  }}<b></b></label>
<label style="background:;height:5%;width:100%;margin-top:10%;text-align:center;position:absolute;font-size:9pt"><b>{{ $alamat_koperasi  }}</b></label>
<label style="position:absolute;margin-top:15%;margin-left:-18%">-----------------------------------------------------------------------</label>
<div style="background:;height:5%;width:100%;margin-top:20%;margin-left:60%;position:absolute;font-size:8pt">Tanggal&nbsp;:</div>
<div style="background:;height:5%;width:100%;margin-top:20%;margin-left:79%;position:absolute;font-size:8pt"><?php echo date("Y-m-d");?></div>
<div style="background:;height:5%;width:100%;margin-top:25%;margin-left:5%;position:absolute;font-size:8pt">No. Ref : {{  $norefnya }}</div>
<div style="background:;height:5%;width:100%;margin-top:30%;margin-left:5%;position:absolute;font-size:8pt">Kasir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $kasir  }}</div>
<div style="background:;height:5%;width:100%;margin-top:37%;margin-left:5%;position:absolute;font-size:8pt">Tentang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Retur Pembelian</div>

<div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:45%; margin-left:0%; width:100%;height:5%;">
    <table border="1" class="display dataTable table table-hover" cellspacing="0" style="margin-top:0px; margin-left:0px;width:100%;position:relative;">
        <thead>
        </thead>
        <tbody style="height: 5%;">
            @foreach($returbarang as $value)
            <tr style="border-solid:1px;font-size:8pt; color:black;">
                <td align="center">{{ $value->produk  }}</td>
                <td align="center">{{ $value->qty  }}</td>
                <td align="center">Rp. {!! number_format($value->harga ,2,",",".") !!}</td>
                <td align="center">Rp. {!! number_format($value->sub_total ,2,",",".") !!}</td>
            </tr>
@endforeach
        </tbody>
    </table>
    <!-- </div>-->
    <div style="position:absolute;margin-top:10%;margin-left:-18%">------------------------------------------------------------------------------</div>
    <div style="position:absolute;margin-top:20%;margin-left:-18%">------------------------------------------------------------------------------</div>
    <div style="margin-top:0%;margin-left:50%;position:absolute;font-size:8pt">Total &nbsp;&nbsp;:</div>
    <div style="margin-top:19%;margin-left:0%;position:absolute;font-size:8pt">No. Kartu&nbsp;&nbsp;&nbsp;:</div>
    <div style="margin-top:0%;margin-left:67%;position:absolute;font-size:8pt">Rp. {!! number_format($jumlah ,2,",",".") !!}</div>
    <div style="margin-top:19%;margin-left:25%;position:absolute;font-size:8pt"><b>{{ $kartu  }}</b></div>

</div>
