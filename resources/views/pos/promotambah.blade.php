<!DOCTYPE html>
<html>
<head>
    @include('templates.headerpos')
</head>

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

    <div style="background:#ecf0f1;width:22.2%;height:100%;position:absolute;"></div>
    <a onclick="FunctionLoading()" href="{!! url('pos/master') !!}"><div  style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:7%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Informasi Instansi
        </div></a>
    <a onclick="FunctionLoading()" href="{!! url('pos/master/iklan') !!}"><div style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:13%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Iklan
        </div></a>
    <a onclick="FunctionLoading()" href="{!! url('pos/master/jenis') !!}"><div style="background:#ecf0f1;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:18%;color:#000;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Jenis Transaksi
        </div></a>
    <a onclick="FunctionLoading()" href="{!! url('pos/master/jenis') !!}"><div style="background:#3498db;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:23%;color:#FFF;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Promo
        </div></a>
<form action="{{ url('pos/master/promo/tambah/action')  }}" method="POST">
    <div style="background:#ecf0f1;position:absolute;width:70%;height:70%;margin-left:26%;margin-top:-3%;">

        <label style="color:#000;font-size:18px;position:absolute;margin-top:10%;margin-left:2%">Nama Promo</label>
        <input style="width:30%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:20%;margin-top:10%;" value="" name="namapromo">
        <input style="width:30%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:66%;margin-top:10%;text-align:center" name="akhirpromo" id="status" value="" required>
        <input style="width:16%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:33%;margin-top:22.5%;text-align:center" name="diskon" id="diskon" value="0">
        <input style="width:16%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:33%;margin-top:22.5%;text-align:center" name="nominal" id="nominal" value="0">
        <label style="color:#000;font-size:18px;position:absolute;margin-top:10%;margin-left:54%">Akhir Promo</label>
        <label style="color:#000;font-size:18px;position:absolute;margin-top:16.5%;margin-left:54%">Anggota</label>
        <label style="color:#000;font-size:18px;position:absolute;margin-top:22.5%;margin-left:54%">Keterangan</label>
        <label style="color:#000;font-size:18px;position:absolute;margin-top:16.5%;margin-left:2%">Type Promo</label>
        <label id="nominal1" style="color:#000;font-size:18px;position:absolute;margin-top:22.5%;margin-left:20%">Nominal (Rp)</label>
        <label id="diskon1" style="color:#000;font-size:18px;position:absolute;margin-top:22.5%;margin-left:20%">Diskon (%)</label>
        <textarea style="width:30%;height:25%;position:absolute;font-size:16px;color:#000;margin-left:66%;margin-top:22.5%;" name="Eket" id="Ealamat" required></textarea>
        <div style="font-size:18px;position:absolute;margin-left:66%;width:29.5%;margin-top:16.5%">
            <select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="anggota" name="anggota" required>
                <option placeholder="pilih nama kasir"></option>
                <option value="UMUM">UMUM</option>
                <option value="LUAR BIASA">LUAR BIASA</option>
                <option value="BIASA">BIASA</option>
            </select>
        </div>

        <div style="font-size:18px;position:absolute;margin-left:20%;width:29.5%;margin-top:16.5%">
            <select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="type" name="type" required>
                <option placeholder="pilih nama kasir"></option>
                <option value="Produk">Produk</option>
                <option value="Diskon (%)">Diskon (%)</option>
                <option value="Nominal (Rp)">Nominal (Rp)</option>
            </select>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <button type="submit" style="font-size:14px;width:14%;height:6.3%;color:#FFF;background:#3498db;position:absolute;border:none;margin-left:81.8%;margin-top:40.7%">Simpan</button>
    </div>
</form>
</div>


{{--<input type="hidden" value="{{ $angkanya3 }}" id="input3" style="margin-left:50%;margin-top:20%;">--}}

<script>
    $("#nominal").maskMoney();
    $("#status").datepicker({
        dateFormat: "yyyy-MM-dd",
        autoclose :true
    });
    $("#anggota").select2({
        placeholder: "Anggota",
        allowClear: true
    });

    $("#type").select2({
        placeholder: "Type Promo",
        allowClear: true
    });

    $('#diskon').css('display','none');
    $('#diskon1').css('display','none');
    $('#nominal').css('display','none');
    $('#nominal1').css('display','none');



    $('#type').on('change', function(){

        if($('#type').val() == "Produk")
        {
            $('#diskon').css('display','none');
            $('#diskon1').css('display','none');
            $('#nominal').css('display','none');
            $('#nominal1').css('display','none');
        }
        else if($('#type').val() =="Diskon (%)")
        {

            $('#diskon').css('display','block');
            $('#diskon1').css('display','block');
            $('#nominal').css('display','none');
            $('#nominal1').css('display','none');
        }
        else if($('#type').val() =="Nominal (Rp)")
        {

            $('#diskon').css('display','none');
            $('#diskon1').css('display','none');
            $('#nominal').css('display','block');
            $('#nominal1').css('display','block');
        }

    });
</script>

</body>
</html>
