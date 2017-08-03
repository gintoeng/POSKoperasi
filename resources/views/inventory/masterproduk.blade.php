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

<script>
    $("#showDialogButton").on('click',function(){
        var dialog = $(id).data('dialog');
        dialog.open();
    });
</script>

<title>Inventory</title>
<style>
body{
    margin:0;
    background-color:#fff;
    overflow:auto;
}
</style>

<div class="app-bar navy" data-role="appbar">
        <a class="app-bar-element" href="{!! url('/inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
        <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
        <span class="app-bar-divider"></span>
        <ul class="app-bar-menu">
        {{--<li>--}}
        {{--<a class="dropdown-toggle"> <span class="mif-tools"></span> Konfigurasi</a>--}}
            {{--<ul class="d-menu" data-role="dropdown">--}}
                {{--<li><a>  <span class="mif-cart"></span> &nbsp;Stok</a></li></ul>--}}
        {{--</li>--}}
    </div>

    </head>
<body id="">
        <h1 style="margin-left:4%; margin-top:7%;"><a href="{!! url('/inventory') !!}" class="nav-button transform"><span></span></a>&nbsp;Master Produk</h1>
        <hr style="width:95%;">
    <br>

        <br><br>
        <div class="grid">test</div>
        <div class="grid">
        <div class="row cells12">
            <div>

            </div>
            <div class="cell"></div>
            <div class="cell colspan11">

         <div class="input-control text" data-role="input" style="width:100%; margin-left:2%;">
               <input type="hidden" id="idnyaaa">
               <input type="text" id="barangnya">
               <button class="button info" id="test"><span class="mif-search"></span></button>
         </div>

                <table class="dataTable striped hovered cell-hovered border bordered " data-role="datatable" data-searching="true" style="overflow:auto; width:100%; background-color:#fff; margin-left:2%; width:100%;">

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
                <th class="text-center ribbed-cyan fg-white padding10 text-shadow" colspan="3" align="center">Opsi</th>
            </tr>
        </thead>

        <?php
            $i = 1;
        ?>
        <tbody>
                         @foreach ($produk as $value)
                    <tr>
                        <td>{!! $i++ !!}</td>
                        <td>{!! $value->barcode !!}</td>
                        <td>{!! $value->nama !!}</td>
                        <td>{!! $value->created_at !!}</td>
                        <td>{!! $value->classification !!}</td>
                        <td>{!! $value->stok !!}</td>
                        <td>{!! $value->harga_beli !!}</td>
                        <td>{!! $value->harga_jual !!}</td>
                        <td>{!! $value->unit !!}</td>
                        <td><a href="{!! url('/ubahproduk/'.$value->id) !!}" class="button warning" align="center">Edit</a></td>
                        <td><a href="{!! url('/deleteproduk/'.$value->id)!!}"class="button danger" data-title="Hapus?" id="delete" align="center">Hapus</a></td>
                        <td><a href="{!! url('/detail/'.$value->id)!!}"class="button info" align="center">Detail</a></td>
                    </tr>
                @endforeach

                        </tbody>

            </table>
            </div>
<<<<<<< HEAD

=======
            <div data-role="dialog" id="dialogButton">
    <h1>Simple dialog</h1>
    <p>
        Dialog :: Metro UI CSS - The front-end framework
        for developing projects on the web in Windows Metro Style.
    </p>
</div>
            <div style="pull-left">{!! $produk->links() !!}</div>
>>>>>>> 51657e8ffc3bd7652b3c09f8189a3957017e06bf
             <div style="margin-left:84.3%; margin-top:15%">

            <a href="{!! url('/tambahproduk') !!}"><button class="button success"><span class="mif-paper-plane mif-ani-float"></span>Tambah Produk</button></a>
            <!-- <button class="button info loading-cube">Tambah Stok</button>          -->
            </div>


        </div>
    </div>
        <div>{!! $produk->links() !!}</div>


    <script>
        $('#test').on('click', function () {

//alert("{!! url('/stockopname/cari') !!}/" + $('#barangnya').val());

     location.href = "{!! url('/masterproduk/cari') !!}/" + $('#barangnya').val();

    });

        $('button.delete').click(function() {
            var apusIni = $(this);
            deleteBarang(apusIni);
        });

        function deleteBarang(apusIni) {
            swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete this photo?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "Yes, delete it!",
                confirmButtonColor: "#ec6c62"
            }, function() {
                $.ajax({
                    url: "/deleteproduk" + apusIni,
                    type: "DELETE"
                })
                        .done(function(data) {
                            swal("Deleted!", "Your file was successfully deleted!", "success");
                        })
                        .error(function(data) {
                            swal("Oops", "We couldn't connect to the server!", "error");
                        });
            });
        }
    </script>
    </body>
    </html>
