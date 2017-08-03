<!doctype html>
<html class="no-js" lang="">
<head>
    @include('templates.headerpos')
    <script src="{{asset('assets/plugins/jquery-1.11.1.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/js/bootstrap.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/poscss/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/poscss/css/select2.css')}}">
    <script src="{{asset('assets/poscss/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/plugins/datepicker/datepicker.css')}}"/>
</head>

<body id="">
<div class="se-pre-con"></div>
<!--header-->
<div style="width:100%; height:100px; overflow:hidden; margin: 0 auto; background-color:#369">

    <div style="width:1500px; height:150px; margin:0 auto; overflow:hidden; position:relative">
        <a href="{{ url('pos/laporan')  }}"><img style="cursor:pointer;position:absolute;margin-left:3%;margin-top:50px" src="{{ url('assets/poscss/imgs/backbtn.png') }}" alt=""></a>
        <a onclick="FunctionLoading()"><div style="font-size:50px;color:#FFF;height:80px;margin-top:30px;float:left; margin-left:100px; position:absolute">Laporan Transaksi</div></a>
    </div>

</div>

<!--buttons-->

<br>

<a onclick="" href="{{ url('pos/laporan/transaksi/penjualan')  }}"><div style="width:467px;height:210px;
background:#e74c3c;position:absolute;margin-left:24.5%;margin-top:6%;cursor:pointer">
        <img src="{{ url('assets/poscss/imgs/7.png') }}" style="position:absolute;margin-left:38%;margin-top:6%;cursor:pointer;">
        <div style="color:#FFF;font-size:24px;margin-left:3%;margin-top:36%;position:absolute;cursor:pointer;"><b>Transaksi Penjualan</b></div></div>
</a>

<a href="{{ url('pos/laporan/transaksi/anggota') }}"><div style="width:230px;height:210px;
background:#e67e22;position:absolute;margin-left:59.5%;margin-top:6%;cursor:pointer">
        <img src="{{ url('assets/poscss/imgs/7.png') }}" style="position:absolute;margin-left:25%;margin-top:6%;cursor:pointer;">
        <div style="color:#FFF;font-size:18px;margin-left:20%;margin-top:57%;position:absolute;cursor:pointer;"><b>Transaksi Anggota</b></div></div>
</a>

{{--<a onclick="FunctionLoading()" href="{!! url('/inventory') !!}"><div style="width:250px;height:210px;background:#4B77BE;position:absolute;margin-left:52%;margin-top:6%">--}}
{{--<img src="{{ url('assets/poscss/imgs/6.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">--}}
{{--<div style="color:#FFF;font-size:18px;margin-left:22%;margin-top:54%;position:absolute"><b>Laporan Anggota</b></div>--}}

{{--</div></a>--}}

<a href="{{ url('pos/laporan/transaksi/retur')  }}"><div style="cursor:pointer;width:230px;
height:210px;background:#9b59b6;position:absolute;margin-left:24.5%;margin-top:23%">
        <img src="{{ url('assets/poscss/imgs/7.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">
        <div style="color:#FFF;font-size:18px;margin-left:24%;margin-top:57%;position:absolute"><b>Retur Penjualan</b></div>
    </div></a>

<div id="klik" onclick="lightbox_open()" style="cursor:pointer;width:230px;height:210px;
background:#1abc9c;position:absolute;margin-left:42%;margin-top:23%">
        <img src="{{ url('assets/poscss/imgs/8.png') }}" style="position:absolute;margin-left:24%;margin-top:5%">
        <div style="color:#FFF;font-size:18px;margin-left:23%;margin-top:57%;position:absolute"><b>Rekap Transaksi</b></div>
    </div>

<a href="{{ ('transaksi/fastmoving/slowmoving')  }}"><div style="cursor:pointer;width:230px;height:210px;
background:#3498db;position:absolute;margin-left:59.5%;margin-top:23%">
    <img src="{{ url('assets/poscss/imgs/10.png') }}" style="position:absolute;margin-left:24%;margin-top:5%">
    <div style="color:#FFF;font-size:18px;margin-left:28%;margin-top:57%;position:absolute"><b>Fastmoving</b></div>
    <div style="color:#FFF;font-size:18px;margin-left:28%;margin-top:70%;position:absolute"><b>Slowmoving</b></div>
    <div style="color:#FFF;font-size:14px;margin-left:46%;margin-top:65%;position:absolute"><b>&</b></div>
</div></a>
<input type="hidden" value="{{ $rolenya  }}" id="init">

<!--footer-->
<div id="light" class="lighte">

    <div id="divkasir" style="width:3975%; height:1680%; overflow:hidden; margin: 0 auto; position:absolute; margin-top:1300%; margin-left:50%; background-color:#59ABE3">

    </div>
</div>

<div id="fade" class="fadeee" onClick="lightbox_close();"></div>
</body>


<script>
    function lightbox_open(){
        document.getElementById('light').style.display='block';
        document.getElementById('fade').style.display='block';
    }


    $("#klik").click(function(){
        $("#divkasir").load("{!! URL::to('/pos/laporan/transaksi/rekap') !!}/");

    });

    $('#pdf').on('click', function () {

        var df = $('#tanggalnya').val();
        var dt = $('#tanggalnya2').val();

        if($('#idnya').val()=="")
        {

            window.open("{!! url('pos/laporan/hpp/cetak/hari') !!}/"+ df + "/" + dt);
        }
        else
        {

            window.open("{!! url('pos/laporan/hpp/cetak/pdf/hari') !!}/"+ $('#idnya').val() + "/" + df  + "/" + dt);

        }



    });
    $('#pdf1').on('click', function () {

        var df = $('#tanggalnya').val();
        var dt = $('#tanggalnya2').val();

        if($('#idnya').val()=="")
        {
            window.open("{!! url('pos/laporan/hpp/cetak/bulan') !!}/"+ df + "/" + dt);
        }
        else
        {
            window.open("{!! url('pos/laporan/hpp/cetak/pdf/bulan') !!}/"+ $('#idnya').val() + "/" + df + "/" + dt);
        }



    });
    $('#pdf2').on('click', function () {

        var df = $('#tanggalnya').val();
        var dt = $('#tanggalnya2').val();
        if($('#idnya').val()==""){

            window.open("{!! url('pos/laporan/hpp/cetak/tahun') !!}/"+ df + "/" + dt);
        }
        else{
            window.open("{!! url('pos/laporan/hpp/cetak/pdf/tahun') !!}/"+ $('#idnya').val() + "/" + df + "/" + dt);
        }



    });




    $('#btnok1').on('click', function () {


        var df = $('#datepicker1').val();
        var dt = $('#datepicker2').val();
        df = df.split('/');
        dt = dt.split('/');
        var dfrom = df[2] + "-" + df[0] + "-" + df[1];
        var dto = dt[2] + "-" + dt[0] + "-" + dt[1];

        if($('#nama').val()=="")
        {
            location.href = "{!! url('pos/laporan/hpp/search/hari/all/qdert') !!}/" + dfrom + "/" + dto;
        }
        else
        {
            location.href = "{!! url('pos/laporan/hpp/search/hari') !!}/" + $('#nama').val() + "/" + dfrom + "/" + dto;
        }



    });



    $('#btnok2').on('click', function () {

        var df = $('#datepickerr1').val();
        var dt = $('#datepickerr2').val();
        if($('#nama').val()=="")
        {
            location.href = "{!! url('pos/laporan/hpp/search/bulan/all/qdert') !!}/" + df + "/" + dt;
        }
        else
        {
            location.href = "{!! url('pos/laporan/hpp/search/bulan') !!}/" + $('#nama').val() + "/" + df + "/" + dt;
        }


    });



    $('#btnok3').on('click', function () {

        var df = $('#datepickerrr1').val();
        var dt = $('#datepickerrr2').val();
        if($('#nama').val()=="")
        {

            location.href = "{!! url('pos/laporan/hpp/search/tahun/all/qdert') !!}/"+ df + "/" + dt;
        }
        else
        {
            location.href = "{!! url('pos/laporan/hpp/search/tahun') !!}/" + $('#nama').val() + "/" + df + "/" + dt;
        }
    });







</script>
</html>
