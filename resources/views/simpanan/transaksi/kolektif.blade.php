@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Simpanan</a>
        </li>
        <li class="active">Setoran Kolektif</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    @if(session('msg'))
                        <div class="alert alert-{!! session('msgclass') !!}">
                            {!! session('msg') !!}
                        </div>
                    @endif
                    <br>
                    <form class="form-horizontal" role="form" method="post" action="{!! url('simpanan/kolektif') !!}" id="fkolek">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                                    <div class="col-sm-6">
                                        <input type="date" name="tanggal" value="{!! $date !!}" class="form-control datepicker" id="tanggal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_simpanan" class="col-sm-2 control-label">Nomor Simpanan</label>
                                    <div class="col-sm-6">
                                        <select name="nomor_simpanan" class="form-control" style="width:100%;" id="nomor_simpanan" data-placeholder="Pilih Nomor Simpanan">
                                            <option value=""></option>
                                            @foreach($simpanan as $value)
                                                <option value="{!! $value->id !!}">{!! $value->nomor_simpanan !!} - {!! $value->anggotaid->nama !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_anggota" class="col-sm-2 control-label">Nama Anggota</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="nama_anggota" value="" class="form-control" id="nama_anggota" placeholder="Nama Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_anggota" class="col-sm-2 control-label">Alamat Anggota</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="alamat_anggota" value="" class="form-control" id="alamat_anggota" placeholder="Alamat Anggota" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ket" class="col-sm-2 control-label">Keterangan</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="keterangan" value="" class="form-control" id="ket" placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="rejectModal2" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">TIPE</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-10">
                                                    <div class="icheck" style="font-size: 16pt">
                                                        <div class="pull-left">
                                                            <input name="tipe" id="transaksi" type="radio" value="TARIK" checked>
                                                            <label for="transaksi">PENARIKAN DANA</label>
                                                        </div>
                                                        <div class="pull-right">
                                                            <input name="tipe" id="transaksisetor" type="radio" value="SETOR">
                                                            <label for="transaksisetor">SETORAN DANA</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btns" class="btn btn-primary">Oke</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="col-md-4">--}}
                                {{--<fieldset>--}}
                                    {{--<legend>TIPE</legend>--}}
                                    {{--<div class="radio" style="font-size: 14pt">--}}
                                        {{--<div class="pull-left">--}}
                                            {{--<label><input name="tipe" id="transaksi" type="radio" value="TARIK"--}}
                                                          {{--checked>PENARIKAN</label>&nbsp;&nbsp;&nbsp;--}}
                                        {{--</div>--}}
                                        {{--<div class="pull-right">--}}
                                            {{--<label><input name="tipe" id="transaksisetor" type="radio" value="SETOR">SETORAN</label>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</fieldset>--}}
                            {{--</div>--}}
                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="col-md-12">--}}
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <label for="saldo" class="col-sm-1 control-label">Saldo</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="saldo" value="0.00" class="form-control" id="saldo" placeholder="0.00" readonly>
                                        </div>
                                        <label for="jumlah" class="col-sm-1 control-label">Jumlah</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="jumlah" class="form-control" id="jumlah" style="text-align: right" value="0.00" placeholder="0.00">
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="hidden" name="cari" value="1">
                                            {{--<input type="hidden" name="tipe" value="SETOR">--}}
                                            <button type="button" id="mod" class="btn btn-sm btn-primary"><i class="ti-check mr5"></i>Ok</button>
                                            {{--<button id="mod" type="button" class="btn btn-sm btn-warning"><i class="ti-check mr5"></i>Test</button>--}}
                                        </div>
                                    </div>
                                </div>
                            {{--</div>--}}
                        {{--</div>--}}
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mg-t editable-datatable">
                            <thead>
                            <tr class="bg-color">
                                <th class="text-center">No</th>
                                <th class="text-center">No.Simpanan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">NPK</th>
                                <th class="text-center">Kode Anggota</th>
                                <th class="text-center">Nama Anggota</th>
                                <th class="text-center">Setoran Bulanan</th>
                                <th class="text-center">Nominal</th>
                                <th class="text-center">Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = ($kolektif->currentPage() - 1) * $kolektif->perPage() + 1; ?>
                            @foreach($kolektif as $value)
                            <tr>
                                <td class="text-center">{!! $i++ !!}</td>
                                <td>{!! $value->simpananid->nomor_simpanan !!}</td>
                                <td class="text-center">{!! $value->tipe !!}</td>
                                <td>{!! $value->simpananid->anggotaid->npk !!}</td>
                                <td>{!! $value->simpananid->anggotaid->kode !!}</td>
                                <td>{!! $value->simpananid->anggotaid->nama !!}</td>
                                <td class="text-right">{!! number_format($value->simpananid->setoran_bulanan, 2, '.', ',') !!}</td>
                                <td class="text-right">{!! number_format($value->nominal, 2, '.', ',') !!}</td>
                                <td>{!! $value->keterangan !!}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    {!! $kolektif->links() !!}
                                </div>
                            </div>
                        </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <a id="btnup" class="btn btn-sm btn-info">Save</a>
                                <a href="javascript:void(0)" onclick="konfirm()" class="btn btn-sm btn-danger">Cancel</a>
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
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="judul">Pilih nomor pinjaman</h4>
                </div>
                <div class="modal-body">
                    <p id="mess">Pilih nomor pinjaman terlebih dahulu untuk melihat simulasi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#nomor_simpanan").removeAttr('class');
        $("#nomor_simpanan").select2();

        $('#mod').on('click', function(){
            $('#rejectModal2').modal();
        });

        $('#btnup').on('click', function() {
            $.ajax({
                url: "{!! url('simpanan/kolektif/cekup') !!}",
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    if (data[0]["stat"] == "FAIL") {
                        var judul = data[0]["title"];
                        var pesan = data[0]["psg"];
                        $('#judul').html("<h4 class='modal-title' id='judul'>" + judul + "</h4>");
                        $('#mess').html("<p id='mess'>" + pesan + "<p>");
                        $('#rejectModal').modal();
                    } else {
                        location.href = "{!! url('simpanan/kolektif/up') !!}";
                    }
                }

            });
        });

        $('#btns').on('click', function() {

            if($('#nomor_simpanan').val() == "") {
                var judul = "Pilih Nomor Simpanan";
                var pesan = "Nomor Simpanan harus diisi";
                $('#judul').html("<h4 class='modal-title' id='judul'>" + judul + "</h4>");
                $('#mess').html("<p id='mess'>" + pesan + "<p>");
                $('#rejectModal').modal();
            } else {
                var tp = $('input:radio[name=tipe]:checked').val();
                $.ajax({
                    url: "{!! url('simpanan/kolektif/cekaturan') !!}/" + $('#nomor_simpanan').val() + "/" + $('#jumlah').val() + "/" + tp,
                    data: {},
                    dataType: "json",
                    type: "get",
                    success:function(data)
                    {
                        if (data[0]["stat"] == "FAIL") {
                            var judul = data[0]["title"];
                            var pesan = data[0]["psg"];
                            $('#judul').html("<h4 class='modal-title' id='judul'>" + judul + "</h4>");
                            $('#mess').html("<p id='mess'>" + pesan + "<p>");
                            $('#rejectModal').modal();
                        } else {
                            FunctionLoading();
                            $('#fkolek').submit();
                        }
                    }

                });
            }
        });

        $('#jumlah').maskMoney();
        $('#nomor_simpanan').on('change', function () {

            $.ajax({
                url: "{!! url('simpanan/transaksi/ajax/') !!}/" + $(this).val(),
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#nama_anggota').val(data[0]["nama"]);
                    $('#alamat_anggota').val(data[0]["alamat"]);
                    $('#saldo').val(data[0]["saldo"]);
                    $('#jumlah').val(data[0]["setoran_bulanan"]);
                    if (data[0]["stat"] == "FAIL") {
                        var judul = data[0]["title"];
                        var pesan = data[0]["psg"];
                        $('#judul').html("<h4 class='modal-title' id='judul'>" + judul + "</h4>");
                        $('#mess').html("<p id='mess'>" + pesan + "<p>");
                        $('#rejectModal').modal();
                    }

                }

            });
        });

        function konfirm() {
            swal({
                title: "Apakah Anda Yakin?",
                text: "Data dalam tabel akan diHapus",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                confirmButtonText: "Yes, cancel it!",
                closeOnConfirm: false
            }).then(function() {
                swal("Canceled!", "Your imaginary file has been deleted.", "success");
                location.href =  "{{ url('simpanan/kolektif/down') }}";
            })

        }
    </script>

    <script src="{{asset('assets/plugins/icheck/icheck.js')}}"></script>

@stop
