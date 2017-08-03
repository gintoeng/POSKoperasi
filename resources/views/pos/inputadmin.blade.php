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
<div style="width:300px; height:100px; margin-left:0px;auto; background-color:#ecf0f1">

  <div style="width:300px; height:120px; margin:0 auto; position:absolute">
        
           <a href="{!!url('/pos/index')!!}"><div id="caption" style="cursor:pointer;height:80px; margin-top:30px;float:left; margin-left:30px; position:absolute;color:#3498db"><img src="{{ url('assets/poscss/imgs/back.png') }}" style="width:40px;height:40px" alt=""> Master </div></a>
        
    
        
       <div id="pagecaption" style="height:44px; margin-top:0px;float:left; margin-left:12px; position:absolute"> Caption </div>
  </div>

</div>

<!--header-->
<form method="post" action="{!! url('inputadmin') !!}">

<div style="width:100%; height:665px; margin: 0 auto; background-color:#FFF">
    <div style="background:#ecf0f1;width:300px;height:665px;position:absolute;"></div>
    <a href="{!!url('/pos/master')!!}"><div style="background:#ecf0f1;position:absolute;width:300px;height:50px;margin-left:0px;margin-top:100px;color:#000;font-size:22px;padding-left:60px;padding-top:10px;position:absolute;cursor:pointer;">Informasi Instansi
    </div></a>
     <div style="background:#3498db;color:#FFF;position:absolute;width:300px;height:50px;margin-left:0px;margin-top:170px;font-size:22px;padding-left:115px;padding-top:10px;cursor:pointer;">Admin</div>

     <div style="background:#ecf0f1;position:absolute;width:980px;height:400px;margin-left:350px;margin-top:120px;">

      <div style="position:absolute;margin-left:50px;margin-top:70px;font-size:20px;">Nama</div>
      <div class="input-control text" style="font-size:20px; margin-left:200px; margin-top:45px;color:black;">
    <input name="Enama_admin"type="text" style="width:400px;">
</div>
  <div style="position:absolute;margin-left:50px;margin-top:23px;font-size:20px;">Telepon</div>
      <div class="input-control text" style="font-size:20px; margin-left:200px; margin-top:0px;color:black;">
    <input name="Etelp_admin" type="text" style="width:400px;">
</div>
 <div style="position:absolute;margin-left:50px;margin-top:23px;font-size:20px;">Username</div>
      <div class="input-control text" style="font-size:20px; margin-left:200px; margin-top:0px;color:black;">
    <input name="Eusername" type="text" style="width:400px;">
</div>
 <div style="position:absolute;margin-left:50px;margin-top:23px;font-size:20px;">Password</div>
      <div class="input-control text" style="font-size:18px; margin-left:200px; margin-top:0px;color:black;">
    <input name="Epassword"type="text" style="width:400px">
</div>
 <div style="position:absolute;margin-left:50px;margin-top:23px;font-size:20px;">Hak Akses</div>
      
      <div class="input-control text" style="font-size:16px; margin-left:200px;margin-top:0px;color:black;">
    <select name="Ehak"type="text" style="width:400px;font-size:16px;height:40px;">
      <option value="admin">Admin</option>
      <option value="kasir">Kasir</option>
    </select>
    </div>
    
    <div style="margin-left:695px; position:absolute; margin-top:-260px;"><img src="{{ url('assets/poscss/imgs/default.jpg') }}" style="width:170px;height:170px" alt=""></div>

    <div style="background:#3498db;position:absolute;width:170px;height:40px;margin-left:695px;margin-top:-90px;color:#FFF;font-size:18px;padding-left:55px;padding-top:8px;cursor:pointer;">Browse</div>
  </div>
   <input type="hidden" name="_token" value="{!! csrf_token() !!}">
  <button type="submit" style="font-size:18px;width:150px;height:40px;color:#FFF;border:none;margin-left:980px;margin-top:420px;background:#3498db;position:absolute;">Simpan</button>

     <a href="{!!url('/pos/admin')!!}"><div style="background:#3498db;position:absolute;width:150px;height:40px;margin-left:1135px;margin-top:420px;color:#FFF;font-size:18px;padding-left:50px;padding-top:8px;cursor:pointer;">Batal</div></a>
</div>
</form>
</body>
</html>
