@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/customer') !!}">Daftar Customer</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a onclick="cek('tambah')" class="btn btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                                {{--<a onclick="cek('import')" class="btn btn-success mb15"><i class="ti ti-import"></i> Import</a>--}}
                                <a href="{!! url('master/customer/import') !!}" class="btn btn-success mb15"><i class="ti ti-import"></i> Import</a>
                                <a href="{!! url('master/customer/export') !!}" class="btn btn-warning mb15"><i class="ti ti-export"></i> Export</a>
                            </div>
                            <form class="form-inline" role="form" method="get" action="{{ url('master/customer/search') }}">
                                <div class="form-group mr5">
                                    <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                    <input name="query" type="text" class="form-control" placeholder="Cari customer" value="{{ $query }}" id="cari">
                                </div>
                                <input type="hidden" name="search" value="1">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                                <a href="{!! url('master/customer') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
                                <table class="table table-bordered table-striped no-m">
                                    <thead>
                                    <tr class="bg-color">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Kode</th>
                                        <th class="text-center">Jenis</th>
                                        <th class="text-center">NPK</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Alamat</th>
                                        {{--<th class="text-center">Kota</th>--}}
                                        <th class="text-center">Provinsi</th>
                                        {{--<th class="text-center">Telepon</th>--}}
                                        {{--<th class="text-center">Saldo</th>--}}
                                        <th class="text-center">Registrasi</th>
                                        {{--<th class="text-center">ID</th>--}}
                                        {{--<th class="text-center">Keterangan</th>--}}
                                        <th class="text-center">Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = ($anggota->currentPage() - 1) * $anggota->perPage() + 1; ?>
                                    @foreach($anggota as $value)
                                        <tr>
                                            <td class="text-center">{!! $i++ !!}</td>
                                            <td><a href="{!! url('master/customer/detail/'.$value->id) !!}">{!! $value->kode !!}</a></td>
                                            <td class="text-center">{!! $value->jenis_nasabah !!}</td>
                                            <td>{!! $value->npk !!}</td>
                                            <td>{!! $value->nama !!}</td>
                                            <td>{!! $value->alamat !!}</td>
                                            {{--<td>{!! $value->kota !!}</td>--}}
                                            <td>{!! $value->provinsi !!}</td>
                                            {{--<td>{!! $value->telepon !!}</td>--}}
                                            {{--<td>{!! $value->saldo !!}</td>--}}
                                            <td>{!! $value->tanggal_registrasi !!}</td>
                                            {{--<td class="text-center" style="background-color: rgba(34, 138, 255, 0.11)">{!! $value->id !!}</td>--}}
{{--                                            <td>{!! $value->keterangan !!}</td>--}}
                                            <td align="center" class="fa-hover">
                                                <a href="{!! url('master/customer/'.$value->id.'/edit') !!}" data-toggle="tooltip" data-placement="left" title="Ubah"><i class="ti-pencil mr5" style="color: blue; font-size: medium"></i></a>
                                                <a href="javascript:void(0)" onclick="doc({{$value->id}})" data-toggle="tooltip" data-placement="top" title="Attach Document"><i class="ti-clipboard mr5" style="color: limegreen; font-size: medium"></i></a>
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
{{--                                        {!! str_replace('?','?query='.$query.'&',$anggota->links()) !!}--}}
                                        {!! $anggota->appends(['query' => $query])->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

    @include('master.customer.customer_js')
    @include('master.customer.daftarcs_js')

@stop
