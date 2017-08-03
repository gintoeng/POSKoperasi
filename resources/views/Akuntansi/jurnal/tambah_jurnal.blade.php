@extends('layouts.master')

@section('content')

<ol class="breadcrumb">
	<li>
		<a href="javascript:;"><i class="ti-home mr5"></i></a>
	</li>
	<li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active"><a href="{!! url('akuntansi/jurnal') !!}">Daftar Jurnal</a></li>
	<li class="active">Tambah</li>
</ol>
<div class="row">

	<div class="col-md-12">
		<section class="panel no-b">
			<div class="panel-body">
				<form role="form" class="form-horizontal" method="post" action="{!! url('akuntansi/jurnal/store')!!}" onsubmit="return validasitrue();">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group" id="search_form">
								<label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
								<div class="col-sm-8 input-daterange" id="datepicker">
									<input type="text" name="tanggal" value="{!! $date !!}" class="form-control" id="tanggal">
								</div>
							</div>
							<div class="form-group" id="search_form">
								<label for="tanggal" class="col-sm-2 control-label">Kode</label>
								<div class="col-sm-8">
									<input type="text" name="kode" value="{!! $kode !!}" readonly="true" class="form-control" id="">
								</div>
							</div>

						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
								<div class="col-sm-8">
									<textarea name="keterangan" rows="3" class="form-control" id="keterangan"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped table-bordered responsive no-m" id="input-jurnal">
									<thead>
										<tr>
											<th width="2%">No</th>
											<th width="10%">Kode Akun</th>
											<th width="30%">Nama Akun</th>
											<th width="15%">Debet</th>
											<th width="15%">Kredit</th>
											<th width="10%">&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<tr id="f0">
											<td class="text-center">1</td>
											<td class="id_akun">
												<input class="form-control" readonly>
											</td>
											<td>
												<select name="akun[]" style="width:100%" required>
													<option>Pilih Akun</option>
													@foreach($perkiraan as $perkiraans)
													<option value="{!! $perkiraans->id !!}" data-kode="{!! $perkiraans->kode_akun !!}">{!! $perkiraans->nama_akun !!}</option>
													@endforeach
												</select>
											</td>
											<td align="right">
												<input name="debet[]" id="debet[]" class="form-control" value="0.00" style="text-align:right">
											</td>
											<td align="right">
												<input name="kredit[]" id="kredit[]" class="form-control" value="0.00" style="text-align:right">
											</td>
											<td class="text-center">
												<a href="#" class="btn btn-sm btn-danger btn-del"><i class="ti-trash"></i></a>
											</td>
										</tr>
										<tr id="f1">
											<td class="text-center">2</td>
											<td class="id_akun">
												<input class="form-control" readonly>
											</td>
											<td>
												<select name="akun[]" style="width:100%" required>
													<option>Pilih Akun</option>
													@foreach($perkiraan as $perkiraans)
													<option value="{!! $perkiraans->id !!}" data-kode="{!! $perkiraans->kode_akun !!}">{!! $perkiraans->nama_akun !!}</option>
													@endforeach
												</select>
											</td>
											<td align="right">
												<input name="debet[]" id="debet[]" class="form-control" value="0.00" style="text-align:right">
											</td>
											<td align="right">
												<input name="kredit[]" id="kredit[]" class="form-control" value="0.00" style="text-align:right">
											</td>
											<td class="text-center">
												<a href="#" class="btn btn-sm btn-danger btn-del"><i class="ti-trash"></i></a>
											</td>
										</tr>
										<tr>
											<td class="text-center">
												<a href="#" id="add_row" class="btn btn-sm btn-primary"><i class="ti-plus"></i></a>
											</td>
											<td colspan="2" align="right"><h5><strong>Total</strong></h5></td>
											<td align="right"><h5 id="total_debet"><strong>0.00</strong></h5></td>
											<td align="right"><h5 id="total_kredit"><strong>0.00</strong></h5></td>
											<td align="center">
												<button type="submit" class="btn btn-sm btn-primary" id="save" name="save" value="Save"><i class="ti-save"></i> Simpan</button>
											</td>
										</tr>
									</tbody>
								</table>
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
		  <p>Total Debet dan Kredit harus sama (balance).</p>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('assets/plugins/jquery.cookie.js')}}"></script>

<script type="text/javascript">

	$("input[name='kredit[]']").maskMoney();
	$("input[name='debet[]']").maskMoney();

	$('#search_form .input-daterange').datepicker({
		format: "yyyy-mm-dd",
		todayHighlight: true,
		autoclose: true
	});

	$("#add_row").click(function () {
		var current_row = $("#input-jurnal > tbody > tr").length - 1;
		var tr_tag = "<tr id=\"f"+current_row+"\">" +
						"<td class=\"text-center\">"+ (current_row + 1) +"</td>" +
						"<td class=\"id_akun\">" +
							"<input class=\"form-control\" readonly>" +
						"</td>" +
						"<td>" +
							"<select name=\"akun[]\" style=\"width:100%\" required>" +
								"<option>Pilih Akun</option>" +
								"@foreach($perkiraan as $perkiraans)" +
								"<option value=\"{!! $perkiraans->id !!}\" data-kode=\"{!! $perkiraans->kode_akun!!}\">{!! $perkiraans->nama_akun !!}</option>"  +
								"@endforeach" +
							"</select>" +
						"</td>" +
						"<td align=\"right\">" +
							"<input name=\"debet[]\" id=\"debet[]\" class=\"form-control\" value=\"0.00\" style=\"text-align:right\">" +
						"</td>" +
						"<td align=\"right\">" +
							"<input name=\"kredit[]\" id=\"kredit[]\" class=\"form-control\" value=\"0.00\" style=\"text-align:right\">" +
						"</td>" +
						"<td class=\"text-center\">" +
							"<a href=\"#\" class=\"btn btn-sm btn-danger btn-del\"><i class=\"ti-trash\"></i></a>" +
						"</td>" +
					"</tr>";
		$("#input-jurnal > tbody > tr:last-child").before(tr_tag);
		$("select").select2();
		$("select").on('change', function (e) {
			var kode_akun = $('option:selected', this).attr('data-kode');
			$(this).parent().parent().children('.id_akun').children().val(kode_akun);
		});

		$(".btn-del").each(function (key) {
			del_row($(this));
		});

		$("input[name='debet[]']").keyup(function (e) {
			sum_debet($(this));
			jumlah_kredit($(this));
			jumlah_debet($(this));
		});

		$("input[name='kredit[]']").keyup(function (e) {
			sum_kredit($(this));
			jumlah_debet($(this));
			jumlah_kredit($(this));
		});

		$("input[name='kredit[]']").maskMoney();
		$("input[name='debet[]']").maskMoney();

	});

	$(".btn-del").each(function (key) {
		del_row($(this));
	});

	$("input[name='debet[]']").keyup(function (e) {
		sum_debet($(this));
		jumlah_kredit($(this));
		jumlah_debet($(this));
	});

	$("input[name='kredit[]']").keyup(function (e) {
		sum_kredit($(this));
		jumlah_debet($(this));
		jumlah_kredit($(this));
	});

	$("select").select2();
		$("select").on('change', function (e) {
			var kode_akun = $('option:selected', this).attr('data-kode');
			$(this).parent().parent().children('.id_akun').children().val(kode_akun);
		});

	function del_row(el) {
		el.click(function(){
			el.parent().parent().remove();
		})
	}

	var sum_debet_val = 0;
	function sum_debet(el) {
		var valdebet = el.val();
		var valdebetfix = valdebet.replace(/,/gi,'');
		if(valdebetfix > 0){
			el.parent().parent().children().children("input[name='kredit[]']").val('0.00');
			el.parent().parent().children().children("input[name='kredit[]']").attr('readonly', true);
		}else{
			el.parent().parent().children().children("input[name='kredit[]']").attr('readonly', false);
		}
	}

	function jumlah_debet(el) {
		var total_debet = 0;
		sum_debet_val = 0;
		$("input[name='debet[]']").each(function (k,v) {
			var jmldeb = v.value;
			var jmldebfix = jmldeb.replace(/,/gi,'');
			total_debet += parseInt(jmldebfix);
			sum_debet_val += parseInt(jmldebfix);
		});

		var total_debetfix = total_debet.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

		$("#total_debet").children().html('Rp. '+ total_debetfix);
	}

	var sum_kredit_val = 0;
	function sum_kredit(el) {
		var valkredit = el.val();
		var valkreditfix = valkredit.replace(/,/gi,'');
		if(valkreditfix > 0){
			el.parent().parent().children().children("input[name='debet[]']").val('0.00');
			el.parent().parent().children().children("input[name='debet[]']").attr('readonly', true);
		}else{
			el.parent().parent().children().children("input[name='debet[]']").attr('readonly', false);
		}
	}

	function jumlah_kredit(el) {
		var total_kredit = 0;
		sum_kredit_val = 0;
		$("input[name='kredit[]']").each(function (k,v) {
			var jmlkredit = v.value;
			var jmlkreditfix = jmlkredit.replace(/,/gi,'');
			total_kredit += parseInt(jmlkreditfix);
			sum_kredit_val += parseInt(jmlkreditfix);
		});

		var total_kreditfix = total_kredit.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

		$("#total_kredit").children().html('Rp. '+total_kreditfix);
	}

	function validasitrue(){
		if(sum_debet_val==sum_kredit_val){
			return true;
		} else {
			$('#rejectModal').modal();
			return false;
		}
	}
</script>
@stop
