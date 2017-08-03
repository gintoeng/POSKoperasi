<div style="font-size:30px;color:#fff;position:absolute;margin-left:200px;margin-top:155px;">Masukan No. Ref</div>
<div class="input-control text" style="font-size:23px; margin-left:460px; top:140px;color:black;position:absolute;">
    <input type="text" id="Ekartu" style="width:500px;text-align:center" autofocus>
</div>
<input type="hidden" id="jenis_pembayaran">
<input type="hidden" id="noref" style="height:5%;margin-top:30%">

<button id="btncekretur" style="background:#3498db;width:150px;height:40px;margin-left:810px;margin-top:210px;font-size:18px;color:#fff;text-align:center;padding-top:5px;cursor:pointer;border:none;"><b>Cek</b></button>

<button onclick="lightbox_close3()" style="background:#EF4836;width:150px;height:40px;margin-left:-330px;margin-top:210px;font-size:18px;color:#fff;position:absolute;text-align:center;padding-top:5px;cursor:pointer;border:none;"><b>Kembali</b></button>

<script >

    $('#btncekretur').on('click', function () {
        $.ajax({
            url: "{!! url('pos/cekbarang/cek') !!}/" + $('#Ekartu').val(),
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {

                if (data[0]["stat"] == "FAIL") {
                    sweetAlert("Oops...", "Nomor Transaksi tidak ada!", "error");
                } else {

                    $('#jenis_pembayaran').val(data[0]["jenis_pembayaran"]);
                    $('#noref').val(data[0]["noref"]);
                    location.href = "{!! URL::to('/pos/returbarang') !!}/" + $('#noref').val() + "/" + $('#jenis_pembayaran').val();
                }
            }


        });

    });


</script>
