<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<meta name="description" content="Flat, Clean, Responsive, application admin template built with bootstrap 3">
<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>

<link rel="stylesheet" href="{{asset('assets/poscss/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/chosen/chosen.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/poscss/css/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/poscss/css/jquery-ui-1.9.2.custom.css')}}">
<link rel="stylesheet" href="{{asset('assets/poscss/css/jquery-ui-1.9.2.custom.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/poscss/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/poscss/css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/poscss/css/custom.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/dist/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/poscss/css/select2.min.css')}}">
 <link rel="stylesheet" href="{{asset('assets/poscss/css/select2.css')}}">
<link rel="stylesheet" href="{{asset('assets/poscss/css/jquery.dataTables.css')}}">
<link rel="stylesheet" href="{{asset('assets/poscss/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/poscss/css/jquery.dataTables_themeroller.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datepicker/datepicker.css')}}"/>
 <link href="{{ asset('assets/templateinventory/css/metro-schemes.css') }}" rel="stylesheet">

<link href="{{ asset('assets/templateinventory/css/metro-icons.css') }}" rel="stylesheet">

<!--<link href="{{ asset('assets/templateinventory/css/metro.css') }}" rel="stylesheet">-->

<script src="{{asset('assets/poscss/js/jquery.js')}}"></script>
<script src="{{asset('assets/poscss/js/shortcut.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/dist/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/plugins/switchery/switcher y.js')}}"></script>
<script src="{{ asset('assets/templateinventory/js/metro.js') }}"></script>
<script src="{{asset('assets/plugins/modernizr.js')}}"></script>
<script src="{{asset('assets/poscss/js/TweenLite.min.js')}}"></script>
<script src="{{asset('assets/poscss/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/poscss/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/poscss/js/TweenMax.min.js')}}"></script>
<script src="{{asset('assets/poscss/js/gerak.js')}}"></script>
<script src="{{asset('assets/poscss/js/select2.min.js')}}"></script>
<!-- <script src="{{asset('assets/poscss/js/select2.js')}}"></script> -->
<script src="{{asset('assets/poscss/js/jquery-ui-1.9.2.custom.js')}}"></script>
<script src="{{asset('assets/poscss/js/jquery-ui-1.9.2.custom.min.js')}}"></script>
<script src="{{asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/js/pickers.js')}}"></script>
<script src="{{asset('assets/poscss/js/gerak.min.js')}}"></script>
<!--<script src="{{asset('assets/poscss/js/jquery-1.8.3.min.js')}}"></script>
<script src="{{asset('assets/poscss/js/jquery-1.8.3.js')}}"></script>-->
<script src="{{asset('assets/poscss/js/jquery.maskMoney.js')}}"></script>
<script src="{{asset('assets/poscss/js/jquery.maskMoney.min.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>





<script type="text/javascript">

/*$(document).ready(function(){
  TweenLite.to($("#caption"),2,{css:{top:0},delay:1, ease:Power2.easeOut});
  TweenLite.to($("#btn1"),2,{css:{left:0},delay:0.02, ease:Power2.easeOut});
  TweenLite.to($("#btn2"),2,{css:{left:20},delay:0.01, ease:Power2.easeOut});
  TweenLite.to($("#btn3"),2,{css:{left:40},delay:0.3, ease:Power2.easeOut});
  TweenLite.to($("#btn4"),2,{css:{left:0},delay:1, ease:Power2.easeOut});
  TweenLite.to($("#btn5"),2,{css:{left:20},delay:0.5, ease:Power2.easeOut});
  TweenLite.to($("#btn6"),2,{css:{left:40},delay:0.7, ease:Power2.easeOut});

  }); */

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
<?php $profil = \App\Model\Pengaturan\Profil::find(1); ?>
<title>Point Of Sale</title>
<link rel="shortcut icon" type="image/png" href="{{asset('foto/profil/'.$profil->foto)}}"/>

<style>

body{
	margin:0;
	background-color:#369;
	overflow:auto;
}
</style>

