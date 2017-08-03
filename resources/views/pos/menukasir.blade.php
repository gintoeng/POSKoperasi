<!doctype html>
<html class="no-js" lang="">
<head>
@include('templates.headerpos')
<script src="{{asset('assets/plugins/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('assets/bootstrap/js/bootstrap.js')}}"></script>
</head>

<body id="">
<div class="se-pre-con"></div>
<!--header-->
<div style="width:100%; height:100px; overflow:hidden; margin: 0 auto; background-color:#369">

  <div style="width:1500px; height:150px; margin:0 auto; overflow:hidden; position:relative">

       <a onclick="FunctionLoading()"><div style="font-size:50px;color:#FFF;height:80px;cursor:pointer;margin-top:40px;float:left; margin-left:100px; position:absolute">Laporan Kasir</div></a>
        </div>

</div>

<!--buttons-->
<div>
<a onclick="FunctionLoading()"   href="{{ url('pos/index') }}" style="color:#FFF;font-size:20px;margin-left:82%;"><span class="mif-switch" style="color:#FFF;padding-top:-1%"></span> &nbsp;Keluar</a>
</div>
<br>

<a onclick="FunctionLoading()" href="{!! url('') !!}"><div style="width:250px;height:210px;background:#27ae60;position:absolute;margin-left:32%;margin-top:6%">
<img src="{{ url('assets/poscss/imgs/all.png') }}" style="position:absolute;margin-left:27%;margin-top:8%">
  <div style="color:#FFF;font-size:18px;margin-left:25%;margin-top:54%;position:absolute"><b>Semua Transaksi</b></div></div>
</div>
<a onclick="FunctionLoading()" href="{!! url('') !!}"><div style="width:250px;height:210px;background:#e74c3c;position:absolute;margin-left:52%;margin-top:6%">
<img src="{{ url('assets/poscss/imgs/tunai.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">
    <div style="color:#FFF;font-size:18px;margin-left:38%;margin-top:54%;position:absolute"><b>Tunai</b></div>

</div></a>
<a onclick="FunctionLoading()" href="{{ url('') }}"><div style="cursor:pointer;width:250px;height:210px;background:#f1c40f;position:absolute;margin-left:32%;margin-top:23%">
<img src="{{ url('assets/poscss/imgs/autodebet.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">
    <div style="color:#FFF;font-size:18px;margin-left:33%;margin-top:54%;position:absolute"><b>Autodebet</b></div>
</div></a>
<a onclick="FunctionLoading()" href="{!! url('') !!}"><div style="width:250px;height:210px;background:#3498db;position:absolute;margin-left:52%;margin-top:23%">
<img src="{{ url('assets/poscss/imgs/tunda.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">
    <div style="color:#FFF;font-size:18px;margin-left:39%;margin-top:54%;position:absolute"><b>Tunda</b></div>
</div>  </a>
<div id="light" class="lighte">

       <div id="divkasir" style="width:5975%; height:14s00%; overflow:hidden; margin: 0 auto; position:absolute; margin-top:1300%; margin-left:-1100%; background-color:#59ABE3">

      </div>
</div>

<div id="fade" class="fadeee" onClick="lightbox_close();"></div>
</body>

</html>
