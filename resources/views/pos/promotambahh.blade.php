<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/poscss/css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('assets/js/jquery.maskMoney.js')}}"></script>

    <style>
        body{
            margin:0;
            background-color:#fff;
            overflow:auto;
        }
    </style>

    <script>
        function showDialogInput(id){
            var dialog = $(id).data('input');
            dialog.open();
        }
    </script>

    <title>Point Of Sale</title>

</head>

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
        <div style="background:#ecf0f1;position:absolute;width:70%;height:70%;margin-left:26%;margin-top:-3%;">

            <label style="color:#000;font-size:18px;position:absolute;margin-top:10%;margin-left:2%">Nama Promo</label>
            <input readonly style="width:30%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:20%;margin-top:10%;" value="{{ $promo->nama  }}" name="namapromo">
            <input disabled style="width:30%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:66%;margin-top:10%;text-align:center" name="akhirpromo" id="status" value="{{ $promo->akhir_promo }}">
            <input disabled style="width:16%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:33%;margin-top:22.5%;text-align:center" name="diskon" id="diskon" value="{{ $promo->diskon }}">
            <input disabled style="width:16%;height:6%;position:absolute;font-size:16px;color:#000;margin-left:33%;margin-top:22.5%;text-align:center" name="nominal" id="nominal" value="{{ $promo->nominal  }}">
            <label style="color:#000;font-size:18px;position:absolute;margin-top:10%;margin-left:54%">Akhir Promo</label>
            <label style="color:#000;font-size:18px;position:absolute;margin-top:16.5%;margin-left:54%">Anggota</label>
            <label style="color:#000;font-size:18px;position:absolute;margin-top:22.5%;margin-left:54%">Keterangan</label>
            <label style="color:#000;font-size:18px;position:absolute;margin-top:16.5%;margin-left:2%">Type Promo</label>
            <label id="nominal1" style="color:#000;font-size:18px;position:absolute;margin-top:22.5%;margin-left:20%">Nominal (Rp)</label>
            <label id="diskon1" style="color:#000;font-size:18px;position:absolute;margin-top:22.5%;margin-left:20%">Diskon (%)</label>
            <textarea readonly style="width:30%;height:25%;position:absolute;font-size:16px;color:#000;margin-left:66%;margin-top:22.5%;" name="Eket" id="Ealamat" >{{ $promo->keterangan  }}</textarea>
            <div style="font-size:18px;position:absolute;margin-left:66%;width:29.5%;margin-top:16.5%">
                <select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="anggota" name="anggota" >
                    <option value="{{ $promo->status  }}">{{ $promo->status  }}</option>
                </select>
            </div>

            <div style="font-size:18px;position:absolute;margin-left:20%;width:29.5%;margin-top:16.5%">
                <select style="font-size:14px;width:100%;font-size:16px;margin-left:28%;position:absolute;color:black;margin-top:3%" id="type" name="type" >
                    <option value="{{ $promo->type  }}">{{ $promo->type }}</option>
                </select>
            </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}">

        </div>

</div>
<div style="width:10%;margin-top:-25.3%;margin-left:84.5%;position:absolute">
    <a class="place-left button bg-blue bg-active-blue fg-white" onclick="showDialog('#dialog')"> <span class="mif-ani-float"></span> &nbsp;Cari Barang</a>
</div>
<div data-role="dialog" id="input" class="padding20" data-close-button="true" data-windows-style="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
    <div class="container" style="height:500px;">
        <div class="row cells12">
            <div class="cell"></div>
            <div class="cell colspan10">
                <div class="grid">
                    <div class="row cells12">
                        <div class="cell colspan3">
                            <br>Data Keranjang Barang
                        </div>
                        <div class="cell colspan4">
                            <div class="input-control required place-right" data-role="select" style="width:90%;" placeholder="Pilih Jenis Barang">
                                <select name="pilihan" id="pilihan">
                                    <option value="1">Barcode</option>
                                    <option value="2">Nama</option>
                                    <option value="3">Semua Data Barang</option>
                                </select>
                            </div>
                        </div>
                        <div class="cell colspan5">
                            <div class="input-control text" data-role="input" style="width:100%;">
                                <input type="text" name="search" id="search">
                                <button id="searchbtn" class="button info"><span class="mif-search"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="divpertama"> </div>
                <div id="divpertama1">
                    <form action="{{url('pos/master/promo/storebarang')}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="kode2" value="{{$promo->id}}">
                        <div class="container" id="" style="overflow-y: scroll; height:400px;">
                            <table class="dataTable bordered" data-searching="true" style="overflow:auto; width:100%; background-color:#fff;">
                                <thead>
                                <tr>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">No</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Barcode</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Nama Produk</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Tanggal</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Klasifikasi</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Stok</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Harga Beli</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Harga Jual</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">QTY</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow" align="center"><input type="checkbox" name="checkAll" id="TableAll" align="center"></th>
                                </tr>
                                </thead>
                                <?php $i = 1; ?>
                                <tbody>
                                @foreach ($produk as $value)

                                    <tr>
                                        <td>{!! $i++ !!}</td>
                                        <td>{!! $value->barcode !!}</td>
                                        <td>{!! $value->nama !!}</td>
                                        <td>{!! $value->classification !!}</td>
                                        <td>{!! number_format($value->harga_beli, '2') !!}</td>
                                        <td>{!! number_format($value->harga_jual, '2') !!}</td>
                                        <td><input type="text" style="width:40px;text-align:center"  name="qty{{$value->id}}"></td>
                                        <td><input type="checkbox" placeholder="" name="cbpilih[{{$value->id}}]"/></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button class="place-right button success" type="submit"><span class="mif-paper-plane mif-ani-float"></span>Simpan</button>
                    </form>
                </div>
            </div>
            <div class="cell"></div>
        </div>
    </div>
</div>

<div data-role="dialog" id="dialog" class="padding20" data-close-button="true" data-windows-style="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
    <div class="container" style="height:500px;">
        <div class="row cells12">
            <div class="cell"></div>
            <div class="cell colspan10">
                <div class="grid">
                    <div class="row cells12">
                        <div class="cell colspan3">
                            <br>Data Keranjang Barang
                        </div>
                        <div class="cell colspan4">
                            <div class="input-control required place-right" data-role="select" style="width:90%;" placeholder="Pilih Jenis Barang">
                                <select name="pilihan" id="pilihan">
                                    <option value="1">Barcode</option>
                                    <option value="2">Nama</option>
                                    <option value="3">Semua Data Barang</option>
                                </select>
                            </div>
                        </div>
                        <div class="cell colspan5">
                            <div class="input-control text" data-role="input" style="width:100%;">
                                <input type="text" name="search" id="search">
                                <button id="searchbtn" class="button info"><span class="mif-search"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="divpertama"> </div>
                <div id="divpertama1">
                    <form action="{{url('pos/master/promo/storebarang')}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="kode2" value="{{$promo->id}}">
                        <div class="container" id="" style="overflow-y: scroll; height:400px;">
                            <table id="TableAll" class="dataTable bordered" data-searching="true" style="overflow:auto; width:100%; background-color:#fff;">
                                <thead>
                                <tr>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">No</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Barcode</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Nama Produk</th>
                                    {{--<th class="ribbed-cyan fg-white padding10 text-shadow">Tanggal</th>--}}
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Klasifikasi</th>
                                    {{--<th class="ribbed-cyan fg-white padding10 text-shadow">Stok</th>--}}
                                    {{--<th class="ribbed-cyan fg-white padding10 text-shadow">Harga Beli</th>--}}
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Harga Satuan</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">QTY</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow" align="center"><input type="checkbox" name="checkAll" id="TableAll" align="center"></th>
                                </tr>
                                </thead>
                                <?php $i = 1; ?>
                                <tbody>
                                @foreach ($produk as $value)

                                    <tr>
                                        <td>{!! $i++ !!}</td>
                                        <td>{!! $value->barcode !!}</td>
                                        <td>{!! $value->nama !!}</td>
                                        {{--                                        <td>{!! $value->created_at !!}</td>--}}
                                        <td>{!! $value->classification !!}</td>
                                        {{--<td>{!! $value->stok !!}</td>--}}
                                        <td>{!! number_format($value->harga_jual, '2') !!}</td>
                                        <td><input type="text" style="width:40px;"  name="qty{{$value->id}}"></td>
                                        <td><input type="checkbox" placeholder="" name="cbpilih[{{$value->id}}]"/></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button class="place-right button success" type="submit"><span class="mif-paper-plane mif-ani-float"></span>Simpan</button>
                    </form>
                </div>
            </div>
            <div class="cell"></div>
        </div>
    </div>
</div>
</body>
<script>
    var header = <?php echo json_encode($promo->id) ?>;

    function showDialog(id){
        var dialog = $(id).data('dialog');
        dialog.open();
    }

    $("#search").keyup(function (e) {
        if (e.keyCode == 13) {
            $("#divpertama").load("{{ URL::to('pos/master/promo/get')}}/"+$("#search").val() +"/"+ $("#pilihan").val() + "/" + header);
            document.getElementById('divpertama1').style.display = 'none';
        }
    });

    $("#searchbtn").click(function (e) {
        $("#divpertama").load("{{ URL::to('pos/master/promo/get')}}/"+$("#search").val() +"/"+ $("#pilihan").val() + "/" + header);
        document.getElementById('divpertama1').style.display = 'none';
    });

    $("#pilihan").change(function (e) {
        if ($("#pilihan").val() == 3) {
            $("#divpertama").load("{{ URL::to('pos/master/promo/get')}}/"+$("#search").val() +"/"+ $("#pilihan").val() + "/" + header);
            document.getElementById('divpertama1').style.display = 'none';
        }
    });
</script>

<script>
    $('#TableAll').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });

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

</html>
