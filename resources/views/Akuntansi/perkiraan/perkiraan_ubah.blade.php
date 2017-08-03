@extends('layouts.master')

@section('content')
<ol class="breadcrumb">
	<li>
		<a href="javascript:;"><i class="ti-home mr5"></i></a>
	</li>
	<li>
		<a href="javascript:;">Master</a>
	</li>
	<li class="active"><a href="{!! url('akuntansi/perkiraan') !!}">Daftar Perkiraan</a></li>
	<li class="active">Tambah</li>
</ol>
<div class="row">

	<div class="col-md-12">
		<section class="panel no-b">
			<div class="panel-body">
				<form role="form" class="form-horizontal" method="post" action="{!! url('akuntansi/perkiraan/update/'.$values->id) !!}" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="kode" class="col-sm-3 control-label">Tipe Akun</label>
								<div class="col-sm-9">
									<div class="radio">
										<label><input name="tipe_akun" type="radio" value="header" <?php if($values->tipe_akun=='header'){ ?> checked <?php } ?>>Header (Akun tidak dapat diposting)</label>
									</div>
									<div class="radio">
										<label><input name="tipe_akun" type="radio" value="detail" <?php if($values->tipe_akun=='detail'){ ?> checked <?php } ?>>Detail (Akun dapat diposting)</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="kelompok" class="col-sm-3 control-label">Kelompok</label>
								<div class="col-sm-9">
									<select name="kelompok" class="form-control" id="kelompok" placeholder="Kelompok">
										@foreach($perkiraan as $perkiraans)
										<option value="{!! $perkiraans->kelompok !!}" <?php if($perkiraans->id==$values->kelompok){ ?> selected <?php }?> >{!! $perkiraans->kelompok !!}.{!! $perkiraans->nama_akun !!}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="parent" class="col-sm-3 control-label">Posisi di bawah</label>
								<div class="col-sm-9">
									<div id="headers">
									<select name="header" class="form-control" id="header" placeholder="header">
											@foreach($header as $headers)
											<option value="{!! $headers->id !!}" <?php if($headers->id==$values->parent){ ?> selected <?php }?>>{!! $headers->kode_akun !!} - {!! $headers->nama_akun !!}</option>
											@endforeach
									</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="kode_akun" class="col-sm-3 control-label">Kode akun</label>
								<div class="col-sm-9">
									<div id="kelompok_akun" style="float:left;display:inline;width:10%;">
									<input type="text" name="kelompok_akun" class="form-control" disabled value="{!! $values->kelompok !!}">
									</div>
									<div style="margin-left:10%;">
									<input type="text" name="kode_akun" required class="form-control" id="kode_akun" placeholder="Kode akun"  style="display:inline;width:100%;" value="{!! $values->kode_akun!!}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="nama_akun" class="col-sm-3 control-label">Nama akun</label>
								<div class="col-sm-9">
									<input type="text" name="nama_akun" required class="form-control" id="nama_akun" placeholder="Nama akun" value="{!! $values->nama_akun!!}">
								</div>
							</div>
							<div class="form-group">
								<label for="kas" class="col-sm-3 control-label">Akun adalah kas</label>
								<div class="col-sm-9">
									<div class="checkbox">
										<label><input name="kas" type="checkbox" value="1" <?php if($values->kas == '1'){ ?> checked <?php } ?> >&nbsp;</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<label for="tanggal_lahir" class="col-sm-3 control-label"></label>
								<div class="col-sm-2">
									<input type="submit" class="btn btn-primary btn-block" name="save" value="Save">
								</div>
								<div class="col-sm-2">
									<a href="{{ url('akuntansi/perkiraan') }}" id="cancel" class="btn btn-danger btn-block">Cancel</a>
								</div>
							</div>
						</div>

					</div>
			</div>
		</section>
	</div>
</div>

<script>
        $('#kelompok').change(function() {
            $('#headers').load("{!! url('akuntansi/perkiraan/headersget') !!}/"+ $(this).val());
            $('#kelompok_akun').load("{!! url('akuntansi/perkiraan/kelompokget') !!}/"+ $(this).val());
        });
</script>
@stop
