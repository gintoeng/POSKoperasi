
<div style="width:100%;height:50%;overflow:hidden;margin:0 auto; position:absolute; margin-top:2%;margin-left:0px;background-color:#3498db  ;">
<div style="font-size:27px;color:#fff;margin-left:2%;position:absolute;"><i>Total Belanja  :</i></div>
<div style="font-size:90px;color:#fff;margin-left:25%;margin-top:5%;"><b>Rp. {!! number_format($total ,2,",",".") !!}</b></div>
</div>
<div style="font-size:27px;color:#fff;margin-left:29%;margin-top:23.5%;position:absolute;">Nominal Pembayaran  :  Rp</div>
<!-- <form method="post" action="{!! url('pos/cash') !!}"> -->
<div class="input-control text"style="font-size:20px; margin-left:680px; margin-top:22%;color:black;position:absolute;">
    <input onkeypress="return hanyaAngka(event, false)" id="eds" type="text" align="center" name="Enominall" style="width:180%;text-align:center;"autofocus>
</div>
<div style="margin-left:92%;margin-top:23.5%;font-size:23px;color:#fff;position:absolute;">,-</div>

<!-- <input type="hidden" name="_token" value="{!! csrf_token() !!}"> -->
<button id="transaksi" type="" style="border:none;width:18%;height:11%;margin-top:28%;margin-left:62%;background-color:#3498db;text-align:center;color:#fff;position:absolute;font-size:20px;cursor:pointer;"><b>Transaksi</b></button>
<input type="hidden"  name="tanggal_cash" value="<?php echo date("Y-m-d");?>">
<input type="hidden"  name="noref_cash" value="">
<input id="totalnya" type="hidden"  name="total_cash" value="{!! $total !!}">
<input id="kembaliaan"name="kembalian" type="hidden"   value="">
<!-- </form> -->
<input type="hidden" id="norefnya" value="{{ $norefnya }}">`
<input type="hidden" id="pembayaran" value="">
<input type="hidden" id="kembali" value="">
<input type="hidden" id="noref" value="">
<button id="batal" style="border:none;width:10%;height:11%;margin-top:28%;margin-left:81.5%;background-color:#c0392b;text-align:center;color:#fff;position:absolute;font-size:20px;cursor:pointer;"><b>Batal</b></button>
<script>

var total = $('#eds').val();

$("#batal").click(function(){
            $("#divpayment").load("{!! URL::to('/pos/payment') !!}/"+$('#input').val() + "/" + $('#jenis1').val() + "/" + $('#jenis2').val() + "/" + $('#norefnya').val());
});

$('#transaksi').on('click', function () {
  
          $.ajax({
              url: "{!! url('pos/cas') !!}/"+$('#totalnya').val() + "/" + $('#eds').val() + "/" + $('#norefnya').val(),
              data: {},
              dataType: "json",
              type: "get",
              success:function(data)
              {

                  if (data[0]["stat"] == "Fail") {
                      sweetAlert("Oops...", "Nominal pembayaran kurang!", "error");
                  }else {

                $('#pembayaran').val(data[0]["total"]);
                $('#kembali').val(data[0]["uangkembali"]);
                $('#noref').val(data[0]["noref"]);
                $("#divpayment").load("{!! URL::to('pos/berhasil') !!}/" + $('#pembayaran').val() + "/" + $('#kembali').val() + "/" + $('#noref').val());
                  }
              }
          });
      });


$("#eds").maskMoney();

</script>
