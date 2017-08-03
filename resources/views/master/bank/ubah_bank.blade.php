@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/bank') !!}">Daftar Bank</a></li>
        <li class="active">Ubah</li>
        <li class="active">{!! $bank->kode !!}</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{!! url('master/bank/'.$bank->id.'/update') !!}" id="fbank">
                        <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode" class="col-sm-3 control-label">Kode</label>
                                    <div class="col-sm-9">
                                        <input name="kode" type="text" class="form-control" id="kode" placeholder="Kode" value="{!! $bank->kode !!}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namabank" class="col-sm-3 control-label">Nama bank</label>
                                    <div class="col-sm-9">
                                        <input name="nama_bank" type="text" class="form-control" id="nama" placeholder="Nama bank" value="{!! $bank->nama_bank !!}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="matauang" class="col-sm-3 control-label">Mata uang</label>
                                    <div class="col-sm-9">
                                        <select name="mata_uang" style="width:100%;" id="matauang" data-placeholder="Pilih Mata uang" class="chosen" required>
                                            @foreach($matauang as $value)
                                                <option value="{!! $value->id !!}" {!! $bank->mata_uang == $value->id ? 'selected' : $value->def == "1" ? 'selected' : '' !!}>{!! $value->kode !!} - {!! $value->nama !!} {!! $value->def == 1 ? '( DEFAULT )' : '' !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input name="keterangan" type="text" class="form-control" id="keterangan" placeholder="Keterangan" value="{!! $bank->keterangan !!}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <label for="tanggal_lahir" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <button id="btnsave" type="button" class="btn btn-primary btn-block" name="save">Save</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{!! url('master/bank') !!}" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    @include('master.modal_js')
    <script>
        $('#btnsave').on('click', function() {
            if ($('#kode').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Kode Bank</h4>');
                $('#mess').html('<p id="mess">Kode Bank tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            }else if ($('#nama').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama Bank</h4>');
                $('#mess').html('<p id="mess">Nama Bank tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else if($('#matauang').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Matauang</h4>');
                $('#mess').html('<p id="mess">Matauang tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#fbank').submit();
            }

        });

        function validAngka(a)
        {
            if(!/^[0-9.]+$/.test(a.value))
            {
                a.value = a.value.substring(0,a.value.length-1000);
            }
        }
    </script>
@stop
