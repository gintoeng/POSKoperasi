<div style="font-size:30px;color:#fff;position:absolute;margin-left:250px;margin-top:145px;">Masukan NPK</div>
<div class="input-control text" style="font-size:23px; margin-left:500px; top:130px;color:black;position:absolute;">
    <input type="text" id="Ekartu" style="width:500px;text-align:center" onkeypress="return hanyaAngka(event, false)" autofocus>
</div>
{{--<div style="font-size:30px;color:#fff;position:absolute;margin-left:220px;margin-top:185px;">Nama Anggota</div>--}}
{{--<div class="input-control text" style="font-size:23px; margin-left:500px; top:170px;color:black;position:absolute;">--}}
    {{--<input type="text" id="Epin" style="width:500px;text-align:center;" >--}}
{{--</div>--}}
<input type="hidden" name="_token" value="{!! csrf_token() !!}">
<input type="hidden" id="saldonya">
<input type="hidden" id="totaltrs">
<input type="hidden" id="kartu" style="height:5%;margin-top:30%">

<button id="btnsaldo" style="background:#3498db;width:150px;height:40px;margin-left:850px;margin-top:200px;font-size:18px;color:#fff;text-align:center;cursor:pointer;border:none;"><b>Cek Saldo</b></button>

<button style="background:#EF4836;width:150px;height:40px;margin-left:680px;margin-top:-45px;font-size:18px;color:#fff;text-align:center;cursor:pointer;border:none;" onclick="lightbox_close2()"><b>Kembali</b></button>

<script >

$('#btnsaldo').on('click', function () {

 {{--alert("{!! url('pos/ceksaldo/saldo') !!}/"+$('#Ekartu').val() + "/" + $('#Epin').val());--}}

          $.ajax({
              url: "{!! url('pos/ceksaldo/saldo') !!}/"+$('#Ekartu').val(),
              data: {},
              dataType: "json",
              type: "get",
              success:function(data)
              {
                if (data[0]["stat"] == "Fail")
                {
                    sweetAlert("Oops...", "Nomor NPK salah!", "error");

                }
                  else {
                    $('#saldonya').val(data[0]["saldo"]);
                    $('#totaltrs').val(data[0]["totaltrs"]);
                    $('#kartu').val(data[0]["nokartu"]);
                    $('#divceksaldo').load("{!! URL::to('pos/saldo/saldonya') !!}/" + $('#saldonya').val() + "/" + $('#kartu').val() + "/" + $('#totaltrs').val());
                }
              }
          });
      });


</script>
