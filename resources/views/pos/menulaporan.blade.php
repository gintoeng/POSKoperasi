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
        <img id="btnbek" style="cursor:pointer;position:absolute;margin-left:3%;margin-top:50px" src="{{ url('assets/poscss/imgs/backbtn.png') }}" alt="">
        <a onclick="FunctionLoading()"><div style="font-size:50px;color:#FFF;height:80px;margin-top:30px;float:left; margin-left:100px; position:absolute">Laporan</div></a>
    </div>

</div>

<!--buttons-->

<br>

<a onclick=""><div id="klik" style="width:250px;height:210px;background:#1E8BC3;position:absolute;margin-left:32%;margin-top:6%;cursor:pointer">
        <img src="{{ url('assets/poscss/imgs/5.png') }}" style="position:absolute;margin-left:25%;margin-top:6%;cursor:pointer;">
        <div style="color:#FFF;font-size:18px;margin-left:22%;margin-top:54%;position:absolute;cursor:pointer;"><b>Proses Hitung HPP</b></div></div>
    </a>

<a href="{{ url('pos/laporan/stok/barang') }}"><div style="width:250px;height:210px;background:#e74c3c;position:absolute;margin-left:52%;margin-top:6%;cursor:pointer">
        <img src="{{ url('assets/poscss/imgs/9.png') }}" style="position:absolute;margin-left:25%;margin-top:6%;cursor:pointer;">
        <div style="color:#FFF;font-size:18px;margin-left:32%;margin-top:54%;position:absolute;cursor:pointer;"><b>Stok Produk</b></div></div>
</a>

    <a href="{{ url('pos/laporan/transaksi')  }}"><div style="cursor:pointer;width:250px;height:210px;background:#2ECC71;position:absolute;margin-left:32%;margin-top:23%">
            <img src="{{ url('assets/poscss/imgs/7.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">
            <div style="color:#FFF;font-size:18px;margin-left:22%;margin-top:54%;position:absolute"><b>Laporan Transaksi</b></div>
        </div></a>

    <a onclick="FunctionLoading()" href="{{ url('pos/laporan/hpp') }}"><div style="width:250px;height:210px;background:#E67E22;position:absolute;margin-left:52%;margin-top:23%">
            <img src="{{ url('assets/poscss/imgs/8.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">
            <div style="color:#FFF;font-size:18px;margin-left:28%;margin-top:54%;position:absolute"><b>Laporan HPP</b></div>
        </div> </a>
<input type="hidden" value="{{ $rolenya  }}" id="init">

<!--footer-->
<div id="light" class="lighte">

    <div id="divkasir" style="width:5975%; height:14%; overflow:hidden; margin: 0 auto; position:absolute; margin-top:1300%; margin-left:-1100%; background-color:#59ABE3">

    </div>
</div>

<div id="fade" class="fadeee" onClick="lightbox_close();"></div>
</body>


<script>

var init = $('#init').val();

    function lightbox_open(){
        document.getElementById('light').style.display='block';
        document.getElementById('fade').style.display='block';
    }
    function lightbox_close(){
        document.getElementById('light').style.display='none';
        document.getElementById('fade').style.display='none';
    }

    $('#btnbek').on('click', function ()
    {

        if(init==4)
        {
            location.href="{{ url('pos/penjualan')  }}";
        }
        else
        {
            location.href="{{ url('pos/index')  }}";
        }

    });



    $('#klik').on('click', function() {
        $.ajax({
            url: "{!! url('pos/hpp/akumulasi') !!}",
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                if (data[0]["nama"] == "gagal") {
                    sweetAlert("Oops...", "Tidak ada transaksi penjualan hari ini", "error");
                }
                else if (data[0]["nama"] == "udahada")
                {
                    sweetAlert("Oops...", "Hpp sudah di akumulasi \n Silahkan Cek di Laporan HPP", "error");
                }
                else {
                    swal("", "Hpp Berhasil di akumulasi", "success");
                }

            }

        });

    });


</script>
</html>
