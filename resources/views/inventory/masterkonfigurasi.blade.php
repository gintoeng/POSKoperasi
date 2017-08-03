<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="{{ asset ('assets/templateinventory/inventory.ico') }}">
        <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>
        <script src="{{ asset('assets/templateinventory/js/select2.min.js') }}"></script>

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

<link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenLite.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenMax.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/gerak.js') }}"></script>
<title>Master Konfigurasi</title>

  <div class="app-bar navy" data-role="appbar">
        <a class="app-bar-element" href="{!! url('/inventory') !!}"> <img style="height: 28px; display: inline-block; margin-right: 10px;" src="{{asset('assets/templateinventory/images/inventory.png') }}"> Menu Utama</a>
        <a href="{!! url('/login') !!}" class="app-bar-element place-right"> <span class="mif-switch"></span> Log Out</a>
        <span class="app-bar-divider"></span>
        <ul class="app-bar-menu">
         <li>
          <a href="" class="dropdown-toggle"> <span class="mif-enter"></span> Pindah Ke</a>
            <ul class="d-menu" data-role="dropdown">
                <li><a href="{{url('/lapbarangmasuk')}}">  <span class="mif-file-excel"></span> &nbsp;Laporan Barang Masuk</a></li>
                <li><a href="{{url('/lapbarangkeluar')}}">  <span class="mif-file-excel"></span> &nbsp;Laporan Barang Keluar</a></li>
                <li><a href="{{url('/masterproduk')}}">  <span class="mif-database"></span> &nbsp;Master Produk</a></li>
                <li><a href="{{url('/stokminimum')}}">  <span class="mif-warning"></span> &nbsp;Stok Minimum</a></li></ul>
        </li>
    </div>

</head>

<body>
    <div class="container page-content" >
      <h1><a href="{!! url('/inventory') !!}" class="nav-button transform"><span></span></a>&nbsp;Master Konfigurasi</h1>      
      <hr style="margin-bottom: 2%;">
    <div class="cell">

      <div class="panel">
           <div class="heading">
           <span class="icon mif-tools" ></span>
           <span class="title">Konfigurasi</span>
      </div>

         <!--  <form action="{!! url('/masterkonfigurasi/save') !!}" method="POST">

          <div style="display: block;" class="content padding10" align="center">
            <h1 style="float:left;">Diskon</h1>

              <div class="cell">

               <div class="input-control text"  onkeypress="return hanyaAngka(event, false)" style="width:100%;margin-top::;0px;margin-right:150px;">
                  <input align="center" required name="persen" type="text" onkeypress="return hanyaAngka(event, false)" placeholder="Persen Keuntungan %">
                  <button class="button success" type="submit"><span class="mif-paper-plane mif-ani-float"></span>&nbsp;Simpan</button>
              </div>
          </form> -->

          <form action="{!! url('/masterkonfigurasi/save') !!}" method="POST">
        <div style="display: block;" class="content padding9" align="center">
            <h1 style="float:left;">Konfigurasi Stok Minimum</h1>

              <div class="cell">

               <div class="input-control text" onkeypress="return hanyaAngka(event, false)" style="width:100%;margin-top::;0px;margin-right:150px;">
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                  <input align="center" required name="stokmin" type="text" value="{!! $produk->stok !!}" onkeypress="return hanyaAngka(event, false)" placeholder="Input untuk mengganti Stok Minimum" >
                  <button class="button success" type="submit"><span class="mif-paper-plane mif-ani-float"></span>&nbsp;Simpan</button>
              </div>


              </div>
            </div>
          </form>
    </div>


    </div>

      <div class="align-center padding20 text-small"> </div>



  </body>
</html>
