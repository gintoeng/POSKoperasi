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
        <li class="active">Detail</li>
        <li class="active">{!! $anggota->kode !!}</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <div class="box-tab">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#data" data-toggle="tab">Data Customer</a>
                            </li>
                            <li><a href="#outs" data-toggle="tab">Detail Outstanding</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="data">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="alert alert-primary">
                                                @if($anggota->foto == "")
                                                    <img id="imgfoto" src="{{asset('foto/default-avatar-user.png')}}" alt="your image" width="300" height="400"/>
                                                @else
                                                    <img id="imgfoto" src="{{asset('foto/anggota'.'/'.$anggota->foto)}}" alt="your image" width="300" height="400"/>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <?php
                                                $akses = \App\Aksestutup::where('tutup', 'anggota')->where('tipecs', $js)->where('jenis', 'aktif')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();
                                                $akses2 = \App\Aksestutup::where('tutup', 'anggota')->where('tipecs', $js)->where('jenis', 'block')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();
                                                $akses3 = \App\Aksestutup::where('tutup', 'anggota')->where('tipecs', $js)->where('jenis', 'tutup')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();
                                            ?>
                                            @if($anggota->status == "NONAKTIF")
                                                <?php $al = "danger";?>
                                            @elseif($anggota->status == "BLOCK")
                                                <?php $al = "warning";?>
                                            @else
                                                <?php $al = "";?>
                                            @endif
                                            <div class="alert alert-{{$al}}">
                                                <table class="table">
                                                    <tr>
                                                        <td width="20%">Status</td>
                                                        <td width="10%">:</td>
                                                        <td>{!! $anggota->status !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Kode</td>
                                                        <td width="10%">:</td>
                                                        <td>{!! $anggota->kode !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Nama</td>
                                                        <td width="10%">:</td>
                                                        <td>{!! $anggota->nama !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Jenis Customer</td>
                                                        <td width="10%">:</td>
                                                        <td>{!! $anggota->jenis_nasabah !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Tempat, Tanggal Lahir</td>
                                                        <td width="10%">:</td>
                                                        <td>{!! $anggota->tempat_lahir !!}, {!! $anggota->tanggal_lahir !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Nomor KTP</td>
                                                        <td width="10%">:</td>
                                                        <td>{!! $anggota->nomor_ktp !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Telepon</td>
                                                        <td width="10%">:</td>
                                                        <td>{!! $anggota->telepon !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Email</td>
                                                        <td width="10%">:</td>
                                                        <td>{!! $anggota->email !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Alamat</td>
                                                        <td width="10%">:</td>
                                                        <td>{!! $anggota->alamat !!}, {!! $anggota->kota !!}, {!! $anggota->provinsi !!}, {!! $anggota->kode_pos !!}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                                <hr/>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="pull-left">
                                                            <a href="{!! url('master/customer') !!}" class="btn btn-success btn-block">OKE</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{--<div class="pull-right">--}}
                                                            {{--<a href="{!! url('master/customer/tutup/'.$anggota->id.'/AKTIF') !!}" ><button type="button" class="btn btn-{{$al != "" ? 'primary' : 'color'}}" {{$al != "" ? '' : 'disabled'}}>Aktifkan</button></a>--}}
                                                            {{--<a href="{!! url('master/customer/tutup/'.$anggota->id.'/BLOCK') !!}" ><button type="button" class="btn btn-{{$al == "warning" ? 'color' : 'warning'}}" {{$al == "warning" ? 'disabled' : ''}}>Block</button></a>--}}
                                                            {{--<a href="{!! url('master/customer/tutup/'.$anggota->id.'/NONAKTIF') !!}" ><button type="button" class="btn btn-{{$al == "danger" ? 'color' : 'danger'}}" {{$al == "danger" ? 'disabled' : ''}}>Non-Aktifkan</button></a>--}}
                                                        {{--</div>--}}
                                                        <div class="pull-right">
                                                            <a href="{!! url('master/customer/tutup/'.$anggota->id.'/AKTIF') !!}" ><button type="button" class="btn btn-{{$js == "AKTIF" ? 'primary' : 'color'}}" {{$akses == null ? 'disabled' : ''}}>Aktifkan</button></a>
                                                            <a href="{!! url('master/customer/tutup/'.$anggota->id.'/BLOCK') !!}" ><button type="button" class="btn btn-{{$js == "BLOCK" ? 'color' : 'warning'}}" {{$akses2 == null ? 'disabled' : ''}}>Block</button></a>
                                                            <a href="{!! url('master/customer/tutup/'.$anggota->id.'/NONAKTIF') !!}" ><button type="button" class="btn btn-{{$js == "NONAKTIF" ? 'color' : 'danger'}}" {{$akses3 == null ? 'disabled' : ''}}>Non-Aktifkan</button></a>
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="outs">
                                <div class="row">
                                    <section class="panel no-b">
                                        <div class="panel-body">
                                            <div class="box-tab">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#simpanan" data-toggle="tab">Simpanan</a>
                                                    </li>
                                                    <li><a href="#pinjaman" data-toggle="tab">Pinjaman</a>
                                                    </li>
                                                    <li><a href="#waserda" data-toggle="tab">Waserda</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade active in" id="simpanan">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive no-border">
                                                                    <table class="table table-bordered table-striped no-m">
                                                                        <thead>
                                                                        <tr class="bg-primary">
                                                                            <th class="text-center">No</th>
                                                                            <th class="text-center">Kategori SHU</th>
                                                                            <th class="text-center">No Simpanan</th>
                                                                            <th class="text-center">Jenis Simpanan</th>
                                                                            <th class="text-center">Total Saldo</th>
                                                                            <th class="text-center">Setoran Bulanan</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php $i = 1; ?>
                                                                        @foreach($simpanan as $value)
                                                                            <tr>
                                                                                <td class="text-center">{!! $i++ !!}</td>
                                                                                <td>{!! $value->pengaturanid->shuid->nama !!}</td>
                                                                                <td>{!! $value->nomor_simpanan !!}</td>
                                                                                <td>{!! $value->pengaturanid->jenis_simpanan !!}</td>
                                                                                <td class="text-right">{!! number_format($value->akumulasiid->saldo, 2, '.', ',') !!}</td>
                                                                                <td class="text-right">{!! number_format($value->setoran_bulanan, 2, '.', ',') !!}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pinjaman">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive no-border">
                                                                    <table class="table table-bordered table-striped no-m">
                                                                        <thead>
                                                                        <tr class="bg-primary">
                                                                            <th class="text-center">No</th>
                                                                            <th class="text-center">Kategori SHU</th>
                                                                            <th class="text-center">Nomor Pinjaman</th>
                                                                            <th class="text-center">Nama Pinjaman</th>
                                                                            <th class="text-center">Outstanding</th>
                                                                            <th class="text-center">Bunga</th>
                                                                            <th class="text-center">Denda</th>
                                                                            <th class="text-center">Total</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php $n =1; $keypinj = "";?>
                                                                        @foreach($pinjaman as $value2)
                                                                            <tr>
                                                                                @if($value2->pinjamanid->nomor_pinjaman != $keypinj)
                                                                                    <td rowspan="{!! $pinjaman->count() !!}" class="text-center">{!! $n++ !!}</td>
                                                                                    <td rowspan="{!! $pinjaman->count() !!}">{!! $value2->pinjamanid->pengaturanid->shuid->nama !!}</td>
                                                                                    <td rowspan="{!! $pinjaman->count() !!}">{!! $value2->pinjamanid->nomor_pinjaman !!}</td>
                                                                                    <td rowspan="{!! $pinjaman->count() !!}">{!! $value2->pinjamanid->pengaturanid->nama_pinjaman !!}</td>
                                                                                @endif
                                                                                <td class="tex-right">{!! number_format($value2->saldo, 2, '.', ',') !!}</td>
                                                                                <td class="tex-right">{!! number_format($value2->bunga, 2, '.', ',') !!}</td>
                                                                                <td class="tex-right">{!! number_format($value2->denda, 2, '.', ',') !!}</td>
                                                                                <td class="tex-right">{!! number_format($value2->total, 2, '.', ',') !!}</td>
                                                                            </tr>
                                                                            <?php $keypinj = $value2->pinjamanid->nomor_pinjaman; ?>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="waserda">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive no-border">
                                                                    <table class="table table-bordered table-striped no-m">
                                                                        <thead>
                                                                        <tr class="bg-primary">
                                                                            <th class="text-center">No</th>
                                                                            {{--<th class="text-center">Kategori SHU</th>--}}
                                                                            {{--<th class="text-center">Produk</th>--}}
                                                                            <th class="text-center">Harga Satuan</th>
                                                                            <th class="text-center">Qty</th>
                                                                            <th class="text-center">Nomor Ref</th>
                                                                            <th class="text-center">Total</th>
                                                                            <th class="text-center">Status</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php $no = 1; $keynya = ""; ?>
                                                                        @foreach($waserda as $value3)
                                                                            <?php
                                                                                $tran = \App\Model\Pos\Transaksidetail::where('no_ref', $value3->noref)->get();
                                                                            ?>
                                                                            @foreach($tran as $key => $item)
                                                                                <?php $prod = \App\Model\Master\Barang::where('barcode', $item->barcode)->first();?>
                                                                            <tr>
                                                                                <td class="text-center">{!! $no++ !!}</td>
{{--                                                                                <td>{!! $prod->shuid->nama !!}</td>--}}
{{--                                                                                <td>{!! $prod->nama !!}</td>--}}
                                                                                <td class="text-right">{!! number_format($item->harga, 2, '.', ',') !!}</td>
                                                                                <td>{!! $item->qty !!}</td>
                                                                                @if($value3->noref != $keynya)
                                                                                    <td rowspan="{{$tran->count()}}">{!! $value3->noref !!}</td>
                                                                                @endif
                                                                                <td class="text-right">{!! number_format($item->sub_total, 2, '.', ',') !!}</td>
                                                                                <td>{!! $value3->status !!}</td>
                                                                            </tr>
                                                                                <?php $keynya = $value3->noref;?>
                                                                            @endforeach
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
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
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@stop
