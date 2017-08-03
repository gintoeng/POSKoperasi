<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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

    <a onclick="FunctionLoading()" href="{!!url('/pos/laporan/penjualan')!!}"><div style="cursor:pointer;height:80px; margin-top:50px;float:left; margin-left:10px; position:absolute;color:#3498db;font-size:50px"><img src="{{ url('assets/poscss/imgs/back.png') }}" style="width:40px;height:40px" alt="">&nbsp;<b>Detail Penjualan</b></div></a>


    <div style="width:100%; height:100%; margin: 0 auto; background-color:#FFF">


        <div id="show" style="color:black;font-size:22px;position:absolute;margin-left:4%;margin-top:14%">No. Reff &nbsp;&nbsp;:</div>
        <div id="show" style="color:black;font-size:22px;position:absolute;margin-left:29%;margin-top:14%">Tanggal&nbsp;:</div>
        <div id="show" style="color:black;font-size:22px;position:absolute;margin-left:4%;margin-top:18%">Kasir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</div>
        <input id="tanggalnya" type="hidden" value="{{ $tanggalnya  }}">
        <input id="tanggalnya2" type="hidden" value="{{ $tanggalnya2  }}">
        <input id="kasirnya" type="hidden" value="{{ $kasirnya }}">
        <input id="cabangnya" type="hidden" value="{{ $cb  }}">
        <input id="jenisnya" type="hidden" value="{{ $jt  }}">
        <input id="bzz" type="hidden" value="{{ $bzz  }}">
        <div id="hide" style="color:black;font-size:22px;position:absolute;margin-left:29%;margin-top:18%">Type Pembayaran&nbsp;:</div>
        {{--<button id="btnok" style="position:absolute;margin-top:19%;margin-left:44%;color:#FFF;border:none;background:#3498db;width:5%;height:33px;font-size:15px;cursor:pointer">OK</button>--}}
        <div style="font-size:22px;position:absolute;margin-left:12%;width:90%;margin-top:14%;color:#000">
            {{ $noreff  }}
        </div>

        <div style="font-size:22px;position:absolute;margin-left:36%;width:90%;margin-top:14%;color:#000">
        {{ $role_kasir->tanggal  }}
        </div>

        <div style="font-size:22px;position:absolute;margin-left:12%;width:22.5%;margin-top:18%;color:#000">
        {{ $kasir->username  }}
        </div>


        <div style="font-size:22px;position:absolute;margin-left:43%;width:22.5%;margin-top:18%;color:#000">
            {{ $role_kasir->type_pembayaran  }}
        </div>

        <div style="font-size:22px;color:black;margin-left:68%;margin-top:5%;position:absolute;">Total Belanja</div>
        <div style="width:40%;text-align:right;font-size:73px;color:black;margin-left:56%;position:absolute;margin-top:8%">Rp. {!! number_format($jumlah ,2,",",".") !!}</div>

        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:22%; margin-left:3%; width:94%;height:250px">


            <div class="x_panel" style="background:#3498db;margin-top:0px;">

                <div id="table-scroll6" style="width:100%;margin-left:-0.1%">

                    <table id="table" class="display dataTable table table-hover" cellspacing="0" style="margin-top:0px; margin-left:0px;width:100%;position:relative;background:white;">
                        <thead>
                        <tr style="background:#3498db; color: white; font-size:20px;">
                            <td align="center"><b>Produk</b></td>
                            <td align="center"><b>Qty</b></td>
                            <td align="center"><b>Harga Satuan</b></td>
                            <td align="center"><b>Total</b></td>
                        </tr>
                        </thead>

                        <tbody style=" height: 50px;">
                        @foreach($detail as $value)
                            <tr style="background-color: white; font-size:17px; color:black;">
                                <td align="center">{!! $value->produk !!}</td>
                                <td align="center">{!! $value->qty !!}</td>
                                <td align="center">Rp. {!! number_format($value->harga ,2,",",".") !!}</td>
                                <td align="center">Rp. {!! number_format($value->sub_total ,2,",",".") !!}</td>
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
    var kasir = $('#kasirnya').val();

    $("#idkasir").select2({
        placeholder: "Pilih Kasir",
        allowClear: true
    });

    $("#idksr").select2({
        placeholder: "Pilih Hari/Bulan/Tahun",
        allowClear: true
    });

    $("#idkasi").select2({
        placeholder: "Pilih Cabang",
        allowClear: true
    });

    $("#idkasirr").select2({
        placeholder: "Jenis Transaksi",
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


    $('#idksr').on('change', function() {

        if ($('#idksr').val() == "day") {

            $('#btnok1').css('display','block');
            $('#hide1').css('display','block');
            $('#datepicker1').css('display','block');
            $('#datepicker2').css('display','block');

            $('#pdf').css('display','block');
            $('#pdf1').css('display','none');
            $('#pdf2').css('display','none');

            $('#btnok2').css('display','none');
            $('#hide2').css('display','none');
            $('#datepickerr1').css('display','none');
            $('#datepickerr2').css('display','none');

            $('#btnok3').css('display','none');
            $('#hide3').css('display','none');
            $('#datepickerrr1').css('display','none');
            $('#datepickerrr2').css('display','none');


        }
        else if ($('#idksr').val() == "month") {

            $('#pdf').css('display','none');
            $('#pdf1').css('display','block');
            $('#pdf2').css('display','none');

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
        else if ($('#idksr').val() == "year") {


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

            $('#pdf').css('display','none');
            $('#pdf1').css('display','none');
            $('#pdf2').css('display','block');


        }
    });

    if (kasir=="Semua Kasir")
    {


        $('#pdf').on('click', function () {

            var df = $('#tanggalnya').val();
            var dt = $('#tanggalnya2').val();

            window.open("{!! url('pos/kasir/periodik/allkasir/torange/pdf/hari') !!}/"+ df + "/" + dt + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());

        });


        $('#pdf1').on('click', function () {

            var df = $('#tanggalnya').val();
            var dt = $('#tanggalnya2').val();

            window.open("{!! url('pos/kasir/periodik/allkasir/torange/pdf/bulan') !!}/" + df + "/" + dt + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());

        });


        $('#pdf2').on('click', function () {

            var df = $('#tanggalnya').val();
            var dt = $('#tanggalnya2').val();

            window.open("{!! url('pos/kasir/periodik/allkasir/torange/pdf/tahun') !!}/" + df + "/" + dt + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());

        });

    }

    else
    {


        $('#pdf').on('click', function () {
            var df = $('#tanggalnya').val();
            var dt = $('#tanggalnya2').val();

            // df = df.split('/');
            // var dfrom = df[2] + "-" + df[0] + "-" + df[1];
            // alert(dfrom);
            window.open("{!! url('pos/kasir/periodik/sumrange/pdf/hari') !!}/" + $('#kasirnya').val() + "/" + df + "/" + dt + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());


        });



        $('#pdf1').on('click', function () {
            var df = $('#tanggalnya').val();
            var dt = $('#tanggalnya2').val();
            // df = df.split('/');
            // var dfrom = df[2] + "-" + df[0] + "-" + df[1];
            // alert(dfrom);
            window.open("{!! url('pos/kasir/periodik/sumrange/pdf/bulan') !!}/" + $('#kasirnya').val() + "/" + df + "/" + dt + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());


        });



        $('#pdf2').on('click', function () {
            var df = $('#tanggalnya').val();
            var dt = $('#tanggalnya2').val();
            // df = df.split('/');
            // var dfrom = df[2] + "-" + df[0] + "-" + df[1];
            // alert(dfrom);
            window.open("{!! url('pos/kasir/periodik/sumrange/pdf/tahun') !!}/" + $('#kasirnya').val() + "/" + df + "/" + dt + "/" + $('#cabangnya').val() + "/" + $('#jenisnya').val());


        });


    }

    $('#idkasir').on('change', function()
    {

        if ($('#idkasir').val()=="allkasir") {



            $('#btnok1').on('click', function () {

                var df = $('#datepicker1').val();
                var dt = $('#datepicker2').val();
                df = df.split('/');
                dt = dt.split('/');
                var dfrom = df[2] + "-" + df[0] + "-" + df[1];
                var dto = dt[2] + "-" + dt[0] + "-" + dt[1];

                location.href = "{!! url('pos/laporan/all/days') !!}/" + dfrom + "/" + dto + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
            });




            $('#btnok2').on('click', function () {

                var df = $('#datepickerr1').val();
                var dt = $('#datepickerr2').val();
                location.href = "{!! url('pos/laporan/all/months') !!}/" + df + "/" + dt + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
            });




            $('#btnok3').on('click', function () {

                var df = $('#datepickerrr1').val();
                var dt = $('#datepickerrr2').val();
                location.href = "{!! url('pos/laporan/all/years') !!}/" + df + "/" + dt + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
            });




        }



        else
        {



            $('#btnok1').on('click', function () {


                var df = $('#datepicker1').val();
                var dt = $('#datepicker2').val();
                df = df.split('/');
                dt = dt.split('/');
                var dfrom = df[2] + "-" + df[0] + "-" + df[1];
                var dto = dt[2] + "-" + dt[0] + "-" + dt[1];

                location.href = "{!! url('pos/laporan/days') !!}/" + $('#idkasir').val() + "/" + dfrom + "/" + dto + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
            });




            $('#btnok2').on('click', function () {

                var df = $('#datepickerr1').val();
                var dt = $('#datepickerr2').val();
                location.href = "{!! url('pos/laporan/months') !!}/" + $('#idkasir').val() + "/" + df + "/" + dt +  "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
            });




            $('#btnok3').on('click', function () {

                var df = $('#datepickerrr1').val();
                var dt = $('#datepickerrr2').val();
                location.href = "{!! url('pos/laporan/years') !!}/" + $('#idkasir').val() + "/" + df + "/" + dt + "/" + $('#idkasi').val() + "/" + $('#idkasirr').val();
            });






        }


    });


</script>
</body>
</html>
