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
        <a onclick="FunctionLoading()" href="{{ url('pos/laporan')  }}"><img id="btnbek" style="cursor:pointer;position:absolute;margin-left:3%;margin-top:50px" src="{{ url('assets/poscss/imgs/backbtn.png') }}" alt=""></a>
        <div style="font-size:50px;color:#FFF;height:80px;margin-top:30px;float:left; margin-left:100px; position:absolute">Stok Produk</div>
    </div>

</div>

<!--buttons-->

<br>

<a onclick="" href="{{ url('pos/laporan/stok/produk')  }}"><div style="width:400px;height:210px;background:#1E8BC3;position:absolute;margin-left:34%;margin-top:6%;cursor:pointer">
        <img src="{{ url('assets/poscss/imgs/10.png') }}" style="position:absolute;margin-left:33%;margin-top:6%;cursor:pointer;">
        <div style="color:#FFF;font-size:18px;margin-left:30%;margin-top:40%;position:absolute;cursor:pointer;"><b>Produk Slow and Fast</b></div></div>
</a>

<a href="{{ url('pos/laporan/stok/barang') }}"><div style="width:400px;height:210px;background:#e74c3c;position:absolute;margin-left:34%;margin-top:23%;cursor:pointer">
        <img src="{{ url('assets/poscss/imgs/9.png') }}" style="position:absolute;margin-left:33%;margin-top:6%;cursor:pointer;">
        <div style="color:#FFF;font-size:18px;margin-left:37%;margin-top:40%;position:absolute;cursor:pointer;"><b>Stok Barang</b></div></div>
</a>

{{--<a onclick="FunctionLoading()" href="{!! url('/inventory') !!}"><div style="width:250px;height:210px;background:#4B77BE;position:absolute;margin-left:52%;margin-top:6%">--}}
{{--<img src="{{ url('assets/poscss/imgs/6.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">--}}
{{--<div style="color:#FFF;font-size:18px;margin-left:22%;margin-top:54%;position:absolute"><b>Laporan Anggota</b></div>--}}

{{--</div></a>--}}


<!--footer-->
<div id="light" class="lighte">

    <div id="divkasir" style="width:5975%; height:14%; overflow:hidden; margin: 0 auto; position:absolute; margin-top:1300%; margin-left:-1100%; background-color:#59ABE3">

    </div>
</div>

<div id="fade" class="fadeee" onClick="lightbox_close();"></div>
</body>


<script>

</script>
</html>
