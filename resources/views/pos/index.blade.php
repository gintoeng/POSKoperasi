<!doctype html>
<html class="no-js" lang="">
<head>
@include('templates.headerpos')
<script src="{{asset('assets/plugins/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('assets/bootstrap/js/bootstrap.js')}}"></script>
</head>

<body id="">
<div class="se-pre-con"></div>
<!--header-->
@include('templates.menupos')

<!--footer-->
 <div id="light" class="lighte">

       <div id="divkasir" style="width:5975%; height:14s00%; overflow:hidden; margin: 0 auto; position:absolute; margin-top:1300%; margin-left:-1100%; background-color:#59ABE3">
      
      </div>
</div>

<div id="fade" class="fadeee" onClick="lightbox_close();"></div>
</body>


<script>


function lightbox_open(){
    document.getElementById('light').style.display='block';
    document.getElementById('fade').style.display='block'; 
}
function lightbox_close(){
    document.getElementById('light').style.display='none';
    document.getElementById('fade').style.display='none';
}
$("#kasirrr").click(function(){
            $("#divkasir").load("{!! URL::to('/pos/pwsupervisor') !!}/");
    });
</script>
</html>
