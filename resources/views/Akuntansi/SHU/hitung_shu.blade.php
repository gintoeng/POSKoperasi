@extends('layouts.master')

@section('content')

<ol class="breadcrumb">
    <li>
        <a href="javascript:;"><i class="ti-home mr5"></i></a>
    </li>
    <li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active">Hitung SHU</li>
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
					<div class="col-md-12">
						<form role="form" class="form-horizontal" method="get" action="{!! url('akuntansi/hitungshu/cek') !!}">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="tahun_shu" class="col-sm-5 control-label">Tahun SHU</label>
									<div class="col-sm-5">
										<input name="tahun_shu" id="tahun" type="number" class="form-control" value="{!! $tahunterpilih !!}">
									</div>
									<input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="col-sm-2">
										<button type="submit" class="btn btn-sm btn-info"><i class="ti-settings mr5"></i> Cek</button>
									</div>
								</div>
							</div>
						</div>
						</form>
						<form role="form" class="form-horizontal" method="post" action="{!! url('akuntansi/hitungshu/store') !!}">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="jumlah_shu" class="col-sm-5 control-label">Jumlah SHU</label>
										<div class="col-sm-7">
											<input name="jumlah_shu" value="<?php echo number_format($jumlahshu, '2'); ?>" id="jumlah_shu" type="text" placeholder="0.00" readonly class="form-control" style="text-align:right;">
										</div>
									</div>
									<input type="hidden" name="tahun" value="{!! $tahunterpilih !!}">
									<div class="form-group">
										<label for="tanggal_pembagian" class="col-sm-5 control-label">Tanggal Pembagian</label>
										<div class="col-sm-7">
											<div class="input-group">
												<input name="tanggal_pembagian" type="text" class="form-control datepicker" id="tanggal_pembagian" placeholder="Tanggal Pembagian" value="{!! $tanggal_pembagian !!}">
												<span class="input-group-addon"><i class="ti-calendar"></i></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="dana_cadangan" class="col-sm-5 control-label">Dana Cadangan</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input name="dana_cadangan_persen" value="{!! $danacadangan_persen !!}" type="text" class="form-control" id="dana_cadangan_persen" placeholder="0" style="text-align:right">
												<span class="input-group-addon">%</span>
											</div>
										</div>
										<div class="col-md-4">
											<input name="dana_cadangan_rp" value="{!! $danacadangan_rp !!}" id="dana_cadangan_rp" readonly type="text" class="form-control" style="text-align:right">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="shu_anggota" class="col-sm-5 control-label">SHU Anggota</label>
												<div class="col-sm-3">
													<div class="input-group">
														<input name="shu_anggota_persen" value="{!! $shuanggota_persen !!}" type="text" class="form-control" id="shu_anggota_persen" placeholder="0" style="text-align:right">
														<span class="input-group-addon">%</span>
													</div>
												</div>
												<div class="col-md-4">
													<input name="shu_anggota_rp" value="{!! $shuanggota_rp !!}" id="shu_anggota_rp" readonly type="text" class="form-control" style="text-align:right">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="jasa_usaha" class="col-sm-3 control-label">Jasa Usaha</label>
												<div class="col-sm-3">
													<div class="input-group">
														<input name="jasa_usaha_persen" value="{!! $jasausaha_persen !!}" type="text" class="form-control" id="jasa_usaha_persen" placeholder="0" style="text-align:right">
														<span class="input-group-addon">%</span>
													</div>
												</div>
												<div class="col-md-4">
													<input name="jasa_usaha_rp" id="jasa_usaha_rp" value="{!! $jasausaha_rp !!}" readonly type="text" class="form-control" style="text-align:right">
												</div>
											</div>
											<div class="form-group">
												<label for="jasa_modal" class="col-sm-3 control-label">Jasa Modal</label>
												<div class="col-sm-3">
													<div class="input-group">
														<input name="jasa_modal_persen" value="{!! $jasamodal_persen !!}" type="text" class="form-control" id="jasa_modal_persen" placeholder="0" style="text-align:right">
														<span class="input-group-addon">%</span>
													</div>
												</div>
												<div class="col-md-4">
													<input name="jasa_modal_rp" id="jasa_modal_rp" value="{!! $jasamodal_rp !!}" readonly type="text" class="form-control" style="text-align:right">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="dana_pengurus" class="col-sm-5 control-label">Dana Pengurus</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input name="dana_pengurus_persen" value="{!! $danapengurus_persen !!}" type="text" class="form-control" id="dana_pengurus_persen" placeholder="0" style="text-align:right">
												<span class="input-group-addon">%</span>
											</div>
										</div>
										<div class="col-md-4">
											<input name="dana_pengurus_rp" value="{!! $danapengurus_rp !!}" id="dana_pengurus_rp" readonly type="text" class="form-control" style="text-align:right">
										</div>
									</div>
									<div class="form-group">
										<label for="dana_karyawan" class="col-sm-5 control-label">Dana Karyawan</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input name="dana_karyawan_persen" value="{!! $danakaryawan_persen !!}" type="text" class="form-control" id="dana_karyawan_persen" placeholder="0" style="text-align:right">
												<span class="input-group-addon">%</span>
											</div>
										</div>
										<div class="col-md-4">
											<input name="dana_karyawan_rp" id="dana_karyawan_rp" value="{!! $danakaryawan_rp !!}" readonly type="text" class="form-control" style="text-align:right">
										</div>
									</div>
									<div class="form-group">
										<label for="dana_pendidikan" class="col-sm-5 control-label">Dana Pendidikan</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input name="dana_pendidikan_persen" value="{!! $danapendidikan_persen !!}" type="text" class="form-control" id="dana_pendidikan_persen" placeholder="0" style="text-align:right">
												<span class="input-group-addon">%</span>
											</div>
										</div>
										<div class="col-md-4">
											<input name="dana_pendidikan_rp" id="dana_pendidikan_rp" value="{!! $danapendidikan_rp !!}" readonly type="text" class="form-control" style="text-align:right">
										</div>
									</div>
									<div class="form-group">
										<label for="dana_sosial" class="col-sm-5 control-label">Dana Sosial</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input name="dana_sosial_persen" value="{!! $danasosial_persen !!}" type="text" class="form-control" id="dana_sosial_persen" placeholder="0" style="text-align:right">
												<span class="input-group-addon">%</span>
											</div>
										</div>
										<div class="col-md-4">
											<input name="dana_sosial_rp" id="dana_sosial_rp" value="{!! $danasosial_rp !!}" readonly type="text" class="form-control" style="text-align:right">
										</div>
									</div>
									<div class="form-group">
										<label for="dana_pembangunan" class="col-sm-5 control-label">Dana Pembangunan</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input name="dana_pembangunan_persen" value="{!! $danapembangunan_persen !!}" type="text" class="form-control" id="dana_pembangunan_persen" placeholder="0" style="text-align:right">
												<span class="input-group-addon">%</span>
											</div>
										</div>
										<div class="col-md-4">
											<input name="dana_pembangunan_rp" id="dana_pembangunan_rp" value="{!! $danapembangunan_rp !!}" readonly type="text" class="form-control" style="text-align:right">
										</div>
									</div>
									<div class="form-group">
										<label for="dana_lain2" class="col-sm-5 control-label">Dana Lain-lain</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input name="dana_lain2_persen" value="{!! $danadll_persen !!}" type="text" class="form-control" id="dana_lain2_persen" placeholder="0" style="text-align:right">
												<span class="input-group-addon">%</span>
											</div>
										</div>
										<div class="col-md-4">
											<input name="dana_lain2_rp" id="dana_lain2_rp" value="{!! $danadll_rp !!}" readonly type="text" class="form-control" style="text-align:right">
										</div>
									</div>
                                    <div class="form-group">
										<label for="dana_lain2" class="col-sm-5 control-label">Total Akhir</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input name="total_akhir_persen" value="{!! $totalakhir_persen !!}" type="text" class="form-control" readonly id="total_akhir_persen" placeholder="0" style="text-align:right">
												<span class="input-group-addon">%</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="tanggal_lahir" class="col-sm-3 control-label"></label>
										<div class="col-sm-3">
                                            @if($isempty == "yes")
											    <a href="{!! url('akuntansi/hitungshu/hapus/'.$idshusimpan) !!}" disabled class="btn btn-danger btn-block">Hapus SHU</a>
                                            @else
                                                <a href="{!! url('akuntansi/hitungshu/hapus/'.$idshusimpan) !!}" class="btn btn-danger btn-block">Hapus SHU</a>
                                            @endif
										</div>
										<div class="col-sm-3">
                                            @if($isempty == "yes")
                                                <a onclick="$('#rejectModal').modal();" class="btn btn-info btn-block" name="bagi">Pembagian SHU</a>
                                            @else
                                                <a href="{!! url('akuntansi/hitungshu/bagishu/'.$idshusimpan) !!}" class="btn btn-info btn-block" name="bagi">Pembagian SHU</a>
                                            @endif
                                        </div>
                                        <div class="col-sm-3">
											<button type="submit" class="btn btn-primary btn-block" name="save">Simpan</button>
										</div>
									</div>
								</div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="jasa_modal" class="col-sm-3 control-label">Total Akhir</label>
                                        <div class="col-sm-3">
                                            <div class="input-group">
                                                <input name="totalakhiranggota_persen" value="{!! $totalakhiranggota_persen !!}" type="text" class="form-control" id="totalakhiranggota_persen" readonly placeholder="0" style="text-align:right">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
						</form>
					</div>
				</div>

				</div>
			</section>
		</div>
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
		  <p>Simpan pengaturan SHU terlebih dahulu sebelum membagikannya.</p>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>

<script>

    var dana_cadangan_persen = 0;
    var shu_anggota_persen = 0;
    var dana_karyawan_persen = 0;
    var dana_pengurus_persen = 0;
    var dana_pendidikan_persen = 0;
    var dana_sosial_persen = 0;
    var dana_pembangunan_persen = 0;
    var dana_lain2_persen = 0;
    var shu_anggota_rp = 0;

    var jasa_usaha_persen = 0;
    var jasa_usaha_rp = 0;
    var jasa_modal_persen = 0;
    var jasa_modal_rp = 0;

    $("input[name='dana_cadangan_persen']").keyup(function (e) {
        persenan_dana_cadangan($(this));
        total_persen();
    });

    function persenan_dana_cadangan(el) {
        var jumlahshu = <?php echo json_encode($jumlahshu) ?>;

        var dana_cadangan_rp = 0;
		$("input[name='dana_cadangan_persen']").each(function (k,v) {
			dana_cadangan_persen = parseInt(v.value);
            dana_cadangan_rp = jumlahshu * dana_cadangan_persen /100;
		});

		var dana_cadangan_rpfix = dana_cadangan_rp.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

        document.getElementById("dana_cadangan_rp").value = dana_cadangan_rpfix;
	}

    $("input[name='shu_anggota_persen']").keyup(function (e) {
        pesenan_shu_anggota($(this));
        total_persen();

        persenan_jasa_usaha($(this));
        persenan_jasa_modal($(this));
    });

    function pesenan_shu_anggota(el) {
        var jumlahshu = <?php echo json_encode($jumlahshu) ?>;

		$("input[name='shu_anggota_persen']").each(function (k,v) {
			shu_anggota_persen = parseInt(v.value);
            shu_anggota_rp = jumlahshu * shu_anggota_persen /100;
		});

		var shu_anggota_rpfix = shu_anggota_rp.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

        document.getElementById("shu_anggota_rp").value = shu_anggota_rpfix;
	}

    $("input[name='dana_pengurus_persen']").keyup(function (e) {
        persenan_dana_pengurus($(this));
        total_persen();
    });

    function persenan_dana_pengurus(el) {
        var jumlahshu = <?php echo json_encode($jumlahshu) ?>;

        var dana_pengurus_rp = 0;
		$("input[name='dana_pengurus_persen']").each(function (k,v) {
			dana_pengurus_persen = parseInt(v.value);
            dana_pengurus_rp = jumlahshu * dana_pengurus_persen /100;
		});

		var dana_pengurus_rpfix = dana_pengurus_rp.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

        document.getElementById("dana_pengurus_rp").value = dana_pengurus_rpfix;
	}

    $("input[name='dana_karyawan_persen']").keyup(function (e) {
        persenan_dana_karyawan($(this));
        total_persen();
    });

    function persenan_dana_karyawan(el) {
        var jumlahshu = <?php echo json_encode($jumlahshu) ?>;

        var dana_karyawan_rp = 0;
		$("input[name='dana_karyawan_persen']").each(function (k,v) {
			dana_karyawan_persen = parseInt(v.value);
            dana_karyawan_rp = jumlahshu * dana_karyawan_persen /100;
		});

		var dana_karyawan_rpfix = dana_karyawan_rp.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

        document.getElementById("dana_karyawan_rp").value = dana_karyawan_rpfix;
	}

    $("input[name='dana_pendidikan_persen']").keyup(function (e) {
        persenan_dana_pendidikan($(this));
        total_persen();
    });

    function persenan_dana_pendidikan(el) {
        var jumlahshu = <?php echo json_encode($jumlahshu) ?>;

        var dana_pendidikan_rp = 0;
		$("input[name='dana_pendidikan_persen']").each(function (k,v) {
			dana_pendidikan_persen = parseInt(v.value);
            dana_pendidikan_rp = jumlahshu * dana_pendidikan_persen /100;
		});

		var dana_pendidikan_rpfix = dana_pendidikan_rp.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

        document.getElementById("dana_pendidikan_rp").value = dana_pendidikan_rpfix;
	}

    $("input[name='dana_sosial_persen']").keyup(function (e) {
        persenan_dana_sosial($(this));
        total_persen();
    });

    function persenan_dana_sosial(el) {
        var jumlahshu = <?php echo json_encode($jumlahshu) ?>;

        var dana_sosial_rp = 0;
		$("input[name='dana_sosial_persen']").each(function (k,v) {
			dana_sosial_persen = parseInt(v.value);
            dana_sosial_rp = jumlahshu * dana_sosial_persen /100;
		});

		var dana_sosial_rpfix = dana_sosial_rp.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

        document.getElementById("dana_sosial_rp").value = dana_sosial_rpfix;
	}

    $("input[name='dana_pembangunan_persen']").keyup(function (e) {
        persenan_dana_pembangunan($(this));
        total_persen();
    });

    function persenan_dana_pembangunan(el) {
        var jumlahshu = <?php echo json_encode($jumlahshu) ?>;

        var dana_pembangunan_rp = 0;
		$("input[name='dana_pembangunan_persen']").each(function (k,v) {
			dana_pembangunan_persen = parseInt(v.value);
            dana_pembangunan_rp = jumlahshu * dana_pembangunan_persen /100;
		});

		var dana_pembangunan_rpfix = dana_pembangunan_rp.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

        document.getElementById("dana_pembangunan_rp").value = dana_pembangunan_rpfix;
	}

    $("input[name='dana_lain2_persen']").keyup(function (e) {
        persenan_dana_lain2($(this));
        total_persen();
    });

    function persenan_dana_lain2(el) {
        var jumlahshu = <?php echo json_encode($jumlahshu) ?>;

        var dana_lain2_rp = 0;
		$("input[name='dana_lain2_persen']").each(function (k,v) {
			dana_lain2_persen = parseInt(v.value);
            dana_lain2_rp = jumlahshu * dana_lain2_persen /100;
		});

		var dana_lain2_rpfix = dana_lain2_rp.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

        document.getElementById("dana_lain2_rp").value = dana_lain2_rpfix;
	}

    function total_persen() {
        var total_persen = dana_cadangan_persen + shu_anggota_persen + dana_karyawan_persen + dana_pengurus_persen + dana_pendidikan_persen + dana_sosial_persen + dana_pembangunan_persen + dana_lain2_persen;

        document.getElementById("total_akhir_persen").value = total_persen;
    }


    $("input[name='jasa_usaha_persen']").keyup(function (e) {
        persenan_jasa_usaha($(this));
        total_persen_jasa();
    });

    function persenan_jasa_usaha(el) {
		$("input[name='jasa_usaha_persen']").each(function (k,v) {
			jasa_usaha_persen = parseInt(v.value);
            jasa_usaha_rp = shu_anggota_rp * jasa_usaha_persen /100;
		});

		var jasa_usaha_rpfix = jasa_usaha_rp.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

        document.getElementById("jasa_usaha_rp").value = jasa_usaha_rpfix;
	}

    $("input[name='jasa_modal_persen']").keyup(function (e) {
        persenan_jasa_modal($(this));
        total_persen_jasa();
    });

    function persenan_jasa_modal(el) {
		$("input[name='jasa_modal_persen']").each(function (k,v) {
			jasa_modal_persen = parseInt(v.value);
            jasa_modal_rp = shu_anggota_rp * jasa_modal_persen /100;
		});

		var jasa_modal_rpfix = jasa_modal_rp.toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});

        document.getElementById("jasa_modal_rp").value = jasa_modal_rpfix;
	}

    function total_persen_jasa() {
        var total_persen_jasa = jasa_usaha_persen + jasa_modal_persen;

        document.getElementById("totalakhiranggota_persen").value = total_persen_jasa;
    }
</script>
@stop
