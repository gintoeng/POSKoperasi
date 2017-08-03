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
@if(session('alert'))
    <br/><br/>
    {!! session('alert') !!}
@endif
<div class="row">
	<div class="col-md-12">
		<section class="panel no-b">
			<div class="panel-body">
				<div class="row">
					<form class="form-horizontal" role="form" method="post" action="{!! url('akuntansi/jurnal/search') !!}">
						<div class="col-md-6">
								<div class="form-group">
									<label for="kata_kunci" class="col-sm-3 control-label">Kata Kunci</label>
									<div class="col-sm-9">
										<input type="text" name="kata_kunci" class="form-control" value="{!! $kata_kunci !!}" id="kata_kunci" placeholder="No Transaksi">
									</div>
								</div>
								<div class="form-group" id="search_form">
									<label for="datepicker" class="col-sm-3 control-label">Nama Akun</label>
									<div class="col-sm-9">
                                            <select name="akun_perkiraan" class="form-control chosen" type="text" placeholder="Semua Akun">
              								<option value="semua">Semua Akun</option>
              								@foreach($akun as $akuns)
              									<option value="{!! $akuns->id !!}"<?php if($akuns->id==$akun_perkiraan){ ?> selected <?php } ?>>{!! $akuns->kode_akun !!} - {!! $akuns->nama_akun !!}</option>
              								@endforeach
              							</select>
									</div>
								</div>
						</div>
						<div class="col-md-6">
								<div class="form-group">
									<label for="kata_kunci" class="col-sm-2 control-label">Status</label>
									<div class="col-sm-9">
                                        <select name="posting" class="form-control chosen" type="text">
              								<option value="0" <?php if($posting==0){?> selected <?php } ?>>Belum Diposting</option>
              								<option value="1" <?php if($posting==1){?> selected <?php } ?>>Sudah Diposting</option>
              							</select>
									</div>
								</div>
								<div class="form-group" id="search_form">
									<label for="datepicker" class="col-sm-2 control-label">Tanggal</label>
									<div class="col-md-9">
										<div class="input-daterange input-group" id="datepicker">
											<input type="text" class="input-sm form-control" name="datefrom" value="{!! $date1 !!}"/>
											<span class="input-group-addon">to</span>
											<input type="text" class="input-sm form-control" name="dateto" value="{!! $date2 !!}"/>
										</div>
									</div>
								</div>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="form-group">
									<label for="cari" class="col-sm-2 control-label"></label>
									<div class="col-sm-2">
										<button name="cari" type="submit" class="btn btn-sm btn-primary"><i class="ti-search mr5"></i>Cari</button>
									</div>
								</div>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="box-tab">
							<ul class="nav nav-tabs">
                                <li class="{active_tab}"><a href="#semua" data-toggle="tab">Semua</a></li>
								<li class="active"><a href="#manual" data-toggle="tab">Manual</a></li>
								<li class="{active_tab}"><a href="#tabungan" data-toggle="tab">Simpanan</a></li>
								<li class="{active_tab}"><a href="#kredit" data-toggle="tab">Pinjaman</a></li>
								<!--<li class="{active_tab}"><a href="#deposito" data-toggle="tab">Deposito</a></li>-->
								<li class="{active_tab}"><a href="#kas" data-toggle="tab">Kas</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="manual">
									<div class="row">
										<div class="col-md-6">
											<a onclick="ceknomor()" class="btn btn-sm btn-primary mb5"><i class="ti ti-plus mr5"></i>Tambah</a>
											<a href="#" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : {!! $JurnalHeaderManualjml !!}
											</div>
										</div>
                                        <tr>
									</div>
									<div class="row">
                                        <form class="form-horizontal" role="form" method="post" action="{!! url('akuntansi/jurnal/posting') !!}">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t">
						                            <thead>
                                                        <tr>
							                                <th class="text-center">No</th>
                                                            <th class="text-center">No. Transaksi</th>
                                                            <th class="text-center">Tanggal</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Akun</th>
                                                            <th class="text-center">Nama Akun</th>
                                                            <th class="text-center">Keterangan</th>
                                                            <th class="text-center">Debet</th>
                                                            <th class="text-center">Kredit</th>
                                                            <th><input type="checkbox" name="checkAll" id="TableManual"></th>
							                            </tr>
						                            </thead>
						                            <tbody>
                                                        @if($JurnalHeaderManualjml <= 0)
    						                            	<tr>
    						                            		<td colspan="10"><center>Data Tidak Ada</center></td>
    						                            	</tr>
						                            	@else
        						                            <?php
                                                                $i = 1;
                                                                $prev_kode_jurnalManual = '';
                                                            ?>
        						                            @foreach($JurnalHeaderManual as $row)
        						                            	<?php
                                                                    if($akun_perkiraan=="semua" or $akun_perkiraan ==""){
                                                                        $JurnalDetailManual = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
                                                                        $total_detailManual = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->count();
                                                                    } else {
                                                                        $JurnalDetailManual = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->get();
                                                                        $total_detailManual = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->count();
                                                                    }

        						                            	?>
        						                            	@foreach($JurnalDetailManual as $datajurnal)
            							                            <tr>
            							                                <td class="text-center">{!! $i++ !!}.</td>
                                                                        <?php
                                                                            if($row['kode_jurnal'] != $prev_kode_jurnalManual){
                                                                                echo '<td rowspan="'.$total_detailManual.'">'.$row['kode_jurnal'].'</td>';
                                                                            }
                                                                        ?>
            							                                <td class="text-center"><?php echo substr($row['tanggal'], 0,10); ?></td>
            							                                @if($datajurnal->posting==1)
                                                                        <td style="color:blue;"><center> Sudah diposting </center></td>
                                                                        @else
                                                                        <td style="color:red;"><center> Blm diposting </center></td>
                                                                        @endif
            							                                <?php
            							                                	$akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
            							                                ?>
            							                                <td>{!! $akun['kode_akun'] !!}</td>
            							                                <td>{!! $akun['nama_akun'] !!}</td>
            							                                <td>{!! $row->keterangan !!}</td>
            							                                <td class="text-right">Rp. <?php echo number_format($datajurnal->debet, '2');?></td>
            							                                <td class="text-right">Rp. <?php echo number_format($datajurnal->kredit, '2');?></td>
                                                                        <?php
                                                                            if($row['kode_jurnal'] != $prev_kode_jurnalManual){
                                                                                if($datajurnal->posting==1){
                                                                                    echo '<td rowspan="'.$total_detailManual.'"><input type="checkbox" disabled placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                                } else {
                                                                                    echo '<td rowspan="'.$total_detailManual.'"><input type="checkbox" placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <?php $prev_kode_jurnalManual = $row['kode_jurnal']; ?>
            							                            </tr>
        							                            @endforeach
        							                        @endforeach
                                                        @endif
						                            </tbody>
						                        </table>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-sm btn-danger mb5"><i class="ti-check mr5"></i>Posting</button>
                                                </div>
						                    </div>
										</div>
                                        </form>
									</div>
								</div>

								<div class="tab-pane fade" id="tabungan">
									<div class="row">
										<div class="col-md-6">
											<a href="#" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : {!! $JurnalHeaderTabunganjml !!}
											</div>
										</div>
									</div>
									<div class="row">
                                        <form class="form-horizontal" role="form" method="post" action="{!! url('akuntansi/jurnal/posting') !!}">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t editable-datatable">
						                            <thead>
							                            <tr>
							                               	<th class="text-center">No</th>
                                                            <th class="text-center">No. Transaksi</th>
                                                            <th class="text-center">Tanggal</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Akun</th>
                                                            <th class="text-center">Nama Akun</th>
                                                            <th class="text-center">Keterangan</th>
                                                            <th class="text-center">Debet</th>
                                                            <th class="text-center">Kredit</th>
                                                            <th><input type="checkbox" name="checkAll" id="TableTabungan"></th>
							                            </tr>
						                            </thead>
						                            <tbody>
                                                        @if($JurnalHeaderTabunganjml <= 0)
    						                            	<tr>
    						                            		<td colspan="10"><center>Data Tidak Ada</center></td>
    						                            	</tr>
						                            	@else
                                                            <?php
                                                                $i = 1;
                                                                $prev_kode_jurnalTabungan = '';
                                                            ?>
        						                            @foreach($JurnalHeaderTabungan as $row)
                                                                <?php
                                                                    if($akun_perkiraan=="semua" or $akun_perkiraan ==""){
                                                                        $JurnalDetailTabungan = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
                                                                        $total_detailTabungan = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->count();
                                                                    } else {
                                                                        $JurnalDetailTabungan = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->get();
                                                                        $total_detailTabungan = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->count();
                                                                    }

                                                                ?>
                                                                @foreach($JurnalDetailTabungan as $datajurnal)
                                                                    <tr>
                                                                        <td class="text-center">{!! $i++ !!}.</td>
                                                                        <?php
                                                                            if($row['kode_jurnal'] != $prev_kode_jurnalTabungan){
                                                                                echo '<td rowspan="'.$total_detailTabungan.'">'.$row['kode_jurnal'].'</td>';
                                                                            }
                                                                        ?>
                                                                        <td class="text-center"><?php echo substr($row['tanggal'], 0,10); ?></td>
                                                                        @if($datajurnal->posting==1)
                                                                        <td style="color:blue;"><center> Sudah diposting </center></td>
                                                                        @else
                                                                        <td style="color:red;"><center> Blm diposting </center></td>
                                                                        @endif
                                                                        <?php
                                                                            $akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
                                                                        ?>
                                                                        <td>{!! $akun['kode_akun'] !!}</td>
                                                                        <td>{!! $akun['nama_akun'] !!}</td>
                                                                        <td>{!! $row->keterangan !!}</td>
                                                                        <td class="text-right">Rp. <?php echo number_format($datajurnal->debet, '2');?></td>
                                                                        <td class="text-right">Rp. <?php echo number_format($datajurnal->kredit, '2');?></td>
                                                                        <?php
                                                                            if($row['kode_jurnal'] != $prev_kode_jurnalTabungan){
                                                                                if($datajurnal->posting==1){
                                                                                    echo '<td rowspan="'.$total_detailTabungan.'"><input type="checkbox" disabled placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                                } else {
                                                                                    echo '<td rowspan="'.$total_detailTabungan.'"><input type="checkbox" placeholder="" name="cbpilih['.$row->id.']"></td>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <?php $prev_kode_jurnalTabungan = $row['kode_jurnal']; ?>
                                                                    </tr>
                                                                @endforeach
    							                            @endforeach
                                                        @endif
						                            </tbody>
						                        </table>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-sm btn-danger mb5"><i class="ti-check mr5"></i>Posting</button>
                                                </div>
						                    </div>
										</div>
                                        </form>
									</div>
								</div>
								<div class="tab-pane fade" id="kredit">
									<div class="row">
										<div class="col-md-6">
											<a href="#" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : {!! $JurnalHeaderKreditjml !!}
											</div>
										</div>
									</div>
									<div class="row">
                                        <form class="form-horizontal" role="form" method="post" action="{!! url('akuntansi/jurnal/posting') !!}">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t editable-datatable">
						                            <thead>
							                            <tr>
							                               	<th class="text-center">No</th>
            												<th class="text-center">No. Transaksi</th>
                                                            <th class="text-center">Tanggal</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Akun</th>
                                                            <th class="text-center">Nama Akun</th>
                                                            <th class="text-center">Keterangan</th>
                                                            <th class="text-center">Debet</th>
                                                            <th class="text-center">Kredit</th>
                                                            <th><input type="checkbox" name="checkAll" id="TableKredit"></th>
							                            </tr>
						                            </thead>
						                            <tbody>
                                                        @if($JurnalHeaderKreditjml <= 0)
    						                            	<tr>
    						                            		<td colspan="10"><center>Data Tidak Ada</center></td>
    						                            	</tr>
						                            	@else
                                                            <?php
                                                                $i = 1;
                                                                $prev_kode_jurnalKredit = '';
                                                            ?>
        						                            @foreach($JurnalHeaderKredit as $row)
                                                                <?php
                                                                    if($akun_perkiraan=="semua" or $akun_perkiraan ==""){
                                                                        $JurnalDetailKredit = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
                                                                        $total_detailKredit = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->count();
                                                                    } else {
                                                                        $JurnalDetailKredit = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->get();
                                                                        $total_detailKredit = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->count();
                                                                    }
                                                                ?>
                                                                @foreach($JurnalDetailKredit as $datajurnal)
                                                                    <tr>
                                                                        <td class="text-center">{!! $i++ !!}.</td>
                                                                        <?php
                                                                            if($row['kode_jurnal'] != $prev_kode_jurnalKredit){
                                                                                echo '<td rowspan="'.$total_detailKredit.'">'.$row['kode_jurnal'].'</td>';
                                                                            }
                                                                        ?>
                                                                        <td class="text-center"><?php echo substr($row['tanggal'], 0,10); ?></td>
                                                                        @if($datajurnal->posting==1)
                                                                        <td style="color:blue;"><center> Sudah diposting </center></td>
                                                                        @else
                                                                        <td style="color:red;"><center> Blm diposting </center></td>
                                                                        @endif
                                                                        <?php
                                                                            $akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
                                                                        ?>
                                                                        <td>{!! $akun['kode_akun'] !!}</td>
                                                                        <td>{!! $akun['nama_akun'] !!}</td>
                                                                        <td>{!! $row->keterangan !!}</td>
                                                                        <td class="text-right">Rp. <?php echo number_format($datajurnal->debet, '2');?></td>
                                                                        <td class="text-right">Rp. <?php echo number_format($datajurnal->kredit, '2');?></td>
                                                                        <?php
                                                                            if($row['kode_jurnal'] != $prev_kode_jurnalKredit){
                                                                                if($datajurnal->posting==1){
                                                                                    echo '<td rowspan="'.$total_detailKredit.'"><input type="checkbox" disabled placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                                } else {
                                                                                    echo '<td rowspan="'.$total_detailKredit.'"><input type="checkbox" placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <?php $prev_kode_jurnalKredit = $row['kode_jurnal']; ?>
                                                                    </tr>
                                                                @endforeach
        							                        @endforeach
                                                        @endif
						                            </tbody>
						                        </table>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-sm btn-danger mb5"><i class="ti-check mr5"></i>Posting</button>
                                                </div>
						                    </div>
										</div>
                                        </form>
									</div>
								</div>
                                <!--
                                <div class="tab-pane fade" id="deposito">
									<div class="row">
										<div class="col-md-6">
											<a href="{url}/tabungan/cetak" target="_blank" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : {!! $JurnalHeaderDepositojml !!}
											</div>
										</div>
									</div>
									<div class="row">
                                        <form class="form-horizontal" role="form" method="post" action="{!! url('akuntansi/jurnal/posting') !!}">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t editable-datatable">
						                            <thead>
							                            <tr>
							                               	<th class="text-center">No</th>
                                                            <th class="text-center">No. Transaksi</th>
                                                            <th class="text-center">Tanggal</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Akun</th>
                                                            <th class="text-center">Nama Akun</th>
                                                            <th class="text-center">Keterangan</th>
                                                            <th class="text-center">Debet</th>
                                                            <th class="text-center">Kredit</th>
                                                            <th><input type="checkbox" name="checkAll" id="TableDeposito"></th>
							                            </tr>
						                            </thead>
						                            <tbody>
                                                        @if($JurnalHeaderDepositojml <= 0)
    						                            	<tr>
    						                            		<td colspan="10"><center>Data Tidak Ada</center></td>
    						                            	</tr>
						                            	@else
                                                            <?php
                                                                $i = 1;
                                                                $prev_kode_jurnalDeposito = '';
                                                            ?>
        						                            @foreach($JurnalHeaderDeposito as $row)
                                                                <?php
                                                                    if($akun_perkiraan=="semua" or $akun_perkiraan ==""){
                                                                        $JurnalDetailDeposito = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
                                                                        $total_detailDeposito = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->count();
                                                                    } else {
                                                                        $JurnalDetailDeposito = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->get();
                                                                        $total_detailDeposito = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->count();
                                                                    }
                                                                ?>
                                                                @foreach($JurnalDetailDeposito as $datajurnal)
                                                                    <tr>
                                                                        <td class="text-center">{!! $i++ !!}.</td>
                                                                        <?php
                                                                            if($row['kode_jurnal'] != $prev_kode_jurnalDeposito){
                                                                                echo '<td rowspan="'.$total_detailDeposito.'">'.$row['kode_jurnal'].'</td>';
                                                                            }
                                                                        ?>
                                                                        <td class="text-center"><?php echo substr($row['tanggal'], 0,10); ?></td>
                                                                        @if($datajurnal->posting==1)
                                                                        <td style="color:blue;"><center> Sudah diposting </center></td>
                                                                        @else
                                                                        <td style="color:red;"><center> Blm diposting </center></td>
                                                                        @endif
                                                                        <?php
                                                                            $akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
                                                                        ?>
                                                                        <td>{!! $akun['kode_akun'] !!}</td>
                                                                        <td>{!! $akun['nama_akun'] !!}</td>
                                                                        <td>{!! $row->keterangan !!}</td>
                                                                        <td class="text-right">Rp. <?php echo number_format($datajurnal->debet, '2');?></td>
                                                                        <td class="text-right">Rp. <?php echo number_format($datajurnal->kredit, '2');?></td>
                                                                        <?php
                                                                            if($row['kode_jurnal'] != $prev_kode_jurnalDeposito){
                                                                                if($datajurnal->posting==1){
                                                                                    echo '<td rowspan="'.$total_detailDeposito.'"><input type="checkbox" disabled placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                                } else {
                                                                                    echo '<td rowspan="'.$total_detailDeposito.'"><input type="checkbox" placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <?php $prev_kode_jurnalDeposito = $row['kode_jurnal']; ?>
                                                                    </tr>
                                                                @endforeach
        							                        @endforeach
                                                        @endif
						                            </tbody>
						                        </table>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-sm btn-danger mb5"><i class="ti-check mr5"></i>Posting</button>
                                                </div>
						                    </div>
										</div>
                                        </form>
									</div>
								</div>-->
								<div class="tab-pane fade" id="kas">
									<div class="row">
										<div class="col-md-6">
											<a href="#" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : {!! $JurnalHeaderKasjml !!}
											</div>
										</div>
									</div>
									<div class="row">
                                        <form class="form-horizontal" role="form" method="post" action="{!! url('akuntansi/jurnal/posting') !!}">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t editable-datatable">
						                            <thead>
							                            <tr>
							                                <th class="text-center">No</th>
                                                            <th class="text-center">No. Transaksi</th>
                                                            <th class="text-center">Tanggal</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Akun</th>
                                                            <th class="text-center">Nama Akun</th>
                                                            <th class="text-center">Keterangan</th>
                                                            <th class="text-center">Debet</th>
                                                            <th class="text-center">Kredit</th>
                                                            <th><input type="checkbox" name="checkAll" id="TableKas"></th>
							                            </tr>
						                            </thead>
						                            <tbody>
                                                        @if($JurnalHeaderKasjml <= 0)
    						                            	<tr>
    						                            		<td colspan="10"><center>Data Tidak Ada</center></td>
    						                            	</tr>
						                            	@else
        						                            <?php
                                                                $i = 1;
                                                                $prev_kode_jurnalKas = '';
                                                            ?>
        						                            @foreach($JurnalHeaderKas as $row)
                                                                <?php
                                                                    if($akun_perkiraan=="semua" or $akun_perkiraan ==""){
                                                                        $JurnalDetailKas = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
                                                                        $total_detailKas = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->count();
                                                                    } else {
                                                                        $JurnalDetailKas = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->get();
                                                                        $total_detailKas = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->count();
                                                                    }
                                                                ?>
                                                                @foreach($JurnalDetailKas as $datajurnal)
                                                                <tr>
                                                                    <td class="text-center">{!! $i++ !!}.</td>
                                                                    <?php
                                                                        if($row['kode_jurnal'] != $prev_kode_jurnalKas){
                                                                            echo '<td rowspan="'.$total_detailKas.'">'.$row['kode_jurnal'].'</td>';
                                                                        }
                                                                    ?>
                                                                    <td class="text-center"><?php echo substr($row['tanggal'], 0,10); ?></td>
                                                                    @if($datajurnal->posting==1)
                                                                    <td style="color:blue;"><center> Sudah diposting </center></td>
                                                                    @else
                                                                    <td style="color:red;"><center> Blm diposting </center></td>
                                                                    @endif
                                                                    <?php
                                                                        $akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
                                                                    ?>
                                                                    <td>{!! $akun['kode_akun'] !!}</td>
                                                                    <td>{!! $akun['nama_akun'] !!}</td>
                                                                    <td>{!! $row->keterangan !!}</td>
                                                                    <td class="text-right">Rp. <?php echo number_format($datajurnal->debet, '2');?></td>
                                                                    <td class="text-right">Rp. <?php echo number_format($datajurnal->kredit, '2');?></td>
                                                                    <?php
                                                                        if($row['kode_jurnal'] != $prev_kode_jurnalKas){
                                                                            if($datajurnal->posting==1){
                                                                                echo '<td rowspan="'.$total_detailKas.'"><input type="checkbox" disabled placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                            } else {
                                                                                echo '<td rowspan="'.$total_detailKas.'"><input type="checkbox" placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <?php $prev_kode_jurnalKas = $row['kode_jurnal']; ?>
                                                                </tr>
                                                                @endforeach
        							                        @endforeach
                                                        @endif
						                            </tbody>
						                        </table>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-sm btn-danger mb5"><i class="ti-check mr5"></i>Posting</button>
                                                </div>
						                    </div>
										</div>
                                        </form>
									</div>
								</div>
								<div class="tab-pane fade" id="semua">
									<div class="row">
										<div class="col-md-6">
											<a href="#" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data : {!! $JurnalHeaderAlljml !!}
											</div>
										</div>
									</div>
									<div class="row">
                                        <form class="form-horizontal" role="form" method="post" action="{!! url('akuntansi/jurnal/posting') !!}">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t editable-datatable">
						                            <thead>
							                            <tr>
							                               	<th class="text-center">No</th>
                                                            <th class="text-center">No. Transaksi</th>
                                                            <th class="text-center">Tanggal</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Akun</th>
                                                            <th class="text-center">Nama Akun</th>
                                                            <th class="text-center">Keterangan</th>
                                                            <th class="text-center">Debet</th>
                                                            <th class="text-center">Kredit</th>
                                                            <th><input type="checkbox" name="checkAll" id="TableAll"></th>
							                            </tr>
						                            </thead>
						                            <tbody>
                                                        @if($JurnalHeaderAlljml <= 0)
    						                            	<tr>
    						                            		<td colspan="10"><center>Data Tidak Ada</center></td>
    						                            	</tr>
						                            	@else
                                                            <?php
                                                                $i = 1;
                                                                $prev_kode_jurnalAll = '';
                                                            ?>
        						                            @foreach($JurnalHeaderAll as $row)
                                                                <?php
                                                                    if($akun_perkiraan=="semua" or $akun_perkiraan ==""){
                                                                        $JurnalDetailAll = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
                                                                        $total_detailAll = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->count();
                                                                    } else {
                                                                        $JurnalDetailAll = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->get();
                                                                        $total_detailAll = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->count();
                                                                    }

                                                                ?>
                                                                @foreach($JurnalDetailAll as $datajurnal)
        							                            <tr>
        							                                <td class="text-center">{!! $i++ !!}.</td>
                                                                    <?php
                                                                        if($row['kode_jurnal'] != $prev_kode_jurnalAll){
                                                                            echo '<td rowspan="'.$total_detailAll.'">'.$row['kode_jurnal'].'</td>';
                                                                        }
                                                                    ?>
        							                                <td class="text-center"><?php echo substr($row['tanggal'], 0,10); ?></td>
        							                                @if($datajurnal->posting==1)
                                                                    <td style="color:blue;"><center> Sudah diposting </center></td>
                                                                    @else
                                                                    <td style="color:red;"><center> Blm diposting </center></td>
                                                                    @endif
        							                                <?php
        							                                	$akun = App\Model\Akuntansi\Perkiraan::find($datajurnal->id_akun);
        							                                ?>
        							                                <td>{!! $akun['kode_akun'] !!}</td>
        							                                <td>{!! $akun['nama_akun'] !!}</td>
        							                                <td>{!! $row->keterangan !!}</td>
        							                                <td class="text-right">Rp. <?php echo number_format($datajurnal->debet, '2');?></td>
        							                                <td class="text-right">Rp. <?php echo number_format($datajurnal->kredit, '2');?></td>
                                                                    <?php
                                                                        if($row['kode_jurnal'] != $prev_kode_jurnalAll){
                                                                            if($datajurnal->posting==1){
                                                                                echo '<td rowspan="'.$total_detailAll.'"><input type="checkbox" disabled placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                            } else {
                                                                                echo '<td rowspan="'.$total_detailAll.'"><input type="checkbox" placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <?php $prev_kode_jurnalAll = $row['kode_jurnal']; ?>
        							                            </tr>
        							                            @endforeach
							                                @endforeach
                                                        @endif
						                            </tbody>
						                        </table>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-sm btn-danger mb5"><i class="ti-check mr5"></i>Posting</button>
                                                </div>
						                    </div>
										</div>
                                        </form>
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

<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:red">Peringatan</h4>
      </div>
	  <div class="modal-body">
		  <p>Format nomor untuk Jurnal Manual belum disetting</p>
	  </div>
      <div class="modal-footer">
        <a href="{{url('pengaturan/nomor')}}" type="button" class="btn btn-primary">Klik disini untuk setting</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

    function ceknomor(){
       $.ajax({
           url: "{!! url('akuntansi/jurnal/ceknomor') !!}",
           data: {},
           dataType: "json",
           type: "get",
           success:function(data)
           {
               if (data[0]["stat"] == "kosong") {
                   $('#rejectModal').modal();
               } else {
                       location.href = "{!! url('akuntansi/jurnal/create') !!}";
               }
           }

       });
    };

	$('#search_form .input-daterange').datepicker({
		format: "yyyy-mm-dd",
		todayHighlight: true,
		autoclose: true
	});

    $('#TableManual').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
    $('#TableAll').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
    $('#TableTabungan').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
    $('#TableKredit').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
    // $('#TableDeposito').click(function (e) {
    //     $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    // });
    $('#TableKas').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
</script>
@stop
