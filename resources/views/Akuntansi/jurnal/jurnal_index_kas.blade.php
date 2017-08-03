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
					<form class="form-horizontal" role="form" method="get" action="{!! url('akuntansi/jurnal/search/kas') !!}">
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
                                @if($status=="index")
                                <li class=""><a href="{{url('akuntansi/jurnal/semua')}}">Semua</a></li>
                                <li class=""><a href="{{url('akuntansi/jurnal')}}">Manual</a></li>
								<li class=""><a href="{{url('akuntansi/jurnal/simpanan')}}">Simpanan</a></li>
								<li class=""><a href="{{url('akuntansi/jurnal/pinjaman')}}" >Pinjaman</a></li>
								<li class="active"><a href="#kas" data-toggle="tab">Kas</a></li>
									<li class=""><a href="{{url('akuntansi/jurnal/waserda')}}">Waserda</a></li>
                                @elseif($status=="cari")
                                <li class=""><a href="{{url('akuntansi/jurnal/search/semua?kata_kunci='.$kata_kunci.'&'.'akun_perkiraan='.$akun_perkiraan.'&'.'posting='.$posting.'&'.'datefrom='.$date1.'&'.'dateto='.$date2)}}">Semua</a></li>
                                <li class=""><a href="{{url('akuntansi/jurnal/search?kata_kunci='.$kata_kunci.'&'.'akun_perkiraan='.$akun_perkiraan.'&'.'posting='.$posting.'&'.'datefrom='.$date1.'&'.'dateto='.$date2)}}">Manual</a></li>
								<li class=""><a href="{{url('akuntansi/jurnal/search/simpanan?kata_kunci='.$kata_kunci.'&'.'akun_perkiraan='.$akun_perkiraan.'&'.'posting='.$posting.'&'.'datefrom='.$date1.'&'.'dateto='.$date2)}}">Simpanan</a></li>
								<li class=""><a href="{{url('akuntansi/jurnal/search/pinjaman?kata_kunci='.$kata_kunci.'&'.'akun_perkiraan='.$akun_perkiraan.'&'.'posting='.$posting.'&'.'datefrom='.$date1.'&'.'dateto='.$date2)}}">Pinjaman</a></li>
								<li class="active"><a href="#kas" data-toggle="tab">Kas</a></li>
									<li class=""><a href="{{url('akuntansi/jurnal/search/waserda?kata_kunci='.$kata_kunci.'&'.'akun_perkiraan='.$akun_perkiraan.'&'.'posting='.$posting.'&'.'datefrom='.$date1.'&'.'dateto='.$date2)}}">Waserda</a></li>
                                @endif
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="kas">
									<div class="row">
										<div class="col-md-6">
											<a target="_blank" href="{{url('akuntansi/jurnal/cetak/Kas/'.$status.'?kata_kunci='.$kata_kunci.'&'.'akun_perkiraan='.$akun_perkiraan.'&'.'posting='.$posting.'&'.'datefrom='.$date1.'&'.'dateto='.$date2)}}" class="btn btn-sm btn-info mb5"><i class="ti-printer mr5"></i>Cetak</a>
										</div>
										<div class="col-md-6">
											<div class="pull-right">
												Total data dalam semua transaksi : {!! $JurnalHeaderKASjml !!}
											</div>
										</div>
									</div>
									<div class="row">
                                        <form class="form-horizontal" role="form" method="post" action="{!! url('akuntansi/jurnal/posting') !!}" id="formsubmit">
										<div class="col-md-12">
											<div class="table-responsive no-border">
						                        <table class="table table-bordered table-striped mg-t">
						                            <thead>
                                                        <tr class="bg-color">
							                                <th class="text-center">No</th>
                                                            <th class="text-center">No. Transaksi</th>
                                                            <th class="text-center">Tanggal</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Akun</th>
                                                            <th class="text-center">Nama Akun</th>
                                                            <th class="text-center">Keterangan</th>
                                                            <th class="text-center">Debet</th>
                                                            <th class="text-center">Kredit</th>
                                                            <th><input type="checkbox" name="checkAll" id="TableKAS"></th>
							                            </tr>
						                            </thead>
						                            <tbody>
                                                        @if($JurnalHeaderKASjml <= 0)
    						                            	<tr>
    						                            		<td colspan="10"><center>Data Tidak Ada</center></td>
    						                            	</tr>
						                            	@else
        						                            <?php
                                                                $i = ($JurnalHeaderKAS->currentPage() - 1) * $JurnalHeaderKAS->perPage() + 1;
                                                                $prev_kode_jurnalKAS = '';
                                                            ?>
        						                            @foreach($JurnalHeaderKAS as $row)
        						                            	<?php
                                                                    if($akun_perkiraan=="semua" or $akun_perkiraan ==""){
                                                                        $JurnalDetailKAS = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->get();
                                                                        $total_detailKAS = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->count();
                                                                    } else {
                                                                        $JurnalDetailKAS = App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->get();
                                                                        $total_detailKAS= App\Model\Akuntansi\JurnalDetail::where('id_header', $row->id)->where('id_akun', $akun_perkiraan)->count();
                                                                    }

        						                            	?>
        						                            	@foreach($JurnalDetailKAS as $datajurnal)
            							                            <tr>
                                                                        <?php
                                                                            if($row['kode_jurnal'] != $prev_kode_jurnalKAS){
                                                                                echo '<td class="text-center" rowspan="'.$total_detailKAS.'">'.$i++.'.</td>';
                                                                                echo '<td rowspan="'.$total_detailKAS.'">'.$row['kode_jurnal'].'</td>';
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
                                                                            if($row['kode_jurnal'] != $prev_kode_jurnalKAS){
                                                                                if($datajurnal->posting==1){
                                                                                    echo '<td rowspan="'.$total_detailKAS.'"><input type="checkbox" disabled placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                                } else {
                                                                                    echo '<td rowspan="'.$total_detailKAS.'"><input type="checkbox" placeholder="" name="cbpilih['.$row->id.']"/></td>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                        <?php $prev_kode_jurnalKAS = $row['kode_jurnal']; ?>
            							                            </tr>
        							                            @endforeach
        							                        @endforeach
                                                        @endif
						                            </tbody>
						                        </table>
                                                <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="form-group pull-right">
                                                                @if($status=="index")
                                                                {{ $JurnalHeaderKAS->links() }}
                                                                @elseif($status=="cari")
                                                                {!! str_replace('?','?kata_kunci='.$kata_kunci.'&'.'akun_perkiraan='.$akun_perkiraan.'&'.'posting='.$posting.'&'.'datefrom='.$date1.'&'.'dateto='.$date2.'&',$JurnalHeaderKAS->links()) !!}
                                                                @endif
                            								</div>
                                                        </div>
                                						<div class="col-md-1">
                                							<div class="form-group pull-right" style="margin-right:2%;margin-top:25%;">
																<a href="javascript:void(0)"><button type="button" id="buttonsubmit" class="btn btn-sm btn-{{\Illuminate\Support\Facades\Auth::user()->posting == 1 ? 'danger' : ''}} mb5" {{\Illuminate\Support\Facades\Auth::user()->posting == 1 ? '' : 'disabled'}}><i class="ti-check mr5"></i>Posting</button></a>
                            								</div>
                                						</div>
                                                </div>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
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

<div class="modal fade" id="rejectModalPOS" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #00ccff;color: white">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Posting Jurnal</h4>
      </div>
      <div class="modal-body">
          <p>Apakah anda yakin ingin memposting transaksi jurnal?</p>
      </div>
      <div class="modal-footer">
        <button id="submit" class="btn btn-primary">Ya, Posting!</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

    $('#buttonsubmit').click(function() {
        $('#rejectModalPOS').modal();
    });

    $('#submit').click(function(){
        $('#formsubmit').submit();
    });

	$('#search_form .input-daterange').datepicker({
		format: "yyyy-mm-dd",
		todayHighlight: true,
		autoclose: true
	});

    $('#TableKAS').click(function (e) {
        $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });
</script>
@stop
