@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="{!! url('pinjaman') !!}">Pinjaman</a>
        </li>
        <li class="active">Daftar Pinjaman</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="pull-left">
                                <a href="{!! url('pinjaman/create') !!}" class="btn btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                                {{--<a href="{!! url('pinjaman/import') !!}" class="btn btn-success mb15"><i class="ti ti-import"></i> Import</a>--}}
                            </div>
                            <form class="form-inline" role="form" method="get" action="{{ url('pinjaman/search') }}">
                                <div class="form-group mr5">
                                    <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                    <input name="query" type="text" class="form-control" placeholder="Cari pinjaman" id="cari">
                                </div>
                                <input type="hidden" name="search" value="1">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form class="form-horizontal" role="form" method="post">
                                <div class="form-group">
                                    <label for="realisasi" class="col-sm-3 control-label">Status Realisasi</label>
                                    <div class="col-sm-9">
                                            <div class="radio" id="realis">
                                                <label><input id="all" name="realisasi" type="radio" value="all" checked>ALL</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label><input id="real" name="realisasi" type="radio" value="belum">Belum Realisasi</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label><input id="real2" name="realisasi" type="radio" value="sudah">Sudah Realisasi</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <label><input id="real3" name="realisasi" type="radio" value="lunas">Sudah Lunas</label>
                                            </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="kolektibilitas" class="col-sm-3 control-label">Kolektibilitas</label>
                                    <div class="col-sm-9">
                                        <select name="kolektibilitas" type="text" class="form-control chosen" id="kolektibilitas" data-placeholder="Pilih Kolektibilitas">
                                            <option value="0" selected>ALL</option>
                                            @foreach($kolektibilitas as $value)
                                                <option value="{!! $value->id !!}">{!! $value->kode !!} - {!! $value->keterangan !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <br>
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
                                        <th class="text-center">No.Pinjaman</th>
                                        <th class="text-center">NPK</th>
                                        <th class="text-center">Kode Anggota</th>
                                        <th class="text-center">Nama Anggota</th>
                                        <th class="text-center">Nama Pinjaman</th>
                                        <th class="text-center">Suku Bunga</th>
                                        {{--<th class="text-center">Tanggal Pengajuan</th>--}}
                                        <th class="text-center">Jumlah Pengajuan</th>
                                        <th class="text-center">Jangka Waktu</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" width="5%">Option</th>
                                        <th class="text-center" width="5%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table">
                                    <?php $i = ($pinjaman->currentPage() - 1) * $pinjaman->perPage() + 1; ?>
                                    @foreach($pinjaman as $value)
                                        <tr>
                                            <?php
                                                $maxlev = $value->pengaturanid->approveroleid->max('level');
                                                $approve = \App\Approve::where('id_for', $value->id)->first();
                                                if($value->approved == 0) {
                                                    $wait = "FAIL";
                                                } else {
                                                    $wait = "OK";
                                                }

                                                if($value->status_realisasi == "N") {
                                                    $stat = 'Not Approved';
                                                    $statc = "text-danger";
                                                    $breal = "btn-success";
                                                } else {
                                                    if($wait == 'OK') {
                                                        $breal = "";
                                                        $stat = 'Approved';
                                                        $statc = "text-primary";
                                                    } else {
                                                        $stat = 'Waiting for Approve ...';
                                                        $statc = "text-success";
                                                        $breal = "btn-color";
                                                    }
                                                }
                                            ?>
                                            <td class="text-center">{!! $i++ !!}</td>
                                            <td><a href="javascript:void(0)">{!! $value->nomor_pinjaman !!}</td>
                                            <td>{!! $value->anggotaid->npk !!}</td>
                                            <td>{!! $value->anggotaid->kode !!}</td>
                                            <td>{!! $value->anggotaid->nama !!}</td>
                                            <td>{!! $value->pengaturanid->nama_pinjaman !!}</td>
                                            <td class="text-right">{!! $value->suku_bunga !!} %</td>
{{--                                            <td class="text-center">{!! $value->tanggal_pengajuan !!}</td>--}}
                                            <td class="text-right">{!! number_format($value->jumlah_pengajuan, 2, '.', '.') !!}</td>
                                            <td class="text-right">{!! $value->jangka_waktu !!} {!! $value->pengaturanid->tipe_maksimum_waktu == "bulan" ? 'Bulan' : 'Hari' !!}</td>

                                                <td class="text-center {{$statc}}">{!! $stat !!}</td>
                                            <td align="center" class="fa-hover">
                                                <a href="javascript:void(0)" onclick="cekrealup({{$value->id}})" data-toggle="tooltip" data-placement="left" title="Ubah"><i class="ti-pencil mr5" style="color: blue; font-size: medium"></i></a>
                                                <a href="javascript:void(0)" onclick="cekreal({{$value->id}})" data-toggle="tooltip" data-placement="right" title="Hapus"><i class="ti-trash mr5" style="color: red; font-size: medium"></i></a>
                                            </td>
                                            <td align="center" class="fa-hover">
                                                @if($value->status_realisasi == "Y")
                                                    @if($wait == "OK")
                                                        <?php
                                                        $akses3 = \App\Aksestutup::where('tutup', 'pinnjaman')->where('jenis', 'tutup')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();
                                                        if($value->status_lunas == "N" || $akses3 == null) {
                                                            $dis = "disabled";
                                                        } else {
                                                            $dis = "";
                                                        }
                                                        ?>

                                                        <a href="{!! url('pinjaman/tutup/'.$value->id) !!}" data-toggle="tooltip" data-placement="top" title="Tutup"><button class="btn btn-xs {{$value->status_lunas == "N" ? 'btn-warning' : ''}}" {{$dis}}><i class="ti-na mr5"> Tutup</i></button></a>
                                                    @else
                                                        <a href="{!! url('pinjaman/reject/'.$value->id) !!}" data-toggle="tooltip" data-placement="top" title="Reject"><button class="btn btn-xs btn-danger"><i class="ti-close mr5"> Reject</i></button></a>
                                                    @endif
                                                @else
                                                    <a href="{!! url('pinjaman/realisasi/'.$value->id) !!}" data-toggle="tooltip" data-placement="top" title="Realisasi"><button class="btn btn-xs {{$breal}}" {{$value->status_realisasi == "N" ? '' : 'disabled'}}><i class="ti-import mr5"> {{$value->status_realisasi == "N" ? 'Realisasi' : 'Waiting Approve ...'}}</i></button></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        {!! $pinjaman->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

    @include('pinjaman.daftar_js')
@stop
