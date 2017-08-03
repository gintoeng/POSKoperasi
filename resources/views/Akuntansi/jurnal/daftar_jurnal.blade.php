@extends('layouts.master')

@section('content')

<ol class="breadcrumb">
    <li>
        <a href="javascript:;"><i class="ti-home mr5"></i></a>
    </li>
    <li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active">Daftar Jurnal</li>
</ol>

<input type="number" name="qty" id="qty">
<script>

</script>
<div class="row">
		<section class="panel no-b">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8">
						<form class="form-horizontal" role="form" method="post" action="{!! url('jurnal/search') !!}">
							<div class="form-group">
								<label for="kata_kunci" class="col-sm-2 control-label">Kata Kunci</label>
								<div class="col-sm-6">
									<input type="text" name="kata_kunci" class="form-control" id="kata_kunci" placeholder="Cari">
								</div>
							</div>
							<div class="form-group" id="search_form">
								<label for="datepicker" class="col-sm-2 control-label">Tanggal</label>
								<div class="col-md-6">
									<div class="input-daterange input-group" id="datepicker">
										<input type="text" class="input-sm form-control" name="datefrom" value="{!! $date !!}"/>
										<span class="input-group-addon">to</span>
										<input type="text" class="input-sm form-control" name="dateto" value="{!! $date !!}"/>
									</div>
								</div>
							</div>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group">
								<label for="cari" class="col-sm-2 control-label"></label>
								<div class="col-sm-2">
									<button name="cari" value="Cari" type="submit" class="btn btn-sm btn-primary"><i class="ti-search mr5"></i>Cari</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="box-tab">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#manual" data-toggle="tab">Manual</a></li>
								<li class="{active_tab}"><a href="#tabungan" data-toggle="tab">Tabungan</a></li>
								<li class="{active_tab}"><a href="#kredit" data-toggle="tab">Kredit</a></li>
								<li class="{active_tab}"><a href="#deposito" data-toggle="tab">Deposito</a></li>
								<li class="{active_tab}"><a href="#kas" data-toggle="tab">Kas</a></li>
								<li class="{active_tab}"><a href="#semua" data-toggle="tab">Semua</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="manual">
									<div class="row">
										<div class="col-md-6">
											<a href="{!! url('akuntansi/jurnal/create')!!}" class="btn btn-sm btn-primary mb5"><i class="ti-printer mr5"></i>Tambah</a>
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-danger mb5"><i class="fa fa-file-pdf-o mr5"></i>PDF</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : 15
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t datatable editable-datatable">
						                            <thead>
							                            <tr>
							                               	<th class="">No</th>
															<th class="">No. Transaksi</th>
															<th class="">Tanggal</th>
															<th class="">Status</th>
															<th class="">Akun</th>
															<th class="">Nama Akun</th>
															<th class="">Keterangan</th>
															<th class="">Debet</th>
															<th class="">Kredit</th>
							                            </tr>
						                            </thead>
						                            <tbody>
						                            <?php $i = 1; ?>
						                            @foreach($JurnalHeaderManual as $row)
						                            	<?php
						                            		$JurnalDetailManual = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
						                            	?>
						                            	@foreach($JurnalDetailManual as $datajurnal)
							                            <tr>
							                                <td>{!! $i++ !!}</td>
							                                <td>{!! $row->kode_jurnal !!}</td>
							                                <td><?php echo substr($row['tanggal'], 0,10); ?></td>
							                                <td>{!! $row->status !!}</td>
							                                <?php
							                                	$akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
							                                ?>
							                                <td>{!! $akun['kode_akun'] !!}</td>
							                                <td>{!! $akun['nama_akun'] !!}</td>
							                                <td>{!! $row->keterangan !!}</td>
							                                <td>{!! $datajurnal->debet !!}</td>
							                                <td>{!! $datajurnal->kredit !!}</td>
							                            </tr>
							                            @endforeach
							                        @endforeach
						                            </tbody>
						                        </table>
						                    </div>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="tabungan">
									<div class="row">
										<div class="col-md-6">
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-danger mb5"><i class="fa fa-file-pdf-o mr5"></i>PDF</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : 15
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t datatable editable-datatable">
						                            <thead>
							                            <tr>
							                               	<th class="">No</th>
															<th class="">No. Transaksi</th>
															<th class="">Tanggal</th>
															<th class="">Status</th>
															<th class="">Akun</th>
															<th class="">Nama Akun</th>
															<th class="">Keterangan</th>
															<th class="">Debet</th>
															<th class="">Kredit</th>
							                            </tr>
						                            </thead>
						                            <tbody>
						                            <?php $i = 1; ?>
						                            @foreach($JurnalHeaderTabungan as $row)
						                            	<?php
						                            		$JurnalDetailManual = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
						                            	?>
						                            	@foreach($JurnalDetailManual as $datajurnal)
							                            <tr>
							                                <td>{!! $i++ !!}</td>
							                                <td>{!! $row->kode_jurnal !!}</td>
							                                <td>{!! $row->tanggal !!}</td>
							                                <td>{!! $row->status !!}</td>
							                                <?php
							                                	$akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
							                                ?>
							                                <td>{!! $akun['kode_akun'] !!}</td>
							                                <td>{!! $akun['nama_akun'] !!}</td>
							                                <td>{!! $row->keterangan !!}</td>
							                                <td>{!! $datajurnal->debet !!}</td>
							                                <td>{!! $datajurnal->kredit !!}</td>
							                            </tr>
							                            @endforeach
							                        @endforeach
						                            </tbody>
						                        </table>
						                    </div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="kredit">
									<div class="row">
										<div class="col-md-6">
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-danger mb5"><i class="fa fa-file-pdf-o mr5"></i>PDF</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : 15
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t datatable editable-datatable">
						                            <thead>
							                            <tr>
							                               	<th class="">No</th>
															<th class="">No. Transaksi</th>
															<th class="">Tanggal</th>
															<th class="">Status</th>
															<th class="">Akun</th>
															<th class="">Nama Akun</th>
															<th class="">Keterangan</th>
															<th class="">Debet</th>
															<th class="">Kredit</th>
							                            </tr>
						                            </thead>
						                            <tbody>
						                            <?php $i = 1; ?>
						                            @foreach($JurnalHeaderKredit as $row)
						                            	<?php
						                            		$JurnalDetailManual = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
						                            	?>
						                            	@foreach($JurnalDetailManual as $datajurnal)
							                            <tr>
							                                <td>{!! $i++ !!}</td>
							                                <td>{!! $row->kode_jurnal !!}</td>
							                                <td>{!! $row->tanggal !!}</td>
							                                <td>{!! $row->status !!}</td>
							                                <?php
							                                	$akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
							                                ?>
							                                <td>{!! $akun['kode_akun'] !!}</td>
							                                <td>{!! $akun['nama_akun'] !!}</td>
							                                <td>{!! $row->keterangan !!}</td>
							                                <td>{!! $datajurnal->debet !!}</td>
							                                <td>{!! $datajurnal->kredit !!}</td>
							                            </tr>
							                            @endforeach
							                        @endforeach
						                            </tbody>
						                        </table>
						                    </div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="deposito">
									<div class="row">
										<div class="col-md-6">
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-danger mb5"><i class="fa fa-file-pdf-o mr5"></i>PDF</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : 15
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t datatable editable-datatable">
						                            <thead>
							                            <tr>
							                               	<th class="">No</th>
															<th class="">No. Transaksi</th>
															<th class="">Tanggal</th>
															<th class="">Status</th>
															<th class="">Akun</th>
															<th class="">Nama Akun</th>
															<th class="">Keterangan</th>
															<th class="">Debet</th>
															<th class="">Kredit</th>
							                            </tr>
						                            </thead>
						                            <tbody>
						                            <?php $i = 1; ?>
						                            @foreach($JurnalHeaderDeposito as $row)
						                            	<?php
						                            		$JurnalDetailManual = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
						                            	?>
						                            	@foreach($JurnalDetailManual as $datajurnal)
							                            <tr>
							                                <td>{!! $i++ !!}</td>
							                                <td>{!! $row->kode_jurnal !!}</td>
							                                <td>{!! $row->tanggal !!}</td>
							                                <td>{!! $row->status !!}</td>
							                                <?php
							                                	$akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
							                                ?>
							                                <td>{!! $akun['kode_akun'] !!}</td>
							                                <td>{!! $akun['nama_akun'] !!}</td>
							                                <td>{!! $row->keterangan !!}</td>
							                                <td>{!! $datajurnal->debet !!}</td>
							                                <td>{!! $datajurnal->kredit !!}</td>
							                            </tr>
							                            @endforeach
							                        @endforeach
						                            </tbody>
						                        </table>
						                    </div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="kas">
									<div class="row">
										<div class="col-md-6">
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-danger mb5"><i class="fa fa-file-pdf-o mr5"></i>PDF</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : 15
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t datatable editable-datatable">
						                            <thead>
							                            <tr>
							                               	<th class="">No</th>
															<th class="">No. Transaksi</th>
															<th class="">Tanggal</th>
															<th class="">Status</th>
															<th class="">Akun</th>
															<th class="">Nama Akun</th>
															<th class="">Keterangan</th>
															<th class="">Debet</th>
															<th class="">Kredit</th>
							                            </tr>
						                            </thead>
						                            <tbody>
						                            <?php $i = 1; ?>
						                            @foreach($JurnalHeaderKas as $row)
						                            	<?php
						                            		$JurnalDetailManual = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
						                            	?>
						                            	@foreach($JurnalDetailManual as $datajurnal)
							                            <tr>
							                                <td>{!! $i++ !!}</td>
							                                <td>{!! $row->kode_jurnal !!}</td>
							                                <td>{!! $row->tanggal !!}</td>
							                                <td>{!! $row->status !!}</td>
							                                <?php
							                                	$akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
							                                ?>
							                                <td>{!! $akun['kode_akun'] !!}</td>
							                                <td>{!! $akun['nama_akun'] !!}</td>
							                                <td>{!! $row->keterangan !!}</td>
							                                <td>{!! $datajurnal->debet !!}</td>
							                                <td>{!! $datajurnal->kredit !!}</td>
							                            </tr>
							                            @endforeach
							                        @endforeach
						                            </tbody>
						                        </table>
						                    </div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="semua">
									<div class="row">
										<div class="col-md-6">
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-danger mb5"><i class="fa fa-file-pdf-o mr5"></i>PDF</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : 15
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t datatable editable-datatable">
						                            <thead>
							                            <tr>
							                               	<th class="">No</th>
															<th class="">No. Transaksi</th>
															<th class="">Tanggal</th>
															<th class="">Status</th>
															<th class="">Akun</th>
															<th class="">Nama Akun</th>
															<th class="">Keterangan</th>
															<th class="">Debet</th>
															<th class="">Kredit</th>
							                            </tr>
						                            </thead>
						                            <tbody>
						                            <?php $i = 1; ?>
						                            @foreach($JurnalHeaderAll as $row)
						                            	<?php
						                            		$JurnalDetailManual = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
						                            	?>
						                            	@foreach($JurnalDetailManual as $datajurnal)
							                            <tr>
							                                <td>{!! $i++ !!}</td>
							                                <td>{!! $row->kode_jurnal !!}</td>
							                                <td>{!! $row->tanggal !!}</td>
							                                <td>{!! $row->status !!}</td>
							                                <?php
							                                	$akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
							                                ?>
							                                <td>{!! $akun['kode_akun'] !!}</td>
							                                <td>{!! $akun['nama_akun'] !!}</td>
							                                <td>{!! $row->keterangan !!}</td>
							                                <td>{!! $datajurnal->debet !!}</td>
							                                <td>{!! $datajurnal->kredit !!}</td>
							                            </tr>
							                            @endforeach
							                        @endforeach
						                            </tbody>
						                        </table>
						                    </div>
										</div>
									</div>
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
	$('#search_form .input-daterange').datepicker({
		format: "yyyy-mm-dd",
		todayHighlight: true,
		autoclose: true
	});
</script>
@stop
