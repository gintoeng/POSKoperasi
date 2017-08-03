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
<body id="" style="overflow:auto">
<!--header-->
<div style="width:100%; height:140px; overflow:hidden; margin: 0 auto; background-color:#369">
  <div style="width:1500px; height:120px; margin:0 auto; overflow:hidden; position:relative">
           <a onclick="FunctionLoading()" href="{!!url('/pos/penjualan')!!}"><div id="caption" style="cursor:pointer;height:100px; margin-top:50px;float:left; margin-left:80px; position:absolute"><img src="{{ url('assets/poscss/imgs/backbtn.png') }}" alt=""> Data Produk </div></a>
       <div id="pagecaption" style="height:44px; margin-top:0px;float:left; margin-left:12px; position:absolute"> Caption </div>
  </div>
</div>
<input type="hidden" id="idnyaaa">
<button id="cari" style="width:7%;height:4%;color:#FFF;;background:#3498db;border:none;margin-top:19px;position:absolute;text-align:center;font-size:18px;position:absolute;margin-left:87.2%">Cari</button>

{{--<input id="barangnya" style="width:21%;height:5%;border:none;margin-top:15px;position:absolute;font-size:18px;position:absolute;margin-left:65%;text-align:center;color:#000">--}}

<div style="font-size:17px;position:absolute;margin-left:65%;%;width:22.2%;margin-top:1.3%;height:27%">
    <select style="width:100%;font-size:16px;margin-left:0%;height:100%;position:absolute;color:black;margin-top:0%" id="barangnya">
        @foreach($produk2 as $values)
            <option></option>
            <option value="{!! $values->barcode !!}">{!! $values->barcode !!} - {!! $values->nama !!}</option>
        @endforeach
    </select>
</div>
<button id="btnok" style="width:7%;height:5%;color:#FFF;;background:#3498db;border:none;margin-top:550px;position:absolute;text-align:center;font-size:18px;position:absolute;margin-left:79%">OK</button>
<a onclick="FunctionLoading()" href="{!! url('pos/penjualan') !!}"><button style="width:7%;height:5%;color:#FFF;background:#e74c3c;border:none;margin-top:550px;position:absolute;text-align:center;font-size:18px;position:absolute;margin-left:87%">Kembali</button></a>
<div style="margin-top:2%;margin-left:5.5%;font-size:20px;position:absolute;color:#FFF">Produk Terpilih :</div>
<div id="Enoref" style="margin-top:2%;margin-left:17%;font-size:20px;position:absolute;color:#FFF"> - </div>
<!-- <input type="text" id="Enoref" style="position:absolute;margin-top:40%;margin-left:20%">
 --><input type="hidden" id="Eid" style="position:absolute">
<div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:100px; margin-left:50px; width:92.5%;height:60%;">

                                    <div class="x_panel" style="background:#369;margin-top:-40px">
                                    <div id="table-scrolll">
                                    <table  class="table table-hover" style="margin-top:0px; margin-left:0px;width:100%;position:relative;background:white;">
                                       <thead>
                                            <tr style="background:#3498db; color: white; font-size:20px;">
                                                <td align="center">Barcode</td>
                                                <td align="center">Nama Produk</td>
                                                <td align="center">Harga Jual</td>
                                                <td align="center">Expired</td>
                                                <td align="center">Stok</td>

                                            </tr>
                                        </thead>
                                        <tbody style="height:50px;overflow:auto">
                                            @foreach ($produk as $value)
                                                <?php
                                                {
                                                    $stok = \App\Model\Master\Mappingbarang::where('id_cabang', Auth::user()->cabang)->where('id_produk', $value->id)->first();
                                                    $expired = \App\Model\Pos\Mstok::where('cabang', Auth::user()->cabang)->where('id_produk', $value->id)->first();
                                                }
                                                ?>
                                                <tr style="background-color: white; font-size:18px; color:black;">
                                                <td align="center" ondblclick="input()" style="cursor:pointer" onclick="pilih({{ $value->id }})">{!! $value->barcode !!}</td>

                                                <td align="center" ondblclick="input()" style="cursor:pointer" onclick="pilih({{ $value->id }})">{{ $value->nama }}</td>

                                                <td align="center" ondblclick="input()" style="cursor:pointer" onclick="pilih({{ $value->id }})">Rp. {!! number_format($value->harga_jual ,2,",",".") !!}</td>

                                                <td align="center" ondblclick="input()" style="cursor:pointer" onclick="pilih({{ $value->id }})">{!! $expired->tanggal_expired !!}</td>

                                                    <td align="center" ondblclick="input()" style="cursor:pointer" onclick="pilih({{ $value->id }})">{!! $stok->stok !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <div style="margin-left:6%;top:575px;position:absolute"></div>

<script>

    $("#barangnya").select2({
        placeholder: "Cari Barang",
        allowClear: true
    });

    $("#barangnya").keyup(function (e) {


        if (e.keyCode == 13) {
            location.href = "{!! url('pos/dataproduk/cari') !!}/" + $('#barangnya').val();


        }
    });

        function pilih(id) {

            //alert("{!! url('pos/dataproduk/cek') !!}/" + id);
            $.ajax({
                url: "{!! url('pos/dataproduk/cek') !!}/" + id,
                data: {},
                dataType: "json",
                type: "get",
                success: function (data) {
                    $('#idnyaaa').val(data[0]["barcode"]);
                    $('#Enoref').html(data[0]["nama"]);
                }

            });
        }

        $('#btnok').on('click', function () {

            var idnya = $('#idnyaaa').val();

            location.href = "{!! url('pos/penjualan') !!}/" + idnya;

        });


        $('#cari').on('click', function () {

            location.href = "{!! url('pos/dataproduk/cari') !!}/" + $('#barangnya').val();

        });


  function input()
  {
    var idnya = $('#idnyaaa').val();

    location.href = "{!! url('pos/penjualan') !!}/" + idnya;
  }

</script>
</body>
</html>
