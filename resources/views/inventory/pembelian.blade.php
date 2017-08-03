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
        <link rel="stylesheet" href="{{asset('assets/plugins/datepicker/datepicker.css')}}"/>

        <script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/ga.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/prettify/run_prettify.js') }}"></script>        
        <script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">

<title>Pembelian</title>

  <div class="app-bar navy" data-role="appbar">
        <a class="app-bar-element" href="{!! url('/inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
        <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
        <span class="app-bar-divider"></span>
        <ul class="app-bar-menu">
         <li>
          <a href="" class="dropdown-toggle"> <span class="mif-enter"></span> Pindah Ke</a>
            <ul class="d-menu" data-role="dropdown">
                <li><a href="{{url('/retur')}}">  <span class="mif-keyboard-return"></span> &nbsp;Retur Barang</a></li>
                <li><a href="{{url('/invoice')}}">  <span class="mif-file-text"></span> &nbsp;Invoice</a></li></ul>
        </li>
    </div>

</head>

<body class="metro" style="width:100%;">
      <div class="container colspan10" style="width:80%; margin-top:5%;">
      <h1><a href="{!! url('/inventory') !!}" class="nav-button transform"><span></span></a>&nbsp;Stock Opname</h1>
      <hr>

      <div data-role="dialog" id="dialog" class="padding20" data-close-button="true" data-overlay="true" data-overlay-color="op-dark" data-overlay-click-close="true" data-windows-style="true" data-background="bg-blue" data-color="fg-white">
            <h1><span class="mif-qrcode"></span>&nbsp;Pembelian Barang</h1>
            <hr style="background-color:#fff;">
            <br>            

        </div>

    <div class="cell" style="width:100%;">

      <div>
      <div class="panel" style="width:100%; position:center;">
           <div class="heading">
           <span class="icon mif-info" ></span>
           <span class="title">Informasi Barang</span>
          </div>
          
          <div class="input-control text" data-role="input" style="width:54.5%;">
               <input type="hidden" id="idnyaaa">
               <input type="text" id="barangnya">
               <button class="button info" id="test"><span class="mif-search"></span></button>
         </div>          

      <table class="table striped hovered cell-hovered border bordered">

        <thead>
            <tr>
            <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">No</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Tanggal</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Nama Produk</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Klasifikasi</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Keluar</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Sisa Stok</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow">Selisih</th>
                <th align="center" class="ribbed-cyan fg-white padding10 text-shadow" colspan="3" align="center">Opsi</th>
            </tr>
        </thead>

        <?php
            $i = 1;
        ?>
        <tbody>
                         @foreach ($produk as $value)
                    <tr>
                        <td>{!! $i++ !!}</td>
                        <td>{!! $value->created_at !!}</td>
                        <td>{!! $value->nama !!}</td>
                        <td>{!! $value->classification !!}</td>
                        <td>{!! $value->harga_beli !!}</td>
                        <td>{!! $value->stok !!}</td>
                        <td>{!! $value->adjust !!}</td>
                        <td align="center"><a class="button warning mif-qrcode" href="{!!url('/opname/cek/'.$value->id)!!}">&nbsp;Opname</a></td>
                        <td align="center"><a class="button success mif-file-excel" href="">&nbsp;Opname</a></td>
                        <td align="center"><a class="button danger mif-file-pdf" href="">&nbsp;Opname</a></td>
                    </tr>

                @endforeach

                        </tbody>


      </table>

    </div>    

      <div class="align-center padding20 text-small"> </div>

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


      $('#test').on('click', function () {

//alert("{!! url('/stockopname/cari') !!}/" + $('#barangnya').val());

     location.href = "{!! url('/stockopname/cari') !!}/" + $('#barangnya').val();

    });

</script>
</body>
</html>
