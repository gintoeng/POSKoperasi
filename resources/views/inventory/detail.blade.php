<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset ('assets/templateinventory/inventory.ico') }}">
  <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/templateinventory/js/jquery.dataTables.min.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenLite.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenMax.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/gerak.js') }}"></script>

<title>Stock Opname</title>
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
     <li>
    <a href="" class="dropdown-toggle"> <span class="mif-enter"></span> Pindah Ke</a>
        <ul class="d-menu" data-role="dropdown">
            <li><a href="{{url('/lapbarangmasuk') }}">  <span class="mif-file-excel"></span> &nbsp;Laporan Barang Masuk</a></li>
            <li><a href="{{url('/stokminimum')}}"> <span class="mif-warning"></span> &nbsp;Stok Minimum</a></li>
            <li><a href="{{url('/masterproduk')}}">  <span class="mif-database"></span> &nbsp;Master Produk</a></li>
            <li><a href="{{url('/masterkonfigurasi')}}">  <span class="mif-tools"></span> &nbsp;Master Konfigurasi</a></li>
            </ul>

    </li>
</div>

</head>

<body>
  <h1 style="margin-left:4%; margin-top:2.5%;"><a href="{!! url()->previous() !!}" class="nav-button transform"><span></span></a>&nbsp;Detail Produk</h1>
  <hr style="width:90%;">
  <br>
  <div style="padding-left:5%; padding-right:5%;">
    <div class="grid">
      <div class="row">
        <div class="span12">
          <div class="panel warning">
            <div class="heading">
              <span class="icon mif-shopping-basket bg-orange"></span>
              <span class="title">Detail Produk</span>
            </div>
            <div class="content">
                <div class="grid">
                    <div class="row cells12">
                        <div class="cell colspan3">
                            <br>
                            <center>
                            @if($produk->foto == "avatar.jpg" || $produk->foto == "")
                                <img src="{{asset('assets/img/avatar.jpg')}}" style="position:center; width: 200px; height: 200px"/>
                            @else
                                <img src="{{ asset('foto/barang/'.$produk->foto) }}" style="position:center; width: 200px; height: 200px"/>
                            @endif
                            </center>
                        </div>
                        <div class="cell colspan5">
                            <table class="table striped">
                                <tr>
                                    <td style="width:30%;padding-left:3%;">Barcode</td>
                                    <td style="width:1%">:</td>
                                    <td>{!! $produk->barcode !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;padding-left:3%;"> Nama Barang </td>
                                    <td style="width:1%">:</td>
                                    <td>{!! $produk->nama !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;padding-left:3%;"> Merk </td>
                                    <td style="width:1%">:</td>
                                    <td>{!! $produk->classification !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;padding-left:3%;"> Unit </td>
                                    <td style="width:1%">:</td>
                                    <td>{!! $produk->unitid->nama !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;padding-left:3%;"> Kategori </td>
                                    <td style="width:1%">:</td>
                                    <td>{!! $produk->kategoriid->nama !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;padding-left:3%;"> Harga Beli </td>
                                    <td style="width:1%">:</td>
                                    <td>{!! $produk->matauang->kode !!}. {!! number_format($produk->harga_beli,2, '.', ',') !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;padding-left:3%;"> Harga Jual </td>
                                    <td style="width:1%">:</td>
                                    <td>{!! $produk->matauang->kode !!}. {!! number_format($produk->harga_jual,2, '.', ',') !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;padding-left:3%;"> Diskon </td>
                                    <td style="width:1%">:</td>
                                    <td>{!! $produk->disc_tipe == "nominal" ? $produk->matauang->kode.". ".number_format($produk->disc_nominal,2, '.', ',') : $produk->disc." %" !!}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;padding-left:3%;"> Tanggal Diskon </td>
                                    <td style="width:1%">:</td>
                                    <td>{!! $produk->tanggal_awal_diskon !!} - {!! $produk->tanggal_akhir_diskon !!}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="cell colspan4">
                            <br>
                            <div class="grid">
                                <div class="row cells12">
                                    <div class="cell colspan11">
                                        <div class="panel warning">
                                            <div class="heading">
                                                <span class="title">Stock</span>
                                            </div>
                                            <div style="height:250px;">
                                                <?php $mapro = \App\Model\Master\Mappingbarang::where('id_produk', $produk->id)->where('id_cabang', \Illuminate\Support\Facades\Auth::user()->cabang)->first(); ?>
                                                <input type="hidden" name="" value="{!! $mapro->stok !!}" id="total">
                                                <br><br/><br>
                                                <center><font style="font-size:100pt;color:#0288D1;" id="totals">{!! $mapro->stok !!}</font></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>

              <div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
      
    </div>
    </div>   

</body>
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

    function cek(bc) {
        if (bc == $('#bcp').val()) {
          var ang = $('#hitung').val();
          var jum = ang * 1 + 1;
          $('#hitung').val(jum);
          $('#hitungs').html('<font style="font-size:200px;color:#4CAF50;" id="hitungs">' + jum + '</font>');
        } else {
          alert("Nomor BARCODE SALAH !!!");
        }
    }

    function adj(adj) {
      var total = $('#total').val();
      var ang = $('#hitung').val();
      var jum = total - ang; 
      $('#selisih').val(jum);
      if(jum > 0) {
          var jum2 = "-"+jum;
      } else {
          var jum2 = -1 * jum;
      }
      $('#sels').val(jum2);
      $('#selisihs').html('<font style="font-size:200px;color:#F44336;" id="selisihs">-'+jum2+'</font>');
    }
    
</script>

<script>
function setFocusToTextBox(){
    document.getElementById("bcp2").focus();
}
$('#btnadj').on('click', function () {   
//alert("{!! url('/opname/save') !!}/"+$('#idbarang').val() + "/" + $('#sels').val());
          $.ajax({
              url: "{!! url('/opname/save') !!}/"+$('#idbarang').val() + "/" + $('#sels').val(),
              data: {},
              dataType: "json",
              type: "get",
              success:function(data)
              {
                swal(
                    'Success!',
                    'Berhasil di simpan!',
                    'success'
                )
                location.reload();
              }
          });
      });
</script>
<script src="{{ asset('assets/templateinventory/js/sweetalert.js') }}"></script>
<link href="{{ asset('assets/templateinventory/css/sweetalert.css') }}" rel="stylesheet">
</html>
