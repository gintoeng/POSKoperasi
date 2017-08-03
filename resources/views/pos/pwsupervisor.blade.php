<div style="font-size:30px;color:#fff;position:absolute;margin-left:220px;margin-top:115px;">Masukan Username</div>
<div class="input-control text" style="font-size:23px; margin-left:500px; top:100px;color:black;position:absolute;">
    <input type="text" id="Ekartu" style="width:500px;text-align:center" autofocus>
</div>
<div style="font-size:30px;color:#fff;position:absolute;margin-left:220px;margin-top:185px;">Masukan Password</div>
<div class="input-control text" style="font-size:23px; margin-left:500px; top:170px;color:black;position:absolute;">
    <input type="password" id="Epin" style="width:500px;text-align:center;">
</div>
<input type="hidden" name="_token" value="{!! csrf_token() !!}">
<input type="hidden" id="saldonya">
<input type="hidden" id="kartu" style="height:5%;margin-top:30%">

<button id="btnsaldo" style="background:#3498db;width:150px;height:40px;margin-left:850px;margin-top:250px;font-size:18px;color:#fff;text-align:center;padding-top:10px;cursor:pointer;border:none;"><b>OK</b></button>

<a href="{{ url('pos/penjualan') }}"><button style="background:#EF4836;width:150px;height:40px;margin-left:680px;margin-top:-45px;font-size:18px;color:#fff;text-align:center;padding-top:10px;cursor:pointer;border:none;"><b>Kembali</b></button></a>

<script >

    $('#btnsaldo').on('click', function () {


                 $.ajax({
            url: "{!! url('pos/supervisor/cek') !!}/"+$('#Ekartu').val() + "/" + $('#Epin').val(),
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                if (data[0]["stat"] == "Fail")
                {
                    sweetAlert("Oops...", "Username/Password salah!", "error");

                }

                else {
                    var total = $('#input').val();

                    if (total == 0) {
                        sweetAlert("Oops...", "Tidak ada transaksi", "error");
                        $("#divpayment").hide();
                        document.getElementById('fade').style.display = 'none';
                    }
                    else
                    {
                        swal({
                            title: "Apa anda yakin ingin membatalkan transaksi ? ",
                            text: "Transaksi akan dibatalkan bila di klik",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                            confirmButtonText: "Yes",
                            closeOnConfirm: false
                        }).then(function() {
                            swal("", "Transaksi berhasil dibatalkan", "success");
                            location.href =  "{{ url('pos/void') }}";
                        });
                    }

                }
            }
        });
    });


</script>
