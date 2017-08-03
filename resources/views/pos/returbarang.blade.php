<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
@include('templates.headerpos')
</head>

<body>
    <style>
    body{
    margin:0;
    background-color:#369;
    overflow:auto;
}
</style>
    </body>
<body id="" style="overflow:auto">
<!--header-->
<div style="width:100%; height:140px; overflow:hidden; margin: 0 auto; background-color:#369">
  <div style="width:1500px; height:120px; margin:0 auto; overflow:hidden; position:relative">
           <a onclick="FunctionLoading()" href="{!!url('/pos/penjualan')!!}"><div id="caption" style="cursor:pointer;height:100px; margin-top:50px;float:left; margin-left:80px; position:absolute"><img src="{{ url('assets/poscss/imgs/backbtn.png') }}" alt=""> Retur Penjualan </div></a>
       <div id="pagecaption" style="height:44px; margin-top:0px;float:left; margin-left:12px; position:absolute"> Caption </div>
  </div>
</div>
<input type="hidden" id="idnyaaa">
<form action="{{ url('pos/retur')  }}" method="get">
<button id="btnok" type="submit" style="width:7%;height:5%;color:#FFF;;background:#3498db;border:none;margin-top:550px;position:absolute;text-align:center;font-size:18px;position:absolute;margin-left:79%">Retur</button>
<div style="margin-top:2%;margin-left:10%;font-size:25px;position:absolute;color:#FFF">No Ref   :</div>
<div style="margin-top:2%;margin-left:68%;font-size:25px;position:absolute;color:#FFF">Jenis Pembayaran   :</div>
<div id="Enoref" style="margin-top:2%;margin-left:18%;font-size:25px;position:absolute;color:#FFF">{{ $nomor  }}</div>
<input type="hidden" name="nomor" value="{{ $nomor  }}"/>
    <input type="hidden" name="type" value="{{ $jenis_pembayaran  }}"/>
<div id="" style="margin-top:2%;margin-left:85%;font-size:25px;position:absolute;color:#FFF">{{ $jenis_pembayaran  }}</div>
<input type="hidden" id="Eid" style="position:absolute">

<div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:100px; margin-left:50px; width:92.5%;height:60%;">

                                    <div class="x_panel" style="background:#369;margin-top:-40px">
                                    <div id="table-scrolll">
                                    <table  class="table table-hover" style="margin-top:0px; margin-left:0px;width:100%;position:relative;background:white;">
                                       <thead>
                                            <tr style="background:#3498db; color: white; font-size:20px;">
                                                <td align="center">Produk</td>
                                                <td align="center">Qty</td>
                                                <td align="center">Harga</td>
                                                <td align="center">Subtotal</td>
                                                <td align="center" width="10%;">Retur</td>
                                                <td align="center"><input id="TableManual" type="checkbox" style="cursor:pointer;"></td>
                                            </tr>
                                        </thead>
                                        <?php $i = 1; ?>
                                        @foreach($produk as $value)
                                        <tbody style="height: 50px;">
                                            <tr style="background-color: white; font-size:18px; color:black;">
                                                <td align="center">{{ $value->produk  }}</td>
                                                <td align="center">{{ $value->qty  }}</td>
                                                <td align="center">Rp. {!! number_format($value->harga ,2,",",".") !!}</td>
                                                <td align="center">Rp. {!! number_format($value->sub_total ,2,",",".") !!}</td>
                                                <td align="center"><input type="text" name="qty{{ $value->id  }}"  style="margin-top:-1%;width:40%;text-align:center;"></td>
                                                <td align="center"><input type="checkbox" name="cbpilih[{{ $value->id  }}]" style="cursor:pointer;"></td>
                                  </tr>
                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <div style="margin-left:6%;top:575px;position:absolute"></div>
</form>
<a onclick="FunctionLoading()" href="{!! url('pos/penjualan') !!}"><button style="width:7%;height:5%;color:#FFF;background:#e74c3c;border:none;margin-top:0px;position:absolute;text-align:center;font-size:18px;position:absolute;margin-left:87%">Kembali</button></a>

<script>

        $('#TableManual').click(function (e) {
            $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
        });

        function ceknomor(id){
        var dialog = $(id).data('dialog');
        dialog.open();
        };

        $('#btnok').on('click', function () {
            window.open("{{ url('pos/penjualan') }}");
        });

</script>
</body>
</html>
