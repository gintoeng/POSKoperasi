
<div style="width:1200px; height:370px; overflow:hidden; margin: 0 auto; position:relative; margin-top:-19px; margin-left:0px; background-color:#59ABE3">
	<div style="background:#3498db;width:1200px;height:70px;position:absolute;margin-top:20px;color:#FFF;font-size:45px;text-align:center;"><b>Transaksi Berhasil</b></div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-left:220px;margin-top:125px;">Pembayaran</div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-top:125px;margin-left:640px">:</div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-top:185px;margin-left:640px">:</div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-top:245px;margin-left:640px">:</div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-left:710px;margin-top:125px;">Rp. {!! number_format($pembayaran ,2,",",".") !!}</div>
		<div style="font-size:36px;color:#fff;position:absolute;margin-left:220px;margin-top:185px;">Nominal Kembalian</div>
		<div style="font-size:36px;color:#fff;position:absolute;margin-left:710px;margin-top:185px;">Rp. {!! number_format($kembali ,2,",",".") !!}</div>
		<div style="font-size:36px;color:#fff;position:absolute;margin-left:220px;margin-top:245px;">Jenis Pembayaran</div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-left:710px;margin-top:245px;">Kartu</div>
	    <button id="print" style="width:150px;height:40px;background:#3498db;color:#fff;font-size:23px;margin-left:1020px;margin-top:320px;position:absolute;border:none;cursor:pointer">Print</button>
		<a href="{!! url('/pos/penjualan') !!}"><button id="kembali"style="width:150px;height:40px;background:#e74c3c;color:#fff;font-size:23px;margin-left:850px;margin-top:320px;cursor:pointer;position:absolute;border:none;">Kembali</button>	
</div>
<script type="text/javascript">


      	
</script>
