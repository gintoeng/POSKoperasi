<!doctype html>
<html class="signin no-js" lang="">

<!-- Mirrored from sublime.nyasha.me/admin/signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Mar 2015 03:34:41 GMT -->
<head>

<meta charset="utf-8">
<meta name="description" content="Flat, Clean, Responsive, application admin template built with bootstrap 3">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">

<title>Koperasi</title>

<script type="text/javascript">
//<![CDATA[
try{if (!window.CloudFlare) {var CloudFlare=[{verbose:0,p:0,byc:0,owlid:"cf",bag2:1,mirage2:0,oracle:0,paths:{cloudflare:"/cdn-cgi/nexp/dok3v=1613a3a185/"},atok:"db1656c10c4d96f79488ea367506ffe2",petok:"d23bc28cbcc46f52721e3e5ba2d4db290e98535c-1426735984-1800",zone:"nyasha.me",rocket:"0",apps:{"ga_key":{"ua":"UA-50530436-1","ga_bs":"2"}}}];CloudFlare.push({"apps":{"ape":"797f2869513ed32b9765b9d2f3a58507"}});!function(a,b){a=document.createElement("script"),b=document.getElementsByTagName("script")[0],a.async=!0,a.src="http://ajax.cloudflare.com/cdn-cgi/nexp/dok3v=919620257c/cloudflare.min.js",b.parentNode.insertBefore(a,b)}()}}catch(e){};
//]]>
</script>
<link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/font-awesome.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/themify-icons.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/animate.min.css') }}">


<link rel="stylesheet" href="{{ url('assets/css/skins/palette.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/fonts/font.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/main.css') }}">


<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<script src="{{ url('assets/plugins/modernizr.js') }}"></script>
<script type="text/javascript">
/* <![CDATA[ */
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-50530436-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

(function(b){(function(a){"__CF"in b&&"DJS"in b.__CF?b.__CF.DJS.push(a):"addEventListener"in b?b.addEventListener("load",a,!1):b.attachEvent("onload",a)})(function(){"FB"in b&&"Event"in FB&&"subscribe"in FB.Event&&(FB.Event.subscribe("edge.create",function(a){_gaq.push(["_trackSocial","facebook","like",a])}),FB.Event.subscribe("edge.remove",function(a){_gaq.push(["_trackSocial","facebook","unlike",a])}),FB.Event.subscribe("message.send",function(a){_gaq.push(["_trackSocial","facebook","send",a])}));"twttr"in b&&"events"in twttr&&"bind"in twttr.events&&twttr.events.bind("tweet",function(a){if(a){var b;if(a.target&&a.target.nodeName=="IFRAME")a:{if(a=a.target.src){a=a.split("#")[0].match(/[^?=&]+=([^&]*)?/g);b=0;for(var c;c=a[b];++b)if(c.indexOf("url")===0){b=unescape(c.split("=")[1]);break a}}b=void 0}_gaq.push(["_trackSocial","twitter","tweet",b])}})})})(window);
/* ]]> */
</script>
<style type="text/css">
.row{
  margin:0!important;
}
</style>
</head>
<body class="bg-primary">
<div class="cover" style="background-image: url(/assets/img/cover3.jpg)"></div>
<div class="overlay bg-primary"></div>
<div class="center-wrapper">
<div class="center-content">
<div class="row">
<div class="text-center col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
<section class="panel bg-white no-b">
<header class="panel-heading">
    <img src="{{asset('foto/profil/'.$profil->foto)}}" width="100"><br>
  {{--<h4>--}}
    {{--@if(count($profil)==0)--}}
      {{--Koperasi--}}
    {{--@else--}}
      {{--{{ $profil->nama_koperasi }}--}}
    {{--@endif--}}
  {{--</h4>--}}
</header>
@if(session('msg'))
    <div class="alert alert-{!! session('msgclass') !!}">
        {!! session('msg') !!}
    </div>
@endif
<div class="p15">
<form role="form" action="{{ url('login') }}" method="post">
{!! csrf_field() !!}
<input type="text" name="username" class="form-control input-lg mb25" placeholder="Username" value="{{ old('username') }}">
<input type="password" name="password" class="form-control input-lg mb25" placeholder="Password" value="{{ old('password') }}">
<div class="show">
<label class="checkbox">
<input type="checkbox" name="remember" checked>Remember me
</label>
</div>
<button class="btn btn-primary btn-lg btn-block" type="submit">Sign in</button>
</form>
</div>
</section>
<p class="text-center">
Copyright &copy;
<span id="year" class="mr5"></span>
<span>
  @if(count($profil)==0)
    Koperasi
  @else
    {{ $profil->nama_koperasi }}
  @endif
</span>
</p>
</div>
</div>
</div>
</div>
<script type="text/javascript">
        var el = document.getElementById("year"),
            year = (new Date().getFullYear());
        el.innerHTML = year;
    </script>
</body>

<!-- Mirrored from sublime.nyasha.me/admin/signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 19 Mar 2015 03:34:42 GMT -->
</html>
