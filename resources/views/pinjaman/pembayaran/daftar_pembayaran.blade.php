@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pinjaman</a>
        </li>
        <li class="active">Daftar Pembayaran</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a onclick="cek()" class="btn btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                            </div>
                            <form class="form-inline" role="form" method="get" action="{{ url('pinjaman/pembayaran/search') }}" id="fsearch">
                                <div class="form-group mr5">
                                    <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                    <input name="query" type="text" class="form-control" placeholder="Cari pembayaran" id="cari">
                                </div>
                                <input type="hidden" name="search" value="1">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                                <div class="form-group" id="search_form">
                                    <label for="datepicker" class="col-sm-2 control-label">Tanggal</label>
                                    <div class="col-md-8">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input id="datefrom" type="text" class="input-sm form-control datepicker" name="datefrom" value="{!! $datefrom !!}"/>
                                            <span class="input-group-addon">to</span>
                                            <input id="dateto" type="text" class="input-sm form-control datepicker" name="dateto" value="{!! $dateto !!}"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="pull-right">
                        Total data ditemukan : {!! $jml !!}
                    </div>
                    @if(session('alert'))
                        <br/><br/>
                        {!! session('alert') !!}
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive no-border">
                                <table class="table table-bordered table-striped mg-t editable-datatable">
                                    <thead>
                                    <tr class="bg-color">
                                        <th class="text-center">No</th>
                                        <th class="text-center">No.Transaksi</th>
                                        <th class="text-center">No.Pinjaman</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Anggota</th>
                                        <th class="text-center">Cara Bayar</th>
                                        <th class="text-right">Pokok</th>
                                        <th class="text-right">Bunga</th>
                                        <th class="text-right">Denda</th>
                                        {{--<th class="text-right">Lain-lain</th>--}}
                                        <th class="text-right">Total</th>
                                        <th class="text-center">Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $id = 1;
                                    ?>
                                    <?php $i = ($pembayaran->currentPage() - 1) * $pembayaran->perPage() + 1; ?>
                                    @foreach($pembayaran as $value)
                                        <tr>
                                            <td class="text-center">{!! $i++ !!}</td>
                                            <td>{{ $value->nomor_transaksi }}</td>
                                            <td class="text-center">{!! $value->pinjamanid->nomor_pinjaman !!}</td>
                                            <td class="text-center">{!! $value->tanggal !!}</td>
                                            <td class="text-center text-{!! $value->status == "AKTIF" ? 'primary' : 'danger' !!}">{!! $value->status !!}</td>
                                            <td>{!! $value->pinjamanid->anggotaid->nama !!}</td>
                                            <td class="text-center">{{ $value->cara_bayar }}</td>
                                            <td class="text-right">{!! number_format($value->pokok, 2, '.', ',') !!}</td>
                                            <td class="text-right">{!! number_format($value->bunga, 2, '.', ',') !!}</td>
                                            <td class="text-right">{!! number_format($value->denda, 2, '.', ',') !!}</td>
                                            {{--<td class="text-right">{!! number_format($value->lain, 2, '.', ',') !!}</td>--}}
                                            <td class="text-right">{!! number_format($value->total, 2, '.', ',') !!}</td>
                                            <td align="center" class="fa-hover">
                                                <a href="{!! url('pinjaman/pembayaran/'.$value->id.'/show') !!}" data-toggle="tooltip" data-placement="left" title="Lihat"><i class="ti-eye mr5" style="color: limegreen; font-size: medium"></i></a>
                                                <a href="javascript:void(0)" onclick="konfirm({{$value->id}})" data-toggle="tooltip" data-placement="right" title="Hapus"><i class="ti-trash mr5" style="color: red; font-size: medium"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        {!! $pembayaran->links() !!}
{{--                                        {!! $pembayaran->appends([''])->links() !!}--}}
                                    </div>
                                </div>
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
                    <p id="mess">Anda TIDAK bisa melakukan PENARIKAN atau TRANSFER</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#datefrom').on('change', function() {
            $('#fsearch').submit();
        });

        $('#dateto').on('change', function() {
            $('#fsearch').submit();
        });

        function cek() {
            $.ajax({
                url: "{!! url('pinjaman/bayar/cek') !!}",
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    if (data[0]["stat"] == "FAIL") {
                        var judul = data[0]["title"];
                        var pesan = data[0]["psg"];
                        $('#judul').html("<h4 class='modal-title' id=''judul'>" + judul + "</h4>");
                        $('#mess').html("<p id='mess'>" + pesan + "<p>");
                        $('#rejectModal').modal();
                    } else {
                        location.href = "{!! url('pinjaman/pembayaran/create') !!}";
                    }
                }

            });
        };

        function konfirm(id) {
            swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this imaginary file!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
            }).then(function() {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                location.href =  "{{ url('pinjaman/pembayaran') }}/" + id + "/destroy";
            })

        }
    </script>
@stop
