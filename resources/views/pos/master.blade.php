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

  <div style="width:22.2%; height:200px; margin:0 auto; position:absolute">

           <a onclick="FunctionLoading()" href="{!!url('/pos/index')!!}"><div id="caption" style="cursor:pointer;height:80px; margin-top:100px;float:left; margin-left:30px; position:absolute;color:#3498db"><img src="{{ url('assets/poscss/imgs/back.png') }}" style="width:40px;height:40px" alt="">  Pengaturan</div></a>



       <div id="pagecaption" style="height:44px; margin-top:0px;float:left; margin-left:12px; position:absolute"> Caption </div>
  </div>

</div>
<form method="post" action="{!! url('/pos/master/instansi') !!}" enctype="multipart/form-data">
<!--header-->
<div style="width:100%; height:100%; margin: 0 auto; background-color:#FFF">
    <div style="background:#ecf0f1;width:22.2%;height:100%;position:absolute;"></div>
    <div style="background:#3498db;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:7%;color:#FFF;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Informasi Instansi
    </div>
        <a onclick="FunctionLoading()" href="{!! url('pos/master/iklan') !!}"><div style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:13%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Iklan
    </div></a>

   <a onclick="FunctionLoading()" href="{!! url('pos/master/jenis') !!}"><div style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:18%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Jenis Transaksi
    </div></a>

    {{--<a onclick="FunctionLoading()" href="{!! url('pos/master/promo') !!}"><div style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:23%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Promo--}}
        {{--</div></a>--}}

     <div style="background:#ecf0f1;position:absolute;width:70%;height:70%;margin-left:26%;margin-top:0;">
     <label style="color:#000;font-size:18px;position:absolute;margin-top:10%;margin-left:2%">Nama Koperasi</label>
     <input style="width:30%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:20%;margin-top:10%;" name="Enama_koperasi" id="Enama_koperasi" value="{{ $profil->nama_koperasi }}" disabled>
     <label style="color:#000;font-size:18px;position:absolute;margin-top:15%;margin-left:2%">No. Telepon</label>
     <input style="width:30%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:20%;margin-top:15%;" name="Etelepon" id="Etelepon" value="{{ $profil->telepon }}" disabled>
     <label style="color:#000;font-size:18px;position:absolute;margin-top:20%;margin-left:2%">Kode Pos</label>
     <input style="width:30%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:20%;margin-top:20%;" name="Ekode" id="Ekode" value="{{ $profil->kode_pos }}" disabled>
     <label style="color:#000;font-size:18px;position:absolute;margin-top:25%;margin-left:2%">Keterangan</label>
     <textarea style="width:30%;height:18%;position:absolute;font-size:16px;color:#000;margin-left:20%;margin-top:25%;" name="Eketerangan" id="Eketerangan" disabled>{{ $profil->keterangan }}</textarea> 
     <label style="color:#000;font-size:18px;position:absolute;margin-top:38%;margin-left:2%">Alamat</label>
     <textarea style="width:30%;height:25%;position:absolute;font-size:16px;color:#000;margin-left:20%;margin-top:38%;" name="Ealamat" id="Ealamat" disabled>{{ $profil->alamat_koperasi }}</textarea>
     <img id="imgfoto" src="{!! url('foto/profil/'.$profil->foto) !!}" style="width:20%;height:180px;margin-top:17%;margin-left:67%;position:absolute">
     <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 

  <!--         <button id="matiin" onclick="FunctionLoading()" type="submit"  style="font-size:14px;width:13%;height:6%;color:#FFF;background:#3498db;position:absolute;border:none;margin-left:64%;margin-top:41%">Simpan</button>
          <input name="foto" id="foto" type="file" style="width:30%;height:6;position:absolute;font-size:14px;color:#000;margin-left:67%;margin-top:37%;">
  -->
  </form> 
 </div>              
 </div>
<!-- <button id="nyalain" style="font-size:14px;width:10%;height:4.3%;color:#FFF;background:#3498db;position:absolute;border:none;margin-left:81%;margin-top:28.7%">Ubah</button>
    -->

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


                $('#nyalain').on('click', function () {

                  $('#Enama_koperasi').removeAttr('disabled');
                  $('#Ealamat').removeAttr('disabled');
                  $('#Eketerangan').removeAttr('disabled');
                  $('#Ekode').removeAttr('disabled');
                  $('#Etelepon').removeAttr('disabled');
                  
                   });

                  $('#matiin').on('click', function () {

                  // $('#Enama_koperasi').attr('disabled','disabled');
                  // $('#Ealamat').attr('disabled','disabled');
                  // $('#Eketerangan').attr('disabled','disabled');
                  // $('#Ekode').attr('disabled','disabled');
                  // $('#Etelepon').attr('disabled','disabled');

                   });

</script>

</body>
</html>
