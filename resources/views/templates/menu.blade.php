<header class="header header-fixed navbar">
    <div class="brand">
        <a href="javascript:;" class="ti-menu navbar-toggle off-left visible-xs" data-toggle="collapse" data-target="#hor-menu"></a>
        <a href="{{ url('/') }}" class="navbar-brand">
            <?php $profil = \App\Model\Pengaturan\Profil::findOrNew(1);?>
            <img src="{{ url('foto/profil/'.$profil->foto) }}" alt="">
            <span class="heading-font">
                {{ $profil->nama_koperasi }}
            </span>
        </a>
    </div>

    <div class="collapse navbar-collapse pull-left" id="hor-menu">
        <ul class="nav navbar-nav">
            <?php
            $module_parents = DB::table('role_acl')
                    ->join('modules','role_acl.module_parent','=','modules.id')
                    ->where('role_id', Auth::user()->role_id)
                    ->where(function ($query) {
                        $query->where('create_acl','<>',0)
                                ->orWhere('read_acl','<>',0)
                                ->orWhere('update_acl','<>',0)
                                ->orWhere('delete_acl','<>',0);
                    })
                    ->groupBy('module_parent')
                    ->orderBy('menu_order','asc')
                    ->get();
            ?>
            @foreach($module_parents as $parent)
                <li class="dropdown">
                    <a class="" href="javascript:void(0)" data-toggle="dropdown">
                        <i class="{{ $parent->menu_icon }} mr5"></i><span>{{ $parent->module_name }}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                        $module_childs = DB::table('role_acl')
                                ->join('modules','role_acl.module_id','=','modules.id')
                                ->where('module_parent',$parent->module_parent)
                                ->where('role_id', Auth::user()->role_id)
                                ->where(function ($query) {
                                    $query->where('create_acl','<>',0)
                                            ->orWhere('read_acl','<>',0)
                                            ->orWhere('update_acl','<>',0)
                                            ->orWhere('delete_acl','<>',0);
                                })
                                ->orderBy('menu_order','asc')
                                ->get();
                        ?>
                        @foreach($module_childs as $child)
                            <li>
                                <a href="{{ url($child->menu_path) }}">
                                    <i class="{{ $child->menu_icon }} mr5"></i><span>{{ $child->module_name }}</span>
                                </a>
                            </li>
                            @if($child->divider==1)
                                <li class="divider"></li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
        </ul>
    </div>

    <ul class="nav navbar-nav navbar-right">
        <li class="off-right">
            <a href="javascript:;" data-toggle="dropdown">
                <img src="{{ url('foto/user'.'/'.Auth::user()->photo) }}" class="header-avatar img-circle" alt="{{ Auth::user()->username }}" title="{{ Auth::user()->username }}" style="width:32px; height:32px">
                <span class="hidden-xs ml10">{{ Auth::user()->username }}</span>
                <i class="ti-angle-down ti-caret hidden-xs"></i>
            </a>
            <ul class="dropdown-menu animated fadeInRight">
                <li>
                    <a href="{{ url('account') }}">Settings</a>
                </li>
                <li>
                    <a href="{{ url('logout') }}">Logout</a>
                </li>
            </ul>
        </li>
    </ul>
</header>
