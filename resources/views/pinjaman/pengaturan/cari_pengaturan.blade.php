@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="{!! url('pinjaman') !!}">Pinjaman</a>
        </li>
        <li class="active"><a href="{!! url('pinjaman/pengaturan') !!}">Pengaturan Pinjaman</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{!! url('pinjaman/pengaturan/create') !!}" class="btn btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                            </div>
                            <form class="form-inline" role="form" method="get" action="{{ url('pinjaman/pengaturan/search') }}">
                                <div class="form-group mr5">
                                    <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                    <input name="query" type="text" class="form-control" placeholder="Cari pengaturan" value="{{ $query }}" id="cari">
                                </div>
                                <input type="hidden" name="search" value="1">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                                <a href="{!! url('pinjaman/pengaturan') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
                                        <th class="text-center">Kode</th>
                                        <th class="text-center">Jenis Pinjaman</th>
                                        <th class="text-center">Suku Bunga</th>
                                        <th class="text-center">Sistem Bunga</th>
                                        <th class="text-center">Kode Rekening Awal</th>
                                        {{--<th class="text-center">ID</th>--}}
                                        <th class="text-center">Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = ($pengaturan->currentPage() - 1) * $pengaturan->perPage() + 1; ?>
                                    @foreach($pengaturan as $value)
                                        <tr>
                                            <td class="text-center">{!! $i++ !!}</td>
                                            <td>{!! $value->kode !!}</td>
                                            <td>{!! $value->nama_pinjaman !!}</td>
                                            <td class="text-right">{!! $value->suku_bunga !!} %</td>
                                            <td>{!! $value->sbunga->sistem !!}</td>
                                            <td>{!! $value->kode_awal_rekening !!}</td>
                                            {{--<td class="text-center" style="background-color: rgba(34, 138, 255, 0.11)">{!! $value->id !!}</td>--}}
                                            <td align="center" class="fa-hover">
                                                <a href="{!! url('pinjaman/pengaturan/'.$value->id.'/edit') !!}" data-toggle="tooltip" data-placement="left" title="Ubah"><i class="ti-pencil mr5" style="color: blue; font-size: medium"></i></a>
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
{{--                                        {!! str_replace('?','?query='.$query.'&',$pengaturan->links()) !!}--}}
                                        {!! $pengaturan->appends(['query' => $query])->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

    @include('pinjaman.pengaturan.daftar_js')
@stop
