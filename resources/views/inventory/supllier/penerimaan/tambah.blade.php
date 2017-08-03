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

        <h1 style="margin-left:4%; margin-top:3%;"><a href="{!! url('inventory/supplier/penerimaan') !!}" class="nav-button transform"><span></span></a>&nbsp;Tambah Data Penerimaan</h1>
        <hr style="width:95%;"><br>
        <div class="grid">
            <div class="row cells12">
                <div class="cell"></div>

                <div class="cell colspan10">
                    <form action="{{url('inventory/supplier/penerimaan/storeheader')}}" method="POST" enctype="multipart/form-data">
                    <div class="row cells2">
                            <label>Kode Penerimaan</label>
                            <div class="input-control text full-size">
                                <input type="text" name="kode" value="{{$kode}}">
                            </div>
                    </div>
                    <div class="row cells2">
                        <div class="cell">
                            <label>Tanggal</label>
                            <div class="input-control text full-size">
                                <input type="text" name="tanggal" value="{{$tanggal}}">
                            </div>
                        </div>
                        <div class="cell">
                            <label>Status</label>
                            <div class="input-control full-size">
                                <select name="status">
                                    <option value="Tunai">Tunai</option>
                                    <option value="Tunda">Tunda</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        <div class="row cell">
                            <div class="cell">
                                <label>Kode Pembelian</label>
                                <div class="input-control text full-size">
                                    <select name="pembelian" required>
                                        @foreach($pembelian as $item)
                                            <option value="{{$item->id}}">{{$item->nopembelian}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row cell">
                            <div class="cell">
                                <div class="input-control file" data-role="input" style="width:100%;">
                                    <input type="file" name="foto" placeholder="File INVOICE">
                                    <button class="button warning"><span class="mif-folder fg-white"></span></button>
                                </div>
                            </div>
                        </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="button success place-right"><span class="mif-paper-plane mif-ani-float"></span>Simpan</button>
                    </form>
                </div>
                <div class="cell"></div>
            </div>
        </div>
    </body>

    <div data-role="dialog" id="dialog" class="padding20" data-close-button="true" data-windows-style="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
        <div class="container">
            <h1 style="color:red">Peringatan!</h1>
            <p>
                Format nomor untuk jurnal manual vendor belum disetting, silahkan setting terlebih dahulu!
                <a class="place-right" href="{{url('pengaturan/nomor')}}" ><button class="button warning"><span class="mif-paper-plane mif-ani-float"></span>Klik disini untuk setting!</button></a>
            </p>
        </div>
    </div>
</html>
