@extends('layouts.master')

@section('content')

<ol class="breadcrumb">
    <li>
        <a href="javascript:;"><i class="ti-home mr5"></i></a>
    </li>
    <li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active">Pembagian SHU</li>
</ol>
<div class="row">
	<div class="col-md-12">
		<section class="panel no-b">
			<div class="panel-body">
				<div class="row">
					<form class="form-horizontal" role="form" method="post" action="{url}/tabungan/mutasi/index/cari">
						<div class="col-md-3">
							<div class="form-group">
								<label for="nama_nasabah" class="col-sm-4 control-label">Periode</label>
								<div class="col-sm-8">
									<input type="text" name="nama_nasabah" value="{!! $periode !!}" class="form-control" id="nama_nasabah" placeholder="Nama Nasabah" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat_nasabah" class="col-sm-4 control-label">Tanggal</label>
								<div class="col-sm-8">
									<input type="text" name="tanggal" value="{!! $tanggal !!}" class="form-control" id="alamat_nasabah" placeholder="Alamat Nasabah" readonly>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="nama_nasabah" class="col-sm-6 control-label">Jasa Modal</label>
								<div class="col-sm-6">
									<input type="text" name="nama_nasabah" value="<?php echo number_format($jasa_modal, '2'); ?>" class="form-control" id="nama_nasabah" placeholder="Nama Nasabah" style="text-align:right" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat_nasabah" class="col-sm-6 control-label">Jasa Usaha</label>
								<div class="col-sm-6">
									<input type="text" name="alamat_nasabah" value="<?php echo number_format($jasa_usaha, '2'); ?>" class="form-control" id="alamat_nasabah" placeholder="Alamat Nasabah" style="text-align:right" readonly>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="nama_nasabah" class="col-sm-6 control-label">Total Jasa Modal</label>
								<div class="col-sm-6">
									<input type="text" name="nama_nasabah" value="<?php echo number_format($total_jasamodal,'2');  ?>" class="form-control" id="nama_nasabah" placeholder="Nama Nasabah" style="text-align:right" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat_nasabah" class="col-sm-6 control-label">Total Jasa Usaha</label>
								<div class="col-sm-6">
									<input type="text" name="alamat_nasabah" value="<?php echo number_format($total_jasausaha, '2'); ?>" class="form-control" id="alamat_nasabah" placeholder="Alamat Nasabah" style="text-align:right" readonly>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="nama_nasabah" class="col-sm-4 control-label">Per Rupiah</label>
								<div class="col-sm-8">
									<input type="text" name="nama_nasabah" value="<?php echo number_format($perrupiah_jasamodal, '6'); ?>" class="form-control" id="nama_nasabah" placeholder="Nama Nasabah" style="text-align:right" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat_nasabah" class="col-sm-4 control-label">Per Rupiah</label>
								<div class="col-sm-8">
									<input type="text" name="alamat_nasabah" value="<?php echo number_format($perrupiah_jasausaha, '6'); ?>" class="form-control" id="alamat_nasabah" placeholder="Alamat Nasabah" style="text-align:right" readonly>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-md-12">
						<form class="form-horizontal" role="form" method="post" action="{!! url('shu/bagishu/cetak') !!}">
							<button type="submit" class="btn btn-sm btn-danger mb5"><i class="ti-printer mr5"></i>Cetak</button>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="idvalidasi" value="{!! $idvalidasi !!}">
						</form>
						<div class="table-responsive">
							<table class="table table-striped table-bordered responsive no-m">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Nama</th>
										<th class="text-center">NIK</th>
										<th class="text-center">Jasa Modal</th>
										<th class="text-center">Jasa Belanja</th>
										<th class="text-center">SHU Jasa Anggota</th>
										<th class="text-center">SHU Jasa Usaha</th>
										<th class="text-center">Total</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; ?>
									@foreach($anggota as $anggotas)
                                    <?php
                                        $shujasaanggotaa = 0;
                                        foreach($anggotas->simpananid as $simpanans) {
                                            $transaksisimpanand = App\Model\Simpanan\Transaksi::where('id_simpanan', $simpanans->id)->sum('debet');
                                            $transaksisimpanank = App\Model\Simpanan\Transaksi::where('id_simpanan', $simpanans->id)->sum('kredit');
                                            $simpanantransaksi = $transaksisimpanank - $transaksisimpanand;
                                            $shujasaanggotaa += $simpanantransaksi;
                                        }
                                        $shujasaanggota = $shujasaanggotaa * $perrupiah_jasamodal;
                                    ?>
									<tr>
										<td class="text-center">{!! $i++ !!}</td>
										<td>{!! $anggotas->nama !!}</td>
										<td>{!! $anggotas->nik !!}</td>
										<td align="right">{!! number_format($shujasaanggotaa, '2') !!}</td>
										<td align="right">{!! number_format($simpananwajib, '2') !!}</td>
										<td align="right">{!! number_format($shujasaanggota, '2') !!}</td>
										<td align="right">{!! number_format($simpananwajib, '2') !!}</td>
										<td align="right">{!! number_format($simpananwajib, '2') !!}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

@stop
