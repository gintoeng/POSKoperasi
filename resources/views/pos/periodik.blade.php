<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
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
<div style="color:black;font-size:16px;position:absolute;margin-left:28%;margin-top:5%">Nama Kasir</div>
<div id="show" style="color:black;font-size:16px;position:absolute;margin-left:51.5%;margin-top:5%">Cabang</div>
<div id="show" style="color:black;font-size:16px;position:absolute;margin-left:28%;margin-top:10%">Jenis Transkasi</div>
<div style="color:black;font-size:16px;position:absolute;margin-left:51.5%;margin-top:10%">Range Tanggal</div>
<input id="tanggalnya" type="hidden" value="{{ $tanggalnya }}">
<input id="tanggalnya2" type="hidden" value="{{ $tanggalnya2 }}">
<input id="kasirnya" type="hidden" value="{{ $kasirnya }}">
<input id="cabangnya" type="hidden" value="{{ $cb }}">
<input id="jenisnya" type="hidden" value="{{ $jt }}">
<div id="hide1" style="display:none;color:black;font-size:15px;position:absolute;margin-left:82.2%;margin-top:12.2%">TO</div>
<button id="btnok" style="display:none;position:absolute;margin-top:12%;margin-left:92%;color:#FFF;border:none;background:#3498db;width:4%;height:25px;font-size:10px;cursor:pointer">OK</button>
<input id="datepicker" type="text" style="display:none;position:absolute;width:7%;font-size:12px;color:#000;text-align:center;margin-left:75%;margin-top:12.2%"/>
<input id="datepicker1" type="text" style="display:none;position:absolute;width:7%;font-size:12px;color:#000;margin-left:84%;text-align:center;margin-top:12.2%"/>


<div style="font-size:16px;margin-left:20%;position:absolute;margin-left:28%;width:22.5%;margin-top:7%">
<select placeholder="Pilih Nama Kasir" style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="idkasir">
     <option placeholder="pilih nama kasir"></option>
     <option value="allkasir">Semua Kasir</option>
     @foreach($kasir as $values)
    <option value="{!! $values->id !!}">{!! $values->username !!}</option>
@endforeach
</select>
</div>

<div style="font-size:16px;margin-left:30%;position:absolute;margin-left:51.5%;width:22.5%;margin-top:12%">
<select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="idkasir1">
     <option placeholder="pilih nama kasir"></option>
     <option value="all">ALL</option>
    <option value="today">Hari Ini</option>
    <option value="range">Range Tanggal</option>
</select>
</div>

<div style="font-size:16px;position:absolute;margin-left:51.5%;width:90%;margin-top:7%">
<select style="font-size:14px;width:25%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="idkasi">
     <option placeholder="pilih nama kasir"></option>
     <option value="0">Semua Cabang</option>
     @foreach ($cabang as $value)
    <option value="{{ $value->id }}">{{ $value->kode }}</option>
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

<button id="pdf" class="mif-file-pdf mif-3x" style="background:#EF4836;width:10%;color:#fff;font-size:14px;border:none;height:40px;margin-left:86%;margin-top:7.3%;position:absolute">&nbsp;PDF</button>
<div style="font-size:22px;color:black;margin-left:68%;margin-top:-4%;position:absolute;">Total Pendapatan</div>
<div id="total" style="width:40%;text-align:right;font-size:73px;color:black;margin-left:56%;position:absolute;margin-top:-2%">Rp. {!! number_format($jumlah ,2,",",".") !!}</div>
<div style="background:#ecf0f1;width:22.2%;height:100%;position:absolute;"></div>

<a onclick="FunctionLoading()" href="{!! url('pos/kasir') !!}"><div style="background:#ecf0f1;position:absolute;width:22.2%;height:8%;margin-left:0px;margin-top:8%;color:#000;font-size:18px;padding-left:5%;padding-top:0.8%;position:absolute;cursor:pointer;">Laporan Harian
</div></a>

<a onclick="FunctionLoading()" href="{!! url('pos/kasir/bulan') !!}"><div style="padding-left:5%;background:#ecf0f1;position:absolute;width:22.2%;height:8%;margin-left:0px;margin-top:13%;color:#000;font-size:18px;text-align:left;padding-top:1%;position:absolute;cursor:pointer;">Laporan Bulanan
</div></a>
<a onclick="FunctionLoading()" href="{!! url('pos/kasirtahunan') !!}"><div style="padding-left:5%;background:#ecf0f1;position:absolute;width:22.2%;height:8%;margin-left:0px;margin-top:18%;color:#000;font-size:18px;text-align:left;padding-top:1%;position:absolute;cursor:pointer;">Laporan Tahunan
</div></a>
<a onclick="FunctionLoading()" href="{!! url('pos/kasir/periodik') !!}"><div style="padding-left:5%;background:#3498db;position:absolute;width:22.2%;height:8%;margin-left:0px;margin-top:23%;color:#FFF;font-size:18px;text-align:left;padding-top:1%;position:absolute;cursor:pointer;">Laporan Periodik
</div></a>
{{--<a onclick="FunctionLoading()" href="{!! url('pos/laporan/retur/penjualan') !!}"><div style="padding-left:5%;background:#ecf0f1;position:absolute;width:22.2%;height:8%;margin-left:0px;margin-top:28%;color:#000;font-size:18px;text-align:left;padding-top:1%;position:absolute;cursor:pointer;">Laporan Retur Penjualan--}}
    {{--</div></a>--}}


   <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:18%; margin-left:27%; width:70%;height:250px">



                                    <div class="x_panel" style="background:#3498db;margin-top:-40px;">
                              <div id="table-scroll6" style="width:103%;margin-left:-1.5%">

                                    <table id="table" class="display dataTable table table-hover" cellspacing="0" style="overflow:auto; margin-top:0px; margin-left:0px;width:100%;position:relative;background:white;">
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




<script>

var kasir = $('#kasirnya').val();
var tanggal = $('#tanggalnya2').val();

$("#datepicker").datepicker({
  dateFormat: "yyyy-MM-dd",
  autoclose :true
});
$("#datepicker1").datepicker({
  dateFormat: "yyyy-MM-dd",
  autoclose :true
});

$("#idkasir").select2({
  placeholder: "Pilih Kasir",
         allowClear: true
});

$("#idkasirr").select2({
  placeholder: "Pilih Kasir",
         allowClear: true
});

$("#idkasir1").select2({
  placeholder: "Pilih Tanggal",
         allowClear: true
});
$("#idkasi").select2({
  placeholder: "Pilih Cabang",
         allowClear: true
});


if (kasir=="Semua Kasir") {

if (tanggal=="ALL DATE")
{
            $('#pdf').on('click', function () {

                  window.open("{!! url('pos/kasir/periodik/allkasir/toall/pdf') !!}/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());

            });
}
else if (tanggal=="Hari Ini")
{

            $('#pdf').on('click', function () {

                  window.open("{!! url('pos/kasir/periodik/allkasir/today/pdf') !!}/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());

            });

}

else
{
              $('#pdf').on('click', function () {

                  var df = $('#tanggalnya').val();
                  var dt = $('#tanggalnya2').val();

              window.open("{!! url('pos/kasir/periodik/allkasir/torange/pdf') !!}/"+ df + "/" + dt + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());

            });
}


}


/////////
else
{

  if (tanggal=="ALL DATE")
{
            $('#pdf').on('click', function () {

            window.open("{!! url('pos/kasir/periodik/all/to/pdf') !!}/"+ $('#kasirnya').val() + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());

            });
}
else if (tanggal=="Hari Ini")
{

           $('#pdf').on('click', function () {

                  window.open("{!! url('pos/kasir/periodik/toto/pdf') !!}/"+ $('#kasirnya').val() + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());

            });

}

else
{

            $('#pdf').on('click', function () {
                  var df = $('#tanggalnya').val();
                  var dt = $('#tanggalnya2').val();

                  window.open("{!! url('pos/kasir/periodik/sumrange/pdf') !!}/"+ $('#kasirnya').val() + "/" + df + "/" + dt + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());

            });

}

}

/////


$('#idkasir').on('change', function(){

  if ($('#idkasir').val()=="allkasir")
  {
      $('#idkasir1').on('change', function () {

        if ($('#idkasir1').val()=="all")

          {
            $('#btnok').css('display','none');
            $('#datepicker').css('display','none');
            $('#datepicker1').css('display','none');
            $('#hide1').css('display','none');

            location.href = "{!! url('pos/kasir/periodik/allkasir/all') !!}" + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();

          }
          else if ($('#idkasir1').val()=="today")
          {
            $('#btnok').css('display','none');
            $('#datepicker').css('display','none');
            $('#datepicker1').css('display','none');
            $('#hide1').css('display','none');

            location.href = "{!! url('pos/kasir/periodik/allkasir/today') !!}" + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
          }

            else if ($('#idkasir1').val()=="range")

          {
            //
            // $('#btnok').css('margin-left','70%');
            // $('#datepicker').css('margin-left','52%');
            // $('#datepicker1').css('margin-left','62%');
            $('#btnok').css('display','block');
            $('#hide1').css('display','block');
            $('#datepicker1').css('display','block');
            $('#datepicker').css('display','block');

            $('#btnok').on('click', function () {

                  var df = $('#datepicker').val();
                  var dt = $('#datepicker1').val();
                  df = df.split('/');
                  dt = dt.split('/');
                  var dfrom = df[2] + "-" + df[0] + "-" + df[1];
                  var dto = dt[2] + "-" + dt[0] + "-" + dt[1];

                  location.href = "{!! url('pos/kasir/periodik/allkasir/range') !!}/" + dfrom + "/" + dto + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
                   });

       }



      });


  }
else
  {


         $('#idkasir1').on('change', function () {

          if ($('#idkasir1').val()=="all")

          {

            $('#btnok').css('display','none');
            $('#datepicker').css('display','none');
            $('#datepicker1').css('display','none');
            $('#hide1').css('display','none');

            location.href = "{!! url('pos/kasir/periodik/all') !!}/"+ $('#idkasir').val() + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();

          }

          else if ($('#idkasir1').val()=="today")
          {

            $('#btnok').css('display','none');
            $('#datepicker').css('display','none');
            $('#datepicker1').css('display','none');
            $('#hide1').css('display','none');

            location.href = "{!! url('pos/kasir/periodik/today') !!}/"+ $('#idkasir').val() + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
          }

          else if ($('#idkasir1').val()=="range")

          {

            $('#btnok').css('margin-left','70%');
            $('#datepicker').css('margin-left','52%');
            $('#datepicker1').css('margin-left','62%');

            $('#btnok').css('display','block');
            $('#hide1').css('display','block');
            $('#datepicker1').css('display','block');
            $('#datepicker').css('display','block');

            $('#btnok').on('click', function () {

                  var df = $('#datepicker').val();
                  var dt = $('#datepicker1').val();
                  df = df.split('/');
                  dt = dt.split('/');
                  var dfrom = df[2] + "-" + df[0] + "-" + df[1];
                  var dto = dt[2] + "-" + dt[0] + "-" + dt[1];

                  location.href = "{!! url('pos/kasir/periodik') !!}/"+ $('#idkasir').val() + "/" + dfrom + "/" + dto + $('#idkasi').val() + $('#idkasirr').val();

              });

       }

    });

}

});
</script>
</body>
</html>
