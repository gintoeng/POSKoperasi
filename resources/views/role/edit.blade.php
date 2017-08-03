@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li class="active">Pengaturan</li>
        <li class=""><a href="{!! url('pengaturan/role') !!}">Daftar Hak Akses User</a></li>
        <li class="active">Ubah Hak Akses</li>
        <li class="active">{!! $role->id !!}</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <section class="panel no-b">
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="post" action="{{ url('pengaturan/role/update/'.$role->id) }}" id="froled">
                        <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role_name" class="col-sm-3 control-label">Nama Role</label>
                                    <div class="col-sm-9">
                                        <input name="role_name" type="text" class="form-control" id="role_name" placeholder="Nama Role" value="{{ $role->role_name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <input name="desc" type="text" class="form-control" id="description" placeholder="Keterangan" value="{{ $role->desc }}">
                                    </div>
                                </div>
                                <div class="box-tab" id="mtab">
                                    <ul class="nav nav-tabs">
                                        @foreach($module as $module_parent)
                                            <li class=""><a href="#{{ $module_parent->module_name }}" data-toggle="tab">{{ $module_parent->module_name }}</a></li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content text-center">
                                        @foreach($module as $module_parent)
                                            <div class="tab-pane fade in" id="{{ $module_parent->module_name }}">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered responsive no-m">
                                                        <thead>
                                                        <tr>
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
                                                            <?php
                                                            $count_create = DB::table('role_acl')->where('create_acl',$module_child->id)->where('role_id',$role->id)->first();
                                                            $create_acl = DB::table('role_acl')->where('create_acl',$module_child->id)->where('role_id',$role->id)->first();
                                                            $count_read = DB::table('role_acl')->where('read_acl',$module_child->id)->where('role_id',$role->id)->first();
                                                            $read_acl = DB::table('role_acl')->where('read_acl',$module_child->id)->where('role_id',$role->id)->first();
                                                            $count_update = DB::table('role_acl')->where('update_acl',$module_child->id)->where('role_id',$role->id)->first();
                                                            $update_acl = DB::table('role_acl')->where('update_acl',$module_child->id)->where('role_id',$role->id)->first();
                                                            $count_delete = DB::table('role_acl')->where('delete_acl',$module_child->id)->where('role_id',$role->id)->first();
                                                            $delete_acl = DB::table('role_acl')->where('delete_acl',$module_child->id)->where('role_id',$role->id)->first();
                                                            ?>
                                                            <tr id='minimal-checkbox-{{ $module_child->id }}'>
                                                                <td>
                                                                    {{ $module_child->module_name }}
                                                                    <input type="hidden">
                                                                </td>
                                                                @if(count($count_create)==0)
                                                                    <td>
                                                                        @if($module_parent->id != 5)
                                                                        <input name="{{ $module_child->id }}_create" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}" value="{{ $module_child->id }}">
                                                                        @endif
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        @if($module_parent->id != 5)
                                                                        <input name="{{ $module_child->id }}_create" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}"
                                                                               @if($create_acl->create_acl==$module_child->id)
                                                                               checked
                                                                               @endif value="{{ $module_child->id }}">
                                                                        @endif
                                                                    </td>
                                                                @endif
                                                                @if(count($count_read)==0)
                                                                    <td>
                                                                        <input name="{{ $module_child->id }}_read" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}" value="{{ $module_child->id }}">
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <input name="{{ $module_child->id }}_read" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}"
                                                                               @if($read_acl->read_acl==$module_child->id)
                                                                               checked
                                                                               @endif value="{{ $module_child->id }}">
                                                                    </td>
                                                                @endif
                                                                @if(count($count_update)==0)
                                                                    <td>
                                                                        @if($module_parent->id != 5)
                                                                        <input name="{{ $module_child->id }}_update" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}" value="{{ $module_child->id }}">
                                                                        @endif
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        @if($module_parent->id != 5)
                                                                        <input name="{{ $module_child->id }}_update" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}"
                                                                               @if($update_acl->update_acl==$module_child->id)
                                                                               checked
                                                                               @endif value="{{ $module_child->id }}">
                                                                        @endif
                                                                    </td>
                                                                @endif
                                                                @if(count($count_delete)==0)
                                                                    <td>
                                                                        @if($module_parent->id != 5)
                                                                        <input name="{{ $module_child->id }}_delete" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}" value="{{ $module_child->id }}">
                                                                        @endif
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        @if($module_parent->id != 5)
                                                                        <input name="{{ $module_child->id }}_delete" type="checkbox" id="minimal-checkbox-{{ $module_child->id }}"
                                                                               @if($delete_acl->delete_acl==$module_child->id)
                                                                               checked
                                                                               @endif value="{{ $module_child->id }}">
                                                                        @endif
                                                                    </td>
                                                                @endif
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
                                                    <?php $pengaturan91 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999991')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999991'>
                                                        <td>Informasi Instansi</td>
                                                        <td></td>
                                                        <td><input name="9999999991_read" type="checkbox" id="minimal-checkbox-9999999991" value="9999999991" {{$pengaturan91 != null && $pengaturan91->read_acl == '9999999991' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999991" value="all" name="all" onChange="check(9999999991)" /></td>
                                                    </tr>
                                                    <?php $pengaturan92 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999992')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999992'>
                                                        <td>Iklan</td>
                                                        <td></td>
                                                        {{--<td><input name="9999999992_create" type="checkbox" id="minimal-checkbox-9999999992" value="9999999992" {{$pengaturan92 != null && $pengaturan92->create_acl == '9999999992' ? 'checked' : ''}}></td>--}}
                                                        <td><input name="9999999992_read" type="checkbox" id="minimal-checkbox-9999999992" value="9999999992" {{$pengaturan92 != null && $pengaturan92->read_acl == '9999999992' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999992_update" type="checkbox" id="minimal-checkbox-9999999992" value="9999999992" {{$pengaturan92 != null && $pengaturan92->update_acl == '9999999992' ? 'checked' : ''}}></td>
                                                        {{--<td><input name="9999999992_delete" type="checkbox" id="minimal-checkbox-9999999992" value="9999999992" {{$pengaturan92 != null && $pengaturan92->delete_acl == '9999999992' ? 'checked' : ''}}></td>--}}
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999992" value="all" name="all" onChange="check(9999999992)" /></td>
                                                    </tr>
                                                    <?php $pengaturan93 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999993')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999993'>
                                                        <td>Jenis Transaksi</td>
                                                        <td></td>
                                                        <td><input name="9999999993_read" type="checkbox" id="minimal-checkbox-9999999993" value="9999999993" {{$pengaturan93 != null && $pengaturan93->read_acl == '9999999993' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999993_update" type="checkbox" id="minimal-checkbox-9999999993" value="9999999993" {{$pengaturan93 != null && $pengaturan93->update_acl == '9999999993' ? 'checked' : ''}}></td>
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
                                                    <?php $penjualan94 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999994')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999994'>
                                                        <td>Cek Saldo</td>
                                                        <td></td>
                                                        <td><input name="9999999994_read" type="checkbox" id="minimal-checkbox-9999999994" value="9999999994" {{$penjualan94 != null && $penjualan94->read_acl == '9999999994' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999994" value="all" name="all" onChange="check(9999999994)" /></td>
                                                    </tr>
                                                    <?php $penjualan95 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999995')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999995'>
                                                        <td>Pembayaran</td>
                                                        <td><input name="9999999995_create" type="checkbox" id="minimal-checkbox-9999999995" value="9999999995" {{$penjualan95 != null && $penjualan95->create_acl == '9999999995' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999995" value="all" name="all" onChange="check(9999999995)" /></td>
                                                    </tr>
                                                    <?php $penjualan96 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999996')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999996'>
                                                        <td>Tahan Transaksi</td>
                                                        <td><input name="9999999996_create" type="checkbox" id="minimal-checkbox-9999999996" value="9999999996" {{$penjualan96 != null && $penjualan96->create_acl == '9999999996' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999996_read" type="checkbox" id="minimal-checkbox-9999999996" value="9999999996" {{$penjualan96 != null && $penjualan96->read_acl == '9999999996' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999996_update" type="checkbox" id="minimal-checkbox-999999999" value="9999999996" {{$penjualan96 != null && $penjualan96->update_acl == '9999999996' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999996" value="all" name="all" onChange="check(9999999996)" /></td>
                                                    </tr>
                                                    <?php $penjualan97 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999997')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999997'>
                                                        <td>Retur</td>
                                                        <td><input name="9999999997_create" type="checkbox" id="minimal-checkbox-9999999997" value="9999999997" {{$penjualan97 != null && $penjualan97->create_acl == '9999999997' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999997_read" type="checkbox" id="minimal-checkbox-9999999997" value="9999999997" {{$penjualan97 != null && $penjualan97->read_acl == '9999999997' ? 'checked' : ''}}></td>
                                                        {{--<td><input name="9999999997_update" type="checkbox" id="minimal-checkbox-999999997" value="9999999997" {{$penjualan97 != null && $penjualan97->update_acl == '9999999997' ? 'checked' : ''}}></td>--}}
                                                        {{--<td><input name="9999999997_delete" type="checkbox" id="minimal-checkbox-9999999997" value="9999999997" {{$penjualan97 != null && $penjualan97->delete_acl == '9999999997' ? 'checked' : ''}}></td>--}}
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999997" value="all" name="all" onChange="check(9999999997)" /></td>
                                                    </tr>
                                                    <?php $penjualan98 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999998')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999998'>
                                                        <td>List Barang Belanjaan</td>
                                                        <td><input name="9999999998_create" type="checkbox" id="minimal-checkbox-9999999998" value="9999999998" {{$penjualan98 != null && $penjualan98->create_acl == '9999999998' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999998_read" type="checkbox" id="minimal-checkbox-9999999998" value="9999999998" {{$penjualan98 != null && $penjualan98->read_acl == '9999999998' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999998_update" type="checkbox" id="minimal-checkbox-999999998" value="9999999998" {{$penjualan98 != null && $penjualan98->update_acl == '9999999998' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999998_delete" type="checkbox" id="minimal-checkbox-9999999998" value="9999999998" {{$penjualan98 != null && $penjualan98->delete_acl == '9999999998' ? 'checked' : ''}}></td>
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
                                                    <?php $inv81 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999981')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999981'>
                                                        <td>Pembelian Supplier</td>
                                                        <td><input name="9999999981_create" type="checkbox" id="minimal-checkbox-9999999981" value="9999999981" {{$inv81 != null && $inv81->create_acl == '9999999981' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999981_read" type="checkbox" id="minimal-checkbox-9999999981" value="9999999981" {{$inv81 != null && $inv81->read_acl == '9999999981' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999981_update" type="checkbox" id="minimal-checkbox-9999999981" value="9999999981" {{$inv81 != null && $inv81->update_acl == '9999999981' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999981_delete" type="checkbox" id="minimal-checkbox-9999999981" value="9999999981" {{$inv81 != null && $inv81->delete_acl == '9999999981' ? 'checked' : ''}}></td>
                                                        <td><input type="checkbox" id="all-9999999981" value="all" name="all" onChange="check(9999999981)" /></td>
                                                    </tr>
                                                    <?php $inv82 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999982')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999982'>
                                                        <td>Penerimaan Supplier</td>
                                                        <td><input name="9999999982_create" type="checkbox" id="minimal-checkbox-9999999982" value="9999999982" {{$inv82 != null && $inv82->create_acl == '9999999982' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999982_read" type="checkbox" id="minimal-checkbox-9999999982" value="9999999982" {{$inv82 != null && $inv82->read_acl == '9999999982' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999982_update" type="checkbox" id="minimal-checkbox-9999999982" value="9999999982" {{$inv82 != null && $inv82->update_acl == '9999999982' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999982_delete" type="checkbox" id="minimal-checkbox-9999999982" value="9999999982" {{$inv82 != null && $inv82->delete_acl == '9999999982' ? 'checked' : ''}}></td>
                                                        <td><input type="checkbox" id="all-9999999982" value="all" name="all" onChange="check(9999999982)" /></td>
                                                    </tr>
                                                    <?php $inv83 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999983')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999983'>
                                                        <td>Retur Supplier</td>
                                                        <td><input name="9999999983_create" type="checkbox" id="minimal-checkbox-9999999983" value="9999999983" {{$inv83 != null && $inv83->create_acl == '9999999983' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999983_read" type="checkbox" id="minimal-checkbox-9999999983" value="9999999983" {{$inv83 != null && $inv83->read_acl == '9999999983' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999983_update" type="checkbox" id="minimal-checkbox-9999999983" value="9999999983" {{$inv83 != null && $inv83->update_acl == '9999999983' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999983_delete" type="checkbox" id="minimal-checkbox-9999999983" value="9999999983" {{$inv83 != null && $inv83->delete_acl == '9999999983' ? 'checked' : ''}}></td>
                                                        <td><input type="checkbox" id="all-9999999983" value="all" name="all" onChange="check(9999999983)" /></td>
                                                    </tr>
                                                    <?php $inv84 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999984')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999984'>
                                                        <td>Pengiriman Cabang</td>
                                                        <td><input name="9999999984_create" type="checkbox" id="minimal-checkbox-9999999984" value="9999999984" {{$inv84 != null && $inv84->create_acl == '9999999984' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999984_read" type="checkbox" id="minimal-checkbox-9999999984" value="9999999984" {{$inv84 != null && $inv84->read_acl == '9999999984' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999984_update" type="checkbox" id="minimal-checkbox-9999999984" value="9999999984" {{$inv84 != null && $inv84->update_acl == '9999999984' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999984_delete" type="checkbox" id="minimal-checkbox-9999999984" value="9999999984" {{$inv84 != null && $inv84->delete_acl == '9999999984' ? 'checked' : ''}}></td>
                                                        <td><input type="checkbox" id="all-9999999984" value="all" name="all" onChange="check(9999999984)" /></td>
                                                    </tr>
                                                    <?php $inv85 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999985')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999985'>
                                                        <td>Penerimaan Cabang</td>
                                                        <td><input name="9999999985_create" type="checkbox" id="minimal-checkbox-9999999985" value="9999999985" {{$inv85 != null && $inv85->create_acl == '9999999985' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999985_read" type="checkbox" id="minimal-checkbox-9999999985" value="9999999985" {{$inv85 != null && $inv85->read_acl == '9999999985' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999985_update" type="checkbox" id="minimal-checkbox-9999999985" value="9999999985" {{$inv85 != null && $inv85->update_acl == '9999999985' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999985_delete" type="checkbox" id="minimal-checkbox-9999999985" value="9999999985" {{$inv85 != null && $inv85->delete_acl == '9999999985' ? 'checked' : ''}}></td>
                                                        <td><input type="checkbox" id="all-9999999985" value="all" name="all" onChange="check(9999999985)" /></td>
                                                    </tr>
                                                    <?php $inv86 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999986')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999986'>
                                                        <td>Stock Opname</td>
                                                        <td><input name="9999999986_create" type="checkbox" id="minimal-checkbox-9999999986" value="9999999986" {{$inv86 != null && $inv86->create_acl == '9999999986' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999986_read" type="checkbox" id="minimal-checkbox-9999999986" value="9999999986" {{$inv86 != null && $inv86->read_acl == '9999999986' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999986_update" type="checkbox" id="minimal-checkbox-9999999986" value="9999999986" {{$inv86 != null && $inv86->update_acl == '9999999986' ? 'checked' : ''}}></td>
                                                        <td><input name="9999999986_delete" type="checkbox" id="minimal-checkbox-9999999986" value="9999999986" {{$inv86 != null && $inv86->delete_acl == '9999999986' ? 'checked' : ''}}></td>
                                                        <td><input type="checkbox" id="all-9999999986" value="all" name="all" onChange="check(9999999986)" /></td>
                                                    </tr>
                                                    <?php $inv87 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999987')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999987'>
                                                        <td>Laporan Barang Masuk</td>
                                                        <td></td>
                                                        <td><input name="9999999987_read" type="checkbox" id="minimal-checkbox-9999999987" value="9999999987" {{$inv87 != null && $inv87->read_acl == '9999999987' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999987" value="all" name="all" onChange="check(9999999987)" /></td>
                                                    </tr>
                                                    <?php $inv88 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999988')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999988'>
                                                        <td>Laporan Barang Keluar</td>
                                                        <td></td>
                                                        <td><input name="9999999988_read" type="checkbox" id="minimal-checkbox-9999999988" value="9999999988" {{$inv88 != null && $inv88->read_acl == '9999999988' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999988" value="all" name="all" onChange="check(9999999988)" /></td>
                                                    </tr>
                                                    <?php $inv89 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999989')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999989'>
                                                        <td>Stock Minimum</td>
                                                        <td></td>
                                                        <td><input name="9999999989_read" type="checkbox" id="minimal-checkbox-9999999989" value="9999999989" {{$inv89 != null && $inv89->read_acl == '9999999989' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999989" value="all" name="all" onChange="check(9999999989)" /></td>
                                                    </tr>
                                                    <?php $inv90 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999990')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999990'>
                                                        <td>Barang Expired</td>
                                                        <td></td>
                                                        <td><input name="9999999990_read" type="checkbox" id="minimal-checkbox-9999999990" value="9999999990" {{$inv90 != null && $inv90->read_acl == '9999999990' ? 'checked' : ''}}></td>
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
                                                    <?php $laporan71 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999971')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999971'>
                                                        <td>Proses Hitung HPP</td>
                                                        <td><input name="9999999971_create" type="checkbox" id="minimal-checkbox-9999999971" value="9999999971" {{$laporan71 != null && $laporan71->create_acl == '9999999971' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999971" value="all" name="all" onChange="check(9999999971)" /></td>
                                                    </tr>
                                                    <?php $laporan72 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999972')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999972'>
                                                        <td>Laporan Stok Barang</td>
                                                        <td></td>
                                                        <td><input name="9999999972_read" type="checkbox" id="minimal-checkbox-9999999972" value="9999999972" {{$laporan72 != null && $laporan72->read_acl == '9999999972' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999972" value="all" name="all" onChange="check(9999999972)" /></td>
                                                    </tr>
                                                    <?php $laporan73 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999973')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999973'>
                                                        <td>Laporan HPP</td>
                                                        <td></td>
                                                        <td><input name="9999999973_read" type="checkbox" id="minimal-checkbox-9999999973" value="9999999973" {{$laporan73 != null && $laporan73->read_acl == '9999999973' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999973" value="all" name="all" onChange="check(9999999973)" /></td>
                                                    </tr>
                                                    <?php $laporan74 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999974')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999974'>
                                                        <td>Laporan Penjualan</td>
                                                        <td></td>
                                                        <td><input name="9999999974_read" type="checkbox" id="minimal-checkbox-9999999974" value="9999999974" {{$laporan74 != null && $laporan74->read_acl == '9999999974' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999974" value="all" name="all" onChange="check(9999999974)" /></td>
                                                    </tr>
                                                    <?php $laporan75 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999975')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999975'>
                                                        <td>Laporan Penjualan Anggota</td>
                                                        <td></td>
                                                        <td><input name="9999999975_read" type="checkbox" id="minimal-checkbox-9999999975" value="9999999975" {{$laporan75 != null && $laporan75->read_acl == '9999999975' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999975" value="all" name="all" onChange="check(9999999975)" /></td>
                                                    </tr>
                                                    <?php $laporan76 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999976')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999976'>
                                                        <td>Retur Penjualan</td>
                                                        <td></td>
                                                        <td><input name="9999999976_read" type="checkbox" id="minimal-checkbox-9999999976" value="9999999976" {{$laporan76 != null && $laporan76->read_acl == '9999999976' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999976" value="all" name="all" onChange="check(9999999976)" /></td>
                                                    </tr>
                                                    <?php $laporan77 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999977')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999977'>
                                                        <td>Rekap Penjualan</td>
                                                        <td></td>
                                                        <td><input name="9999999977_read" type="checkbox" id="minimal-checkbox-9999999977" value="9999999977" {{$laporan77 != null && $laporan77->read_acl == '9999999977' ? 'checked' : ''}}></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><input type="checkbox" id="all-9999999977" value="all" name="all" onChange="check(9999999977)" /></td>
                                                    </tr>
                                                    <?php $laporan78 = \App\Roleaclwaserda::where('role_id', $role->id)->where('mod_kd', '9999999978')->first() ;?>
                                                    <tr id='minimal-checkbox-9999999978'>
                                                        <td>Fast Moving & Slow Moving</td>
                                                        <td></td>
                                                        <td><input name="9999999978_read" type="checkbox" id="minimal-checkbox-9999999978" value="99999999778" {{$laporan78 != null && $laporan78->read_acl == '9999999978' ? 'checked' : ''}}></td>
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
                                        <a href="{{ url('pengaturan/role') }}" class="btn btn-danger btn-block">Cancel</a>
                                    </div>
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
                                                    <input tabindex="1" type="radio" onclick="mtabkop()" id="radio1" name="akses" value="koperasi" {!! $role->akses == "koperasi" ? 'checked' : '' !!}>
                                                    <label for="radio1"><i class="fa fa-umbrella mr5"></i>KOPERASI</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="2" type="radio" onclick="mtabpos()" id="radio2" name="akses" value="pos" {!! $role->akses == "pos" ? 'checked' : '' !!}>
                                                    <label for="radio2"><i class="fa fa-star mr5"></i>POS</label>
                                                </div>
                                                <div class="mb5">
                                                    <input tabindex="3" type="radio" onclick="mtabkas()" id="radio3" name="akses" value="kasir" {!! $role->akses == "kasir" ? 'checked' : '' !!}>
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
            <a class="exit-offscreen"></a>
        </div>
    </div>

    @include('master.modal_js')

    <script type="text/javascript">
        @if($role->akses == "koperasi")
            mtabokop();
        @elseif($role->akses == "pos")
                mtabpos();
        @else
                mtabkas();
        @endif

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
                $('#froled').submit();
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
