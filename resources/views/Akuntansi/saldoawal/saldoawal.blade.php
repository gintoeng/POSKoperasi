@extends('layouts.master')

@section('content')

<ol class="breadcrumb">
    <li>
        <a href="javascript:;"><i class="ti-home mr5"></i></a>
    </li>
    <li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active">Saldo Awal</li>
</ol>
@if(session('alert'))
    <br/><br/>
    {!! session('alert') !!}
@endif
<div class="row">
	<div class="col-md-12">
		<section class="panel no-b">
			<div class="panel-body">
                <form class="form-horizontal" role="form" method="post" action="{!! url('akuntansi/saldoawal/store') !!}" onsubmit="return validasitrue();">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="row">
					<div class="col-md-6">
                        <div class="form-group">
                            <label for="parent" class="col-sm-2 control-label">Activa</label>
                            <select name="pertama" id="pertama" class="col-sm-10" required>
                                <option>Pilih Akun</option>
                                @foreach($akun as $akuns)
                                <option value="{{$akuns->id}}"> {{$akuns->kode_akun}} - {{$akuns->nama_akun}}</option>
                                @endforeach
                            </select>
                        </div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive no-border">
                                    <div id="divpertama"> </div>
                                    <div id="divpertama1">
                                        <table class="table table-striped table-bordered scroll responsive no-m" style="display: -moz-groupbox;">
    						                <thead>
    							                <tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">
    							                    <th class="">No</th>
    												<th class="">Kode Perkiraan</th>
    												<th class="">Nama</th>
    												<th class="">Jumlah</th>
    							                </tr>
    						                </thead>
                                            <thead>
    							                <tr class="" style="width: 100%; height:375px; display: inline-table;table-layout: fixed;">
    							                    <th class=""></th>
    												<th class=""></th>
    												<th class=""></th>
    												<th class=""></th>
    							                </tr>
    						                </thead>
    						            </table>
                                    </div>
						        </div>
							</div>
						</div>
                        <div class="row" style="padding-top:5px;">
							<div class="col-md-12">
								<div class="no-border">
						            <table class="table">
						                <thead>
							                <tr class="bg-warning">
							                    <th class=""></th>
												<th class=""></th>
												<th class="text-right">Total Saldo</th>
												<th class="text-right"><font id="totalactiva">Rp. 0.00</font></th>
							                </tr>
						                </thead>

						            </table>
						        </div>
							</div>
						</div>
                        <button onclick="ceknomor()" type="submit" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Simpan</button>
                        &nbsp; &nbsp; &nbsp;
                        Pertanggal : <?php echo date('Y-m-d'); ?>, <b>Kode Jurnal</b> : <?php echo $kode; ?>
                        <input type="hidden" name="kode" value="{{$kode}}">
					</div>

					<div class="col-md-6">
                        <div class="form-group">
                            <label for="parent" class="col-sm-3 control-label">Kewajiban & Modal</label>
                            <select name="kedua" id="kedua" class="col-sm-9" required>
                                <option>Pilih Akun</option>
                                @foreach($akun as $akuns)
                                <option value="{{$akuns->id}}"> {{$akuns->kode_akun}} - {{$akuns->nama_akun}}</option>
                                @endforeach
                            </select>
                        </div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive no-border">
                                    <div id="divkedua"> </div>
                                    <div id="divkedua2">
                                        <table class="table table-striped table-bordered scroll responsive no-m" style="display: -moz-groupbox;">
    						                <thead>
    							                <tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">
    							                    <th class="">No</th>
    												<th class="">Kode Perkiraan</th>
    												<th class="">Nama</th>
    												<th class="">Jumlah</th>
    							                </tr>
    						                </thead>
                                            <thead>
    							                <tr style="width: 100%; height:375px; display: inline-table;table-layout: fixed;">
    							                    <th class=""></th>
    												<th class=""></th>
    												<th class=""></th>
    												<th class=""></th>
    							                </tr>
    						                </thead>
    						            </table>
                                    </div>
						        </div>
							</div>
						</div>
                        <div class="row" style="padding-top:5px;">
							<div class="col-md-12">
								<div class="no-border">
						            <table class="table ">
						                <thead>
							                <tr class="bg-success">
							                    <th class=""></th>
												<th class=""></th>
												<th class="text-right">Total Saldo</th>
												<th class="text-right"><font id="totalkewajiban">Rp. 0.00</font></th>
							                </tr>
						                </thead>
						            </table>
						        </div>
							</div>
						</div>
                    </div>
				</div>
                </form>
			</div>
		</section>
	</div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:red">Peringatan</h4>
      </div>
	  <div class="modal-body">
		  <p>Total Activa dan Kewajiban dan modal harus sama (balance).</p>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rejectModal0" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:red">Peringatan</h4>
      </div>
	  <div class="modal-body">
		  <p>Total Saldo tidak boleh kurang atau sama dengan 0</p>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rejectModal1" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:red">Peringatan</h4>
      </div>
	  <div class="modal-body">
		  <p>Format nomor untuk Saldo Awal Akuntansi belum disetting</p>
	  </div>
      <div class="modal-footer">
        <a href="{{url('pengaturan/nomor')}}" type="button" class="btn btn-primary">Klik disini untuk setting</a>
      </div>
    </div>
  </div>
</div>

<script>
    $("select").select2();

    $("#pertama").change(function(){
            $("#divpertama").load("{{ url('akuntansi/saldoawal/getperkiraanpertama')}}/"+$("#pertama").val());
            document.getElementById('divpertama1').style.display = 'none';
            $("#totalactiva").html('Rp. 0.00');
    });

    $("#kedua").change(function(){
            $("#divkedua").load("{{ url('akuntansi/saldoawal/getperkiraankedua')}}/"+$("#kedua").val());
            document.getElementById('divkedua2').style.display = 'none';
            $("#totalkewajiban").html('Rp. 0.00');
    });

    var kode = <?php echo json_encode($kode) ?>;

    if(kode=="Kode Belum Disetting"){
        $('#rejectModal1').modal();
    }

    var sum_kewajiban_val = 0;
    function jumlah_kewajiban(el) {
        var total_wajib = 0;
        sum_kewajiban_val = 0;
        $("input[name='jumlahkewajiban[]']").each(function (k,v) {
            var jmlwajib = v.value;
            var jmlwajibfix = jmlwajib.replace(/,/gi,'');
            total_wajib += parseInt(jmlwajibfix);
            sum_kewajiban_val += parseInt(jmlwajibfix);
        });

        var total_wajibfix = total_wajib.toFixed(2).replace(/./g, function(c, i, a) {
            return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
        });

        $("#totalkewajiban").html('Rp. '+ total_wajibfix);
    }

    var sum_activa_val = 0;
    function jumlah_activa(el) {
        var total_activa = 0;
        sum_activa_val = 0;
        $("input[name='jumlahactiva[]']").each(function (k,v) {
            var jmlactiva = v.value;
            var jmlactivafix = jmlactiva.replace(/,/gi,'');
            total_activa += parseInt(jmlactivafix);
            sum_activa_val += parseInt(jmlactivafix);
        });

        var total_activafix = total_activa.toFixed(2).replace(/./g, function(c, i, a) {
            return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
        });

        $("#totalactiva").html('Rp. '+ total_activafix);
    }

    function ceknomor(){
        $.ajax({
            url: "{!! url('akuntansi/saldoawal/ceknomor') !!}",
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                if (data[0]["stat"] == "kosong") {
                    $('#rejectModal1').modal();
                }
            }

        });
    }

    function validasitrue(){
        if(kode=="Kode Belum Disetting"){
            $('#rejectModal1').modal();
            return false;
        }
        else if(sum_activa_val==sum_kewajiban_val && sum_activa_val>0){
            return true;
        } else if(sum_activa_val==0){
            $('#rejectModal0').modal();
            return false;
        } else {
            $('#rejectModal').modal();
            return false;
        }
    }

</script>
@stop
