                          
<div style="width:1200px;height:50px;font-size:36px;background-color:#3498db;position:absolute;margin-left:0px;margin-top:15px;color:#fff;padding-left:50px"><b>Saldo</b></div>
<div style="font-size:20px;position:absolute;margin-left:-20px;margin-top:300px;color:#fff;padding-left:50px"><b>NPK :</b></div>
<div style="font-size:20px;position:absolute;margin-left:40px;margin-top:300px;color:#fff;padding-left:50px"><b>{!! $kartunya !!}</b></div>

<div style="font-size:20px;position:absolute;margin-left:150px;margin-top:300px;color:#fff;padding-left:50px"><b>Nama :</b></div>
<div style="font-size:20px;position:absolute;margin-left:220px;margin-top:300px;color:#fff;padding-left:50px"><b>{{ $getsaldo->nama  }}</b></div>

<div style="font-size:20px;position:absolute;margin-left:462px;margin-top:300px;color:#fff;padding-left:50px"><b>Kode :</b></div>
<div style="font-size:20px;position:absolute;margin-left:520px;margin-top:300px;color:#fff;padding-left:50px"><b>{{ $getsaldo->kode  }}</b></div>
<div style="font-size:20px;position:absolute;margin-left:-20px;margin-top:260px;color:#fff;padding-left:50px"><b>Total Transaksi yang sudah digunakan :</b></div>
<div style="font-size:20px;position:absolute;margin-left:350px;margin-top:260px;color:#fff;padding-left:50px"><b>Rp. {!! number_format($totaltrs ,2,",",".") !!}</b></div>
<input type="hidden" value="{{ $kartunya  }}" id="kartu">


<div style="font-size:75pt;color:#fff;position:absolute;margin-left:200px;margin-top:105px;"><b>Rp. {!! number_format($saldonya ,2,",",".") !!}</b></div>

<a href="{!! url('pos/penjualan') !!}"><button style="background:#c0392b;width:150px;height:45px;margin-left:840px;margin-top:260px;font-size:22px;color:#fff;text-align:center;cursor:pointer;padding-top:5px;border:none;"><b>Kembali</b></button></a>
<button id="btnsaldo"style="background:#3498db;width:150px;height:45px;margin-left:1020px;margin-top:-50px;font-size:22px;color:#fff;text-align:center;cursor:pointer;padding-top:5px;border:none;"><b>Print</b></button>

<script>

    $('#btnsaldo').on('click', function () {
        window.open("{{ url('pos/print/saldo')  }}" + "/" + $('#kartu').val());
        location.reload();
    });


</script>

