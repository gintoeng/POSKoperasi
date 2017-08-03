	<div style="background:#3498db;width:1200px;height:70px;position:absolute;margin-top:20px;color:#FFF;font-size:45px;text-align:center;"><b>Transaksi Berhasil</b></div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-left:220px;margin-top:125px;">No. Kartu</div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-top:125px;margin-left:640px">:</div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-top:185px;margin-left:640px">:</div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-top:245px;margin-left:640px">:</div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-left:710px;margin-top:125px;">{{ $kartu }}</div>
		<div style="font-size:36px;color:#fff;position:absolute;margin-left:220px;margin-top:185px;">Total Belanja</div>
		<div style="font-size:36px;color:#fff;position:absolute;margin-left:710px;margin-top:185px;">Rp. {!! number_format($total ,2,",",".") !!}</div>
		<div style="font-size:36px;color:#fff;position:absolute;margin-left:220px;margin-top:245px;">Jenis Pembayaran</div>
	<div style="font-size:36px;color:#fff;position:absolute;margin-left:710px;margin-top:245px;">Tunda</div>
	<input type="hidden" id="noref" value="{!! $noref !!}" style="position:absolute;">
	<input type="hidden" id="kartu" value="{!! $kartu !!}" style="position:absolute;margin-top:5%;">
	<input type="hidden" id="total" value="{!! $total !!}" style="position:absolute;margin-top:8%;">
	<button id="print" style="width:150px;height:40px;background:#3498db;color:#fff;font-size:23px;margin-left:1020px;margin-top:320px;position:absolute;border:none;cursor:pointer">Print</button>
		<a href="{!! url('/pos/penjualan') !!}"><button style="width:150px;height:40px;background:#e74c3c;color:#fff;font-size:23px;margin-left:850px;margin-top:320px;cursor:pointer;position:absolute;border:none;">Kembali</button></a>
		

<script>
$('#print').on('click', function () {


	window.open("{!! url('pos/printund') !!}/"+$('#kartu').val() + "/" + $('#total').val() + "/" + $('#noref').val());
		location.reload();
      });
</script>


