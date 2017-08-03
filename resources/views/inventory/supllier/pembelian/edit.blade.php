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

<h1 style="margin-left:4%; margin-top:3%;"><a href="{!! url('inventory/supplier/pembelian') !!}" class="nav-button transform"><span></span></a>&nbsp;Edit Pembelian</h1>
<hr style="width:95%;"><br>
<div class="grid">
    <div class="row cells12">
        <div class="cell"></div>
        <div class="cell colspan10">
            <div class="row cells2">
                <div class="cell">
                    <label>Kode Pembelian</label>
                    <div class="input-control text full-size">
                        <input type="text" name="kode" readonly value="{{$header->nopembelian}}">
                    </div>
                </div>
                <div class="cell">
                    <label>Total Harga Pembelian</label>
                    <div class="input-control text full-size">
                        <input type="text" name="kode" readonly value="Rp. {{number_format($header->detail->SUM('sub_total'), '2')}}">
                    </div>
                </div>
            </div>
            <div class="row cells2">
                <div class="cell">
                    <label>Tanggal</label>
                    <div class="input-control text full-size">
                        <input type="text" name="tanggal" readonly value="{{$header->tanggal}}">
                    </div>
                </div>
                {{--<div class="cell">--}}
                    {{--<label>Status</label>--}}
                    {{--<div class="input-control text full-size">--}}
                        {{--<input type="text" name="status" readonly value="{{$header->status}}">--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="row cells2">
                <div class="cell">
                    <label>Vendor</label>
                    <div class="input-control text full-size">
                        <input type="text" name="vendor" readonly value="{{$header->vendor->nama_vendor}}">
                    </div>
                </div>
                <div class="cell">
                    <label>Tanggal Pengiriman</label>
                    <div class="input-control text full-size">
                        <input type="text" name="tanggal_kirim" readonly value="{{$header->tanggal_kirim}}">
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
            @if($header->start == 0)
                <div class="grid">
                    <div class="row cells12">
                        <div class="cell colspan6">
                            {{--<a href="{{url('/tambahproduk/'.$header->id)}}" class="place-left button bg-cyan bg-active-cyan fg-white"> <span class="mif-plus mif-ani-float"></span> &nbsp;Tambah Barang</a>--}}
                            <a class="place-left button bg-orange bg-active-orange fg-white" onclick="showDialog('#dialog')"> <span class="mif-dollar2 mif-ani-float"></span> &nbsp;Cari Barang</a>
                        </div>
                        <div class="cell colspan6">
                            {{--<a class="place-right button success" href="{!! url('/excelbeli') !!}"><span class="mif-paper-plane mif-ani-float"></span>Cetak</a>--}}
                        </div>
                    </div>
                </div>
            @endif
            <table class="dataTable striped hovered cell-hovered border bordered " data-searching="true" style="overflow:auto; width:100%; background-color:#fff; width:100%;">
                <thead>
                <tr>
                    <th class="text-center ribbed-cyan fg-white padding10 text-shadow">No</th>
                    <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Barcode</th>
                    <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Nama Barang</th>
                    <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Harga</th>
                    <th class="text-center ribbed-cyan fg-white padding10 text-shadow">QTY</th>
                    <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Sub Total</th>
                    <th class="text-center ribbed-cyan fg-white padding10 text-shadow"><center>Opsi</center></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($detail as $details)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$details->barang->barcode}}</td>
                        <td>{{$details->barang->nama}}</td>
                        <td align="right">{{number_format($details->sub_total / $details->qty, '2')}}</td>
                        <td>{{$details->qty}}</td>
                        <td align="right">{{number_format($details->sub_total, '2')}}</td>
                        <td><center>
                                <a href="{{url('inventory/supplier/pembelian/hapusdetail/'.$details->id.'/'.$header->id)}}"class="button danger" align="center">Hapus</a>
                                <a href="{!! url('/detail/'.$details->id_barang)!!}"class="button info" align="center">Detail</a>
                            </center></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
                    <form action="{{url('inventory/supplier/pembelian/storebarang')}}" method="POST">
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
{{--                                        <td>{!! $value->stok !!}</td>--}}
                                        <td>{!! number_format($value->harga_beli, '2') !!}</td>
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
                                <button id="searchbtn" type="button" class="button info"><span class="mif-search"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="divpertama"> </div>
                <div id="divpertama1">
                    <form action="{{url('inventory/supplier/pembelian/storebarang')}}" method="POST">
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
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">Harga Satuan</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow">QTY</th>
                                    <th class="ribbed-cyan fg-white padding10 text-shadow" align="center"><input type="checkbox" name="checkAll" id="TableAll" align="center"></th>
                                </tr>
                                </thead>
                                <?php $i = 1; ?>
                                <tbody>
                                @foreach ($produk as $value)
                                    <?php $mapping = \App\Model\Master\Mappingbarang::where('id_cabang', \Illuminate\Support\Facades\Auth::user()->cabang)->where('id_produk', $value->id)->first();?>
                                    <tr>
                                        <td>{!! $i++ !!}</td>
                                        <td>{!! $value->barcode !!}</td>
                                        <td>{!! $value->nama !!}</td>
                                        {{--                                        <td>{!! $value->created_at !!}</td>--}}
                                        <td>{!! $value->classification !!}</td>
                                        @if($mapping == null)
                                            <td>0</td>
                                        @else
                                            <td>{!! $mapping->stok !!}</td>
                                        @endif
                                        <td>{!! number_format($value->harga_beli, '2') !!}</td>
                                        <td><input type="text" onkeyup="validAngka(this)" name="harga{{$value->id}}"></td>
                                        <td><input type="number" style="width:60px;" onkeyup="validAngka(this)" min="1" value="1" name="qty{{$value->id}}"></td>
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
            $("#divpertama").load("{{ URL::to('inventory/supplier/pembelian/get')}}/"+$("#search").val() +"/"+ $("#pilihan").val() + "/" + header);
            document.getElementById('divpertama1').style.display = 'none';
        }
    });

    $("#searchbtn").click(function (e) {
        $("#divpertama").load("{{ URL::to('inventory/supplier/pembelian/get')}}/"+$("#search").val() +"/"+ $("#pilihan").val() + "/" + header);
        document.getElementById('divpertama1').style.display = 'none';
    });

    $("#pilihan").change(function (e) {
        if ($("#pilihan").val() == 3) {
            $("#divpertama").load("{{ URL::to('inventory/supplier/pembelian/get')}}/"+$("#search").val() +"/"+ $("#pilihan").val() + "/" + header);
            document.getElementById('divpertama1').style.display = 'none';
        }
    });
</script>

<script>
    function validAngka(a)
    {
        if(!/^[0-9.]+$/.test(a.value))
        {
            a.value = a.value.substring(0,a.value.length-1000);
        }
    }

    $('#TableAll').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
</script>

</html>
