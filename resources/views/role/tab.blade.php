@include('templates.head')
<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        @foreach($modules as $module)
            <li role="presentation"><a href="{{ $module->module_name }}" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
        @endforeach
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        @foreach($modules as $module)
            <div role="tabpanel" class="tab-pane" id="{{ $module->module_name }}">
                @foreach(App\Module::where('menu_parent', $module->id)->get() as $child)
                    - {{ $child->module_name }} <br>
                @endforeach
            </div>
        @endforeach
    </div>

</div>
@include('templates.foot')