<div style="background:#3498db;width:1200px;height:70px;position:absolute;margin-top:20px;color:#FFF;font-size:45px;text-align:center;"><b>Info Anggota</b></div>
<div style="font-size:26px;color:#fff;position:absolute;margin-left:260px;margin-top:125px;">NPK</div>
<div style="font-size:26px;color:#fff;position:absolute;margin-top:125px;margin-left:640px">:</div>
<div style="font-size:26px;color:#fff;position:absolute;margin-top:165px;margin-left:640px">:</div>
<div style="font-size:26px;color:#fff;position:absolute;margin-top:215px;margin-left:640px">:</div>
<div style="font-size:26px;color:#fff;position:absolute;margin-top:275px;margin-left:640px">:</div>
<div style="font-size:26px;color:#fff;position:absolute;margin-left:660px;margin-top:125px;">{{ $anggota->npk  }}</div>
<input type="hidden" value="{{ $anggota->npk  }}" id="kartu">
<input type="hidden" value="" id="total">
<div style="font-size:26px;color:#fff;position:absolute;margin-left:260px;margin-top:165px;">Nama Anggota</div>
<div style="font-size:26px;color:#fff;position:absolute;margin-left:660px;margin-top:165px;">{{ $anggota->nama  }}</div>
<div style="font-size:26px;color:#fff;position:absolute;margin-left:260px;margin-top:215px;">Jenis Anggota</div>
<input id="norefnya" type="hidden" value="{{ $norefnya  }}">
<div style="font-size:26px;color:#fff;position:absolute;margin-left:660px;margin-top:215px;">{{ $namanya }}</div>
<input type="hidden" value="{{ $namanya  }}" id="namanya">
<input type="hidden" value="{{ $status  }}" id="status">
<div style="font-size:26px;color:#fff;position:absolute;margin-left:260px;margin-top:275px;">Total Transaksi yang digunakan </div>
<div style="font-size:26px;color:#fff;position:absolute;margin-left:660px;margin-top:275px;">Rp. {!! number_format($totaltrs ,2,",",".") !!}</div>
{{--<input type="hidden" id="noref" value="{!! $noref !!}" style="position:absolute;">--}}
{{--<input type="hidden" id="kartu" value="{!! $kartu !!}" style="position:absolute;margin-top:5%;">--}}
{{--<input type="hidden" id="noref" value="{!! $total !!}" style="position:absolute;margin-top:8%;">--}}
<button id="trs" style="width:150px;height:40px;background:#3498db;color:#fff;font-size:23px;margin-left:1020px;margin-top:320px;position:absolute;border:none;cursor:pointer">Transaksi</button>
<a href="{!! url('/pos/penjualan') !!}"><button style="width:150px;height:40px;background:#e74c3c;color:#fff;font-size:23px;margin-left:850px;margin-top:320px;cursor:pointer;position:absolute;border:none;">Kembali</button></a>


<script>
    var stts =  $('#status').val();



        $('#trs').on('click', function () {
            if (stts=="AKTIF")
            {

            $.ajax({
                url: "{!! url('pos/penjual/tunda/oooo') !!}/"+$('#kartu').val() + "/" + $('#norefnya').val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {

                    $('#total').val(data[0]["total"]);

                    $('#divpayment').load("{!! URL::to('pos/berhasiltunda') !!}/" + $('#kartu').val() + "/" + $('#total').val() + "/" + $('#norefnya').val());
                }
            });

            }

            else
            {
                sweetAlert("Oops...", "Transaksi Gagal. Periksa status keanggotaan anda!", "error");
            }

        });



</script>


