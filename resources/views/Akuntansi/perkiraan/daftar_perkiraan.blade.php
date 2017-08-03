@extends('layouts.master')

@section('content')


<ol class="breadcrumb">
    <li>
        <a href="javascript:;"><i class="ti-home mr5"></i></a>
    </li>
    <li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active">Daftar Perkiraan</li>
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
						<div class="box-tab">
		                    <ul class="nav nav-tabs">
		                    @foreach($akun_parent as $parent)
		                    	@if(session('actives'))
		                    		<?php $active = session('actives'); ?>
							    @endif
		                    	<?php
		                    		$activenav = "";
		                    		if($parent->id == $active){
										$activenav = 'active';
		                    		}
		                    	?>
		                        <li class="{!! $activenav !!}">
		                            <a href="#{!! $parent->id !!}" data-toggle="tab"><font style="font-size:12px;"><?php echo substr($parent['nama_akun'], 0, 15) . (strlen($parent['nama_akun']) > 10 ? '...' : '');?></font></a>
		                        </li>
		                    @endforeach
                                <li class="pull-right">
                                    <a href="{!! url('akuntansi/perkiraan/import') !!}"><i class="fa ti-import"></i> Import</a>
                                </li>
                                <li class="pull-right">
                                    <a href="{{url('akuntansi/perkiraan/create')}}"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
                                </li>
		                    </ul>
		                    <div class="tab-content">
		                    @foreach($akun_parent as $parent)
		                    	@if(session('actives'))
		                    		<?php $active = session('actives'); ?>
							    @endif
		                    	<?php
		                    		$activetab = "";
		                    		if($parent->id == $active){
										$activetab = 'active in';
		                    		}
		                    	?>

		                        <div class="tab-pane fade {!! $activetab !!} " id="{!! $parent->id !!}">
		                        	<div class="row">
										<div class="col-md-12">
											<div class="pull-left">
												<a href="#" id="tambah{!! $parent->id !!}" class="btn btn-primary btn-sm mb15"><i class="ti ti-plus"></i> Tambah</a>
												<a href="#" id="ubah{!! $parent->id !!}" class="btn btn-primary btn-sm mb15"><i class="ti ti-pencil"></i> Ubah</a>
												<a href="#" id="hapus{!! $parent->id !!}" class="btn btn-danger btn-sm mb15"><i class="ti ti-trash"></i> Hapus</a>
											</div>
										</div>
									</div>
									<div id="jstree{!! $parent->id !!}" class="demo">
										<?php
											$akun_parentt = App\Model\Akuntansi\Perkiraan::where('parent', '0')->where('id', $parent->id)->orderBy('id', 'ASC')->get();
										?>
										@foreach($akun_parentt as $akun_parents)
										<ul>
										<li data-jstree='{ "opened" : true, "selected" :true}' id="{!! $akun_parents->id !!}">{!! $akun_parents->kode_akun !!} - {!! $akun_parents->nama_akun !!}
											<?php
												$akun_header = App\Model\Akuntansi\Perkiraan::where('parent', $parent->id)->orderBy('id', 'ASC')->get();
											?>
											@foreach($akun_header as $akun_headers)
											<ul>
											<li data-jstree=<?php if ($akun_headers->tipe_akun == 'header') {?> '{ "opened" : true }' <?php } else { ?> '{"icon" : "glyphicon glyphicon-file"}' <?php } ?> id="{!! $akun_headers->id !!}">{!! $akun_headers->kode_akun !!} - {!! $akun_headers->nama_akun !!}
												<?php
													$akun_headers_relasi = App\Model\Akuntansi\Perkiraan::where('parent', $akun_headers->id)->orderBy('id', 'ASC')->get();
												?>
												@foreach($akun_headers_relasi as $akun_headersrelasi)
												<ul>
												<li data-jstree=<?php if ($akun_headersrelasi->tipe_akun == 'header') {?> '{ "opened" : true }' <?php } else { ?> '{"icon" : "glyphicon glyphicon-file"}' <?php } ?> id="{!! $akun_headersrelasi->id !!}">{!! $akun_headersrelasi->kode_akun !!} - {!! $akun_headersrelasi->nama_akun !!}
													<?php
														$akun_child = App\Model\Akuntansi\Perkiraan::where('kelompok', $akun_headersrelasi->kelompok)->where('parent', $akun_headersrelasi->id)->orderBy('id', 'ASC')->get();
													?>
													@foreach($akun_child as $akun_childs)
													<ul>
														<li data-jstree=<?php if ($akun_childs->tipe_akun == 'header') {?> '{ "opened" : true }' <?php } else { ?> '{"icon" : "glyphicon glyphicon-file"}' <?php } ?> id="{!! $akun_childs->id !!}">{!! $akun_childs->kode_akun !!} - {!! $akun_childs->nama_akun !!}</li>
													</ul>
													@endforeach
												</ul>
												@endforeach
											</li>
											</ul>
											@endforeach
										</li>
										</ul>
										@endforeach
									</div>
		                        </div>
		                    @endforeach
		                    </div>
                		</div>
					</div>
				</div>

				</div>
			</section>
		</div>
	</div>
</div>

<script>
        $('#pasiva2').onclick(function() {
            $('#parent2').load("{!! url('akuntansi/perkiraan/parentget') !!}/"+ $(this).val());
        });


</script>

@foreach($akun_parent as $parent)
<script type="text/javascript">
	$('#jstree{!! $parent->id !!}').jstree();

	var selected = $('#jstree{!! $parent->id !!}').jstree('get_selected');
		$("#tambah{!! $parent->id !!}").attr('href','{!! url('akuntansi/perkiraan/create') !!}/' + selected);
		$("#ubah{!! $parent->id !!}").attr('href','{!! url('akuntansi/perkiraan/edit') !!}/'  + selected);


	$('#jstree{!! $parent->id !!}').on("changed.jstree", function (e, data) {
	  var id = data.selected;
	  $("#tambah{!! $parent->id !!}").attr('href','{!! url('akuntansi/perkiraan/create') !!}/' + id);
	  $("#ubah{!! $parent->id !!}").attr('href','{!! url('akuntansi/perkiraan/edit') !!}/' + id);
	  $("#hapus{!! $parent->id !!}").attr('onclick','konfirm(' + id + ')');

	});
</script>
@endforeach

<script>
function konfirm(id) {
    swal({
                title: "Apakah anda yakin?",
                text: "Anda mungkin tidak dapat mengembalikan data akun!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                confirmButtonText: "Ya, Hapus Akun!",
                closeOnConfirm: false
            }).then(function(){
                swal("Terhapus!", "Akun Perkiraan Telah Terhapus.", "success");
                location.href =  "{{ url('akuntansi/perkiraan/hapus') }}/" + id;
            });
}
</script>


@stop
