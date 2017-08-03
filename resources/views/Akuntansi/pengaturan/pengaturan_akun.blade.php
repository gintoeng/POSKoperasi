@extends('layouts.master')

@section('content')
<ol class="breadcrumb">
    <li>
        <a href="javascript:;"><i class="ti-home mr5"></i></a>
    </li>
    <li>
		<a href="javascript:;">Akuntansi</a>
	</li>
	<li class="active">Pengaturan Akun</li>
</ol>
@if(session('msg'))
	<div class="alert alert-{!! session('msgclass') !!}">
		{!! session('msg') !!}
	</div>
@endif
<div class="row">

	<div class="col-md-12">
		<section class="panel no-b">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="box-tab">
							<ul class="nav nav-tabs">
								@foreach($Akun as $Akuns)
			                    	@if(session('actives'))
			                    		<?php $active = session('actives'); ?>
								    @endif
			                    	<?php
			                    		$activenav = "";
			                    		if($Akuns->id == $active){
											$activenav = 'active';
			                    		}
			                    	?>
			                        <li class="{!! $activenav !!}">
			                            <a href="#{!! $Akuns->id !!}" data-toggle="tab"><font style="font-size:12px;"><?php echo substr($Akuns['caption'], 0, 15) . (strlen($Akuns['caption']) > 10 ? '...' : '');?></font></a>
			                        </li>
			                    @endforeach
							</ul>
							<div style="height:400px;" class="tab-content">
							@foreach($Akun as $Akuns)
                                @if(session('actives'))
                                    <?php $active = session('actives'); ?>
                                @endif
                                <?php
                                    $activetab = "";
                                    if($Akuns->id == $active){
                                        $activetab = 'active in';
                                    }
                                ?>
                                <div class="tab-pane fade {!! $activetab !!}" id="{!! $Akuns->id !!}">
                                    <form role="form" class="form-horizontal" method="post" action="{!! url('akuntansi/pengaturanakun/update/'.$Akuns->id) !!}">
										{!! csrf_field() !!}
                                        <div class="row">
                                            @foreach($Akuns->akunheader as $akunss)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <label for="laba_tahun_berjalan" class="col-sm-3 control-label">{!! $akunss->akunheaderdrdetail->caption !!}</label>
                                                    <div class="col-sm-9">
                                                        <select name="akun-{!! $akunss->id !!}" type="text" style="width:100%" id="laba_tahun_berjalan" required>
                                                            @foreach($Perkiraan as $perkiraans)
                                                            <option value='{!! $perkiraans->id !!}' <?php if($perkiraans->id==$akunss->id_akun){ ?> selected <?php } ?>>{!! $perkiraans->kode_akun !!} - {!! $perkiraans->nama_akun !!}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
							@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>


<script type="text/javascript">
	$("select").select2();
		$("select").on('change', function (e) {
			var kode_akun = $('option:selected', this).attr('data-kode');
			$(this).parent().parent().children('.id_akun').children().val(kode_akun);
		});
</script>

@stop
