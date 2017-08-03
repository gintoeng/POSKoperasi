@extends('layouts.master')

@section('content')

<ol class="breadcrumb">
    <li>
        <a href="javascript:;"><i class="ti-home mr5"></i></a>
    </li>
    <li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active">Kas Keluar</li>
</ol>
@if(session('alert'))
    <br/><br/>
    {!! session('alert') !!}
@endif
<div class="row">
	<div class="col-md-12">
        <section class="panel no-b">
            <form class="form-horizontal" role="form" method="post" action="{{ url('akuntansi/kaskeluar/store') }}" onsubmit="return validasitrue();">
                <div class="panel-body">
                    <div class="row">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent" class="col-sm-3 control-label">Keluar Dari Akun</label>
                                        <select name="akunkas" class="col-sm-9" required>
                                            <option>Pilih Akun</option>
                                            @foreach($perkiraankas as $perkiraanss)
                                                <option value="{!! $perkiraanss->id !!}" data-kode="{!! $perkiraanss->kode_akun !!}">{!! $perkiraanss->kode_akun !!} - {!! $perkiraanss->nama_akun !!}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="module_name" class="col-sm-3 control-label">Jumlah</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="jumlah" readonly class="form-control" id="jumlah" placeholder="0.00" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="module_name" class="col-sm-3 control-label">Kode</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="kode" readonly class="form-control" id="kode" value="{{$kode}}" >
                                    </div>
                                </div>

    						</div>
    						<div class="col-md-6">
                                <div class="form-group" id="search_form">
                              	    <label for="module_name" class="col-sm-2 control-label">Tanggal</label>
                              		    <div class="col-sm-9">
    								        <input type="text" class="form-control datepicker" name="tanggal" value="{!! $date !!}"/>
                              		    </div>
                                </div>
                                <div class="form-group" id="search_form">
                                    <label class="col-sm-2 control-label">Keterangan</label>
                                    <div class="col-md-9 input-daterange">
                                        <textarea type="textarea" name="keterangan" class="form-control" id="kata_kunci" placeholder="Keterangan" ></textarea>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <label for="save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <input type="submit" class="btn btn-primary btn-block" value="Save">
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{{ url('module') }}" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{{ url('module') }}" class="btn btn-info btn-block">Cetak</a>
                                    </div>
                                </div>-->
    						</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive" style="padding:2%">
                            Dana Ke Akun
                            <table class="table table-striped table-bordered responsive no-m" id="input-jurnal">
                                <thead>
                                    <tr>
                                        <th width="2%">No</th>
                                        <th width="10%">Kode Akun</th>
                                        <th width="30%">Nama Akun</th>
                                        <th width="15%">Nominal</th>
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
                                            <input name="nominal[]" class="form-control" value="0" style="text-align:right">
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
                                            <input name="nominal[]" class="form-control" value="0" style="text-align:right">
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
                                        <td align="right"><h5 id="total_nominal"><strong>0</strong></h5></td>
                                        <td align="center">
                                            <button onclick="ceknomor()" type="submit" class="btn btn-sm btn-primary" name="save" value="Save"><i class="ti-save"></i> Simpan</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
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
		  <p>Jumlah tidak boleh kurang atau sama dengan 0</p>
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
		  <p>Format nomor untuk Kas Keluar belum disetting</p>
	  </div>
      <div class="modal-footer">
        <a href="{{url('pengaturan/nomor')}}" type="button" class="btn btn-primary">Klik disini untuk setting</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

var kode = <?php echo json_encode($kode) ?>;

if(kode=="Kode Belum Disetting"){
    $('#rejectModal1').modal();
}


$("select").select2();
$("select").on('change', function (e) {
    var kode_akun = $('option:selected', this).attr('data-kode');
    $(this).parent().parent().children('.id_akun').children().val(kode_akun);
});

	$('#kode_perkiraan').change(function() {
            $('#nama_akun').load("{!! url('bukubesar/getnama') !!}/"+ $(this).val());
        });
</script>

<script type="text/javascript">

	$("input[name='nominal[]']").maskMoney();

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
							"<input name=\"nominal[]\" id=\"debet[]\" class=\"form-control\" value=\"0.00\" style=\"text-align:right\">" +
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

		$("input[name='nominal[]']").keyup(function (e) {
			jumlah_nominal($(this));
		});

		$("input[name='nominal[]']").maskMoney();

	});

	$(".btn-del").each(function (key) {
		del_row($(this));
	});

	$("input[name='nominal[]']").keyup(function (e) {
		jumlah_nominal($(this));
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

	var sum_nominal_val = 0;
	function jumlah_nominal(el) {
		var total_nominal = 0;
		sum_nominal_val = 0;
		$("input[name='nominal[]']").each(function (k,v) {
			var jmlnom = v.value;
			var jmlnomfix = jmlnom.replace(/,/gi,'');
			total_nominal += parseInt(jmlnomfix);
			sum_nominal_val += parseInt(jmlnomfix);
		});

		var total_nominalfix = total_nominal.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

		$("#total_nominal").children().html('Rp. '+ total_nominalfix);
        $("input[name='jumlah']").val(total_nominalfix);
	}

    function ceknomor(){
        $.ajax({
            url: "{!! url('akuntansi/kaskeluar/ceknomor') !!}",
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
        } else if(sum_nominal_val>0){
            return true;
        } else {
            $('#rejectModal').modal();
            return false;
        }
	}

</script>
@stop
