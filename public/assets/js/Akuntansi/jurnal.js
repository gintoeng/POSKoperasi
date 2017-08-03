
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
							"<input name=\"debet[]\" class=\"form-control\" value=\"0\" style=\"text-align:right\">" +
						"</td>" +
						"<td align=\"right\">" +
							"<input name=\"kredit[]\" class=\"form-control\" value=\"0\" style=\"text-align:right\">" +
						"</td>" +
						"<td class=\"text-center\">" +
							"<a href=\"\" class=\"btn btn-sm btn-primary\"><i class=\"ti-pencil\"></i></a>&nbsp;" +
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
			sum_kredit($(this));
		});

	});

	$(".btn-del").each(function (key) {
		del_row($(this));
	});

	$("input[name='debet[]']").keyup(function (e) {
		sum_debet($(this));
	});

	$("input[name='kredit[]']").keyup(function (e) {
		sum_kredit($(this));
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

	function sum_debet(el) {
		if(el.val() > 0){
			el.parent().parent().children().children("input[name='kredit[]']").attr('readonly', true);
		}else{
			el.parent().parent().children().children("input[name='kredit[]']").attr('readonly', false);
		}

		var total_debet = 0;
		$("input[name='debet[]']").each(function (k,v) {
			total_debet += parseInt(v.value);
		});

		$("#total_debet").children().html(total_debet);
	}

	function sum_kredit(el) {
		if(el.val() > 0){
			el.parent().parent().children().children("input[name='debet[]']").attr('readonly', true);
		}else{
			el.parent().parent().children().children("input[name='debet[]']").attr('readonly', false);
		}

		var total_kredit = 0;
		$("input[name='kredit[]']").each(function (k,v) {
			total_kredit += parseInt(v.value);
		});

		$("#total_kredit").children().html(total_kredit);
	}
