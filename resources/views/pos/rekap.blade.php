
    <div id="hide1" style="display:none;color:white;font-size:15px;position:absolute;margin-left:63.7%;margin-top:23%">TO</div>
    <div id="hide2" style="display:none;color:white;font-size:15px;position:absolute;margin-left:63.7%;margin-top:23%">TO</div>
    <div id="hide3" style="display:none;color:white;font-size:15px;position:absolute;margin-left:63.7%;margin-top:23%">TO</div>



    <input id="datepicker1" type="text" style="display:none;position:absolute;width:13%;font-size:12px;color:#000;text-align:center;margin-left:50%;margin-top:23%"/>
    <input id="datepicker2" type="text" style="display:none;position:absolute;width:13%;font-size:12px;color:#000;text-align:center;margin-left:67%;margin-top:23%"/>

    <input id="datepickerr1" type="text" style="display:none;position:absolute;width:13%;font-size:12px;color:#000;text-align:center;margin-left:50%;margin-top:23%"/>
    <input id="datepickerr2" type="text" style="display:none;position:absolute;width:13%;font-size:12px;color:#000;margin-left:67%;text-align:center;margin-top:23%"/>

    <input id="datepickerrr1" type="text" style="display:none;position:absolute;width:13%;font-size:12px;color:#000;margin-left:50%;text-align:center;margin-top:23%"/>
    <input id="datepickerrr2" type="text" style="display:none;position:absolute;width:13%;font-size:12px;color:#000;margin-left:67%;text-align:center;margin-top:23%"/>


    {{--<div id="show" style="color:black;font-size:16px;position:absolute;margin-left:4%;margin-top:12%">Produk</div>--}}
    {{--<div id="show" style="color:black;font-size:16px;position:absolute;margin-left:29%;margin-top:12%">Cabang</div>--}}
    <div id="show" style="color:white;font-size:20px;position:absolute;margin-left:33%;margin-top:15.5%">Jenis Rekap</div>
    <a href="{{ url('pos/laporan/transaksi')  }}">
    <div style="color:red;font-size:20px;position:absolute;margin-left:95%;margin-top:2.5%;cursor:pointer"><b>X</b></div>
    </a>{{--<input id="tanggalnya" type="hidden" value="{{ $tanggalnya  }}">--}}
    {{--<input id="tanggalnya2" type="hidden" value="{{ $tanggalnya2  }}">--}}
    {{--<input id="cabangnya" type="hidden" value="{{ $cb  }}">--}}
    {{--<input id="jenisnya" type="hidden" value="{{ $jt  }}">--}}
    {{--<input id="bzz" type="hidden" value="{{ $bzz  }}">--}}

    <div id="hide11" style="display:none;color:white;font-size:20px;position:absolute;margin-left:50%;margin-top:15.5%">Range Hari/Bulan/Tahun</div>
    <div id="hide22" style="display:none;color:white;font-size:20px;position:absolute;margin-left:50%;margin-top:15.5%">Status Anggota</div>
    <div id="hide33" style="display:none;color:white;font-size:20px;position:absolute;margin-left:50%;margin-top:15.5%">Jenis Transaksi</div>
    <input type="hidden" name="_token" id="token" value="{{ csrf_token()  }}">


    {{--<input id="idnya" type="hidden" value="{{ $id  }}">--}}
    {{--<button id="btnok" style="position:absolute;margin-top:19%;margin-left:44%;color:#FFF;border:none;background:#3498db;width:5%;height:33px;font-size:15px;cursor:pointer">OK</button>--}}

    {{--<div style="font-size:16px;position:absolute;margin-left:4%;width:90%;margin-top:14%">--}}
    {{--<select style="font-size:14px;width:25%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:7%" id="idkasir">--}}
    {{--<option placeholder="pilih nama kasir"></option>--}}
    {{--@foreach($produk as $value)--}}
    {{--<option value="{{ $value->id  }}">{{ $value->nama  }} - {{ $value->barcode  }}</option>--}}
    {{--@endforeach--}}
    {{--</select>--}}
    {{--</div>--}}

    <div style="font-size:20px;position:absolute;margin-left:33%;width:35.5%;margin-top:19%" id="desoo">
        <select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="deso">
            <option placeholder=""></option>
            <option value="jenis">Jenis Transaksi</option>
            <option value="status">Status Anggota</option>
            <option value="tanggal">Tanggal</option>
        </select>
    </div>




    <div style="display:none;font-size:20px;position:absolute;margin-left:50%;width:35.5%;margin-top:19%"id="desisionn">
        <select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="desision">
            <option placeholder="pilih nama kasir"></option>
            <option value="day">Hari</option>
            <option value="month">Bulan</option>
            <option value="year">Tahun</option>
        </select>
    </div>


    <div style="display:none;font-size:20px;position:absolute;margin-left:50%;width:35.5%;margin-top:19%" id="desii">
        <select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="desi">
            <option placeholder="pilih nama kasir"></option>
            @foreach($cabang as $value)
            <option value="{{ $value->id  }}">{{ $value->nama  }}</option>
            @endforeach
        </select>
    </div>


    <div style="display:none;font-size:20px;position:absolute;margin-left:50%;width:35.5%;margin-top:19%" id="desuu">
        <select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="desu">
            <option placeholder="pilih nama kasir"></option>
            <option value="tunda">Tunda</option>
            <option value="cash">Cash</option>
        </select>
    </div>

    <button id="pdf" class="mif-file-powerpoint" style="display:none;background:#EF4836;width:15%;color:#fff;font-size:14px;border:none;height:40px;margin-left:70.2%;margin-top:30.3%;position:absolute">&nbsp;PDF</button>
    <button id="pdf1" class="mif-file-powerpoint" style="display:none;background:#EF4836;width:15%;color:#fff;font-size:14px;border:none;height:40px;margin-left:70.2%;margin-top:30.3%;position:absolute">&nbsp;PDF</button>
    <button id="pdf2" class="mif-file-powerpoint" style="display:none;background:#EF4836;width:15%;color:#fff;font-size:14px;border:none;height:40px;margin-left:70.2%;margin-top:30.3%;position:absolute">&nbsp;PDF</button>

    <button id="pdf4" class="mif-file-powerpoint" style="display:none;background:#EF4836;width:15%;color:#fff;font-size:14px;border:none;height:40px;margin-left:70.2%;margin-top:30.3%;position:absolute">&nbsp;PDF</button>
    <button id="pdf5" class="mif-file-powerpoint" style="display:none;background:#EF4836;width:15%;color:#fff;font-size:14px;border:none;height:40px;margin-left:70.2%;margin-top:30.3%;position:absolute">&nbsp;PDF</button>
    <script>

        $("#desision").select2({
            placeholder: "Pilih Hari/Bulan/Tahun",
            allowClear: true
        });

        $("#deso").select2({
            placeholder: "",
            allowClear: true
        });
        $("#desi").select2({
            placeholder: "Pilih Cabang",
            allowClear: true
        });
        $("#desu").select2({
            placeholder: "Pilih Jenis Transaksi",
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



        $('#deso').on('change', function() {

            if($('#deso').val()=="jenis")
            {
                $('#desuu').css('display','block');
                $('#desoo').css('margin-left','14%');
                $('#show').css('margin-left','14%');
                $('#desii').css('display','none');
                $('#desisionn').css('display','none');
                $('#hide33').css('display','block');
                $('#hide22').css('display','none');
                $('#hide11').css('display','none');

                $('#btnok1').css('display','none');
                $('#hide1').css('display','none');
                $('#datepicker1').css('display','none');
                $('#datepicker2').css('display','none');

                $('#btnok2').css('display','none');
                $('#hide2').css('display','none');
                $('#datepickerr1').css('display','none');
                $('#datepickerr2').css('display','none');

                $('#btnok3').css('display','none');
                $('#hide3').css('display','none');
                $('#datepickerrr1').css('display','none');
                $('#datepickerrr2').css('display','none');
                $('#pdf').css('display','none');
                $('#pdf1').css('display','none');
                $('#pdf2').css('display','none');
                $('#pdf4').css('display','block');
                $('#pdf5').css('display','none');
            }
            else  if($('#deso').val()=="status")
            {
                $('#desoo').css('margin-left','14%');
                $('#show').css('margin-left','14%');
                $('#desuu').css('display','none');
                $('#desii').css('display','block');
                $('#desisionn').css('display','none');
                $('#hide33').css('display','none');
                $('#hide22').css('display','block');
                $('#hide11').css('display','none');


                $('#btnok1').css('display','none');
                $('#hide1').css('display','none');
                $('#datepicker1').css('display','none');
                $('#datepicker2').css('display','none');

                $('#btnok2').css('display','none');
                $('#hide2').css('display','none');
                $('#datepickerr1').css('display','none');
                $('#datepickerr2').css('display','none');

                $('#btnok3').css('display','none');
                $('#hide3').css('display','none');
                $('#datepickerrr1').css('display','none');
                $('#datepickerrr2').css('display','none');
                $('#pdf').css('display','none');
                $('#pdf1').css('display','none');
                $('#pdf2').css('display','none');
                $('#pdf4').css('display','none');
                $('#pdf5').css('display','block');

            }
               else if($('#deso').val()=="")
            {
                $('#desoo').css('margin-left','33%');
                $('#show').css('margin-left','33%');
                $('#desuu').css('display','none');
                $('#desii').css('display','none');
                $('#desisionn').css('display','none');
                $('#hide33').css('display','none');
                $('#hide22').css('display','none');
                $('#hide11').css('display','none');


                $('#btnok1').css('display','none');
                $('#hide1').css('display','none');
                $('#datepicker1').css('display','none');
                $('#datepicker2').css('display','none');

                $('#btnok2').css('display','none');
                $('#hide2').css('display','none');
                $('#datepickerr1').css('display','none');
                $('#datepickerr2').css('display','none');

                $('#btnok3').css('display','none');
                $('#hide3').css('display','none');
                $('#datepickerrr1').css('display','none');
                $('#datepickerrr2').css('display','none');
                $('#pdf').css('display','none');
                $('#pdf1').css('display','none');
                $('#pdf2').css('display','none');
                $('#pdf4').css('display','none');
                $('#pdf5').css('display','none');
            }
            else {

                $('#desoo').css('margin-left','14%');
                $('#show').css('margin-left','14%');
                $('#desuu').css('display','none');
                $('#desii').css('display','none');
                $('#desisionn').css('display','block');
                $('#hide33').css('display','none');
                $('#hide22').css('display','none');
                $('#hide11').css('display','block');
                $('#pdf4').css('display','none');
                $('#pdf5').css('display','none');
            }
        });

        $('#desision').on('change', function() {

            if ($('#desision').val() == "day") {

                $('#pdf').css('display','block');
                $('#pdf1').css('display','none');
                $('#pdf2').css('display','none');
                $('#pdf4').css('display','none');
                $('#pdf5').css('display','none');

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

                $('#pdf4').css('display','none');
                $('#pdf5').css('display','none');
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
            else if ($('#desision').val() == "year") {
                $('#pdf4').css('display','none');
                $('#pdf5').css('display','none');

                $('#pdf').css('display','none');
                $('#pdf1').css('display','none');
                $('#pdf2').css('display','block');

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
            else if($('#desision').val()==""){
                $('#pdf4').css('display','none');
                $('#pdf5').css('display','none');
                $('#pdf').css('display','none');
                $('#pdf1').css('display','none');
                $('#pdf2').css('display','none');

                $('#btnok3').css('display','none');
                $('#hide3').css('display','none');
                $('#datepickerrr1').css('display','none');
                $('#datepickerrr2').css('display','none');

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

        $('#pdf4').on('click', function () {

            if ($('#desu').val()=="")
            {
                window.open("{!! url('pos/laporan/rekap/transaksi/all') !!}/" + $('#token').val());
            }
            else
            {
               window.open("{!! url('pos/laporan/rekap/transaksi/jenis') !!}/" + $('#desu').val() + "/" + $('#token').val());
            }

        });

        $('#pdf5').on('click', function () {

            if ($('#desi').val()=="")
            {
                window.open("{!! url('pos/laporan/rekap/cabang/all') !!}/" + $('#token').val());
            }
            else
            {
                window.open("{!! url('pos/laporan/rekap/cabang/jenis') !!}/" + $('#desi').val() + "/" + $('#token').val());
            }

        });

        $('#pdf').on('click', function () {


            var df = $('#datepicker1').val();
            var dt = $('#datepicker2').val();
            df = df.split('/');
            dt = dt.split('/');
            var dfrom = df[2] + "-" + df[0] + "-" + df[1];
            var dto = dt[2] + "-" + dt[0] + "-" + dt[1];
            if (df=="")
            {
                sweetAlert("Oops...", "Tanggal tidak boleh kosong", "error");

            }
            else if(dt==""){
                sweetAlert("Oops...", "Tanggal tidak boleh kosong", "error");
            }
            else
            {
                window.open("{!! url('pos/laporan/rekap/hari') !!}/" + dfrom  + "/" + dto + "/" + $('#token').val());

            }
        });

        $('#pdf1').on('click', function () {

            var df = $('#datepickerr1').val();
            var dt = $('#datepickerr2').val();

            if (df=="")
            {
                sweetAlert("Oops...", "Tanggal tidak boleh kosong", "error");
            }
            else if(dt==""){
                sweetAlert("Oops...", "Tanggal tidak boleh kosong", "error");
            }
            else
            {
                window.open("{!! url('pos/laporan/rekap/bulan') !!}/" + df  + "/" + dt + "/" + $('#token').val());

            }

        });

        $('#pdf2').on('click', function () {

            var df = $('#datepickerrr1').val();
            var dt = $('#datepickerrr2').val();

            if (df=="")
            {
                sweetAlert("Oops...", "Tanggal tidak boleh kosong", "error");
            }
            else if(dt==""){
                sweetAlert("Oops...", "Tanggal tidak boleh kosong", "error");
            }
            else
            {
                window.open("{!! url('pos/laporan/rekap/tahun') !!}/" + df  + "/" + dt + "/" + $('#token').val());

            }
        });

    </script>

