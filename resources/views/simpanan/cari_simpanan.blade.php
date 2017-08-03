@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Simpanan</a>
        </li>
        <li class="active"><a href="{!! url('simpanan') !!}">Daftar Simpanan</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{!! url('simpanan/create') !!}" class="btn btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                                <a href="{!! url('simpanan/import') !!}" class="btn btn-success mb15"><i class="ti ti-import"></i> Import</a>
                            </div>
                            <form class="form-inline" role="form" method="get" action="{{ url('simpanan/search') }}">
                                <div class="form-group mr5">
                                    <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                    <input name="query" type="text" class="form-control" placeholder="Cari simpanan" value="{{ $query  }}" id="cari">
                                </div>
                                <input type="hidden" name="search" value="1">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                                <a href="{!! url('simpanan') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
                                        <th class="text-center">No.Simpanan</th>
                                        <th class="text-center">NPK</th>
                                        <th class="text-center">Kode Anggota</th>
                                        <th class="text-center">Nama Anggota</th>
                                        <th class="text-center">Jenis Simpanan</th>
                                        <th class="text-center">Setoran Bulanan</th>
                                        <th class="text-center">Tanggal Pembuatan</th>
                                        {{--<th class="text-center">Keterangan</th>--}}
                                        <th class="text-center">Option</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = ($simpanan->currentPage() - 1) * $simpanan->perPage() + 1; ?>
                                    @foreach($simpanan as $value)
                                        <tr>
                                            <td class="text-center">{!! $i++ !!}</td>
                                            <td>{!! $value->nomor_simpanan !!}</td>
                                            <td>{!! $value->anggotaid->npk !!}</td>
                                            <td>{!! $value->anggotaid->kode !!}</td>
                                            <td>{!! $value->anggotaid->nama !!}</td>
                                            <td>{!! $value->pengaturanid->jenis_simpanan !!}</td>
                                            {{--<td class="text-right">{!! $value->pengaturanid->suku_bunga !!} %</td>--}}
                                            <td class="text-right">{!! number_format($value->setoran_bulanan, 2, '.', ',') !!}</td>
                                            <td class="text-center">{!! $value->tanggal_pembuatan !!}</td>
                                            {{--<td>{!! $value->keterangan !!}</td>--}}
                                            <td align="center" class="fa-hover">
                                                <a href="{!! url('simpanan/'.$value->id.'/edit') !!}" data-toggle="tooltip" data-placement="left" title="Ubah"><i class="ti-pencil mr5" style="color: blue; font-size: medium"></i></a>
                                                <a href="javascript:void(0)" onclick="konfirm({{$value->id}})" data-toggle="tooltip" data-placement="right" title="Hapus"><i class="ti-trash mr5" style="color: red; font-size: medium"></i></a>
                                            </td>
                                            <td align="center" class="fa-hover">
                                                <?php
                                                $akses = \App\Aksestutup::where('tutup', 'simpanan')->where('jenis', 'aktif')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();
                                                $akses2 = \App\Aksestutup::where('tutup', 'simpanan')->where('jenis', 'blokir')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();
                                                $akses3 = \App\Aksestutup::where('tutup', 'simpanan')->where('jenis', 'tutup')->where('id_user', \Illuminate\Support\Facades\Auth::user()->id)->first();
                                                if($akses == null || $value->status == 0) {
                                                    $dis = "disabled";
                                                } else {
                                                    $dis = "";
                                                }

                                                if($akses2 == null || $value->status == 1) {
                                                    $dis2 = "disabled";
                                                } else {
                                                    $dis2 = "";
                                                }

                                                if($akses3 == null || $value->status == 2) {
                                                    $dis3 = "disabled";
                                                } else {
                                                    $dis3 = "";
                                                }


                                                ?>
                                                {{--<a href="{!! url('simpanan/tutup/'.$value->id."/0") !!}"><button type="button" class="btn btn-{{$value->status == 0 ? 'color' : 'primary'}} btn-xs" {{$dis}}>Aktif</button> </a>--}}
                                                {{--<a href="{!! url('simpanan/tutup/'.$value->id."/1") !!}"><button type="button" class="btn btn-{{$value->status == 1 ? 'color' : 'warning'}} btn-xs" {{$dis}}>Blokir</button> </a>--}}
                                                <a href="{!! url('simpanan/tutup/'.$value->id."/2") !!}"><button type="button" class="btn btn-{{$value->status == 2 ? 'color' : 'warning'}} btn-xs" {{$dis}}><i class="ti-na mr5"> Tutup</i></button> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
{{--                                        {!! str_replace('?','?query='.$query.'&',$simpanan->links()) !!}--}}
                                        {!! $simpanan->appends(['query' => $query])->links() !!}
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
                title: "Apakah Anda Yakin?",
                text: "Data Transaksi Simapanan ini juga akan Terhapus !",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
            }).then(function() {
                swal("Deleted!", "Simpanan Telah Terhapus.", "success");
                location.href =  "{{ url('simpanan') }}/" + id + "/destroy";
            })

        }
    </script>

@stop
