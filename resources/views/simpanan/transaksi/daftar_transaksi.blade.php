@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Simpanan</a>
        </li>
        <li class="active"><a href="{!! url('simpanan/transaksi') !!}">Daftar Transaksi</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{!! url('simpanan/transaksi/create') !!}" class="btn btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                            </div>
                            <form class="form-inline" role="form" method="get" action="{{ url('simpanan/transaksi/search') }}">
                                <div class="form-group mr5">
                                    <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                    <input name="query" type="text" class="form-control" placeholder="Cari transaksi" id="cari">
                                </div>
                                <input type="hidden" name="search" value="1">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
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
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tipe</th>
                                        <th class="text-center">No.Simpanan</th>
                                        <th class="text-center">NPK</th>
                                        <th class="text-center">Kode Anggota</th>
                                        <th class="text-center">Anggota</th>
                                        <th class="text-center">Nominal</th>
                                        <th class="text-center">Info</th>
                                        {{--<th class="text-center">Keterangan</th>--}}
                                        <th class="text-center">Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = ($transaksi->currentPage() - 1) * $transaksi->perPage() + 1; ?>
                                    @foreach($transaksi as $value)
                                        <tr>
                                            <?php
                                                $maxlev = $value->simpananid->pengaturanid->approveroleid->max('level');
                                                $approve = \App\Approve::where('id_for', $value->id)->first();
                                                if($value->approved == 0) {
                                                    $wait = "FAIL";
                                                } else {
                                                    $wait = "OK";
                                                }
                                            ?>
                                            <td class="text-center">{!! $i++ !!}</td>
                                            <td>{!! $value->kode !!}</td>
                                            <td class="text-center">{!! $value->tanggal !!}</td>
                                            @if($wait == "OK")
                                                <td class="text-center text-{!! $value->status == "AKTIF" ? 'primary' : 'danger' !!}">{!! $value->status !!}</td>
                                            @else
                                                <td class="text-center text-success">Waiting Approve ...</td>
                                            @endif
                                            <td>{!! $value->tipe !!}</td>
                                            <td>{!! $value->simpananid->nomor_simpanan !!}</td>
                                            <td>{!! $value->simpananid->anggotaid->npk !!}</td>
                                            <td>{!! $value->simpananid->anggotaid->kode !!}</td>
                                            <td>{!! $value->simpananid->anggotaid->nama !!}</td>
                                            <td class="text-right">{!! number_format($value->nominal, 2, '.', ',') !!}</td>
                                            <td>{!! $value->info !!}</td>
{{--                                            <td>{!! $value->keterangan !!}</td>--}}
                                            <td align="center" class="fa-hover">
                                                <a href="{!! url('simpanan/transaksi/'.$value->id.'/show') !!}" data-toggle="tooltip" data-placement="left" title="Lihat"><i class="ti-eye mr5" style="color: limegreen; font-size: medium"></i></a>
                                                <a href="javascript:void(0)" @if($wait == "OK") onclick="konfirm({{$value->id}})" @else onclick="waiting()" @endif data-toggle="tooltip" data-placement="right" title="Hapus"><i class="ti-trash mr5" style="color: red; font-size: medium"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        {!! $transaksi->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

    <script>
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
                location.href =  "{{ url('simpanan/transaksi') }}/" + id + "/destroy";
            })

        }

        function waiting() {
            sweetAlert(
                    'Oops...Can not delete!',
                    'Waiting for Approved',
                    'error'
            )
        }
    </script>

@stop
