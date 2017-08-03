@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pinjaman</a>
        </li>
        <li class="active"><a href="{!! url('pinjaman/reschedule') !!}">Jadwal Ulang Pinjaman</a></li>
        <li class="active">Import</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-inline" role="form" method="get" action="{{ url('pinjaman/search') }}">
                                <div class="form-group mr5">
                                    <label class="sr-only" for="cari">Cari</label>
                                    <input name="query" type="text" class="form-control" placeholder="Cari pinjaman" id="cari" value="{!! $query !!}">
                                </div>
                                <input type="hidden" name="search" value="1">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                                <a href="{!! url('pinjaman/reschedule') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
                            <form action="{!! url('pinjaman/reschedule/add') !!}" role="form" method="post" enctype="multipart/form-data" id="formres">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="table-responsive no-border">
                                    <table class="table table-bordered table-striped no-m">
                                        <thead>
                                        <tr class="bg-color">
                                            <th class="text-center">No</th>
                                            <th class="text-center">No.Pinjaman</th>
                                            <th class="text-center">NPK</th>
                                            <th class="text-center">Kode Anggota</th>
                                            <th class="text-center">Nama Anggota</th>
                                            <th class="text-center">Nama Pinjaman</th>
                                            <th class="text-center">Suku Bunga</th>
                                            <th class="text-center">Tanggal Pengajuan</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Kolektibilitas</th>
                                            <th><input type="checkbox" name="checkAll" id="TableAll"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="table">
                                        <?php $i = ($pinjaman->currentPage() - 1) * $pinjaman->perPage() + 1; ?>
                                        @foreach($pinjaman as $value)
                                            @if($value->status_realisasi == 'Y' && $value->status_lunas == 'N')
                                            <tr>
                                                <td class="text-center">{!! $i++ !!}</td>
                                                <td>{!! $value->nomor_pinjaman !!}</td>
                                                <td>{!! $value->anggotaid->npk !!}</td>
                                                <td>{!! $value->anggotaid->kode !!}</td>
                                                <td>{!! $value->anggotaid->nama !!}</td>
                                                <td>{!! $value->pengaturanid->nama_pinjaman !!}</td>
                                                <td class="text-right">{!! $value->suku_bunga !!} %</td>
                                                <td class="text-center">{!! $value->tanggal_pengajuan !!}</td>
                                                <td>{!! $value->keterangan !!}</td>
                                                <td>{!! $value->kolektibilitasid->keterangan !!}</td>
                                                <td class="text-center"><input type="checkbox" placeholder="" name="cbpilih[{{$value->id}}]"/></td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            {!! $pinjaman->appends(['query' => $query])->links() !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                           <button type="submit" class="btn btn-info btn-sm"><i class="ti ti-check-box"> Re Schedule</i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@stop
