@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li class="active">Pengaturan</li>
        <li class=""><a href="{!! url('pengaturan/role') !!}">Daftar Hak Akses User</a></li>
        <li class="active">Tambah Hak Akses</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{{ url('pengaturan/role/add') }}" id="frole">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role_name" class="col-sm-3 control-label">Nama Role</label>
                                    <div class="col-sm-9">
                                        <input name="role_name" type="text" class="form-control" id="role_name" placeholder="Nama Role">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input name="desc" type="text" class="form-control" id="description" placeholder="Keterangan">
                                    </div>
                                </div>
                                <div class="box-tab" id="mtab">
                                    <ul class="nav nav-tabs">
                                        @foreach($module as $module_parent)
                                            <li class="" id="{{$module_parent->id}}"><a href="#{{ $module_parent->module_name }}" data-toggle="tab">{{ $module_parent->module_name }}</a></li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content text-center">
                                        @foreach($module as $module_parent)
                                            <div class="tab-pane fade in" id="{{ $module_parent->module_name }}">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered responsive no-m">
                                                        <thead>
                                                        <tr class="bg-primary">
                                                            <th class="">Module</th>
                                                            <th class="text-center">Create</th>
                                                            <th class="text-center">Read</th>
                                                            <th class="text-center">Update</th>
                                                            <th class="text-center">Delete</th>
                                                            <th class="text-center">Check All</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="">
                                                        @foreach(App\Module::where('menu_parent', $module_parent->id)->get() as $module_child)
                                                            <tr id='minimal-checkbox-{{ $module_child->id }}'>
                                                                <td>
                                                                    {{ $module_child->module_name }}
                                                                </td>
                                                                <td>
                                                                    @if($module_parent->id != 5)
                                                                    <input name="{{ $module_child->id }}_create" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}" value="{{ $module_child->id }}">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <input name="{{ $module_child->id }}_read" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}" value="{{ $module_child->id }}">
                                                                </td>
                                                                <td>
                                                                    @if($module_parent->id != 5)
                                                                    <input name="{{ $module_child->id }}_update" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}" value="{{ $module_child->id }}">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($module_parent->id != 5)
                                                                    <input name="{{ $module_child->id }}_delete" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}" value="{{ $module_child->id }}">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($module_parent->id != 5)
                                                                    <div id="checkboxes">
                                                                        <input type="checkbox" id="all-{{ $module_child->id }}" value="all" name="all" onChange="check({{ $module_child->id }})" />
                                                                    </div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="box-tab hide" id="mtab2">
                                    <ul class="nav nav-tabs">
                                        <li class="active" id="91"><a href="#pospengaturan" data-toggle="tab">Pengaturan</a></li>
                                        <li class="" id="92"><a href="#pospenjualan" data-toggle="tab">Penjualan</a></li>
                                        <li class="" id="93"><a href="#posinventory" data-toggle="tab">Inventory</a></li>
                                        <li class="" id="94"><a href="#poslaporan" data-toggle="tab">Laporan</a></li>
                                    </ul>
                                    <div class="tab-content text-center">
                                        <div class="tab-pane fade in active" id="pospengaturan">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered responsive no-m">
                                                    <thead>
                                                    <tr class="bg-primary">
                                                        <th class="">Module</th>
                                                        <th class="text-center">Create</th>
                                                        <th class="text-center">Read</th>
                                                        <th class="text-center">Update</th>
                                                        <th class="text-center">Delete</th>
                                                        <th class="text-center">Check All</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="">
                                                    <tr id='minimal-checkbox-9999999991'>
                                                        <td>Informasi Instansi</td>
                                                        <td></td>
                                                        <td><input name="9999999991_read" type="checkbox" id="minimal-checkbox-9999999991" value="9999999991"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999991" value="all" name="all" onChange="check(9999999991)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999992'>
                                                        <td>Iklan</td>
                                                        <td></td>
                                                        {{--<td><input name="9999999992_create" type="checkbox" id="minimal-checkbox-9999999992" value="9999999992"></td>--}}
                                                        <td><input name="9999999992_read" type="checkbox" id="minimal-checkbox-9999999992" value="9999999992"></td>
                                                        <td><input name="9999999992_update" type="checkbox" id="minimal-checkbox-9999999992" value="9999999992"></td>
                                                        {{--<td><input name="9999999992_delete" type="checkbox" id="minimal-checkbox-9999999992" value="9999999992"></td>--}}
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999992" value="all" name="all" onChange="check(9999999992)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999993'>
                                                        <td>Jenis Transaksi</td>
                                                        <td></td>
                                                        <td><input name="9999999993_read" type="checkbox" id="minimal-checkbox-9999999993" value="9999999993"></td>
                                                        <td><input name="9999999993_update" type="checkbox" id="minimal-checkbox-9999999993" value="9999999993"></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999993" value="all" name="all" onChange="check(9999999993)" /></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade in" id="pospenjualan">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered responsive no-m">
                                                    <thead>
                                                    <tr class="bg-primary">
                                                        <th class="">Module</th>
                                                        <th class="text-center">Create</th>
                                                        <th class="text-center">Read</th>
                                                        <th class="text-center">Update</th>
                                                        <th class="text-center">Delete</th>
                                                        <th class="text-center">Check All</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="">
                                                    <tr id='minimal-checkbox-9999999994'>
                                                        <td>Cek Saldo</td>
                                                        <td></td>
                                                        <td><input name="9999999994_read" type="checkbox" id="minimal-checkbox-9999999994" value="9999999994"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999994" value="all" name="all" onChange="check(9999999994)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999995'>
                                                        <td>Pembayaran</td>
                                                        <td><input name="9999999995_create" type="checkbox" id="minimal-checkbox-9999999995" value="9999999995"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999995" value="all" name="all" onChange="check(9999999995)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999996'>
                                                        <td>Tahan Transaksi</td>
                                                        <td><input name="9999999996_create" type="checkbox" id="minimal-checkbox-9999999996" value="9999999996"></td>
                                                        <td><input name="9999999996_read" type="checkbox" id="minimal-checkbox-9999999996" value="9999999996"></td>
                                                        <td><input name="9999999996_update" type="checkbox" id="minimal-checkbox-999999999" value="9999999996"></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999996" value="all" name="all" onChange="check(9999999996)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999997'>
                                                        <td>Retur</td>
                                                        <td><input name="9999999997_create" type="checkbox" id="minimal-checkbox-9999999997" value="9999999997"></td>
                                                        <td><input name="9999999997_read" type="checkbox" id="minimal-checkbox-9999999997" value="9999999997"></td>
                                                        {{--<td><input name="9999999997_update" type="checkbox" id="minimal-checkbox-999999997" value="9999999997"></td>--}}
                                                        {{--<td><input name="9999999997_delete" type="checkbox" id="minimal-checkbox-9999999997" value="9999999997"></td>--}}
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999997" value="all" name="all" onChange="check(9999999997)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999998'>
                                                        <td>List Barang Belanjaan</td>
                                                        <td><input name="9999999998_create" type="checkbox" id="minimal-checkbox-9999999998" value="9999999998"></td>
                                                        <td><input name="9999999998_read" type="checkbox" id="minimal-checkbox-9999999998" value="9999999998"></td>
                                                        <td><input name="9999999998_update" type="checkbox" id="minimal-checkbox-999999998" value="9999999998"></td>
                                                        <td><input name="9999999998_delete" type="checkbox" id="minimal-checkbox-9999999998" value="9999999998"></td>
                                                        <td><input type="checkbox" id="all-9999999998" value="all" name="all" onChange="check(9999999998)" /></td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade in" id="posinventory">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered responsive no-m">
                                                    <thead>
                                                    <tr class="bg-primary">
                                                        <th class="">Module</th>
                                                        <th class="text-center">Create</th>
                                                        <th class="text-center">Read</th>
                                                        <th class="text-center">Update</th>
                                                        <th class="text-center">Delete</th>
                                                        <th class="text-center">Check All</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="">
                                                    <tr id='minimal-checkbox-9999999981'>
                                                        <td>Pembelian Supplier</td>
                                                        <td><input name="9999999981_create" type="checkbox" id="minimal-checkbox-9999999981" value="9999999981"></td>
                                                        <td><input name="9999999981_read" type="checkbox" id="minimal-checkbox-9999999981" value="9999999981"></td>
                                                        <td><input name="9999999981_update" type="checkbox" id="minimal-checkbox-9999999981" value="9999999981"></td>
                                                        <td><input name="9999999981_delete" type="checkbox" id="minimal-checkbox-9999999981" value="9999999981"></td>
                                                        <td><input type="checkbox" id="all-9999999981" value="all" name="all" onChange="check(9999999981)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999982'>
                                                        <td>Penerimaan Supplier</td>
                                                        <td><input name="9999999982_create" type="checkbox" id="minimal-checkbox-9999999982" value="9999999982"></td>
                                                        <td><input name="9999999982_read" type="checkbox" id="minimal-checkbox-9999999982" value="9999999982"></td>
                                                        <td><input name="9999999982_update" type="checkbox" id="minimal-checkbox-9999999982" value="9999999982"></td>
                                                        <td><input name="9999999982_delete" type="checkbox" id="minimal-checkbox-9999999982" value="9999999982"></td>
                                                        <td><input type="checkbox" id="all-9999999982" value="all" name="all" onChange="check(9999999982)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999983'>
                                                        <td>Retur Supplier</td>
                                                        <td><input name="9999999983_create" type="checkbox" id="minimal-checkbox-9999999983" value="9999999983"></td>
                                                        <td><input name="9999999983_read" type="checkbox" id="minimal-checkbox-9999999983" value="9999999983"></td>
                                                        <td><input name="9999999983_update" type="checkbox" id="minimal-checkbox-9999999983" value="9999999983"></td>
                                                        <td><input name="9999999983_delete" type="checkbox" id="minimal-checkbox-9999999983" value="9999999983"></td>
                                                        <td><input type="checkbox" id="all-9999999983" value="all" name="all" onChange="check(9999999983)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999984'>
                                                        <td>Pengiriman Cabang</td>
                                                        <td><input name="9999999984_create" type="checkbox" id="minimal-checkbox-9999999984" value="9999999984"></td>
                                                        <td><input name="9999999984_read" type="checkbox" id="minimal-checkbox-9999999984" value="9999999984"></td>
                                                        <td><input name="9999999984_update" type="checkbox" id="minimal-checkbox-9999999984" value="9999999984"></td>
                                                        <td><input name="9999999984_delete" type="checkbox" id="minimal-checkbox-9999999984" value="9999999984"></td>
                                                        <td><input type="checkbox" id="all-9999999984" value="all" name="all" onChange="check(9999999984)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999985'>
                                                        <td>Penerimaan Cabang</td>
                                                        <td><input name="9999999985_create" type="checkbox" id="minimal-checkbox-9999999985" value="9999999985"></td>
                                                        <td><input name="9999999985_read" type="checkbox" id="minimal-checkbox-9999999985" value="9999999985"></td>
                                                        <td><input name="9999999985_update" type="checkbox" id="minimal-checkbox-9999999985" value="9999999985"></td>
                                                        <td><input name="9999999985_delete" type="checkbox" id="minimal-checkbox-9999999985" value="9999999985"></td>
                                                        <td><input type="checkbox" id="all-9999999985" value="all" name="all" onChange="check(9999999985)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999986'>
                                                        <td>Stock Opname</td>
                                                        <td><input name="9999999986_create" type="checkbox" id="minimal-checkbox-9999999986" value="9999999986"></td>
                                                        <td><input name="9999999986_read" type="checkbox" id="minimal-checkbox-9999999986" value="9999999986"></td>
                                                        <td><input name="9999999986_update" type="checkbox" id="minimal-checkbox-9999999986" value="9999999986"></td>
                                                        <td><input name="9999999986_delete" type="checkbox" id="minimal-checkbox-9999999986" value="9999999986"></td>
                                                        <td><input type="checkbox" id="all-9999999986" value="all" name="all" onChange="check(9999999986)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999987'>
                                                        <td>Laporan Barang Masuk</td>
                                                        <td></td>
                                                        <td><input name="9999999987_read" type="checkbox" id="minimal-checkbox-9999999987" value="9999999987"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999987" value="all" name="all" onChange="check(9999999987)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999988'>
                                                        <td>Laporan Barang Keluar</td>
                                                        <td></td>
                                                        <td><input name="9999999988_read" type="checkbox" id="minimal-checkbox-9999999988" value="9999999988"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999988" value="all" name="all" onChange="check(9999999988)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999989'>
                                                        <td>Stock Minimum</td>
                                                        <td></td>
                                                        <td><input name="9999999989_read" type="checkbox" id="minimal-checkbox-9999999989" value="9999999989"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999989" value="all" name="all" onChange="check(9999999989)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999990'>
                                                        <td>Barang Expired</td>
                                                        <td></td>
                                                        <td><input name="9999999990_read" type="checkbox" id="minimal-checkbox-9999999990" value="9999999990"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999990" value="all" name="all" onChange="check(9999999990)" /></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade in" id="poslaporan">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered responsive no-m">
                                                    <thead>
                                                    <tr class="bg-primary">
                                                        <th class="">Module</th>
                                                        <th class="text-center">Create</th>
                                                        <th class="text-center">Read</th>
                                                        <th class="text-center">Update</th>
                                                        <th class="text-center">Delete</th>
                                                        <th class="text-center">Check All</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="">
                                                    <tr id='minimal-checkbox-9999999971'>
                                                        <td>Proses Hitung HPP</td>
                                                        <td><input name="9999999971_create" type="checkbox" id="minimal-checkbox-9999999971" value="9999999971"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999971" value="all" name="all" onChange="check(9999999971)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999972'>
                                                        <td>Laporan Stok Barang</td>
                                                        <td></td>
                                                        <td><input name="9999999972_read" type="checkbox" id="minimal-checkbox-9999999972" value="9999999972"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999972" value="all" name="all" onChange="check(9999999972)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999973'>
                                                        <td>Laporan HPP</td>
                                                        <td></td>
                                                        <td><input name="9999999973_read" type="checkbox" id="minimal-checkbox-9999999973" value="9999999973"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999973" value="all" name="all" onChange="check(9999999973)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999974'>
                                                        <td>Laporan Penjualan</td>
                                                        <td></td>
                                                        <td><input name="9999999974_read" type="checkbox" id="minimal-checkbox-9999999974" value="9999999974"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999974" value="all" name="all" onChange="check(9999999974)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999975'>
                                                        <td>Laporan Penjualan Anggota</td>
                                                        <td></td>
                                                        <td><input name="9999999975_read" type="checkbox" id="minimal-checkbox-9999999975" value="9999999975"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999975" value="all" name="all" onChange="check(9999999975)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999976'>
                                                        <td>Retur Penjualan</td>
                                                        <td></td>
                                                        <td><input name="9999999976_read" type="checkbox" id="minimal-checkbox-9999999976" value="9999999976"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999976" value="all" name="all" onChange="check(9999999976)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999977'>
                                                        <td>Rekap Penjualan</td>
                                                        <td></td>
                                                        <td><input name="9999999977_read" type="checkbox" id="minimal-checkbox-9999999977" value="9999999977"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999977" value="all" name="all" onChange="check(9999999977)" /></td>
                                                    </tr>
                                                    <tr id='minimal-checkbox-9999999978'>
                                                        <td>Fast Moving & Slow Moving</td>
                                                        <td></td>
                                                        <td><input name="9999999978_read" type="checkbox" id="minimal-checkbox-9999999978" value="99999999778"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999978" value="all" name="all" onChange="check(9999999978)" /></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_lahir" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-2">
                                        <input type="button" onclick="btnsave()" class="btn btn-primary btn-block" name="save" value="Save">
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{{ url('pengaturan/role')  }}" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
                                    <script type="text/javascript">
                                        var d = document.getElementById("1");
                                        // d.className += "active";
                                        d.classList.add("active");
                                    </script>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <section class="panel panel-success">
                                    <header class="panel-heading" style="background-color: #00ae00; color: white">Pilih Akses</header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="pilih" class="col-sm-1 control-label"></label>
                                            <div class="col-sm-10">
                                                <div class="mb5 mt5">
                                                    <input tabindex="1" type="radio" onclick="mtabkop()" id="radio1" name="akses" value="koperasi" checked>
                                                    <label for="radio1"><i class="fa fa-umbrella mr5"></i>KOPERASI</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="2" type="radio" onclick="mtabpos()" id="radio2" name="akses" value="pos">
                                                    <label for="radio2"><i class="fa fa-star mr5"></i>POS</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="3" type="radio" onclick="mtabkas()" id="radio3" name="akses" value="kasir">
                                                    <label for="radio3"><i class="fa fa-user mr5"></i>Kasir</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    @include('master.modal_js')

    <script type="text/javascript">
        function check(no) {
            document.getElementById('minimal-checkbox-'+no).addEventListener('change', function(e) {
                var el = e.target;
                var inputs = document.getElementById('minimal-checkbox-'+no).getElementsByTagName('input');

                if (el.id === 'all-'+no) {
                    for (var i = 0, input; input = inputs[i++]; ) {
                        input.checked = el.checked;
                    }
                } else {
                    var numChecked = 0;

                    for (var i = 1, input; input = inputs[i++]; ) {
                        if (input.checked) {
                            numChecked++;
                        }
                    }
                    inputs[0].checked = numChecked === inputs.length - 1;
                }
            }, false);
        }

        function btnsave() {
            if ($('#role_name').val() == "") {
                $('#judul').html('<h4 class="modal-title" id="judul">Nama Role</h4>');
                $('#mess').html('<p id="mess">Nama Role tidak boleh kosong.</p>');
                $('#rejectModal').modal();
            } else {
                FunctionLoading();
                $('#frole').submit();
            }
        }

        function mtabkop() {
            $("#mtab").removeClass('hide');
            $("#mtab").show();
            $("#mtab2").hide();
        }

        function mtabpos() {
            $("#mtab2").removeClass('hide');
            $("#mtab2").show();
            $("#mtab").hide();

            $('.nav-tabs a[href="#pospengaturan"]').tab('show');

            $("#91").removeClass('hide');
            $("#91").show();
            $("#92").removeClass('hide');
            $("#92").show();
            $("#93").removeClass('hide');
            $("#93").show();
            $("#94").removeClass('hide');
            $("#94").show();
        }

        function mtabkas() {
            $("#mtab2").removeClass('hide');
            $("#mtab2").show();
            $("#mtab").hide();

            $('.nav-tabs a[href="#pospenjualan"]').tab('show');

            $("#91").hide();
            $("#92").removeClass('hide');
            $("#92").show();
            $("#93").hide();
            $("#94").hide();
        }
    </script>

@stop
