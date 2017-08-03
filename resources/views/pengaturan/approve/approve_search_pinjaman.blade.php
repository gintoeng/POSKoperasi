@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pengaturan</a>
        </li>
        <li class="active"><a href="{!! url('pengaturan/approve') !!}">Daftar Approve</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">
                    <div class="box-tab">
                        <ul class="nav nav-tabs">
                            <li><a href="{!! url('pengaturan/approve/simpanan') !!}">Simpanan</a>
                            </li>
                            <li class="active"><a href="#pinjaman" data-toggle="tab">Pinjaman</a>
                            </li>
                            <li><a href="{!! url('pengaturan/approve/waserda') !!}">Waserda</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="pinjaman">
                                <div class="row">
                                    {{--<div class="col-md-12">--}}
                                    <form class="form-inline" role="form" method="get" action="{{ url('pengaturan/approve/pinjaman/search') }}">
                                        <div class="form-group mr5">
                                            <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                            <input name="query" type="text" class="form-control" placeholder="Cari pinjaman" id="cari">
                                        </div>
                                        <input type="hidden" name="search" value="1">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                                        <a href="{!! url('pengaturan/approve/pinjaman') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
                                    </form>
                                    {{--</div>--}}
                                </div>

                                <div class="pull-right">
                                    Total data ditemukan : {!! $jml !!}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped no-m">
                                            <thead>
                                            <tr class="bg-color">
                                                <th class="text-center">No</th>
                                                <th class="text-center">Pinjaman</th>
                                                <th class="text-center">Jenis Pinjaman</th>
                                                <th class="text-center">Nama Anggota</th>
                                                <th class="text-center">Jumlah Pengajuan</th>
                                                <th class="text-center">Approve</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = ($approve->currentPage() - 1) * $approve->perPage() + 1; ?>
                                            @foreach($approve as $value)
                                                <?php
                                                    $lev1 = \App\Approverole::where('for', 'pinjaman')->where('id_for', $value->pinjamanid->nama_pinjaman)->where('level', '1')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();
                                                    $lev2 = \App\Approverole::where('for', 'pinjaman')->where('id_for', $value->pinjamanid->nama_pinjaman)->where('level', '2')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();
                                                    $lev3 = \App\Approverole::where('for', 'pinjaman')->where('id_for', $value->pinjamanid->nama_pinjaman)->where('level', '3')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();
                                                    $rel = \App\Approverole::where('for', 'pinjaman')->where('id_for', $value->pinjamanid->nama_pinjaman)->where('level', '4')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();

                                                    if($value->lev1 == "1") {
                                                        $blev1 = "btn-primary";
                                                    } else if($value->lev1 == "2") {
                                                        $blev1 = "";
                                                    } else {
                                                        $blev1 = "btn-success";
                                                    }

                                                    if($value->lev2 == "1") {
                                                        $blev2 = "btn-primary";
                                                    } else if($value->lev2 == "2") {
                                                        $blev2 = "";
                                                    } else {
                                                        $blev2 = "btn-success";
                                                    }

                                                    if($value->lev3 == "1") {
                                                        $blev3 = "btn-primary";
                                                    } else if($value->lev3 == "2") {
                                                        $blev3 = "";
                                                    } else {
                                                        $blev3 = "btn-success";
                                                    }

                                                    if($value->release == "1") {
                                                        $blev4 = "btn-primary";
                                                    } else if($value->release == "2") {
                                                        $blev4 = "";
                                                    } else {
                                                        $blev4 = "btn-success";
                                                    }
                                                ?>
                                                <tr>
                                                    <td class="text-center">{!! $i++ !!}</td>
                                                    <td>{!! $value->pinjamanid->nomor_pinjaman !!}</td>
                                                    <td>{!! $value->pinjamanid->pengaturanid->nama_pinjaman !!}</td>
                                                    <td>{!! $value->pinjamanid->anggotaid->nama !!}</td>
                                                    <td class="text-right">{!! number_format($value->pinjamanid->jumlah_pengajuan, 2, '.', ',') !!}</td>
                                                    <td align="center" class="fa-hover">
                                                        <a {{$value->lev1 == 1 ? 'href=#' : 'href='.url('pengaturan/approve/lev1/'.$value->id)}} data-toggle="tooltip" data-placement="top" title="Level 1"><button class="btn btn-xs {{$blev1}}" {{$lev1 == null ? 'disabled' : ''}}>&nbsp;&nbsp;L E V E L 1&nbsp;&nbsp;</button></a>
                                                        <a {{$value->lev2 == 1 ? 'href=#' : 'href='.url('pengaturan/approve/lev2/'.$value->id)}} data-toggle="tooltip" data-placement="top" title="Level 2"><button class="btn btn-xs {{$blev2}}" {{$lev2 == null ? 'disabled' : ''}}>&nbsp;&nbsp;L E V E L 2&nbsp;&nbsp;</button></a>
                                                        <a {{$value->lev3 == 1 ? 'href=#' : 'href='.url('pengaturan/approve/lev3/'.$value->id)}} data-toggle="tooltip" data-placement="top" title="Level 3"><button class="btn btn-xs {{$blev3}}" {{$lev3 == null ? 'disabled' : ''}}>&nbsp;&nbsp;L E V E L 3&nbsp;&nbsp;</button></a>
                                                        <a {{$value->rel == 1 ? 'href=#' : 'href='.url('pengaturan/approve/rel/'.$value->id)}} data-toggle="tooltip" data-placement="top" title="Release"><button class="btn btn-xs {{$blev4}}" {{$rel == null ? 'disabled' : ''}}>&nbsp;&nbsp;&nbsp;&nbsp;R E L E A S E&nbsp;&nbsp;&nbsp;&nbsp;  </button></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="pull-right">
                                                    {!! $approve->appends(['query' => $query])->links() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>

@stop
