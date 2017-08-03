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

           <a href="{!!url('/pos/index')!!}"><div id="caption" style="cursor:pointer;height:80px; margin-top:100px;float:left; margin-left:30px; position:absolute;color:#3498db"><img src="{{ url('assets/poscss/imgs/back.png') }}" style="width:40px;height:40px" alt="">  Pengaturan</div></a>



       <div id="pagecaption" style="height:44px; margin-top:0px;float:left; margin-left:12px; position:absolute"> Caption </div>
  </div>

</div>

<!--header-->
<div style="width:100%; height:100%;overflow:auto;  background-color:#FFF">

    <div style="background:#ecf0f1;width:22.2%;height:100%;position:absolute;">      
    </div>
        <a href="{!! url('pos/master') !!}"><div style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:10%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Informasi Instansi
    </div></a>
        <div style="background:#3498db;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:10%;color:#FFF;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Iklan
    </div>
 </div>

<script>
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
