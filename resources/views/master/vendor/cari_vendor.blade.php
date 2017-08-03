@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Master</a>
        </li>
        <li class="active"><a href="{!! url('master/vendor') !!}">Daftar Vendor</a></li>
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
                                <a href="{!! url('master/vendor/import') !!}" class="btn btn-success mb15"><i class="ti ti-import"></i> Import</a>
                                <a href="{!! url('master/vendor/export') !!}" class="btn btn-warning mb15"><i class="ti ti-export"></i> Export</a>
                            </div>
                            <form class="form-inline" role="form" method="get" action="{{ url('master/vendor/search') }}">
                                <div class="form-group mr5">
                                    <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                    <input name="query" type="text" class="form-control" placeholder="Cari vendor" value="{{ $query }}" id="cari">
                                </div>
                                <input type="hidden" name="search" value="1">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                                <a href="{!! url('master/vendor') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
                                        <th class="text-center">Nama Vendor</th>
                                        <th class="text-center">Nama Kontak</th>
                                        <th class="text-center">Telepon</th>
                                        {{--<th class="text-center">ID</th>--}}
                                        <th class="text-center">Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = ($vendor->currentPage() - 1) * $vendor->perPage() + 1; ?>
                                    @foreach($vendor as $value)
                                        <tr>
                                            <td class="text-center">{!! $i++ !!}</td>
                                            <td>{!! $value->kode !!}</td>
                                            <td>{!! $value->nama_vendor !!}</td>
                                            <td>{!! $value->nama_kontak !!}</td>
                                            <td>{!! $value->phone !!}</td>
                                            {{--<td class="text-center" style="background-color: rgba(34, 138, 255, 0.11)">{!! $value->id !!}</td>--}}
                                            <td align="center" class="fa-hover">
                                                <a href="{!! url('master/vendor/'.$value->id.'/edit') !!}" data-toggle="tooltip" data-placement="left" title="Ubah"><i class="ti-pencil mr5" style="color: blue; font-size: medium"></i></a>
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
{{--                                        {!! str_replace('?','?query='.$query.'&',$vendor->links()) !!}--}}
                                        {!! $vendor->appends(['query' => $query])->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
    @include('master.vendor.vendor_js')
@stop
