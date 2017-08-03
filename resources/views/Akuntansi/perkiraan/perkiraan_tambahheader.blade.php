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
@if(session('alert'))
	{{ session('alert') }}
@endif
<div class="row">
	<div class="col-md-12">
		<section class="panel no-b">
			<div class="panel-body">
				<form role="form" class="form-horizontal" method="post" action="{!! url('akuntansi/perkiraan/headerstore') !!}" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="kode" class="col-sm-3 control-label">Tipe Akun</label>
								<div class="col-sm-9">
									<div class="radio">
										<label><input name="tipe_akun" type="radio" value="header" checked>Header (Akun tidak dapat diposting)</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="kode_akun" class="col-sm-3 control-label">Kode akun</label>
								<div class="col-sm-2">
									<div id="kelompok_akun">
									<input type="text" name="kelompok_akun" class="form-control" style="text-align:right;" readonly value="{{$values}}">
									</div>
								</div>
								<div class="col-sm-7">
									<div>
									<input type="text" name="kode_akun" required class="form-control" id="kode_akun" placeholder="Kode akun"  style="display:inline;width:100%;">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="nama_akun" class="col-sm-3 control-label">Nama akun</label>
								<div class="col-sm-9">
									<input type="text" name="nama_akun" required class="form-control" id="nama_akun" placeholder="Nama akun">
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
				</form>
			</div>
		</section>
	</div>
</div>

@stop
