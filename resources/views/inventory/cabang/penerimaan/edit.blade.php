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
            <a class="app-bar-element" href="{!! url('inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
            <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
            <span class="app-bar-divider"></span>
        </div>

        <h1 style="margin-left:4%; margin-top:3%;"><a href="{!! url('inventory/cabang/penerimaan') !!}" class="nav-button transform"><span></span></a>&nbsp;Ubah Data Penerimaan</h1>
        <hr style="width:95%;"><br>
        <div class="grid">
            <div class="row cells12">
                <div class="cell"></div>

                <div class="cell colspan10">
                    <form action="{{url('inventory/cabang/penerimaan/updateheader/'.$header->id)}}" method="POST" enctype="multipart/form-data">
                    <div class="row cells2">
                        <div class="cell">
                            <label>Kode Penerimaan</label>
                            <div class="input-control text full-size">
                                <input type="text" name="kode" readonly value="{{$header->nopembelian}}">
                            </div>
                        </div>
                        <div class="cell">
                            <label>Total Harga Penerimaan</label>
                            <div class="input-control text full-size">
                                <input type="text" name="kode" readonly value="Rp. {{number_format($header->detail->SUM('sub_total'), '2')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row cells2">
                        <div class="cell">
                            <label>Tanggal</label>
                            <div class="input-control text full-size">
                                <input type="text" name="tanggal" value="{{$header->tanggal}}">
                            </div>
                        </div>
                        <div class="cell">
                            <label>Status</label>
                            <div class="input-control full-size">
                                <select name="status">
                                    <option value="Tunai" {{$header->status == "Tunai" ? 'selected' : ''}}>Tunai</option>
                                    <option value="Tunda" {{$header->status == "Tunda" ? 'selected' : ''}}>Tunda</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        <div class="row cell">
                            <div class="cell">
                                <label>Kode Pengiriman</label>
                                <div class="input-control text full-size">
                                    <select name="pembelian" required>
                                        @foreach($pembelian as $item)
                                            <option value="{{$item->id}}" {{$header->nofaktur == $item->nopembelian ? 'selected' : ''}}>{{$item->nopembelian}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row cell">
                            <div class="cell">
                                <div class="input-control file" data-role="input" style="width:100%;">
                                    <input type="hidden" name="inv">
                                    <input type="file" name="foto" placeholder="File INVOICE" value="{{$header->invoice}}">
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
</html>
