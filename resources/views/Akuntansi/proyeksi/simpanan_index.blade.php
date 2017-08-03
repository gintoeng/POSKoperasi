@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Proyeksi</a>
        </li>
        <li class="active"><a href="{!! url('akuntansi/proyeksi/simpanan') !!}">Proyeksi Simpanan</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form role="form" class="form-horizontal" method="get" action="{!! url('akuntansi/proyeksi/simpanan/cetak') !!}" target="_blank" id="fprosimp">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="print" id="print" value="">
                                <div class="pull-left">
                                    <button id="btnpre" type="button" class="btn btn-sm btn-warning mb15"><i class="fa fa-file-text-o mr5"></i>Preview</button>
                                    <button id="btnctk" type="button" class="btn btn-sm btn-danger mb15"><i class="fa fa-file-pdf-o mr5"></i>PDF</button>
                                    <a href="{!! url('akuntansi/proyeksi/simpanan/excel') !!}" ><button id="btnexc" type="button" class="btn btn-sm btn-success mb15"><i class="fa fa-file-excel-o mr5"></i>Excel</button></a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="pull-right">
                        Total data ditemukan : {!! $jml !!}
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive no-border">
                                <table class="table table-bordered table-striped no-m">
                                    <thead>
                                    <tr class="bg-color">
                                        <th rowspan="2" class="text-center" style="vertical-align: middle;">No</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle;">Kode Anggota</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle;">Nama Anggota</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle;">NPK</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle;">Simpanan</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle;">Setoran Bulanan</th>
                                        <th rowspan="2" class="text-center" style="vertical-align: middle;">Tgl. Pembuatan</th>
                                        {{--<th rowspan="2" class="text-center" style="vertical-align: middle;">Total Bulan</th>--}}
                                        <th rowspan="2" class="text-center" style="vertical-align: middle;">Saldo Sekarang</th>
                                        <th colspan="2" class="text-center">Bulan Ini</th>
                                    </tr>
                                    <tr class="bg-color">
                                        <th class="text-center">Setoran</th>
                                        <th class="text-center">Saldo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        date_default_timezone_set('Asia/Jakarta');
                                        $i = ($simpanan->currentPage() - 1) * $simpanan->perPage() + 1;
                                            $idanggota = "";
                                    ?>
                                    @foreach($simpanan as $value)
                                        <?php $cektr = \App\Model\Simpanan\Transaksi::where('id_simpanan', $value->id)->where('tanggal', '>=', date('Y-m-01'))->where('tanggal', '<=', date('Y-m-t'))->where('tipe', 'SETOR')->where('kredit' , $value->setoran_bulanan)->first();
                                                $cekang = \App\Model\Simpanan\Simpanan::where('anggota', $value->anggota)->count();
                                        ?>
                                        <tr>
                                            @if($value->anggota != $idanggota)
                                                <td rowspan="{{$cekang}}" class="text-center">{!! $i++ !!}</td>
                                                <td rowspan="{{$cekang}}">{!! $value->anggotaid->kode !!}</td>
                                                <td rowspan="{{$cekang}}">{!! $value->anggotaid->nama !!}</td>
                                                <td rowspan="{{$cekang}}">{!! $value->anggotaid->npk !!}</td>
                                            @endif
                                            <td>{!! $value->pengaturanid->jenis_simpanan !!}</td>
                                            <td class="text-right">{!! number_format($value->setoran_bulanan, 2, '.', ',') !!}</td>
                                            <td class="text-center">{!! $value->tanggal_pembuatan !!}</td>
                                            @if($cektr == null)
                                                <td class="text-right">{!! number_format($value->akumulasiid->saldo, 2, '.', ',') !!}</td>
                                                <td class="text-right">{!! number_format($value->setoran_bulanan, 2, '.', ',') !!}</td>
                                                <td class="text-right">{!! number_format($value->akumulasiid->saldo + $value->setoran_bulanan, 2, '.', ',') !!}</td>
                                            @else
                                                <td class="text-right">{!! number_format($value->akumulasiid->saldo - $value->setoran_bulanan, 2, '.', ',') !!}</td>
                                                <td class="text-right">{!! number_format($value->setoran_bulanan, 2, '.', ',') !!}</td>
                                                <td class="text-right">{!! number_format($value->akumulasiid->saldo, 2, '.', ',') !!}</td>
                                            @endif
                                        </tr>
                                        <?php $idanggota = $value->anggota; ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        {!! $simpanan->links() !!}
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
                text: "Data Vendor yg menggunakan Bank ini juga akan Terhapus !",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then(function() {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                location.href =  "{{ url('master/bank') }}/" + id + "/destroy";
            })

        }

        $('#btnpre').on('click', function(){
            $('#print').val("preview");
            $('#fprosimp').submit();
        });
        $('#btnctk').on('click', function(){
            $('#print').val("cetak");
            $('#fprosimp').submit();
        });
    </script>

@stop
