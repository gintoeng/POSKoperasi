<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="{{ asset ('assets/templateinventory/inventory.ico') }}">
      <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
      <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/select2.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenLite.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenMax.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/gerak.js') }}"></script>

<title>Inventory</title>
<style>	
body{
	margin:0;
	background-color:#369;
	overflow:auto;
}
</style>

<div class="app-bar navy" data-role="appbar">
        <a class="app-bar-element" href="{!! url('/inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
        <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
        <span class="app-bar-divider"></span>
        <ul class="app-bar-menu">
</ul>
</div>          

</head>

<body id="">
<!--header-->
<div class="cell">
<div style="width:100%; height:10%; overflow:hidden; margin: 0 auto; background-color:#369">

  <div style="width:100; height:150px; margin:0 auto; overflow:hidden; position:relative margin-top:150px;">
		
        <a href="{!! url('/login') !!}"><div id="caption" style="height:82px; margin-top:85px;float:left; margin-left:80px; position:absolute"> <img src="{{ asset ('assets/templateinventory/icon/1.png') }}" style="padding-bottom:6px;" /> Inventory </div></a>
       <div id="pagecaption" style="height:44px; margin-top:20px;float:left; margin-left:12px; position:absolute"> Caption </div> 

      
    </div>
  </div>
</div>
<!--buttons-->
<div style="width:60%; height:500px; overflow:hidden; margin: 0 auto; position:relative; margin-top:80px; margin-left:350px; position:left; background-color:#369">
<tr>
	<a href="{!! url('/masterproduk') !!}"> <div id="btn1" style="float:left"><img src="{{ asset ('assets/templateinventory/imgs/1.png') }}"/><span style='float:right;padding-right:30px; overflow:hidden;  position:absolute'>MasterProduk</span></div> </a>
   
    <a href="{!! url('/stokminimum') !!} "><div id="btn2" style="float:left;"><img src="{{ asset ('assets/templateinventory/icon/Report-Editor-128.png') }}"/><span style='float:right;padding-right:30px; position:absolute'>StokMinimum</span></div> </a>
    
    <a href="{!! url('/masterkonfigurasi') !!}"> <div id="btn3" style="float:left"><img src="{{ asset ('assets/templateinventory/icon/11.png')}}"/><span style='float:right;padding-right:30px; position:absolute'>MasterKonfig</span></div> </a>
    
    <a href="{!! url('/lapbarangmasuk') !!}"> <div id="btn4" style="float:left"><img src="{{ asset ('assets/templateinventory/icon/1in.png') }}"/><span style='float:right;margin-right:60px; position:absolute'>Lap.BarMasuk</span></div> </a>
    
    <a href="{!! url('/lapbarangkeluar') !!}"> <div id="btn5" style="float:left;"><img src="{{ asset('assets/templateinventory/icon/1out.png') }}"/><span style='float:right;padding-right:60px; position:absolute'>Lap.BarKeluar</span></div> </a>

    <a href="{!! url('/') !!}"> <div id="btn6" style="float:left"><img src="{{ asset ('assets/templateinventory/icon/kluar.png') }}"/><span style='float:right; position:absolute margin-right:100px;'>Keluar</span></div> </a>
   
    <div id="content" style="position:absolute"> <iframe name="main" frameborder=0 height=40% width=100%></iframe>  </div>

</tr>
</div>

<!--footer-->
<div style="width:100%; height:100px; overflow:hidden; margin: 0 auto; background-color:#369; margin-top:20px;">
 
</div>
</body>

        <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet"/>
        <script type="text/javascript" src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>

</html>