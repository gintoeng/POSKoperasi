<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" type="image/x-icon" href="{{ asset ('assets/templateinventory/inventory.ico') }}">
        <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/metro-responsive.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/ga.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/prettify/run_prettify.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/jquery.dataTables.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">


        <script language="javascript">
    function hanyaAngka(e, decimal) {
    var key;
    var keychar;
     if (window.event) {
         key = window.event.keyCode;
     } else
     if (e) {
         key = e.which;
     } else return true;

    keychar = String.fromCharCode(key);
    if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
        return true;
    } else
    if ((("0123456789").indexOf(keychar) > -1)) {
        return true;
    } else
    if (decimal && (keychar == ".")) {
        return true;
    } else return false;
    }
</script>

<script>
       function showDialog(id){
           var dialog = $("#"+id).data('dialog');
           if (!dialog.element.data('opened')) {
               dialog.open();
           } else {
               dialog.close();
           }
       }
   </script>

<title>Menu Retur</title>

  <div class="app-bar navy" data-role="appbar">
        <a class="app-bar-element" href="{!! url('/inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
        <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
        <span class="app-bar-divider"></span>
        <ul class="app-bar-menu">
         <li>
          <a href="" class="dropdown-toggle"> <span class="mif-enter"></span> Pindah Ke</a>
            <ul class="d-menu" data-role="dropdown">
                <li><a href="{{url('/stockopname')}}">  <span class="mif-qrcode"></span> &nbsp;Stock Opname</a></li>
                <li><a href="{{url('/invoice')}}'">  <span class="mif-file-text"></span> &nbsp;Invoice</a></li>
                </ul>
        </li>
    </div>

</head>

<body class="metro colspan10" style="width:100%;">
      <div class="container colspan10" style="width:80%; margin-top:5%;">
      <h1><a href="{!! url('/inventory') !!}" class="nav-button transform"><span></span></a>&nbsp;Menu Retur</h1>
      <hr>

        <div data-role="dialog" id="dialog" class="padding20" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true" data-windows-style="true" data-background="bg-blue" data-color="fg-white">
              <h1><span class="mif-warning"></span>&nbsp;Apa Anda Yakin ?</h1>
              <hr style="background-color:#fff;">
              <br>
          <div>
                      <p>
                        Apa anda yakin ingin meretur barang ini?
                      </p>
              <div class="place-right">
                <a href="#"><button class="button danger" name="button"> Tidak </button></a>
                <a href="#"><button class="button info" name="button"> Ya </button></a>
              </div>

          </div>

      </div>

    <div class="cell" style="width:100%;">

      <div>
      <div class="panel" style="width:100%; position:center;">
           <div class="heading">
           <span class="icon mif-info" ></span>
           <span class="title">Informasi Barang</span>
          </div>


          <div class="input-control required" data-role="select" style="width:45%;" placeholder="Pilih Jenis Barang">
              <select>
              <option>Makanan</option>
                        ...
              <option>Elektronik</option>
              </select>
          </div>
          <div class="input-control text" data-role="input" style="width:54.5%;">
               <input type="text">
               <button class="button info"><span class="mif-search"></span></button>
         </div>
         <hr>         

      <table class="dataTable  bordered " data-role="datatable" data-searching="true" style="overflow:auto; width:100%; background-color:#fff;">

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
                <th class="ribbed-cyan fg-white padding10 text-shadow">Unit</th>
                <th class="ribbed-cyan fg-white padding10 text-shadow" align="center"><input type="checkbox" name="checkAll" id="TableAll" align="center"></th>
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
                        <td><input type="checkbox" placeholder="" name="cbpilih['.$value->id.']"/></td>
                    </tr>
                @endforeach

                        </tbody>
      </table>
      <div style="margin-top:5%; margin-left:85%;">
          <a style="margin-top:5%;" href="#" ><button class="button success" onclick="showDialog('dialog')"><span class="mif-paper-plane"></span>&nbsp;Retur Barang</button></a>
      </div>


    </div>
    <script>
    $('#TableAll').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
  </script>

  <script>
         function showDialog(id){
             var dialog = $("#"+id).data('dialog');
             if (!dialog.element.data('opened')) {
                 dialog.open();
             } else {
                 dialog.close();
             }
         }
     </script>

</body>
</html>
