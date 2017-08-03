@extends('layouts.master')

@section('content')

<ol class="breadcrumb">
    <li>
        <a href="javascript:;"><i class="ti-home mr5"></i></a>
    </li>
    <li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active">Daftar Kas</li>
</ol>
<div class="row">
	<div class="col-md-12">
		<section class="panel no-b">
			<div class="panel-body">
				<div class="row">
					<div style="width:100%;">
						<form class="form-horizontal" role="form" method="get" action="{!! url('akuntansi/daftarkas/search') !!}">
							<div <div class="col-md-6">
								<div class="form-group">
									<label for="kata_kunci" class="col-sm-2 control-label">Tipe</label>
									<div class="col-sm-8">
										<select class="form-control chosen" name="tipe">
											<option value="Masuk" <?php if($tipe=="Masuk"){?> selected <?php } ?>> Masuk </option>
											<option value="Keluar" <?php if($tipe=="Keluar"){?> selected <?php } ?>> Keluar </option>
                                            <option value="Transfer" <?php if($tipe=="Transfer"){?> selected <?php } ?>> Transfer </option>
                                            <option value="Semua" <?php if($tipe=="Semua"){?> selected <?php } ?>> Semua </option>
										</select>
									</div>
								</div>
								<div class="form-group" id="search_form">
									<label for="datepicker" class="col-sm-2 control-label">Tanggal</label>
									<div class="col-md-8">
										<div class="input-daterange input-group" id="datepicker">
											<input type="text" class="input-sm form-control" name="datefrom" value="{!! $date1 !!}"/>
											<span class="input-group-addon">to</span>
											<input type="text" class="input-sm form-control" name="dateto" value="{!! $date2 !!}"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="cari" class="col-sm-2 control-label"></label>
									<div class="col-sm-2">
										<button name="cari" value="Cari" type="submit" class="btn btn-sm btn-primary"><i class="ti-search mr5"></i>&nbsp; Cari &nbsp;&nbsp;</button>
									</div>
								</div>
							</div>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
						</form>
					</div>
				</div>
				<hr>
                <div class="col-md-12">
                    <div class="pull-right" style="margin-bottom:2px;position:relative">
                        Total data ditemukan : {{ $kascount }}
                    </div>
                </div>
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive no-border">
									<table class="table table-bordered table-striped mg-t">
										<thead>
										<tr class="bg-color">
											<th class="text-center">No</th>
											<th class="text-center">Tanggal</th>
											<th class="text-center">Tipe</th>
											<th class="text-center">Akun</th>
											<th class="text-center">Nama Akun</th>
											<th class="text-center">Keterangan</th>
											<th class="text-center">Nominal</th>
										</tr>
										</thead>
										<tbody>
										@if($kascount <= 0)
											<tr>
												<td colspan="9"><center>Data Tidak Ada</center></td>
											</tr>
										@else
											<?php $i = ($kas->currentPage() - 1) * $kas->perPage() + 1; ?>
											@foreach($kas as $kass)
												<tr>
													<td class="text-center">{!!$i++!!}.</td>
													<td class="text-center"><?php echo substr($kass['tanggal'], 0,10); ?></td>
													<td class="text-center">{!! $kass->tipe !!}</td>
													<?php
													$akun = App\Model\Akuntansi\Perkiraan::find($kass->id_akun);
													?>
													<td>{!! $akun['kode_akun'] !!}</td>
													<td>{!! $akun['nama_akun'] !!}</td>
													<td>{!! $kass->keterangan !!}</td>
													<td class="text-right">Rp. <?php echo number_format($kass->jumlah, '2');?></td>
												</tr>
											@endforeach
										@endif
										</tbody>
									</table>
								</div>
								<div class="pull-right">
									@if($statuscari=="index")
										{!! $kas->links() !!}
									@elseif($statuscari=="cari")
										{!! str_replace('?','?tipe='.$tipe.'&'.'datefrom='.$date1.'&'.'dateto='.$date2.'&',$kas->links()) !!}
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

<script type="text/javascript">

	$('#kode_perkiraan').change(function() {
            $('#nama_akun').load("{!! url('bukubesar/getnama') !!}/"+ $(this).val());
        });

	$('#search_form .input-daterange').datepicker({
		format: "yyyy-mm-dd",
		todayHighlight: true,
		autoclose: true
	});
</script>
@stop
