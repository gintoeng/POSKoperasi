@extends('layouts.master')

@section('content')
<ol class="breadcrumb">
  <li>
    <a href="javascript:;"><i class="ti-home mr5"></i></a>
  </li>
  <li>
    <a href="javascript:;">Akuntansi</a>
  </li>
  <li class="active"><a href="{!! url('perkiraan') !!}">Kas Transfer</a></li>
</ol>
@if(session('alert'))
    <br/><br/>
    {!! session('alert') !!}
@endif
<div class="row">

  <div class="col-md-12">
    <section class="panel no-b">
      <div class="panel-body">
          <form class="form-horizontal" role="form" method="post" action="{{ url('akuntansi/kastransfer/store') }}" onsubmit="return validasitrue();">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                      <div class="col-md-6">
                            <div class="form-group" id="search_form">
                                <label for="datepicker" class="col-sm-3 control-label">Kode</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" readonly="true" name="kode" value="{!! $kode !!}"/>
                                </div>
                            </div>
                       <div class="form-group" id="search_form">
                          <label for="datepicker" class="col-sm-3 control-label">Tanggal</label>
                          <div class="col-md-9 input-daterange"  id="datepicker">
                              <input type="text" class="form-control datepicker" name="tanggal" value="{!! $date !!}"/>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="module_name" class="col-sm-3 control-label">Dari Akun</label>
                          <div class="col-sm-9">
                            <select name="dariakun" class="form-control chosen" required>
                              <option>Pilih Akun</option>
                              @foreach($perkiraan as $perkiraans)
                                <option value="{!! $perkiraans->id !!}" data-kode="{!! $perkiraans->kode_akun !!}">{!! $perkiraans->kode_akun !!} - {!! $perkiraans->nama_akun !!}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="module_name" class="col-sm-3 control-label">Ke Akun</label>
                          <div class="col-sm-9">
                            <select name="keakun" class="form-control chosen" required>
                              <option>Pilih Akun</option>
                              @foreach($perkiraan as $perkiraans)
                                <option value="{!! $perkiraans->id !!}" data-kode="{!! $perkiraans->kode_akun !!}">{!! $perkiraans->kode_akun !!} - {!! $perkiraans->nama_akun !!}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="module_name" class="col-sm-3 control-label">Jumlah</label>
                          <div class="col-sm-9">
                            <input name="jumlah" id="jumlah" type="text" class="form-control" id="jumlah" placeholder="0.00">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="module_name" class="col-sm-3 control-label">Keterangan</label>
                          <div class="col-sm-9">
                            <textarea name="keterangan" type="number" class="form-control" id="menu_order" placeholder="Keterangan"></textarea>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="save" class="col-sm-3 control-label"></label>
                          <div class="col-sm-2">
                            <button onclick="ceknomor()" type="submit" class="btn btn-primary btn-block"> Simpan </button>
                          </div>
                          <!--<div class="col-sm-2">
                            <a href="{{ url('module') }}" class="btn btn-danger btn-block">Cancel</a>
                          </div>
                          <div class="col-sm-2">
                            <a href="{{ url('module') }}" class="btn btn-info btn-block">Cetak</a>
                        </div>-->
                        </div>
                      </div>
                    </div>
                  </form>
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
		  <p>Jumlah tidak boleh sama atau kurang dari 0</p>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rejectModal1" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color:red">Peringatan</h4>
      </div>
	  <div class="modal-body">
		  <p>Format nomor untuk Kas Transfer belum disetting</p>
	  </div>
      <div class="modal-footer">
        <a href="{{url('pengaturan/nomor')}}" type="button" class="btn btn-primary">Klik disini untuk setting</a>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

    var kode = <?php echo json_encode($kode) ?>;

    if(kode=="Kode Belum Disetting"){
        $('#rejectModal1').modal();
    }

    $("#jumlah").maskMoney();

    function ceknomor(){
        $.ajax({
            url: "{!! url('akuntansi/kastransfer/ceknomor') !!}",
            data: {},
            dataType: "json",
            type: "get",
            success:function(data)
            {
                if (data[0]["stat"] == "kosong") {
                    $('#rejectModal1').modal();
                }
            }

        });
    }

    function validasitrue(){
        sum_nominal_val = document.getElementById("jumlah").value;
        sum_nominal_valfix = parseInt(sum_nominal_val);
        if(kode=="Kode Belum Disetting"){
            $('#rejectModal1').modal();
            return false;
        }
        else if(sum_nominal_valfix>0){
			return true;
		} else {
			$('#rejectModal').modal();
			return false;
		}
	}

</script>
@stop
