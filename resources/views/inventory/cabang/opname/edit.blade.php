<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/templateinventory/inventory.ico') }}">
    <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">
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

    <title>Inventory</title>
</head>

<body id="">
<div class="app-bar navy" data-role="appbar">
    <a class="app-bar-element" href="{!! url('/inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
    <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
    <span class="app-bar-divider"></span>
    <ul class="app-bar-menu">
        {{--<li>--}}
        {{--<a class="dropdown-toggle"> <span class="mif-tools"></span> Tambah Barang</a>--}}
        {{--<ul class="d-menu" data-role="dropdown">--}}
        {{--<li><a onclick="showDialog('#dialog')"> <span class="mif-dollar2"></span> &nbsp;Cari Barang</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
    </ul>
</div>

<h1 style="margin-left:4%; margin-top:3%;"><a href="{!! url('inventory/cabang/opname') !!}" class="nav-button transform"><span></span></a>&nbsp;Edit Opname</h1>
<hr style="width:95%;"><br>
<div class="grid">
    <div class="row cells12">
        <div class="cell"></div>
        <div class="cell colspan10">
            <div class="row cells2">
                {{--<div class="cell">--}}
                    <label>Kode Opname</label>
                    <div class="input-control text full-size">
                        <input type="text" name="kode" readonly value="{{$header->nopembelian}}">
                    </div>
                {{--</div>--}}
            </div>
            <div class="row cells2">
                <div class="cell">
                    <label>Tanggal</label>
                    <div class="input-control text full-size">
                        <input type="text" name="tanggal" readonly value="{{$header->tanggal}}">
                    </div>
                </div>
                <div class="cell">
                    <label>Cabang</label>
                    <div class="input-control text full-size">
                        <input type="text" name="vendor" readonly value="{{$header->cabang->nama}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="cell"></div>
    </div>
    <div class="row cells12"></div>
    <div class="row cells12">
        <div class="cell"></div>
        <div class="cell colspan10">
            <form action="{{url('inventory/cabang/opname/adjust')}}" method="post" role="form" enctype="multipart/form-data" id="fadj">
                <input type="hidden" name="urlnya" value="{{url()->previous()}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                    @if($header->start == 0)
                        <div class="grid">
                            <div class="row cells12">
                                <div class="cell colspan6">
                                    {{--<a href="{{url('/tambahproduk/'.$header->id)}}" class="place-left button bg-cyan bg-active-cyan fg-white"> <span class="mif-plus mif-ani-float"></span> &nbsp;Tambah Barang</a>--}}
                                    <a class="place-left button bg-orange bg-active-orange fg-white" onclick="showDialog('#dialog')"> <span class="mif-dollar2 mif-ani-float"></span> &nbsp;Cari Barang</a>
                                    {{--<button type="submit" class="button bg-cobalt bg-active-darkBlue fg-white"><span class="mif-tag mif-ani-float"></span> Adjust</button>--}}
                                </div>
                                {{--<div class="cell colspan6">--}}
                                    {{--<div class="input-control text full-size" data-role="input">--}}
                                        {{--<input type="text" name="bsearch" id="bsearch" autofocus onkeypress="barcodesearch()">--}}
                                        {{--<button class="button primary" type="button" onclick="barcodesearch()"><span class="mif-search"></span></button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    @endif
                    <input type="hidden" id="idh" value="{{$header->id}}" name="idh">
                    <table class="dataTable striped hovered cell-hovered border bordered " data-searching="true" style="overflow:auto; width:100%; background-color:#fff; width:100%;">
                        <thead>
                        <tr>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">No</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Barcode</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Nama Barang</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Stok Sistem</th>
                            {{--<th class="text-center ribbed-cyan fg-white padding10 text-shadow">Stok Fisik</th>--}}
                            {{--<th class="text-center ribbed-cyan fg-white padding10 text-shadow">Selisih</th>--}}
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow"><center>Opsi</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($header->detail as $details)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$details->barang->barcode}}</td>
                                <td>{{$details->barang->nama}}</td>
                                <td align="center">{{$details->stok_sistem}}</td>
                                {{--<td align="center">--}}
                                    {{--<div class="input-control text" data-role="input">--}}
                                        {{--<input type="text" style="width:100%;" name="stoknya{{$details->id}}" id="stoknya{{$details->id}}" value="{{$details->stok_fisik}}">--}}
                                        {{--<div class="button-group">--}}
                                            {{--<button type="button" class="button warning" onclick="minus({{$details->id}})"><span class="icon mif-minus"></span></button>--}}
                                            {{--<button type="button" class="button success" onclick="plus({{$details->id}})"><span class="icon mif-plus"></span></button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                                {{--<td align="center">{{$details->stok_fisik - $details->stok_sistem}}</td>--}}
                                <td><center>
                                        <a href="{{url('inventory/cabang/opname/hapusdetail/'.$details->id.'/'.$header->id)}}" class="button danger" align="center">Hapus</a>
                                        <a href="{!! url('/detail/'.$details->id_barang)!!}" class="button info" align="center">Detail</a>
                                    </center></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--<button type="submit" class="button bg-cobalt bg-active-darkBlue fg-white place-right"><span class="mif-tag mif-ani-float"></span> Adjust</button>--}}
            </form>
        </div>
        <div class="cell"></div>
    </div>
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
                    <form action="{{url('inventory/cabang/opname/storebarang')}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="kode2" value="{{$header->id}}">
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
                                    <th class="ribbed-cyan fg-white padding10 text-shadow" align="center"><input type="checkbox" name="checkAll" id="TableAll" align="center"></th>
                                </tr>
                                </thead>
                                <?php $i = 1; ?>
                                <tbody>
                                @foreach ($produk as $value)
                                    <?php $mapro = \App\Model\Master\Mappingbarang::where('id_produk', $value->id)->where('id_cabang', \Illuminate\Support\Facades\Auth::user()->cabang)->first();?>
                                    <tr>
                                        <td>{!! $i++ !!}</td>
                                        <td>{!! $value->barcode !!}</td>
                                        <td>{!! $value->nama !!}</td>
                                        <td>{!! $value->created_at !!}</td>
                                        <td>{!! $value->classification !!}</td>
                                        <td>{!! $mapro->stok !!}</td>
                                        <td>{!! number_format($value->harga_beli, '2') !!}</td>
                                        <td>{!! number_format($value->harga_jual, '2') !!}</td>
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
                    <form action="{{url('inventory/cabang/opname/storebarang')}}" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="kode2" value="{{$header->id}}">
                        <div class="container" id="" style="overflow-y: scroll; height:400px;">
                            <table class="dataTable bordered" data-searching="true" style="overflow:auto; width:100%; background-color:#fff;">
                                <thead>
                                <tr>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">No</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Barcode</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Nama Produk</th>
                                    {{--<th class="ribbed-cyan fg-white padding10 text-shadow">Tanggal</th>--}}
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Merk</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Stok</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Harga Beli</th>
                                    {{--<th class="ribbed-cyan fg-white padding10 text-shadow">Harga Satuan</th>--}}
                                    {{--<th class="ribbed-cyan fg-white padding10 text-shadow">QTY</th>--}}
                                    <th class="ribbed-cyan fg-white padding10 text-shadow" align="center"><input type="checkbox" name="checkAll" id="TableAll" align="center"></th>
                                </tr>
                                </thead>
                                <?php $i = 1; ?>
                                <tbody>
                                @foreach ($produk as $value)
                                    <?php $mapro = \App\Model\Master\Mappingbarang::where('id_produk', $value->id)->where('id_cabang', \Illuminate\Support\Facades\Auth::user()->cabang)->first();?>
                                    <tr>
                                        <td>{!! $i++ !!}</td>
                                        <td>{!! $value->barcode !!}</td>
                                        <td>{!! $value->nama !!}</td>
                                        {{--                                        <td>{!! $value->created_at !!}</td>--}}
                                        <td>{!! $value->classification !!}</td>
                                        @if($mapro != null)
                                            <td>{!! $mapro->stok !!}</td>
                                        @else
                                            <td>0</td>
                                        @endif
                                        <td>{!! number_format($value->harga_beli, '2') !!}</td>
                                        {{--<td><input type="text" name="harga{{$value->id}}"></td>--}}
                                        {{--<td><input type="text" style="width:40px;"  name="qty{{$value->id}}"></td>--}}
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
    var header = <?php echo json_encode($header->id) ?>;

    function showDialog(id){
        var dialog = $(id).data('dialog');
        dialog.open();
    }

    $("#search").keyup(function (e) {
        if (e.keyCode == 13) {
            $("#divpertama").load("{{ URL::to('inventory/cabang/opname/get')}}/"+$("#search").val() +"/"+ $("#pilihan").val() + "/" + header);
            document.getElementById('divpertama1').style.display = 'none';
        }
    });

    $("#searchbtn").click(function (e) {
        $("#divpertama").load("{{ URL::to('inventory/cabang/opname/get')}}/"+$("#search").val() +"/"+ $("#pilihan").val() + "/" + header);
        document.getElementById('divpertama1').style.display = 'none';
    });

    $("#pilihan").change(function (e) {
        if ($("#pilihan").val() == 3) {
            $("#divpertama").load("{{ URL::to('inventory/cabang/opname/get')}}/"+$("#search").val() +"/"+ $("#pilihan").val() + "/" + header);
            document.getElementById('divpertama1').style.display = 'none';
        }
    });
</script>

<script>

    $('#TableAll').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });

    function plus(id) {
        var tambah = parseInt($('#stoknya' + id).val()) + 1;
        $('#stoknya' + id).val(tambah);
    }

    function minus(id) {
        var kurang = parseInt($('#stoknya' + id).val()) - 1;
        if(kurang <= 0) {
            $('#stoknya' + id).val(0);
        } else {
            $('#stoknya' + id).val(kurang);
        }
    }
    
    function barcodesearch() {
        $.ajax({
            url: "{!! url('inventory/cabang/opname/cek') !!}/" + $('#idh').val() + "/" + $('#bsearch').val(),
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                if (data[0]["detid"] != "NOL") {
                    var tambah = parseInt($('#stoknya' + data[0]["detid"]).val()) + 1;
                    $('#stoknya' + data[0]["detid"]).val(tambah);
                }
            }

        });
    }
</script>

</html>
