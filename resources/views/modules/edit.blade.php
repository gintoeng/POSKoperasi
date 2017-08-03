@extends('layouts.master')

@section('content')

    <ol class="breadcrumb">
        <li>
            <a href="javascript:;"><i class="ti-home mr5"></i></a>
        </li>
        <li>
            <a href="javascript:;">Pengaturan</a>
        </li>
        <li><a href="{{ url('pengaturan/module') }}">Daftar Module</a></li>
        <li class="active">Ubah Module</li>
        <li class="active">{!! $modules->id !!}</li>
    </ol>
    <section class="panel">
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="post" action="{{ url('pengaturan/module/edit/'.$modules->id) }}">
                <input type="hidden" name="urlnya" value="{!! url()->previous() !!}">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="parent" class="col-sm-3 control-label">Menu Parent</label>
                            <div class="col-sm-9">
                                <select name="menu_parent" class="form-control" id="menu-parent" style="width: 100%">
                                    <option value="0">Select Parent</option>
                                    @foreach($allmodule as $allmodule)
                                        <option value="{{ $allmodule->id }}" @if($modules->menu_parent==$allmodule->id) selected @endif>{{ $allmodule->module_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="module_name" class="col-sm-3 control-label">Module Name</label>
                            <div class="col-sm-9">
                                <input name="module_name" type="text" class="form-control" id="module_name" placeholder="Class" value="{{ $modules->module_name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="module_name" class="col-sm-3 control-label">Menu Mask</label>
                            <div class="col-sm-9">
                                <input name="menu_mask" type="text" class="form-control" id="menu_mask" placeholder="Menu" value="{{ $modules->menu_mask }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="module_name" class="col-sm-3 control-label">Menu Path</label>
                            <div class="col-sm-9">
                                <input name="menu_path" type="text" class="form-control" id="menu_path" placeholder="Path" value="{{ $modules->menu_path }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="module_name" class="col-sm-3 control-label">Menu Icon</label>
                            <div class="col-sm-9">
                                <select name="menu_icon" id="menu-icon" class="form-control" data-placeholder="Pilih Icon" style="width: 100%">
                                    <option value=""></option>
                                    <optgroup label="Arrows & Direction Icons">
                                        @foreach($icon as $item)
                                            <option value="{!! $item->icon_name !!}" class="{!! $item->icon_name !!}" {!! $modules->menu_icon == $item->icon_name ? 'selected' : '' !!}>{!! $item->icon_name !!}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Web App Icons">
                                        @foreach($icon2 as $item2)
                                            <option value="{!! $item2->icon_name !!}" class="{!! $item2->icon_name !!}" {!! $modules->menu_icon == $item2->icon_name ? 'selected' : '' !!}>{!! $item2->icon_name !!}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Control Icons">
                                        @foreach($icon3 as $item3)
                                            <option value="{!! $item3->icon_name !!}" class="{!! $item3->icon_name !!}" {!! $modules->menu_icon == $item3->icon_name ? 'selected' : '' !!}>{!! $item3->icon_name !!}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Text Editor Icons">
                                        @foreach($icon4 as $item4)
                                            <option value="{!! $item4->icon_name !!}" class="{!! $item4->icon_name !!}" {!! $modules->menu_icon == $item4->icon_name ? 'selected' : '' !!}>{!! $item4->icon_name !!}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Layout Icons">
                                        @foreach($icon5 as $item5)
                                            <option value="{!! $item5->icon_name !!}" class="{!! $item5->icon_name !!}" {!! $modules->menu_icon == $item5->icon_name ? 'selected' : '' !!}>{!! $item5->icon_name !!}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Brand Icons">
                                        @foreach($icon6 as $item6)
                                            <option value="{!! $item6->icon_name !!}" class="{!! $item6->icon_name !!}" {!! $modules->menu_icon == $item6->icon_name ? 'selected' : '' !!}>{!! $item6->icon_name !!}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="module_name" class="col-sm-3 control-label">Menu Order</label>
                            <div class="col-sm-9">
                                <div class="spinner input-group">
                                    <input name="menu_order" type="text" class="form-control input-sm spinner-input" id="menu_order" value="{!! $modules->menu_order !!}" placeholder="Order">
                                    <div class="spinner-buttons input-group-btn">
                                        <button type="button" class="btn btn-warning btn-sm spinner-down">
                                            <i class="ti-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm spinner-up">
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="divide_after" class="col-sm-3 control-label">Divider After</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="divider_after" class="checkbox" id="divider_after" value="1" value="{{ $modules->divider }}" {{$modules->divider == "0" ? '' : 'checked'}}>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-2">
                                <input type="submit" onclick="FunctionLoading()" class="btn btn-primary btn-block" value="Save">
                            </div>
                            <div class="col-sm-2">
                                <a href="{{ url('pengaturan/module') }}" class="btn btn-danger btn-block">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        $("#menu-icon").removeAttr('class');
        $("#menu-icon").select2();

        $("#menu-parent").removeAttr('class');
        $("#menu-parent").select2();
    </script>

@stop
