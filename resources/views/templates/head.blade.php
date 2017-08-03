<meta charset="utf-8">
<meta name="description" content="Flat, Clean, Responsive, application admin template built with bootstrap 3">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
<?php $profil = \App\Model\Pengaturan\Profil::find(1); ?>
<title>Koperasi</title>
<link rel="shortcut icon" type="image/png" href="{{asset('foto/profil/'.$profil->foto)}}"/>

<script type="text/javascript">
    //<![CDATA[
    try{if (!window.CloudFlare) {var CloudFlare=[{verbose:0,p:0,byc:0,owlid:"cf",bag2:1,mirage2:0,oracle:0,paths:{cloudflare:"/cdn-cgi/nexp/dok3v=1613a3a185/"},atok:"fd283de87a32702e7aa93ae3461bd83d",petok:"f1852fb5d057ee1726fe77da2e8a04e0be76fa49-1426736011-1800",zone:"nyasha.me",rocket:"0",apps:{"ga_key":{"ua":"UA-50530436-1","ga_bs":"2"}}}];CloudFlare.push({"apps":{"ape":"469140967db38d41f4b83d44868e2c02"}});!function(a,b){a=document.createElement("script"),b=document.getElementsByTagName("script")[0],a.async=!0,a.src="http://ajax.cloudflare.com/cdn-cgi/nexp/dok3v=919620257c/cloudflare.min.js",b.parentNode.insertBefore(a,b)}()}}catch(e){};
    //]]>
</script>


<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables/jquery.dataTables.css')}}">

<link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/plugins/jstree/themes/default/style.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/chosen/chosen.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datepicker/datepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/font-awesome.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/themify-icons.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/skins/palette.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/fonts/font.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">

<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/dist/sweetalert2.css')}}">


<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="{{asset('assets/plugins/modernizr.js')}}"></script>

<script src="{{asset('assets/plugins/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.maskMoney.js')}}"></script>
<script src="{{asset('assets/bootstrap/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/plugins/appear/jquery.appear.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.placeholder.js')}}"></script>
<script src="{{asset('assets/plugins/fastclick.js')}}"></script>

<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('assets/plugins/icheck/icheck.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/dist/sweetalert2.min.js')}}"></script>

<script src="{{asset('assets/plugins/flot/jquery.flot.js')}}"></script>
<script src="{{asset('assets/plugins/flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('assets/plugins/flot/jquery.flot.categories.js')}}"></script>
<script src="{{asset('assets/plugins/flot/jquery.flot.stack.js')}}"></script>
<script src="{{asset('assets/plugins/flot/jquery.flot.time.js')}}"></script>
<script src="{{asset('assets/plugins/flot/jquery.flot.orderBars.js')}}"></script>
<script src="{{asset('assets/plugins/flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.sparkline.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/plugins/easy-pie-chart/jquery.easypiechart.js')}}"></script>
<script src="{{asset('assets/plugins/raphael.min.js')}}"></script>
<script src="{{asset('assets/plugins/morris/morris.js')}}"></script>
<script src="{{asset('assets/plugins/chartjs/Chart.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.blockUI.js')}}"></script>
<script src="{{asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/js/pickers.js')}}"></script>
<script src="{{asset('assets/plugins/fuelux/spinnerr.js')}}"></script>

<script src="{{asset('assets/plugins/chosen/chosen.jquery.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.js')}}"></script>

<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/js/offscreen.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
<script src="{{asset('assets/js/general.js')}}"></script>

<script src="{{asset('assets/js/notifications.js')}}"></script>

<script src="{{asset('assets/js/bootstrap-datatables.js')}}"></script>
<script src="{{asset('assets/js/table-edit.js')}}"></script>

<script src="{{asset('assets/js/chart.js')}}"></script>

<script src="{{asset('assets/js/form-custom.js')}}"></script>

<script src="{{asset('assets/js/jstree.js')}}"></script>

<script src="{{asset('assets/plugins/jstree/jstree.min.js')}}"></script>

<script src="{{ asset('assets/plugins/modernizr.js') }}"></script>
