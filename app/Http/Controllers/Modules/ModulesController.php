<?php

namespace App\Http\Controllers\Modules;

use App\Icon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;
use Validator;
use DB;

class ModulesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex(Request $r)
    {
        $no = 1;
        $keyword = $r->input('keyword');
        $field = $r->input('field');
        $modules = DB::table('modules')->orderBy('menu_parent', 'asc')->paginate(20);
        $count = DB::table('modules')->count();
        return view('modules/index',['no'=>$no,'keyword'=>$keyword,'field'=>$field])->with('count', $count)
            ->with('modules', $modules);
    }

    public function getForm()
    {
        $icon = Icon::where('type', 1)->get();
        $icon2 = Icon::where('type', 2)->get();
        $icon3 = Icon::where('type', 3)->get();
        $icon4 = Icon::where('type', 4)->get();
        $icon5 = Icon::where('type', 5)->get();
        $icon6 = Icon::where('type', 6)->get();
        $modules = DB::table('modules')->where('menu_parent', '0')->get();
        return view('modules/form')->with('module', $modules)->with('icon', $icon)
            ->with('icon2', $icon2)
            ->with('icon3', $icon3)
            ->with('icon4', $icon4)
            ->with('icon5', $icon5)
            ->with('icon6', $icon6);
    }

    public function save(Request $r)
    {
        $menu_parent = $r->input('menu_parent');
        $module_name = $r->input('module_name');
        $menu_mask = $r->input('menu_mask');
        $menu_path = $r->input('menu_path');
        $menu_icon = $r->input('menu_icon');
        $menu_order = $r->input('menu_order');
        $divider = $r->input('divider_after');

        $validator = Validator::make($r->all(),
            [
                'module_name' => 'required',
                'menu_mask' => 'required',
//                'menu_path' => 'required',
                'menu_icon' => 'required',
                'menu_order' => 'required'
            ]);

        if($validator->fails()) {
            return redirect(url('pengaturan/module/add'));
        }

        if ($divider == 1) {
            DB::table('modules')->insert(
                [
                    'menu_parent' => $menu_parent,
                    'module_name' => $module_name,
                    'menu_mask' => $menu_mask,
                    'menu_path' => $menu_path,
                    'menu_icon' => $menu_icon,
                    'menu_order' => $menu_order,
                    'divider' => $divider
                ]);
        } else {
            DB::table('modules')->insert(
                [
                    'menu_parent' => $menu_parent,
                    'module_name' => $module_name,
                    'menu_mask' => $menu_mask,
                    'menu_path' => $menu_path,
                    'menu_icon' => $menu_icon,
                    'menu_order' => $menu_order,
                ]);
        }
        $msg = "Data Berhasil di Tambahkan";
        $alert = Toastr::success($msg, $title = "Tambah Modul", $options = []);
        return redirect(url('pengaturan/module'))->with('alert', $alert);
    }

    public function search(Request $r)
    {
        $no = 1;
        $keyword = $r->input('keyword');

            $modules = DB::table('modules')->where('module_name', 'like', '%'.$keyword.'%')->orWhere('menu_mask', 'like', '%'.$keyword.'%')->paginate(20);
            $count = DB::table('modules')->where('module_name', 'like', '%'.$keyword.'%')->orWhere('menu_mask', 'like', '%'.$keyword.'%')->count();
            return view('modules/search',['modules'=>$modules,'no'=>$no,'keyword'=>$keyword])->with('count', $count);
    }

    public function edit($id)
    {
        $icon = Icon::where('type', 1)->get();
        $icon2 = Icon::where('type', 2)->get();
        $icon3 = Icon::where('type', 3)->get();
        $icon4 = Icon::where('type', 4)->get();
        $icon5 = Icon::where('type', 5)->get();
        $icon6 = Icon::where('type', 6)->get();
        $allmodule = DB::table('modules')->where('menu_parent','0')->get();
        $modules = DB::table('modules')->where('id', $id)->first();
        return view('modules/edit')->with('modules', $modules)->with('allmodule',$allmodule)->with('icon', $icon)
            ->with('icon2', $icon2)
            ->with('icon3', $icon3)
            ->with('icon4', $icon4)
            ->with('icon5', $icon5)
            ->with('icon6', $icon6);
    }

    public function update($id, Request $r)
    {
        DB::table('modules')->where('id', $id)->update([
            'menu_parent' => $r->input('menu_parent'),
            'module_name' => $r->input('module_name'),
            'menu_mask' => $r->input('menu_mask'),
            'menu_path' => $r->input('menu_path'),
            'menu_icon' => $r->input('menu_icon'),
            'menu_order' => $r->input('menu_order'),
            'divider' => $r->input('divider_after')
        ]);
        $msg = "Data Berhasil di Ubah";
        $alert = Toastr::success($msg, $title = "Ubah Modul", $options = []);
//        return redirect(url('pengaturan/module'))->with('alert', $alert);
        return redirect($r->urlnya)->with('alert', $alert);
    }


























    public function up($id)
    {
        $module = DB::table('modules')->where('id', $id)->get();
        foreach ($module as $modules) {
            # code...
        }
        DB::table('modules')->where('id', $id)->update([
            'menu_order' => $modules->menu_order + 1,
        ]);
        return redirect(url()->previous());
    }

    public function down($id)
    {
        $module = DB::table('modules')->where('id', $id)->get();
        foreach ($module as $modules) {
            # code...
        }
        DB::table('modules')->where('id', $id)->update([
            'menu_order' => $modules->menu_order - 1,
        ]);

        return redirect(url()->previous());
    }

    public function delete($id)
    {
        DB::table('modules')->where('id',$id)->delete();
        return redirect(url()->previous());
    }
}
