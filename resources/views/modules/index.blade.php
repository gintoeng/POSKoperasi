@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:void(0);"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:void(0);">Pengaturan</a>
        </li>
        <li class="active"><a href="{!! url('pengaturan/module') !!}">Daftar Module</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <a href="{{ url('pengaturan/module/add') }}" class="btn btn-sm btn-primary mb15"><i class="ti ti-plus"></i> Tambah</a>
                            </div>
                            <form class="form-inline" role="form" method="get" action="{{ url('pengaturan/module/search') }}">
                                <div class="form-group mr5">
                                    <label class="control-label" for="cari">&nbsp;&nbsp;&nbsp;</label>
                                    <input name="keyword" type="text" class="form-control" placeholder="Cari" id="cari" value="{{ $keyword }}">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"> Cari</i></button>
                            </form>
                        </div>
                    </div>

                    <div class="pull-right">
                        Total data ditemukan : {{ $count }}
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered responsive no-m">
                            <thead>
                            <tr class="bg-color">
                                <th class="text-center" width="20">No</th>
                                <th class="text-center">Module</th>
                                <th class="text-center">Menu mask</th>
                                <th class="text-center">Menu path</th>
                                <th class="text-center">Icon</th>
                                <th class="text-center">Order</th>
                                <th class="text-center">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = ($modules->currentPage() - 1) * $modules->perPage() + 1; ?>
                            @foreach($modules as $module)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $module->module_name }}</td>
                                    <td>{{ $module->menu_mask }}</td>
                                    <td>{{ $module->menu_path }}</td>
                                    <td class="text-center"><i class="{{ $module->menu_icon }}"></i></td>
                                    <td class="text-center">
                                        <a href="{{ url('pengaturan/module/order/down/'.$module->id) }}" data-toggle="tooltip" data-placement="left" title="Up">
                                            <i class="ti-angle-up"></i>
                                        </a>
                                        <span class="label label-default">{{ $module->menu_order }}</span>
                                        <a href="{{ url('pengaturan/module/order/up/'.$module->id) }}" data-toggle="tooltip" data-placement="left" title="Down">
                                            <i class="ti-angle-down"></i>&nbsp;
                                        </a>
                                    </td>
                                    <td align="center" class="fa-hover">
                                        <a href="{{ url('pengaturan/module/edit'.'/'.$module->id) }}" data-toggle="tooltip" data-placement="left" title="Ubah"><i class="ti-pencil mr5" style="color: blue; font-size: medium"></i></a>
                                        <a href="javascript:void(0)" onclick="konfirm({{$module->id}})" data-toggle="tooltip" data-placement="right" title="Hapus"><i class="ti-trash mr5" style="color: red; font-size: medium"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                {!! $modules->links() !!}
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
                        title: "Apakah Anda Yakin ?",
                        text: "Hak Akses dan Menu Header yang menggunakan Module ini juga akan Terhapus!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',   cancelButtonColor: '#d33',
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
            }).then(function() {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                location.href =  "{{ url('pengaturan/module/delete') }}/" + id;
            })

        }
    </script>

@stop
