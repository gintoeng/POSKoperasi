@extends('layouts.master')

@section('content')

<ol class="breadcrumb">
    <li>
        <a href="javascript:;"><i class="ti-home mr5"></i></a>
    </li>
    <li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active">Buku Besar</li>
</ol>
<div class="row">
	<div class="col-md-12">
		<section class="panel no-b">
			<div class="panel-body">
				<div class="row">
					<div style="width:100%;">
						<form class="form-horizontal" role="form" method="get" action="{!! url('akuntansi/bukubesar/search') !!}">
							<div <div class="col-md-6">
								<div class="form-group">
									<label for="kata_kunci" class="col-sm-3 control-label">Kode Perkiraan</label>
									<div class="col-sm-9">
										<select name="kode_perkiraan" class="form-control chosen" type="text">
              								<option>Pilih Akun</option>
                                            <option @if($kode_perkiraan=="all") Selected @endif value="all">Semua Akun</option>
              								@foreach($akun as $akuns)
              									<option value="{!! $akuns->id !!}"<?php if($akuns->id==$kode_perkiraan){ ?> selected <?php } ?>>{!! $akuns->kode_akun !!} - {!! $akuns->nama_akun !!}</option>
              								@endforeach
              							</select>
									</div>
								</div>
								<div class="form-group" id="search_form">
									<label for="datepicker" class="col-sm-3 control-label">Tanggal</label>
									<div class="col-md-9">
										<div class="input-daterange input-group" id="datepicker">
											<input type="text" class="input-sm form-control" name="datefrom" value="{!! $date1 !!}"/>
											<span class="input-group-addon">to</span>
											<input type="text" class="input-sm form-control" name="dateto" value="{!! $date2 !!}"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="cari" class="col-sm-3 control-label"></label>
									<div class="col-sm-2">
										<button name="cari" type="submit" class="btn btn-sm btn-primary">&nbsp; &nbsp; <i class="ti-search mr5"></i>Cari &nbsp; &nbsp;</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<hr style="position:relative">
				<div class="col-md-12">
                    <div class="pull-right" style="margin-bottom:2px;position:relative">
                        Total data ditemukan : {{ $JurnalDetailCount }}
                    </div>
                    <div class="pull-left" style="margin-bottom:2px;position:relative">
                        <a href="{{url('akuntansi/bukubesar/cetak?kode_perkiraan='.$kode_perkiraan.'&'.'datefrom='.$date1.'&'.'dateto='.$date2)}}" class="btn btn-sm btn-info mb5" target="_blank"><i class="ti-printer mr5"></i>Cetak</a>
                    </div>
                </div>
				<div class="row">
					<div class="col-md-12">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-striped table-bordered responsive no-m">
						                            <thead>
							                            <tr class="bg-color">
							                               	<th class="text-center">No</th>
                											<th class="text-center">No. Transaksi</th>
                										    <th class="text-center">Tanggal</th>
                											<th class="text-center">Tipe</th>
                											<th class="text-center">Keterangan</th>
                											<th class="text-center">akun</th>
                											<th class="text-center">Debet</th>
                											<th class="text-center">Kredit</th>
                											<th class="text-center">Saldo</th>
                											<th class="text-center">Jurnal</th>
							                            </tr>
						                            </thead>
						                            <tbody>
						                            	@if($cekindexawal == "awal")
						                            	<tr>
						                            		<td colspan="10"><center>Anda harus memilih akun</center></td>
						                            	</tr>
						                            	@elseif($JurnalDetailCount <= 0)
						                            	<tr>
						                            		<td colspan="10"><center>Data Tidak Ada</center></td>
						                            	</tr>
						                            	@else
						                            	<?php $i = ($JurnalDetail->currentPage() - 1) * $JurnalDetail->perPage() + 1; ?>
							                            @foreach($JurnalDetail as $datadetail)
									                            <tr>
									                                <td class="text-center">{!!$i++!!}.</td>
									                                <td>{!! $datadetail->header->kode_jurnal !!}</td>
									                                <td class="text-center">{{ substr($datadetail->header['tanggal'], 0,10) }}</td>
									                                <td>{!! $datadetail->header->tipe !!}</td>
									                                <td>{!! $datadetail->header->keterangan !!}</td>
									                                <td>{!! $datadetail->perkiraan['nama_akun'] !!}</td>
									                                <td class="text-right">Rp. {!! number_format($datadetail->debet, '2') !!}</td>
									                                <td class="text-right">Rp. {!! number_format($datadetail->kredit, '2') !!}</td>
									                                <td class="text-right">Rp. {!! number_format($datadetail->nominal, '2') !!}</td>
									                                <td class="text-center"><a href="#" onclick="history({{$datadetail->id}})"><i class="fa fa-history"></i></a></td>
									                            </tr>
							                            @endforeach
							                            @endif
						                            </tbody>
						                        </table>
						                    </div>
						                        <div class="pull-right">
						                        	@if($cekindexawal=="awal")
						                        	@else
						                        	{!! str_replace('?','?kode_perkiraan='.$kode_perkiraan.'&'.'datefrom='.$date1.'&'.'dateto='.$date2.'&',$JurnalDetail->links()) !!}
						                          	@endif
						                        </div>
										</div>
									</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>


<div class="modal fade" id="rejectModalhistory" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:blue">Jurnal History</h4>
            </div>
	        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-bottom:50px">
                            <label for="nama_simulasi" class="col-sm-4 control-label">No. Transaksi</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama" class="form-control" id="no_transaksi_ajax" readonly>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:50px">
                            <label for="nama_simulasi" class="col-sm-4 control-label">Tanggal</label>
                            <div class="col-sm-8">
                                <input type="text" name="nama" class="form-control" id="tanggal_ajax" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-bottom:50px">
                            <label for="nama_simulasi" class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea type="textarea" readonly name="keterangan" class="form-control" id="keterangan_ajax" placeholder="Keterangan" ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-md-12">
                        <div class="table-responsive no-border" id="table-simulasi">
                            <table class="table table-bordered table-striped no-m">
                                <thead>
                                    <tr class="bg-color">
                                        <th class="text-center">Akun</th>
                                        <th class="text-center">Nama Akun</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Debet</th>
                                        <th class="text-center">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyajax">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
	        </div>
        </div>
    </div>
</div>

<script type="text/javascript">

	$('#kode_perkiraan').change(function() {
            $('#nama_akun').load("{!! url('bukubesar/getnama') !!}/"+ $(this).val());
        });

	$('#search_form .input-daterange').datepicker({
		format: "yyyy-mm-dd",
		todayHighlight: true,
		autoclose: true
	});

    function history(id){
        $('#rejectModalhistory').modal();
        $.ajax({
            url: "{{url('akuntansi/bukubesar/history')}}" + "/" + id,
            data: {},
            type: "get",
            success:function(data)
            {
                    $('#bodyajax').html("");
                    $('#bodyajax').html($('#bodyajax').html()+data);
            }

        });

        $.ajax({
            url: "{{url('akuntansi/bukubesar/history2')}}" + "/" + id,
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                    var trans = data[0]["notrans"];
                    var ket = data[0]["ket"];
                    var tgl = data[0]["tgl"];
                    $('#no_transaksi_ajax').val(trans);
                    $('#keterangan_ajax').val(ket);
                    $('#tanggal_ajax').val(tgl);
            }

        });
    }

</script>
@stop
