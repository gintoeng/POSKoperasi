<div style="width:100%; height:100px; overflow:hidden; margin: 0 auto; background-color:#369">

  <div style="width:1500px; height:150px; margin:0 auto; overflow:hidden; position:relative">

       <a onclick="FunctionLoading()"><div style="font-size:40px;color:#FFF;height:80px;cursor:pointer;margin-top:40px;float:left; margin-left:100px; position:absolute">Main Menu  ( {{ $cabang->nama  }} )</div></a>
        </div>

</div>

<!--buttons-->
<div>
<a onclick="FunctionLoading()"   href="{{ url('logout') }}" style="color:#FFF;font-size:20px;margin-left:82%;"><span class="mif-switch" style="color:#FFF;padding-top:-1%"></span> &nbsp;Logout</a>
</div>
<br>

<a onclick="FunctionLoading()" href="{!! url('/pos/master') !!}"><div style="width:250px;height:210px;background:#27ae60;position:absolute;margin-left:32%;margin-top:6%">
<img src="{{ url('assets/poscss/imgs/2.png') }}" style="position:absolute;margin-left:27%;margin-top:8%">
  <div style="color:#FFF;font-size:18px;margin-left:33%;margin-top:54%;position:absolute"><b>Pengaturan</b></div></div>
</div>
<a onclick="FunctionLoading()" href="{!! url('/inventory') !!}"><div style="width:250px;height:210px;background:#e74c3c;position:absolute;margin-left:52%;margin-top:6%">
<img src="{{ url('assets/poscss/imgs/1.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">
    <div style="color:#FFF;font-size:18px;margin-left:35%;margin-top:54%;position:absolute"><b>Inventory</b></div>

</div></a>
<a onclick="cek()"><div style="cursor:pointer;width:250px;height:210px;background:#f1c40f;position:absolute;margin-left:32%;margin-top:23%">
<img src="{{ url('assets/poscss/imgs/3.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">
    <div style="color:#FFF;font-size:18px;margin-left:30%;margin-top:54%;position:absolute"><b>Point Of Sale</b></div>
</div></a>
<a onclick="FunctionLoading()" href="{!! url('pos/laporan') !!}"><div style="width:250px;height:210px;background:#3498db;position:absolute;margin-left:52%;margin-top:23%">
<img src="{{ url('assets/poscss/imgs/4.png') }}" style="position:absolute;margin-left:25%;margin-top:5%">
    <div style="color:#FFF;font-size:18px;margin-left:38%;margin-top:54%;position:absolute"><b>Laporan</b></div>
</div>  </a>

<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:red">Peringatan</h4>
      </div>
	  <div class="modal-body">
		  <p>Formaat nomor untuk POS belum disetting</p>
	  </div>
      <div class="modal-footer">
        <a href="{{url('pengaturan/nomor')}}" type="button" class="btn btn-primary">Klik disini untuk disetting</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">


	 function cek() {
        $.ajax({
            url: "{!! url('pos/penjualan/cek') !!}",
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                if (data[0]["stat"] == "kosong") {
                    $('#rejectModal').modal();
                } else {
                        location.href = "{!! url('pos/penjualan') !!}";
                }
            }

        });
    };


</script>
