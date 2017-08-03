<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" type="image/x-icon" href="{{ asset ('assets/templateinventory/inventory.ico') }}">
        <link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/sweetalert.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/templateinventory/css/docs.css') }}" rel="stylesheet">        
        <link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">                
<link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenLite.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenMax.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/gerak.js') }}"></script>

<script language="JavaScript">
<!--

function enable_text(status)
{
status=!status; 
    document.f1.disc.disabled = true;
}
//-->
</script>

<title>Tambah Produk</title>

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
                                <li><a href="{{url('/masterkonfigurasi')}}">  <span class="mif-tools"></span> &nbsp;Master Konfigurasi</a></li></ul>
                </li>
        </div>

</head>

<body>
    <div style="margin-top: 2%;">
    <h1><a href="{!! url('/inventory') !!}" class="nav-button transform" style="margin-left: 5%;"><span></span></a>Tambah Produk</h1>
      <hr style="margin-left: 5%; margin-right: 5%;">
    </div>

    <div class="cell colspan10">
        <div class="panel" style="padding-left:5%; padding-right:5%;">
            <div class="heading" >
            <span class="icon mif-pencil"></span>
            <span class="title">Tambah Produk</span>
        </div>
    <div class="content">
        
    <form action="{!!url('tambahproduk/save')!!}" method="POST" enctype="multipart/form-data">
        
            <div class="grid">
                <div class="row cells12">                    
                    <div class="cell colspan8" style="padding-right:30px;">
                        <div class="grid">
                            <div class="row cells2">
                                <div class="cell">
                                    <div class="input-control modern text iconic full-size">                                        
                                        <input name="barcode" required type="numeric" onkeypress="return hanyaAngka(event, false)" placeholder="Barcode">
                                        <span class="informer">Masukan Barcode Produk</span>                                        
                                        <span class="icon mif-barcode"></span>
                                    </div>
                                </div>
                                <div class="cell">
                                    <div class="input-control modern text iconic full-size">
                                       <input name="no_faktur" required type="text" onkeypress="return hanyaAngka(event, false)" placeholder="Nomor Faktur">
                                        <span class="informer">Masukan Nomor Faktur</span>                                        
                                        <span class="icon mif-list-numbered"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row cells2">
                                <div class="cell">
                                    <div class="input-control modern text iconic full-size">
                                        <input name="nama_produk" required placeholder="Nama Produk">
                                        <span class="informer">Masukan Nama Produk</span>                                        
                                        <span class="icon mif-pencil"></span>
                                    </div>
                                </div>
                                <div class="cell">
                                    <div class="input-control modern text iconic full-size">
                                       <input name="stok" required type="numeric" onkeypress="return hanyaAngka(event, false)" placeholder="Stok Barang">
                                        <span class="informer">Masukan Stok Barang</span>                                        
                                        <span class="icon mif-cabinet"></span>
                                    </div>
                                </div>
                            </div>
                            <form name="discountCalculator">
                            <div class="row cells2">
                                <div class="cell">
                                    <div class="input-control modern text iconic full-size">
                                        <input name="harga_beli" id="harga_beli" required type="numeric" onkeypress="return hanyaAngka(event, false)" placeholder="Harga Beli">
                                        <span class="informer">Masukan Harga Beli Barang</span>                                        
                                        <span class="icon mif-tag"></span>
                                    </div>
                                </div>
                                <div class="cell">
                                    <div class="input-control modern text iconic full-size">
                                       <input name="harga_jual" id="harga_jual" required type="text" onkeypress="return hanyaAngka(event, false)" placeholder="Harga Jual">
                                        <span class="informer">Masukan Harga Jual Barang</span>                                        
                                        <span class="icon mif-tags &nbsp; ">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row cells4">

                                <div class="cell full-size" style="margin-left:2%;">
                                    <label class="input-control checkbox small-check">
                                            <input type="checkbox" onclick="document.getElementById('disc').disabled=this.checked;">
                                            <span class="check"></span>
                                            <span class="caption">Matikan Discount</span>
                                    </label>
                                </div>

                                <div class="cell full-size">                                
                                    <div class="input-control modern text iconic full-size">
                                        <input name="disc" required type="numeric" onkeypress="return hanyaAngka(event, false)" id="disc" placeholder="Discount">
                                        <span class="informer">Masukan Discount</span>                                        
                                        <span class="icon mif-discout"></span>
                                    </div>                                                                    
                                </div>
                                <div class="form-group">
                                    <label for="untung" class="col-sm-3 control-label">Untung</label>
                                    <div class="col-sm-9">
                                        <input name="untung" type="text" class="form-control" id="untung" style="text-align:right" placeholder="0.00" required disabled>
                                    </div>
                                </div>
                                

                            </div>                                                        
                            <div class="cell">
                                    <div class="input-control select modern text iconic full-size" style="height:20px;">
                                        <label>Kategori</label>
                                        <select name="kategori">
                                             @foreach ( $kategori as $value )             
                                                 <option value="{!! $value->id !!}">{!! $value->nama !!}</option>              
                                            @endforeach
                                        </select>
                                        <span class="informer">Pilih Kategori</span>                                                                       
                                    </div>
                                </div>

                            <div class="cell">
                                    <div class="input-control select modern text iconic full-size" style="height:20px;">
                                        <label>Curr</label>
                                        <select name="curr">
                                             @foreach ( $curr as $value )             
                                                 <option value="{!! $value->id !!}">{!! $value->nama !!}</option>              
                                            @endforeach
                                        </select>
                                        <span class="informer">Pilih Kategori</span>                                                                       
                                    </div>
                                <div class="cell">
                                    <div class="input-control select modern text iconic full-size" style="height:20px;">
                                        <label>Unit</label>
                                        <select name="unit">
                                             @foreach ( $unit as $value )             
                                                 <option value="{!! $value->id !!}">{!! $value->nama !!}</option>              
                                            @endforeach
                                        </select>
                                        <span class="informer">Pilih Kategori</span>                                                                       
                                    </div>
                                </div>

                                <div class="cell">
                                    <div class="input-control select modern text iconic full-size" style="height:20px;">
                                        <label>Vendor</label>
                                        <select name="vendor">
                                             @foreach ( $vendor as $value )             
                                                 <option value="{!! $value->id !!}">{!! $value->nama_vendor !!}</option>              
                                            @endforeach
                                        </select>
                                        <span class="informer">Pilih Kategori</span>                                                                       
                                    </div>
                                </div>                                                                                     
                                                                                                                                          
                        </div>   

                    </div>
                </div>
                <div class="cell colspan4" style="padding:15px;">
                        <div class="panel warning">
                            <div class="heading">
                                <span class="icon mif-file-image bg-orange"></span>
                                <span class="title">Foto</span>
                            </div>
                            <div class="content">
                                <img src="{{  asset('assets/templateinventory/images/folder-images.png')}}" class="icon place-center" style="padding-right:2%; padding-left:20%; padding-top: 2.5%; padding-bottom: 2.5%;">
                                <div class="input-control file" data-role="input" style="width:100%;">
                                    <input type="file" name="foto" placeholder="Pilih Gambar">
                                    <button class="button warning"><span class="mif-folder fg-white"></span></button>
                                </div>
                            </div>
                        </div>

                        <div class="input-control textarea" style="width:100%;">                                                                    
                                <textarea required name="keterangan" placeholder="Klasifikasi Barang"></textarea>
                        </div>
                        <div>
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <button type="submit" class="button success full-size" onclick="return swal, true"><span class="mif-paper-plane mif-ani-float"></span>&nbsp;Simpan</button>
                        </div>
                    </div>
            </div>
            
             
    </form>
</body>


    <script>
        $('#harga_beli').maskMoney();
        $('#harga_jual').maskMoney();
        //$('#disc').maskMoney();
        $('#untung').maskMoney();

        $('#harga_jual').on('change', function() {
            $.ajax({
                url: "{!! url('master/barang/untung') !!}/" + $('#harga_jual').val() + "/" + $('#harga_beli').val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#untung').val(data[0]["untung"]);
                }

            });
        });

        $('#harga_beli').on('change', function() {
            $.ajax({
                url: "{!! url('master/barang/untung') !!}/" + $('#harga_jual').val() + "/" + $('#harga_beli').val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#untung').val(data[0]["untung"]);
                }

            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imgfoto').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#foto").change(function(){
            readURL(this);
        });

        $('#btnsave').on('click', function() {
            if ($('#nama').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama Barang</h4>');
                $('#mess').html('<p id="mess">Nama Barang tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#matauang').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Matauang</h4>');
                $('#mess').html('<p id="mess">Matauang tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#unit').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Unit</h4>');
                $('#mess').html('<p id="mess">Unit tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#vendor').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Vendor</h4>');
                $('#mess').html('<p id="mess">Vendor tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#kategori').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kategori</h4>');
                $('#mess').html('<p id="mess">Kategori tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#fven').submit();
            }

        });

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

    function swal(swal){
                    'Success!',
                    'Berhasil di simpan!',
                    'success'
                }
    </script>

<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenLite.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenMax.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/gerak.js') }}"></script>
<script src="{{ asset('assets/templateinventory/js/jquery-2.1.3.min.js') }}"></script>
<script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
<script src="{{ asset('assets/templateinventory/js/docs.js') }}"></script>        
<script src="{{ asset('assets/templateinventory/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/templateinventory/js/sweetalert.js') }}"></script>
