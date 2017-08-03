<!DOCTYPE html>
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
        <title>Pindah Cabang</title>
    </head>

    <body id="">
        <div class="app-bar navy" data-role="appbar">
            <a class="app-bar-element" href="{!! url('/inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
            <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
            <span class="app-bar-divider"></span>
            <ul class="app-bar-menu">
            </ul>
        </div>

        <h1 style="margin-left:4%; margin-top:3%;"><a href="{!! url('/inventory') !!}" class="nav-button transform"><span></span></a>&nbsp;Pindah Cabang</h1>
        <hr style="width:95%;"><br>
        <div class="grid">
            <form action="{{url('inventory/cabang/pindah')}}" method="POST">
        <div class="row cells12">
            <div class="cell"></div>
            <div class="cell colspan10">
                <table class="dataTable striped hovered cell-hovered border bordered " data-searching="true" style="overflow:auto; width:100%; background-color:#fff; width:100%;">
                    <thead>
                        <tr>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">No</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Barcode</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Nama Produk</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Tanggal</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Klasifikasi</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Stok</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Harga Beli</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Harga Jual</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Unit</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow">Cabang</th>
                            <th class="text-center ribbed-cyan fg-white padding10 text-shadow"><input type="checkbox" name="checkAll" id="TableManual"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach($produk as $value)
                        <tr>
                            <td>{!! $i++ !!}</td>
                            <td>{!! $value->barcode !!}</td>
                            <td>{!! $value->nama !!}</td>
                            <td>{!! $value->created_at !!}</td>
                            <td>{!! $value->classification !!}</td>
                            <td>{!! $value->stok !!}</td>
                            <td>{!! number_format($value->harga_beli, '2') !!}</td>
                            <td>{!! number_format($value->harga_jual, '2') !!}</td>
                            <td>{!! $value->unit !!}</td>
                            <td>{!! $value->cabang->nama !!}</td>
                            <td><input type="checkbox" placeholder="" name="cbpilih[{{$value->id}}]"/></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a class="place-right button success" onclick="ceknomor('#dialog')"><span class="mif-paper-plane mif-ani-float"></span>Pindah Cabang</a>
            </div>
            <div data-role="dialog" id="dialog" class="padding20" data-close-button="true" data-windows-style="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true">
                <div class="container">
                    <h1 style="color:blue">Pindah Cabang</h1>
                    <p>
                        Silahkan pilih cabang
                        <div class="input-control select2 text iconic full-size" style="height:20px;">
                            <select name="cabang" id="cabang">
                                 @foreach ( $cabang as $value )
                                     <option value="{!! $value->id !!}">{!! $value->nama !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </p>
                    <button type="submit" class="button success place-right"><span class="mif-paper-plane mif-ani-float"></span>Pindah Cabang</button>
                </div>
            </div>

            <div class="cell"></div>
            {{ csrf_field() }}
        </div>
    </form>
        </div>
    </body>

    <script>

        $('#TableManual').click(function (e) {
            $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
        });
        function ceknomor(id){
        var dialog = $(id).data('dialog');
        dialog.open();
        };

    </script>
</html>
