<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
@include('templates.headerpos')


</head>

<body>
    <style>

    body{
    margin:0;
    background-color:#FFF;
}
</style>
<body id="">
<div style="width:22.2%; height:100px; margin-left:0px;auto; background-color:#ecf0f1">


           <a onclick="FunctionLoading()" href="{!!url('/pos/index')!!}"><div style="cursor:pointer;height:80px; margin-top:50px;float:left; margin-left:10px; position:absolute;color:#3498db;font-size:33px"><img src="{{ url('assets/poscss/imgs/back.png') }}" style="width:40px;height:40px" alt="">&nbsp;<b>Laporan Kasir</b></div></a>


</div>

<!--header-->

<div style="width:100%; height:100%; margin: 0 auto; background-color:#FFF">
<div id="show" style="color:black;font-size:16px;position:absolute;margin-left:28%;margin-top:5%">Nama Kasir</div>
<div id="show" style="color:black;font-size:16px;position:absolute;margin-left:53%;margin-top:5%">Cabang</div>
<div id="show" style="color:black;font-size:16px;position:absolute;margin-left:28%;margin-top:10%">Jenis Transaksi</div>
<input id="tanggalnya" type="hidden" value="{{ $tanggalnya }}">
<input id="kasirnya" type="hidden" value="{{ $kasirnya }}">
<input id="cabangnya" type="hidden" value="{{ $cb }}">
<input id="jenisnya" type="hidden" value="{{ $jt }}">
<div id="hide" style="color:black;font-size:16px;position:absolute;margin-left:53%;margin-top:10%">Pilih Tanggal</div>
<button id="btnok" style="position:absolute;margin-top:12%;margin-left:70%;color:#FFF;border:none;background:#3498db;width:5%;height:33px;font-size:15px;cursor:pointer">OK</button>
<div style="font-size:16px;margin-left:20%;position:absolute;margin-left:28%;width:90%;margin-top:7%">
<select style="font-size:14px;width:25%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:7%" id="idkasir">
     <option placeholder="pilih nama kasir"></option>
     <option value="allkasir">Semua Kasir</option>
     @foreach($kasir as $values)
    <option value="{!! $values->id !!}">{!! $values->username !!}</option>
@endforeach
</select>
</div>

<div style="font-size:16px;position:absolute;margin-left:53%;width:90%;margin-top:7%">
<select style="font-size:14px;width:25%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="idkasi">
     <option placeholder="pilih nama kasir"></option>
     <option value="0">Semua Cabang</option>
     @foreach($cabang as $values)
    <option value="{!! $values->id !!}">{!! $values->kode !!}</option>
@endforeach
</select>
</div>

<div style="font-size:16px;position:absolute;margin-left:28%;width:22.5%;margin-top:12%">
<select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="idkasirr">
     <option placeholder="pilih nama kasir"></option>
     <option value="test">Semua Jenis</option>
    <option value="cash">Tunai</option>
    <option value="kartu">Autodebet</option>
    <option value="tunda">Tunda</option>
</select>
</div>


<input id="datepicker" type="text" style="position:absolute;
widht:35%;font-size:17px;color:#000;margin-left:53%;margin-top:12%"/>

<button id="pdf" class="mif-file-powerpoint" style="background:#EF4836;width:10%;color:#fff;font-size:14px;border:none;height:40px;margin-left:86%;margin-top:7.3%;position:absolute">&nbsp;PDF</button>
<div style="font-size:22px;color:black;margin-left:68%;margin-top:-4%;position:absolute;">Total Pendapatan</div>
<div style="width:40%;text-align:right;font-size:73px;color:black;margin-left:56%;position:absolute;margin-top:-2%">Rp. {!! number_format($jumlah ,2,",",".") !!}</div>
<div style="background:#ecf0f1;width:22.2%;height:100%;position:absolute;"></div>

<a onclick="FunctionLoading()" href="{!! url('pos/kasir') !!}"><div style="background:#3498db;position:absolute;width:22.2%;height:8%;margin-left:0px;margin-top:8%;color:#FFF;font-size:18px;padding-left:5%;padding-top:0.8%;position:absolute;cursor:pointer;">Laporan Harian
</div></a>

<a onclick="FunctionLoading()" href="{!! url('pos/kasir/bulan') !!}"><div style="padding-left:5%;background:#ecf0f1;position:absolute;width:22.2%;height:8%;margin-left:0px;margin-top:13%;color:#000;font-size:18px;text-align:left;padding-top:1%;position:absolute;cursor:pointer;">Laporan Bulanan
</div></a>
<a onclick="FunctionLoading()" href="{!! url('pos/kasirtahunan') !!}"><div style="padding-left:5%;background:#ecf0f1;position:absolute;width:22.2%;height:8%;margin-left:0px;margin-top:18%;color:#000;font-size:18px;text-align:left;padding-top:1%;position:absolute;cursor:pointer;">Laporan Tahunan
</div></a>
<a onclick="FunctionLoading()" href="{!! url('pos/kasir/periodik') !!}"><div style="padding-left:5%;background:#ecf0f1;position:absolute;width:22.2%;height:8%;margin-left:0px;margin-top:23%;color:#000;font-size:18px;text-align:left;padding-top:1%;position:absolute;cursor:pointer;">Laporan Periodik
</div></a>
{{--<a onclick="FunctionLoading()" href="{!! url('pos/laporan/retur/penjualan') !!}"><div style="padding-left:5%;background:#ecf0f1;position:absolute;width:22.2%;height:8%;margin-left:0px;margin-top:28%;color:#000;font-size:18px;text-align:left;padding-top:1%;position:absolute;cursor:pointer;">Laporan Retur Penjualan--}}
{{--</div></a>--}}

   <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:18%; margin-left:27%; width:70%;height:250px">



                          <div class="x_panel" style="background:#3498db;margin-top:-40px;">

                              <div id="table-scroll6" style="width:103%;margin-left:-1.5%">

                                    <table id="table" class="display dataTable table table-hover" cellspacing="0" style="margin-top:0px; margin-left:0px;width:100%;position:relative;background:white;">
                                       <thead>
                                            <tr style="background:#3498db; color: white; font-size:16px;">
                                                <td align="center"><b>No Ref</b></td>
                                                <td align="center"><b>Tanggal</b></td>
                                                <td align="center"><b>Jumlah</b></td>
                                                <td align="center"><b>Type Pembayaran</b></td>
                                            </tr>
                                        </thead>

                                        <tbody style="overflow:auto; height: 50px;">
                                            @foreach($detail as $value)
                                            <tr style="background-color: white; font-size:18px; color:black;">
                                                <td align="center">{!! $value->noref !!}</td>
                                                <td align="center">{!! $value->tanggal !!}</td>
                                                <td align="center">Rp. {!! number_format($value->jumlah ,2,",",".") !!}</td>
                                                <td align="center">{!! $value->type_pembayaran!!}</td>
                                               </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                  </div>
                            </div>
                        </div>
                       <div id="paginationharian" style="margin-left:28%;margin-top:37%;position:absolute">{!! $detail->links() !!}</div>
                       </div>

<script>
var kasir = $('#kasirnya').val();
$("#idkasir").select2({
  placeholder: "Pilih Kasir",
         allowClear: true
});
$("#idkasi").select2({
placeholder: "Pilih Cabang",
       allowClear: true
});
$("#idkasirr").select2({
placeholder: "Jenis Transaksi",
       allowClear: true
});

$("#datepicker").datepicker({
  dateFormat: "yyyy-MM-dd",
  autoclose :true
});
$("#tanggalnya").datepicker({
  dateFormat: "yyyy-MM-dd",
  autoclose :true
});

if (kasir=="Semua Kasir")
{

      $('#pdf').on('click', function () {
                  var df = $('#tanggalnya').val();
                  // df = df.split('/');
                  // var dfrom = df[2] + "-" + df[0] + "-" + df[1];
                  // alert(df);
                  window.open("{!! url('pos/kasir/harian/sum/pdf') !!}/"+ df + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());
        });
}
else
{


          $('#pdf').on('click', function () {
                  var df = $('#tanggalnya').val();
                  // df = df.split('/');
                  // var dfrom = df[2] + "-" + df[0] + "-" + df[1];
                  // alert(dfrom);
                  window.open("{!! url('pos/kasir/harian/sumary/pdf') !!}/"+ $('#kasirnya').val() + "/" + df  + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());


        });

}

$('#idkasir').on('change', function()
{

  if ($('#idkasir').val()=="allkasir")
  {


    $('#btnok').on('click', function () {

                  var df = $('#datepicker').val();
                  df = df.split('/');
                  var dfrom = df[2] + "-" + df[0] + "-" + df[1];
                  location.href = "{!! url('pos/kasir/hari/l') !!}/" + dfrom + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
        });

  }


  else
  {

    $('#btnok').on('click', function () {


                  var df = $('#datepicker').val();
                  df = df.split('/');
                  var dfrom = df[2] + "-" + df[0] + "-" + df[1];
                  location.href = "{!! url('pos/kasir/harian') !!}/"+ $('#idkasir').val() + "/" + dfrom + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
        });

  }

});


</script>
</body>
</html>
