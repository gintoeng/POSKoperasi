<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/templateinventory/inventory.ico') }}">
        <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/dist/sweetalert2.css')}}">
        <script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('assets/plugins/sweetalert/dist/sweetalert2.min.js')}}"></script>


        <style>
            body{
            margin:0;
            background-color:#fff;
            overflow:auto;
            }
        </style>
        <title>Inventory</title>
    </head>

    <body id="">
        <div class="app-bar navy" data-role="appbar">
            <a class="app-bar-element" href="{!! url('/inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
            <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
            <span class="app-bar-divider"></span>
        </div>

        <h1 style="margin-left:4%; margin-top:3%;"><a href="{!! url('inventory/supplier/pembelian') !!}" class="nav-button transform"><span></span></a>&nbsp;Tambah Data Pembelian</h1>
        <hr style="width:95%;"><br>
        <div class="grid">
            <form action="{{url('inventory/supplier/pembelian/storeheader')}}" method="POST">
                <div class="row cells12">
                    <div class="cell"></div>
                    <div class="cell colspan10">
                        <div class="row cells2">
                                <label>Kode Pembelian</label>
                                <div class="input-control text full-size">
                                    <input type="text" name="kode" value="{{$kode}}">
                                </div>
                        </div>
                        <div class="row cells2">
                            <div class="cell">
                                <label>Tanggal</label>
                                <div class="input-control text full-size" id="datepicker">
                                    <input type="text" name="tanggal" value="{{$tanggal}}">
                                    <button class="button"><span class="mif-calendar"></span></button>
                                </div>
                            </div>
                            {{--<div class="cell">--}}
                                {{--<label>Status</label>--}}
                                {{--<div class="input-control full-size">--}}
                                    {{--<select name="status">--}}
                                        {{--<option value="Tunai">Tunai</option>--}}
                                        {{--<option value="Tunda">Tunda</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <div class="row cells2">
                            {{--<div class="cell">--}}
                                {{--<label>Cabang</label>--}}
                                {{--<div class="input-control text full-size">--}}
                                    {{--<select name="cabang">--}}
                                        {{--@foreach($cabangs as $cabang)--}}
                                        {{--<option value="{{$cabang->id}}">{{$cabang->nama}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="cell">
                                <label>Vendor</label>
                                <div class="input-control text full-size">
                                    <select name="vendor">
                                        @foreach($vendors as $vendor)
                                        <option value="{{$vendor->id}}">{{$vendor->nama_vendor}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="cell">
                                <label>Tanggal Pengiriman</label>
                                <div class="input-control text full-size" id="datepicker2">
                                    <input type="text" name="tanggal_kirim" value="{{$tanggal}}">
                                    <button class="button"><span class="mif-calendar"></span></button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="button success place-right"><span class="mif-paper-plane mif-ani-float"></span>Simpan</button>
                    </div>
                    <div class="cell"></div>
                </div>
                <div class="row cells12"></div>
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
                                                <td><input type="number" onkeyup="validAngka(this)" min="1" value="1" style="width:60px;"  name="qty{{$value->id}}"></td>
                                                <td><input type="checkbox" placeholder="" name="cbpilih[{{$value->id}}]"/></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                        </div>
                    </div>
                    <div class="cell"></div>
                </div>
            </form>
        </div>
    </body>
    <script>
        $(function(){
            $("#datepicker").datepicker();
            $("#datepicker2").datepicker();
        });
    </script>
    <script>

        function showDialog(id){
            var dialog = $(id).data('dialog');
            dialog.open();
        }

        $("#search").keyup(function (e) {
            if (e.keyCode == 13) {
                $("#divpertama").load("{{ URL::to('inventory/supplier/pembelian/get2')}}/"+$("#search").val() +"/"+ $("#pilihan").val());
                document.getElementById('divpertama1').style.display = 'none';
            }
        });

        $("#searchbtn").click(function (e) {
            {{--alert("{{ URL::to('inventory/supplier/pembelian/get2')}}/"+$("#search").val() +"/"+ $("#pilihan").val());--}}
            $("#divpertama").load("{{ URL::to('inventory/supplier/pembelian/get2')}}/"+$("#search").val() +"/"+ $("#pilihan").val());
            document.getElementById('divpertama1').style.display = 'none';
        });

        $("#pilihan").change(function (e) {
            if ($("#pilihan").val() == 3) {
                $("#divpertama").load("{{ URL::to('inventory/supplier/pembelian/get2')}}/"+$("#search").val() +"/"+ $("#pilihan").val());
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
