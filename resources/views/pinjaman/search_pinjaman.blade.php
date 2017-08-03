@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pinjaman</a>
        </li>
        <li class="active">Daftar Pinjaman</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">
                    <div class="pull-left">
                        <a href="{!! url('pinjaman/create') !!}" class="btn btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                        <a href="{!! url('pinjaman/import') !!}" class="btn btn-success mb15"><i class="ti ti-import"></i> Import</a>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-horizontal" role="form" method="post">
                                <div class="form-group">
                                    <label for="realisasi" class="col-sm-3 control-label">Status Realisasi</label>
                                    <div class="col-sm-9">
                                        <div class="radio">
                                            <label><input name="realisasi" type="radio" value="belum" checked>Belum Realisasi</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input name="realisasi" type="radio" value="sudah">Sudah Realisasi</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label><input name="realisasi" type="radio" value="lunas">Sudah Lunas</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kolektibilitas" class="col-sm-3 control-label">Kolektibilitas</label>
                                    <div class="col-sm-9">
                                        <select name="kolektibilitas" type="text" class="form-control chosen" id="kolektibilitas" data-placeholder="Pilih Kolektibilitas">
                                            <option value=""></option>
                                            @foreach($kolektibilitas as $value)
                                                <option value="{!! $value->id !!}">{!! $value->kode !!} - {!! $value->keterangan !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                          <form class="form-inline" role="form" method="get" action="{{ url('pinjaman/search') }}">
                            <div class="form-group mr5">
                              <label class="sr-only" for="cari">Cari</label>
                              <input name="query" type="text" class="form-control" placeholder="Cari pinjaman" id="cari" value="{{ $query }}">
                            </div>
                            <input type="hidden" name="search" value="1">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                          </form>
                        </div>
                    </div>
                    <br/>
                    @if(session('msg'))
                        <br/><br/>
                        <div class="alert alert-{!! session('msgclass') !!}">
                            {!! session('msg') !!}
                        </div>
                    @endif
                    <div class="table-responsive no-border">
                        <table class="table table-bordered table-striped no-m">
                            <thead>
                            <tr class="bg-color">
                                <th class="text-center">No.Pinjaman</th>
                                <th class="text-center">Kode Anggota</th>
                                <th class="text-center">Nama Anggota</th>
                                <th class="text-center">Nama Pinjaman</th>
                                <th class="text-center">Suku Bunga</th>
                                <th class="text-center">Tanggal Pengajuan</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pinjaman as $value)
                                <tr>
                                    <td>{!! $value->nomor_pinjaman !!}</td>
                                    <td>{!! $value->anggotaid->kode !!}</td>
                                    <td>{!! $value->anggotaid->nama !!}</td>
                                    <td>{!! $value->pengaturanid->nama_pinjaman !!}</td>
                                    <td class="text-center">{!! $value->pengaturanid->suku_bunga !!}</td>
                                    <td class="text-center">{!! $value->tanggal_pengajuan !!}</td>
                                    <td>{!! $value->keterangan !!}</td>
                                    <td align="center">
                                        <a href="{!! url('pinjaman/'.$value->id.'/edit') !!}" class="btn btn-info btn-xs mr5"><i class="ti-pencil"> Ubah</i></a>
                                        <a href="{!! url('pinjaman/'.$value->id.'/destroy') !!}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs mr5"><i class="ti-trash"> Hapus</i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="pull-right">
                          {!! str_replace('?','?query='.$query.'&',$pinjaman->links()) !!}
                        </div>
                      </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@stop
