<!--  <div style="width:1200px; height:350px; overflow:hidden; margin: 0 auto; position:relative; margin-top:0px; margin-left:0px; background-color:#59ABE3">

 -->
 <div style="width:1200px;height:50px;font-size:36px;background-color:#3498db;position:absolute;margin-left:0px;margin-top:15px;color:#fff;padding-left:50px"><b>Saldo</b></div>

<div style="font-size:75pt;color:#fff;position:absolute;margin-left:200px;margin-top:145px;"><b>Rp. {!! number_format($total ,2,",",".") !!}</b></div>
<input type="hidden"  value="{!! $total !!}" id="sasal">
<input type="hidden"  value="{!! $kartu !!}" id="kar" style="position:absolute;margin-top:10%">
<input type="hidden"  value="{!! $norefnya !!}" id="norefnya" style="position:absolute;margin-top:10%">
<input type="hidden" id="sisasaldo" value="">
<input type="hidden" id="kartu" value="">
<input type="hidden"  name="tanggalnya" value="<?php echo date("Y-m-d");?>">
<!--<button style="font-size:20px;background:#3498db;width:150px;height:45px;border:none;margin-top:270px;color:#fff;position:absolute">Transaksi</button>
-->
<button id="transaksi" type="submit" style="background:#3498db;width:150px;height:45px;margin-left:980px;margin-top:320px;font-size:22px;color:#fff;text-align:center;cursor:pointer;padding-top:5px;border:none;"><b>Transaksi</b></button>

<script>

$('#transaksi').on('click', function () {    

	$.ajax({
		url: "{!!url('pos/autodebet/trans/mulai') !!}/" +$('#kar').val() + "/" + $('#norefnya').val()	,
		data: {},               
		dataType: "json",
		type: "get",               
		success:function(data)
		{
			$('#sisasaldo').val(data[0]["saldoawal"]);
			$('#kartu').val(data[0]["total"]);
			$('#divpayment').load("{!! URL::to('pos/berhasildebet') !!}/" + $('#sisasaldo').val() + "/" + $('#kartu').val() + "/" + $('#norefnya').val());

		}
	});   
 }); 
</script>
