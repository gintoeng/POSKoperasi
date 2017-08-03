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
            <li><a href="{{url('/lapbarangmasuk')}}">  <span class="mif-file-excel"></span> &nbsp;Laporan Barang Masuk</a></li>
            <li><a href="{{url('/stokminimum')}}'"> <span class="mif-warning"></span> &nbsp;Stok Minimum</a></li>
            <li><a href="{{url('/masterproduk')}}">  <span class="mif-database"></span> &nbsp;Master Produk</a></li>
            <li><a href="{{url('/masterkonfigurasi')}}'">  <span class="mif-tools"></span> &nbsp;Master Konfigurasi</a></li></ul>

    </li>
</div>

</head>

<body>
  <h1 style="margin-left:4%; margin-top:2.5%;"><a href="{!! url('/stockopname') !!}" class="nav-button transform"><span></span></a>&nbsp;Stock Opname</h1>
  <hr style="width:90%;">
  <br>
  <div style="padding-left:5%; padding-right:5%;">
    <div class="grid">
      <div class="row">
        <div class="span12">
          <div class="panel warning">
            <div class="heading">
              <span class="icon mif-qrcode bg-orange"></span>
              <span class="title">Stock Opnaming</span>
            </div>
            <div class="content">
              <table class="table ">
                <tr>
                  <td rowspan="5" style="width:30%;"><center><img src="{{ url('foto/barang/'.$produk->foto) }}" style="position:center;"/></center></td>
                  <td style="width:15%;padding-left:3%;">Tanggal</td>
                  <td style="width:5%">:</td>
                  <td style="width:20%">{!! $produk->created_at !!}</td>
                  <td rowspan="5" style="width:30%;">
                    <div class="panel warning">
                      <div class="heading">
                        <span class="title">Stock</span>
                      </div>
                      <div style="height:250px;">
                        <input type="hidden" name="" value="{!! $produk->stok !!}" id="total">
                        <center><font style="font-size:1500%;color:#0288D1;" id="totals">{!! $produk->stok !!}</font></center>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="width:15%;padding-left:3%;"> Nama Barang </td>
                  <td style="width:5%">:</td>
                  <td style="width:20%">{!! $produk->nama !!}</td>
                </tr>
                <tr>
                  <td style="width:15%;padding-left:3%;"> Klasifikasi </td>
                  <td style="width:5%">:</td>
                  <td style="width:20%">{!! $produk->classification !!}</td>
                </tr>
                <tr>
                  <td style="width:15%;padding-left:3%;"> Barang Keluar </td>
                  <td style="width:5%">:</td>
                  <td  style="width:20%">{!! $produk->updated_at !!}</td>
                </tr>
              </table>
              <div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="grid">
    <div class="row cells2">
            <div class="cell">
              <div class="panel info">
                <div class="heading">
                  <span class="title">Stock Yang Dihitung</span>
                </div>
                <div style="height:250px;">
                  <input type="hidden" value="0" id="hitung">
                  <center><font style="font-size:200px;color:#4CAF50;" id="hitungs">0</font></center>
                </div>
              </div>
              </div>
              <div class="cell">
              <div class="panel danger">
                <div class="heading">
                  <span class="title">Selisih Barang</span>
                </div>
                <div style="height:250px;">
                  <input type="hidden" id="selisih" name="selisih" value="0">
                  <center><font style="font-size:200px;color:#F44336;" id="selisihs" name="selisihs">{!! $produk->adjust !!}</font></center>
                </div>
              </div>
              
      </div>
      
    </div>
    </div>
    <div class="input-control text" style="width:100%;">
                <span class="mif-qrcode prepend-icon"></span>
                <input id="bcp2" class="input text warning" type="numeric" onkeypress="return hanyaAngka(event, false)" onkeydown="cek($(this).val())">
                <button id="btnadj" class="button warning" style="width:10%;" onclick="adj()"
                >Adjust</button>
                <input type="hidden" id="bcp" value="{!! $produk->barcode !!}">
                <input type="hidden" id="idbarang" value="{{ $produk->id }}">
                <input type="hidden" value="{!! csrf_token() !!}" id="sels" name="adj">
            </dialert('TEST')>
</div>
<footer style="background-color: #fff">
    <div style="width:100%;">
        <div class="span12">
            <div class="grid">

                <div class="row cells2">
                    <div class="cell">
                        <div class="row cells4">                            
                            <div class="cell colspan3 padding20 no-padding-top no-padding-bottom">
                                <h1>Inventory Applications</h1>
                                <p class="text-secondary">
                                    Permata Bank Application
                                </p>
                                <div>
                                    <span class="tag info">Features:</span>
                                    <span class="tag success">MASTER PRODUK</span>
                                    <span class="tag success">PENGATURAN</span>
                                    <span class="tag success">STOK MINIMUM</span>
                                    <span class="tag success">LAPORAN</span>
                                    <span class="tag success">ADJUSTMENT</span>     
                                                                   
                                    <span class="tag success">STOCK OPNAME</span>                                    
                                </div>
                                <br />
                                <div class="bg-white bg-red fg-white padding10 align-center no-display" id="job">
                                    Open for job offer from EU, Canada, or USA (moving).
                                </div>                                
                                <div>
                                    <a href="https://www.jetbrains.com/phpstorm/" title="license for PhpStorm"></a>
                                    <a href="http://www.microsoft.com/bizspark/default.aspx" title="Bizspark Startup"></a>
                                </div>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>        

        <div class="align-center padding20 text-small">
            Copyright 2016 <a href="mailto:sergey@pimenov.com.ua">Bank Permata</a>
        </div>
    </div>
</footer>

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
"{!! url('/opname/save') !!}/"+$('#idbarang').val() + "/" + $('#sels').val();
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
