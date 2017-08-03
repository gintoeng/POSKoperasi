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
</body>
<body id="">

<a onclick="FunctionLoading()" href="{!!url('/pos/laporan/')!!}">
    <img src="{{ url('assets/poscss/imgs/back.png') }}" style="margin-left:40px;width:40px;height:40px;margin-top:68px;position:absolute" alt=""></a>
    <div style="height:80px; margin-top:50px;float:left; margin-left:90px; position:absolute;color:#3498db;font-size:50px">&nbsp;<b>Laporan HPP</b></div>


        <div style="width:100%; height:100%; margin: 0 auto; background-color:#FFF">
            <div id="hide1" style="display:none;color:black;font-size:15px;position:absolute;margin-left:64.7%;margin-top:19.2%">TO</div>
            <div id="hide2" style="display:none;color:black;font-size:15px;position:absolute;margin-left:64.7%;margin-top:19.2%">TO</div>
            <div id="hide3" style="display:none;color:black;font-size:15px;position:absolute;margin-left:64.7%;margin-top:19.2%">TO</div>

            <button id="btnok1" style="display:none;position:absolute;margin-top:19%;margin-left:80%;color:#FFF;border:none;background:#3498db;width:4%;height:25px;font-size:10px;cursor:pointer">OK</button>
            <button id="btnok2" style="display:none;position:absolute;margin-top:19%;margin-left:80%;color:#FFF;border:none;background:#3498db;width:4%;height:25px;font-size:10px;cursor:pointer">OK</button>
            <button id="btnok3" style="display:none;position:absolute;margin-top:19%;margin-left:80%;color:#FFF;border:none;background:#3498db;width:4%;height:25px;font-size:10px;cursor:pointer">OK</button>

            <input id="datepicker1" type="text" style="display:none;position:absolute;width:11%;font-size:12px;color:#000;text-align:center;margin-left:53%;margin-top:19.2%"/>
            <input id="datepicker2" type="text" style="display:none;position:absolute;width:11%;font-size:12px;color:#000;text-align:center;margin-left:67%;margin-top:19.2%"/>

            <input id="datepickerr1" type="text" style="display:none;position:absolute;width:11%;font-size:12px;color:#000;text-align:center;margin-left:53%;margin-top:19.2%"/>
            <input id="datepickerr2" type="text" style="display:none;position:absolute;width:11%;font-size:12px;color:#000;margin-left:67%;text-align:center;margin-top:19.2%"/>

            <input id="datepickerrr1" type="text" style="display:none;position:absolute;width:11%;font-size:12px;color:#000;margin-left:53%;text-align:center;margin-top:19.2%"/>
            <input id="datepickerrr2" type="text" style="display:none;position:absolute;width:11%;font-size:12px;color:#000;margin-left:67%;text-align:center;margin-top:19.2%"/>


            {{--<div id="show" style="color:black;font-size:16px;position:absolute;margin-left:4%;margin-top:12%">Produk</div>--}}
            {{--<div id="show" style="color:black;font-size:16px;position:absolute;margin-left:29%;margin-top:12%">Cabang</div>--}}
            <div id="show" style="color:black;font-size:16px;position:absolute;margin-left:4%;margin-top:17%">Produk</div>
            <input id="tanggalnya" type="hidden" value="{{ $tanggalnya  }}">
            <input id="tanggalnya2" type="hidden" value="{{ $tanggalnya2  }}">
            <input id="cabangnya" type="hidden" value="{{ $cb  }}">
            <input id="jenisnya" type="hidden" value="{{ $jt  }}">
            <input id="bzz" type="hidden" value="{{ $bzz  }}">
            <div id="hide" style="color:black;font-size:16px;position:absolute;margin-left:29%;margin-top:17%">Range Hari/Bulan/Tahun</div>
            <input id="idnya" type="hidden" value="{{ $id  }}">
            {{--<button id="btnok" style="position:absolute;margin-top:19%;margin-left:44%;color:#FFF;border:none;background:#3498db;width:5%;height:33px;font-size:15px;cursor:pointer">OK</button>--}}

            {{--<div style="font-size:16px;position:absolute;margin-left:4%;width:90%;margin-top:14%">--}}
                {{--<select style="font-size:14px;width:25%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:7%" id="idkasir">--}}
                    {{--<option placeholder="pilih nama kasir"></option>--}}
                    {{--@foreach($produk as $value)--}}
                        {{--<option value="{{ $value->id  }}">{{ $value->nama  }} - {{ $value->barcode  }}</option>--}}
                        {{--@endforeach--}}
                {{--</select>--}}
            {{--</div>--}}



            <div style="font-size:16px;position:absolute;margin-left:4%;width:22.5%;margin-top:17.5%">
               <input id="nama" type="text" style="width:100%;font-size:16px">
            </div>


            <div style="font-size:16px;position:absolute;margin-left:29%;width:22.5%;margin-top:19%">
                <select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="desision">
                    <option placeholder="pilih nama kasir"></option>
                    <option value="day">Hari</option>
                    <option value="month">Bulan</option>
                    <option value="year">Tahun</option>
                </select>
            </div>

            <button id="pdf" class="mif-file-powerpoint" style="background:#EF4836;width:10%;color:#fff;font-size:14px;border:none;height:40px;margin-left:86.2%;margin-top:18.3%;position:absolute">&nbsp;PDF</button>
            <button id="pdf1" class="mif-file-powerpoint" style="background:#EF4836;width:10%;color:#fff;font-size:14px;border:none;height:40px;margin-left:86.2%;margin-top:18.3%;position:absolute">&nbsp;PDF</button>
            <button id="pdf2" class="mif-file-powerpoint" style="background:#EF4836;width:10%;color:#fff;font-size:14px;border:none;height:40px;margin-left:86.2%;margin-top:18.3%;position:absolute">&nbsp;PDF</button>
            <div style="font-size:22px;color:black;margin-left:68%;margin-top:5%;position:absolute;">Total HPP</div>
            <div style="width:40%;text-align:right;font-size:61px;color:black;margin-left:56%;position:absolute;margin-top:8%"><b>Rp. {!! number_format($jumlah ,2,",",".") !!}</b></div>

            <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:22%; margin-left:3%; width:94%;height:250px">


                <div class="x_panel" style="background:#3498db;margin-top:0px;">

                    <div id="table-scroll6" style="width:100%;margin-left:-0.1%">

                        <table id="table" class="display dataTable table table-hover" cellspacing="0" style="margin-top:0px; margin-left:0px;width:100%;position:relative;background:white;">
                            <thead>
                            <tr style="background:#3498db; color: white; font-size:20px;">
                                <td align="center"><b>Produk</b></td>
                                <td align="center"><b>Tanggal</b></td>
                                <td align="center"><b>Qty Persediaan</b></td>
                                <td align="center"><b>Qty Pembelian</b></td>
                                <td align="center"><b>Qty Penjualan</b></td>
                                <td align="center"><b>Stok Akhir</b></td>
                                <td align="center"><b>HPP</b></td>
                            </tr>
                            </thead>

                            <tbody style="overflow:auto; height: 50px;">
                            @foreach($detail as $value)
                                <tr style="background-color: white; font-size:17px; color:black;">
                                    <td align="center">{!! $value->produk !!}</td>
                                    <td align="center">{!! $value->tanggal !!}</td>
                                    <td align="center">{!! $value->qty_persediaan !!}</td>
                                    <td align="center">{!! $value->qty_pembelian !!}</td>
                                    <td align="center">{{ $value->qty_penjualan  }}</td>
                                    <td align="center">{{ $value->stok_akhir  }}</td>
                                    <td align="center">Rp. {!! number_format($value->hpp_asli ,2,",",".") !!}</td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div id="paginationharian" style="margin-left:4%;margin-top:44%;position:absolute">{{ $detail->links()  }}</div>
        </div>



<!--header-->


<script>




    $("#desision").select2({
        placeholder: "Pilih Hari/Bulan/Tahun",
        allowClear: true
    });

    $("#tanggalnya").datepicker({
        dateFormat: "yyyy-MM-dd",
        autoclose :true
    });

    $("#datepicker1").datepicker({
        dateFormat: "yyyy-MM-dd",
        autoclose: true
    });

    $("#datepicker2").datepicker({
        dateFormat: "yyyy-MM-dd",
        autoclose: true
    });


    $('#datepickerr1').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true
    });
    $('#datepickerr2').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true
    });

    $('#datepickerrr1').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });

    $('#datepickerrr2').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });

    var bzz = $('#bzz').val();

    if(bzz=="Hari")
    {
        $('#pdf').css('display','block');
        $('#pdf1').css('display','none');
        $('#pdf2').css('display','none');
    }
    else if(bzz=="Bulan")
    {
        $('#pdf').css('display','none');
        $('#pdf1').css('display','block');
        $('#pdf2').css('display','none');
    }
    else if(bzz=="Tahun")
    {
        $('#pdf').css('display','none');
        $('#pdf1').css('display','none');
        $('#pdf2').css('display','block');
    }

    $('#desision').on('change', function() {

        if ($('#desision').val() == "day") {

            $('#btnok1').css('display','block');
            $('#hide1').css('display','block');
            $('#datepicker1').css('display','block');
            $('#datepicker2').css('display','block');

            $('#btnok2').css('display','none');
            $('#hide2').css('display','none');
            $('#datepickerr1').css('display','none');
            $('#datepickerr2').css('display','none');

            $('#btnok3').css('display','none');
            $('#hide3').css('display','none');
            $('#datepickerrr1').css('display','none');
            $('#datepickerrr2').css('display','none');


        }
        else if ($('#desision').val() == "month") {


            $('#btnok2').css('display','block');
            $('#hide2').css('display','block');
            $('#datepickerr1').css('display','block');
            $('#datepickerr2').css('display','block');

            $('#btnok3').css('display','none');
            $('#hide3').css('display','none');
            $('#datepickerrr1').css('display','none');
            $('#datepickerrr2').css('display','none');

            $('#btnok1').css('display','none');
            $('#hide1').css('display','none');
            $('#datepicker1').css('display','none');
            $('#datepicker2').css('display','none');


        }
        else if ($('#desision').val() == "year") {

            $('#btnok3').css('display','block');
            $('#hide3').css('display','block');
            $('#datepickerrr1').css('display','block');
            $('#datepickerrr2').css('display','block');

            $('#btnok1').css('display','none');
            $('#hide1').css('display','none');
            $('#datepicker1').css('display','none');
            $('#datepicker2').css('display','none');

            $('#btnok2').css('display','none');
            $('#hide2').css('display','none');
            $('#datepickerr1').css('display','none');
            $('#datepickerr2').css('display','none');


        }
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
</body>
</html>
