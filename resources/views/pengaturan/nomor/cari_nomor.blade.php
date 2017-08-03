@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pengaturan</a>
        </li>
        <li class="active"><a href="{!! url('pengaturan/nomor') !!}">Daftar Nomor</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <!-- <header class="panel-heading">Test Panel</header>-->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{!! url('pengaturan/nomor/create') !!}" class="btn btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                            </div>
                            <form class="form-inline" role="form" method="get" action="{{ url('pengaturan/nomor/search') }}">
                                <div class="form-group mr5">
                                    <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                    <input name="query" type="text" class="form-control" placeholder="Cari nomor" id="cari" value="{{ $query }}">
                                </div>
                                <input type="hidden" name="search" value="1">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                                <a href="{!! url('pengaturan/nomor') !!}"><button type="button" class="btn btn-color btn-sm"><i class="ti ti-reload"> Reset</i></button></a>
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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered responsive no-m">
                            <thead>
                            <tr class="bg-color">
                                <th class="text-center">No</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Modul</th>
                                <th class="text-center">Jumlah Digit</th>
                                <th class="text-center">Nomor Akhir</th>
                                <th class="text-center">Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = ($nomor->currentPage() - 1) * $nomor->perPage() + 1; ?>
                            @foreach($nomor as $value)
                                <tr>
                                    <td class="text-center">{!! $i++ !!}</td>
                                    <td>{!! $value->kode !!}</td>
                                    <td>{!! $value->modul !!}</td>
                                    <td class="text-center">{!! $value->jumlah_digit !!}</td>
                                    <td class="text-center">{!! $value->nomor_akhir !!}</td>
                                    <td align="center" class="fa-hover">
                                        <a href="{!! url('pengaturan/nomor/'.$value->id.'/edit') !!}" data-toggle="tooltip" data-placement="left" title="Ubah"><i class="ti-pencil mr5" style="color: blue; font-size: medium"></i></a>
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
                                {!! $nomor->appends(['query' => $query])->links() !!}
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
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then(function() {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                location.href =  "{{ url('pengaturan/nomor') }}/" + id + "/destroy";
            })
        }
    </script>

@stop
