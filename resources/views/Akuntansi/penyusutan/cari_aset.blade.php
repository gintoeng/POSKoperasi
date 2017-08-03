@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Penyusutan</a>
        </li>
        <li class="active"><a href="{!! url('akuntansi/penyusutan') !!}">Daftar Aset Penyusutan</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{!! url('akuntansi/penyusutan/create/aset') !!}" class="btn btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                            </div>
                            <form class="form-inline" role="form" method="get" action="{{ url('akuntansi/penyusutan/search') }}">
                                <div class="form-group mr5">
                                    <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                    <input name="query" value="{{$query}}" type="text" class="form-control" placeholder="Cari aset" id="cari">
                                </div>
                                <input type="hidden" name="search" value="1">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
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
                                        <th class="text-center" >No</th>
                                        <th class="text-center" >Kode Aset</th>
                                        <th class="text-center" >Nama Aset</th>
                                        <th class="text-center" >Harga</th>
                                        <th class="text-center" >Penyusutan</th>
                                        <th class="text-center" >Bulan</th>
                                        <th class="text-center" >Option</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = ($aset->currentPage() - 1) * $aset->perPage() + 1; ?>
                                    @foreach($aset as $value)
                                        <tr>
                                            <td class="text-center">{!! $i++ !!}</td>
                                            <td>{!! $value->kode_aset !!}</td>
                                            <td>{!! $value->nama_aset !!}</td>
                                            <td class="text-right">{!! number_format($value->nominal_harga, 2, '.', ',') !!}</td>
                                            <td class="text-right">{!! number_format($value->penyusutan, 2, '.', ',') !!}</td>
                                            <td class="text-center">{!! $value->bulan !!}</td>
                                            {{--<td class="text-center" style="background-color: rgba(34, 138, 255, 0.11)">{!! $value->id !!}</td>--}}
                                            <td align="center" class="fa-hover">
                                                <a href="{!! url('akuntansi/penyusutan/edit/'.$value->id.'/aset') !!}" data-toggle="tooltip" data-placement="left" title="Ubah"><i class="ti-pencil mr5" style="color: blue; font-size: medium"></i></a>
                                                <a href="javascript:void(0)" onclick="konfirm({{$value->id}})" data-toggle="tooltip" data-placement="right" title="Hapus"><i class="ti-trash mr5" style="color: red; font-size: medium"></i></a>
                                                <a href="javascript:void(0)" onclick="susutnya({{$value->id}})" data-toggle="tooltip" data-placement="left" title="Detail"><i class="ti-eye mr5" style="color: limegreen; font-size: medium"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        {!! $aset->appends(['query' => $query])->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="rejectModal2" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="judul">Penyusutan Aset</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama_simulasi" class="col-sm-2 control-label">Aset&nbsp;&nbsp;&nbsp;:</label>
                                <div class="col-sm-10">
                                    <label for="nama_simulasi" id="asetname" class="col-sm-12 control-label">LTS - Laptop Toshiba Radius p55w-52316-4k</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div id="table-wrapper">
                                <div class="table-responsive no-border" id="table-scroll">
                                    <table id="tabsusut" class="table table-bordered table-striped no-m scroll" >
                                        <thead>
                                        <tr class="bg-color" style="width: 100%; display: inline-table;table-layout: fixed;">
                                            <th class="text-center" width="50">No.</th>
                                            <th class="text-center" width="70">Bulan</th>
                                            <th class="text-center">Penyusutan</th>
                                            <th class="text-center">Sisa</th>
                                        </tr>
                                        </thead>
                                        <tbody id="bodysusut" style="overflow-y: scroll;height: 350px;width: auto;position: absolute;">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <br>
                            <div class="panel panel-warning">
                                <header class="panel-heading text-center">STATUS</header>
                                <div class="panel-body">
                                    <legend><font size="2">Nominal :</font></legend>
                                    <div class="alert alert-info">
                                        <center><label id="nom"><font size="4">50,000,000</font></label></center>
                                    </div>
                                    <hr/>
                                    <legend><font size="2">Penyusutan :</font></legend>
                                    <div class="alert alert-success">
                                        <center><label id="sut"><font size="4">50,000,000</font></label></center>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <center>
                                        <div id="btnpro"></div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 pull-right">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
                    </div>
                </div>
            </div>
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
                location.href =  "{{ url('akuntansi/penyusutan/destroy') }}/" + id + "/aset";
            })

        }

        function susutnya(id) {
            $.ajax({
                url: "{!! url('akuntansi/penyusutan/detail') !!}/" + id + "/aset",
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {
                    $('#asetname').html('<label for="nama_simulasi" id="asetname" class="col-sm-12 control-label">' + data[0]["aset"] + '</label>');

                    $('#nom').html('<label id="nom"><font size="4">' + data[0]["nominal"] + '</font></label>');
                    $('#sut').html('<label id="nom"><font size="4">' + data[0]["susut"] + '</font></label>');

                    if (data[0]["sisa"] == 0 && data[0]["stat"] == 0) {
                        $('#btnpro').html('<button id="btnpro" onclick="proses('+ id +')" type="button" class="btn btn-primary btn-xs">Proses</button>');
                    } else {
                        $('#btnpro').html('<button id="btnpro" type="button" class="btn btn-xs" disabled>Proses</button>');
                    }
                    $('#tabsusut').load("{!! url('akuntansi/penyusutan/detail/table') !!}/" + id + "/aset");
                    $('#rejectModal2').modal();
                }

            });
        }

        function proses(id) {
            $.ajax({
                url: "{!! url('akuntansi/penyusutan/proses') !!}/" + id + "/aset",
                data: {},
                dataType: "json",
                type: "get",
                success:function(data)
                {

                }

            });
            swal('Good job!', 'Aset Ini Berhasil Di Kosongkan', 'success');
            $('#btnpro').html('<button id="btnpro" type="button" class="btn btn-xs" disabled>Proses</button>');
        }
    </script>

@stop
