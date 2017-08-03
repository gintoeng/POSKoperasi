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
        <link rel="stylesheet" href="{{asset('assets/plugins/datepicker/datepicker.css')}}"/>

<link rel="stylesheet" type="text/css" href="{{ asset ('assets/templateinventory/css/style.css') }}">
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenLite.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/TweenMax.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/gerak.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery.maskMoney.js') }}"></script>
<script type="text/javascript" src="{{ asset ('assets/templateinventory/js/jquery.maskMoney.min.js') }}"></script>

<script language="JavaScript">
<!--

function enable_text(status)
{
status=!status;
    document.f1.disc.disabled = true;
}

$("#tanggalan").datepicker({
        dateFormat: "yyyy-MM-dd",
        autoclose :true
        });
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
                                <li><a href="{{url('/lapbarangmasuk') }}">  <span class="mif-file-excel"></span> &nbsp;Laporan Barang Masuk</a></li>
                                <li><a href="{{url('/lapbarangkeluar')}}">  <span class="mif-file-excel"></span> &nbsp;Laporan Barang Keluar</a></li>
                                <li><a href="{{url('/masterproduk')}}">  <span class="mif-database"></span> &nbsp;Master Produk</a></li>
                                <li><a href="{{url('/masterkonfigurasi')}}">  <span class="mif-tools"></span> &nbsp;Master Konfigurasi</a></li>
                            </ul>
                </li>
        </div>

</head>

<body>
    <div style="margin-top: 2%;">
    <h1><a href="{!! url('/masterproduk') !!}" class="nav-button transform" style="margin-left: 5%;"><span></span></a>Ubah Produk</h1>
      <hr style="margin-left: 5%; margin-right: 5%;">
    </div>

    <div class="cell colspan10">
        <div class="panel" style="padding-left:5%; padding-right:5%;">
            <div class="heading" >
            <span class="icon mif-pencil"></span>
            <span class="title">Ubah Produk</span>
        </div>
    <div class="content">

    <form action="{!! url('updateproduk/'.$produk->id) !!}" method="POST" enctype="multipart/form-data">

            <div class="grid" style="padding-left:2%; padding-right:2%; padding-top:2%; padding-bottom:2%;">
                <div class="row cells12">
                    <div class="cell colspan12" style="padding-right:30px;">
                        <div class="grid">
                            <div class="row cells2">
                                <div class="cell">
                                    <div class="input-control text full-size">
                                    <label>Masukan No Barcode</label>
                                        <input name="barcode" required type="text"  placeholder="Barcode" value="{!!$produk->barcode!!}">
                                    </div>
                                </div>
                                <div class="cell">
                                    <div class="input-control text full-size">
                                    <label>Masukan Nomor Faktur</label>
                                       <input name="no_faktur" required type="text" onkeypress="return hanyaAngka(event, false)" placeholder="Nomor Faktur" value="{!! $produk->no_faktur !!}">
                                    </div>
                                </div>
                            </div>
                            <div class="row cells2">
                                <div class="cell">
                                    <div class="input-control text full-size">
                                    <label>Masukan Nama Produk</label>
                                        <input name="nama_produk" required placeholder="Nama Produk" value="{!!$produk->nama!!}">
                                    </div>
                                </div>
                                <div class="cell">
                                    <div class="input-control text full-size">
                                    <label>Masukan Stok Barang</label>
                                       <input name="stok" required type="numeric" onkeypress="return hanyaAngka(event, false)" placeholder="Stok Barang" value="{!!$produk->stok!!}">
                                    </div>
                                </div>
                            </div>
                            <form name="discountCalculator">
                            <div class="row cells2">
                                <div class="cell">
                                    <div class="input-control text full-size">
                                    <label>Masukan Harga Beli Barang</label>
                                        <input name="harga_beli" value="{!! number_format($produk->harga_beli, 2, '.', ',') !!}" id="harga_beli" required type="text" onkeypress="return hanyaAngka(event, false)" placeholder="Harga Beli">
                                    </div>
                                </div>
                                <div class="cell">
                                    <div class="input-control text full-size">
                                    <label>Masukan Harga Jual Barang</label>
                                       <input name="harga_jual" value="{!! number_format($produk->harga_jual, 2, '.', ',') !!}" id="harga_jual" required type="text" onkeypress="return hanyaAngka(event, false)" placeholder="Harga Jual">
                                    </div>
                                </div>
                            </div>
                            <div class="row cells2">

                                <div class="cell">
                                    <div class="input-control text full-size">
                                    <label>Masukan Discount</label>
                                        <input name="disc" required placeholder="Discount" type="numeric" onkeypress="return hanyaAngka(event, false)" id="disc" placeholder="Discount" value="{!!$produk->disc!!}">
                                    </div>
                                </div>

                                <div class="cell">
                                    <div class="input-control text full-size">
                                    <label for="untung" class=" control-label">Untung</label>
                                        <input name="untung" type="text" class="full-size" id="untung" placeholder="0.00" readonly style="text-align:right;" value="{!! number_format($produk->untung, 2, '.', ',') !!}">
                                        </div>
                                </div>


                            </div>

                            <div class="row cells2">
                                <div class="cell">
                                    <div class="input-control text full-size">
                                    <label>Masukan Remark</label>
                                        <input name="remark" id="remark"required placeholder="Remark" value="{!!$produk->remark!!}">
                                    </div>
                                </div>
                                <div class="cell">
                                   <div class="input-control text full-size">
                                   <label>Masukan Status Produk</label>
                                        <input name="status" id="status" required placeholder="Status" value="{!!$produk->status!!}">
                                    </div>
                                </div>
                            </div>

                            <div class="row cells2">
                            <div class="cell">
                                    <div class="input-control select2 text iconic full-size" style="height:20px;">
                                        <label>Kategori</label>
                                        <select name="kategori" id="kategori">
                                             @foreach ( $kategori as $value )
                                                 <option value="{!! $value->id !!}">{!! $value->nama !!}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                            <div class="cell">
                                    <div class="input-control select text full-size" style="height:20px;">
                                        <label>Mata Uang</label>
                                        <select name="curr" id="curr">
                                             @foreach ( $curr as $value )
                                                 <option value="{!! $value->id !!}">{!! $value->nama !!}</option>
                                            @endforeach
                                        </select>

                                    </div>
                            </div>
                            </div>

                            <div class="row cells2">
                                <div class="cell">
                                    <div class="input-control select text full-size" style="height:20px;">
                                        <label>Unit</label>
                                        <select name="unit" id="unit">
                                             @foreach ( $unit as $value )
                                                 <option value="{!! $value->id !!}">{!! $value->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="cell">
                                    <div class="input-control select text full-size" style="height:20px;">
                                        <label>Vendor</label>
                                        <select name="vendor" id="vendor">
                                             @foreach ( $vendor as $value )
                                                 <option value="{!! $value->id !!}">{!! $value->nama_vendor !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                         </div>
                         <div class="row">
                             <div class="cell">
                                 <div class="input-control select text full-size" style="height:20px;">
                                     <label>Cabang</label>
                                     <select name="cabang" id="cabang">
                                          @foreach ( $cabang as $value )
                                              <option value="{!! $value->id !!}">{!! $value->nama !!}</option>
                                         @endforeach
                                     </select>
                                 </div>
                             </div>

                      </div>
                                                 

                        </div>

                    </div>
                </div>
                <div class="cell colspan4">
                        <div class="panel warning">
                            <div class="heading">
                                <span class="icon mif-file-image bg-orange"></span>
                                <span class="title">Foto</span>
                            </div>
                            <div class="content">
                                <img src="{{ url('foto/barang/'.$produk->foto) }}" class="icon place-center" style="margin-left:35%; padding:5%;">
                                <div class="input-control file" data-role="input" style="width:100%;">
                                    <input type="file" name="foto" placeholder="Pilih Gambar">
                                    <button class="button warning"><span class="mif-folder fg-white"></span></button>
                                </div>
                            </div>
                        </div>

                        <div class="input-control textarea" style="width:100%;">
                                <textarea required name="keterangan" placeholder="Klasifikasi Barang"> {!! $produk->classification !!} </textarea>
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
                url: "{!! url('/untung') !!}/" + $('#harga_jual').val() + "/" + $('#harga_beli').val(),
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
                url: "{!! url('/untung') !!}/" + $('#harga_jual').val() + "/" + $('#harga_beli').val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#untung').val(data[0]["untung"]);
                }

            });
        });

        $(function(){
        $("#kategori").select2();
    });
        $(function(){
        $("#curr").select2();
    });
        $(function(){
        $("#unit").select2();
    });
        $(function(){
        $("#vendor").select2();
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
<script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
