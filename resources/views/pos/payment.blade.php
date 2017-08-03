<div style="width:100%;height:50%;overflow:hidden;margin:0 auto; position:absolute; margin-top:2%;margin-left:0%;background-color:#3498db;">

<input value="{{ $ck1 }}" id="ck1" type="hidden" style="position:absolute">
<input value="{{ $ck2 }}" id="ck2" type="hidden" style="position:absolute;margin-left:10%;">
{{--<input value="{{ $ck3 }}" id="ck3" type="hidden" style="position:absolute;margin-left:20%">--}}
<input value="{{ $norefnya }}" id="norefnya" type="hidden" >

<div style="font-size:27px;color:#fff;margin-left:2%;position:absolute;"><i>Total Belanja  :</i></div>
<div style="font-size:90px;color:#fff;margin-left:25%;margin-top:5%;"><b>Rp. {!! number_format($total ,2,",",".") !!}</b></div>
<input type="hidden" value="{{ $total }}" id="input">
</div>
{{--<button id="tunda" style="border:none;width:35%;height:11%;background-color:#3498db;margin-top:21%;margin-left:25%;font-size:14pt;text-align:center;color:#fff;position:absolute;cursor:pointer;"><b>Tunda</b></button>--}}
<button id="cso" style="border:none;width:70.5%;height:11%;background-color:#c0392b;margin-top:25.5%;margin-left:25%;font-size:14pt;text-align:center;color:#fff;position:absolute;cursor:pointer;" onclick="lightbox_close()"><b>Batalkan Pembayaran</b></button>
<button id="tunda" style="border:none;width:35%;height:11%;background-color:#3498db;margin-top:21%;margin-left:60.5%;font-size:14pt;text-align:center;color:#fff;position:absolute;cursor:pointer;"><b>Tunda</b></button>
<button id="cash" style="width:35%;height:11%;border:none;margin-top:21%;margin-left:25%;background-color:#3498db;text-align:center;color:#fff;position:absolute;font-size:14pt;cursor:pointer;"><b>Cash</b></button>
<input id="bayar"name="bayarr"type="hidden">

<script type="text/javascript">

var cash1 = $('#ck1').val();
//var autodebet1 = $('#ck2').val();
var tunda1 = $('#ck2').val();
var autodebet1 = 0;

if (cash1==0) 
{
 
   $('#cash').attr('disabled','disabled');
   $('#cash').css('background-color','#c0392b');
    
}
 if (autodebet1==0)
{
 
  $('#autodebet').attr('disabled','disabled');
  $('#autodebet').css('background-color','#c0392b');
  
}
 if (tunda1==0)
{

  $('#tunda').attr('disabled','disabled');
  $('#tunda').css('background-color','#c0392b');
   
}
else 
  {
  $('#cash1').removeAttr('disabled');
  $('#autodebet1').removeAttr('disabled');
  $('#tunda1').removeAttr('disabled');
  $('#cash').css('background-color','#3498db');
  $('#autodebet').css('background-color','#3498db');
  $('#tunda').css('background-color','#3498db');

  }

$("#cash").click(function(){
            $("#divpayment").load("{!! URL::to('/pos/cash') !!}/"+$('#input').val() + "/" + $('#jenis1').val() + "/" + $('#jenis2').val() +  "/" + $('#norefnya').val());

});

{{--$("#autodebet").click(function(){--}}
            {{--$("#divpayment").load("{!! URL::to('/pos/autodebet') !!}/"+$('#input').val() + "/" + $('#jenis1').val() + "/" + $('#jenis2').val() + "/" +  $('#jenis3').val() + "/" + $('#norefnya').val());--}}
{{--});--}}

$('#tunda').on('click', function () {

            $("#divpayment").load("{!! URL::to('/pos/tunda') !!}/"+$('#input').val() + "/" + $('#jenis1').val() + "/" + $('#jenis2').val()  + "/" + $('#norefnya').val());

      });
</script>
