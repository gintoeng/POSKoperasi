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
    <a onclick="FunctionLoading()" href="{!! url('pos/master/promo') !!}"><div style="background:#3498db;position:absolute;width:22%;height:8%;margin-left:0px;margin-top:23%;color:#FFF;font-size:22px;padding-left:45px;padding-top:10px;position:absolute;cursor:pointer;">Promo
        </div></a>

    <div style="background:#ecf0f1;position:absolute;width:70%;height:70%;margin-left:26%;margin-top:0;">
    </div>

    <a href="{{ url('pos/master/promo/tambah')  }}"><button id="simpan" style="font-size:14px;width:10%;height:4.3%;color:#FFF;background:#3498db;position:absolute;border:none;margin-left:27.5%;margin-top:3%">Tambah</button></a>

    <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:10%; margin-left:26%; width:70%;height:400px">



        <div class="x_panel" style="background:#3498db;margin-top:-40px;">

            <div id="table-scroll6" style="width:103%;margin-left:-1.5%">

                <table id="table" class="display dataTable table table-hover" cellspacing="0" style="margin-top:0px; margin-left:0px;width:100%;position:relative;background:white;">
                    <thead>
                    <tr style="background:#3498db; color: white; font-size:16px;">
                        <td align="center"><b>Promo</b></td>
                        <td align="center"><b>Type Promo</b></td>
                        <td align="center"><b>Tanggal Akhir</b></td>
                        <td align="center"><b>Anggota</b></td>
                    </tr>
                    </thead>

                    <tbody style="overflow:auto; height: 50px;">
                    @foreach($promo as $value)
                        <tr style="background-color: white; font-size:18px; color:black;">
                            <td align="center">{{ $value->nama  }}</td>
                            <td align="center">{{ $value->type  }}</td>
                            <td align="center">{{ $value->akhir_promo  }}</td>
                            <td align="center">{{ $value->status  }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



</div>

{{--<input type="hidden" value="{{ $angkanya3 }}" id="input3" style="margin-left:50%;margin-top:20%;">--}}

<script>

</script>

</body>
</html>
