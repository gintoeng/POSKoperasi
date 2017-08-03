@extends('layouts.master')

@section('content')
<ol class="breadcrumb">
	<li>
		<a href="javascript:;"><i class="ti-home mr5"></i></a>
	</li>
	<li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active"><a href="{!! url('akuntansi/perkiraan') !!}">Daftar Perkiraan</a></li>
	<li class="active">Tambah</li>
</ol>
<div class="row">

	<div class="col-md-12">
		<section class="panel no-b">
			<div class="panel-body">
				<form role="form" class="form-horizontal" method="post" action="{!! url('akuntansi/perkiraan/store') !!}" enctype="multipart/form-data">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="kode" class="col-sm-3 control-label">Tipe Akun</label>
								<div class="col-sm-9">
									<div class="radio">
										<label><input name="tipe_akun" type="radio" value="header" checked>Header (Akun tidak dapat diposting)</label>
									</div>
									<div class="radio">
										<label><input name="tipe_akun" type="radio" value="detail">Detail (Akun dapat diposting)</label>
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
											<option value="{!! $headers->id !!}" <?php if($headers->id==$values->id){ ?> selected <?php }?>>{!! $headers->kode_akun !!} - {!! $headers->nama_akun !!}</option>
											@endforeach
									</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="kode_akun" class="col-sm-3 control-label">Kode akun</label>
								<div class="col-sm-2">
									<div id="kelompok_akun">
										<input type="text" name="kelompok_akun" class="form-control" style="text-align:right;" readonly value="{{$values->kelompok}}">
									</div>
								</div>
								<div class="col-sm-7">
									<input type="text" name="kode_akun" required class="form-control" id="kode_akun" placeholder="Kode akun"  style="display:inline;width:100%;">
								</div>
							</div>
							<div class="form-group">
								<label for="nama_akun" class="col-sm-3 control-label">Nama akun</label>
								<div class="col-sm-9">
									<input type="text" name="nama_akun" required class="form-control" id="nama_akun" placeholder="Nama akun">
								</div>
							</div>
							<div class="form-group">
								<label for="kas" class="col-sm-3 control-label">Akun adalah kas</label>
								<div class="col-sm-9">
									<div class="checkbox">
										<label><input name="kas" type="checkbox" value="1">&nbsp;</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<input type="hidden" name="idterpilih" value="{!! $idterpilih !!}">
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
				</form>
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
