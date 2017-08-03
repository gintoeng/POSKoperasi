<!DOCTYPE html>
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
<div style="width:22.2%; height:200px; margin-left:0px;auto; background-color:#ecf0f1">

  <div style="width:300px; height:200px; margin:0 auto; position:absolute">

           <a onclick="FunctionLoading()" href="{!!url('/pos/index')!!}"><div id="caption" style="cursor:pointer;height:80px; margin-top:100px;float:left; margin-left:30px; position:absolute;color:#3498db"><img src="{{ url('assets/poscss/imgs/back.png') }}" style="width:40px;height:40px" alt="">  Pengaturan</div></a>



       <div id="pagecaption" style="height:44px; margin-top:0px;float:left; margin-left:12px; position:absolute"> Caption </div>
  </div>

</div>

<!--header-->
<div style="width:100%; height:100%;overflow:auto;  background-color:#FFF">
<form action="{!! url('pos/master/ohoo') !!}" method="post" enctype="multipart/form-data">

    <div style="background:#ecf0f1;width:22.2%;height:100%;position:absolute;"></div>
     <a onclick="FunctionLoading()" href="{!! url('pos/master') !!}"><div  style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:7%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Informasi Instansi
    </div></a>
        <a onclick="FunctionLoading()" href="{!! url('pos/master/iklan') !!}"><div style="background:#3498db;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:13%;color:#FFF;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Iklan
    </div></a>
     <a onclick="FunctionLoading()" href="{!! url('pos/master/jenis') !!}"><div style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:18%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Jenis Transaksi
    </div></a>
    {{--<a onclick="FunctionLoading()" href="{!! url('pos/master/promo') !!}"><div style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:23%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Promo--}}
        {{--</div></a>--}}

         <div style="background:#ecf0f1;position:absolute;width:50%;height:70%;margin-left:35%;margin-top:0;">
         <img id="imgfoto" src="{!! url('foto/iklan/'.$iklan->title) !!}" style="width:25%;height:70%;margin-top:5%;margin-left:38%;position:absolute">
         
          <input type="hidden" name="_token" value="{!! csrf_token() !!}">
         
         <button type="submit" style="font-size:14px;width:25%;height:5%;color:#FFF;background:#3498db;position:absolute;border:none;margin-left:38%;margin-top:61%">Simpan</button>
         <input name="foto" id="foto" type="file" style="font-size:14px;width:30%;height:10;margin-top:67%;margin-left:38%">
         <div style="width:20%;margin-left:75%;position:absolute;margin-top:-10%">
         <input id="tampil" style="cursor:pointer" type="checkbox" style="position:absolute;"> Tampilkan Iklan
         </div>
         <input id="input1" type="hidden" value="{{ $status }}">
</form>
 </div>

<script>

var cek1 = $('#input1').val();

if (cek1==1)
 {
  $('#tampil').attr('checked','checked');
 } 

  $('#tampil').change(function() {
var nomor = 1;
var angka = 0;

    if ($('#tampil').is(':checked'))

    {

       location.href = "{{ url('pos/iklan/status') }}/" + nomor;


    } 
    else 
    {

      location.href = "{{ url('pos/iklan/status') }}/" + angka;
    }


  });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imgfoto').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#foto").change(function(){
        readURL(this);
    });

</script>

</body>
</html>
