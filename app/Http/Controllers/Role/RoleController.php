<?php

namespace App\Http\Controllers\Role;

use App\Modwaserda;
use App\RoleAcl;
use App\Roleaclwaserda;
use Illuminate\Http\Request;
use App\Module;
use App\Role;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use narutimateum\Toastr\Facades\Toastr;
use Validator;
use DB;

class RoleController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

    public function getIndex()
    {
      $no = 1;
      $role = DB::table('roles')->orderBy('id', 'asc')->paginate(10);
      $count = DB::table('roles')->count();
      return view('role.index')->with('role', $role)->with('count', $count);
    }

    public function search(Request $r)
    {
      $no = 1;
      $query = $r->input('query');
      $role = DB::table('roles')->where('role_name', 'like', '%'.$query.'%')->orWhere('desc', 'like', '%'.$query.'%')->paginate(10);
      $count = DB::table('roles')->where('role_name', 'like', '%'.$query.'%')->orWhere('desc', 'like', '%'.$query.'%')->count();
      return view('role.search')->with('role', $role)->with('count', $count)->with('query', $query);
    }

    public function getForm()
    {
      $modules = Module::where('menu_parent', '0')->get();

      return view('role.form')->with('module', $modules);
    }

    public function save(Request $r)
    {
      $role_name = $r->input('role_name');
      $desc = $r->input('desc');

      $validator = Validator::make($r->all(), [
        'role_name' => 'required',
        'desc' => 'required'
      ]);

      if($validator->fails()) {
        return redirect(url('pengaturan/role/add'));
      }

      $role = Role::create([
        'role_name' => $role_name,
        'desc' => $desc,
        'akses' => $r->akses
      ]);
        $roles = Module::where('menu_parent', '!=', 0)->get();
        $roles2 = Modwaserda::all();
      foreach ($roles as $module) {
        RoleAcl::create([
          'module_id' => $module->id,
          'role_id' => $role->id,
          'create_acl' => $r->input($module->id.'_create'),
          'read_acl' => $r->input($module->id.'_read'),
          'update_acl' => $r->input($module->id.'_update'),
          'delete_acl' => $r->input($module->id.'_delete'),
          'module_parent' =>  $module->menu_parent,
        ]);
      }

      foreach ($roles2 as $module) {
        Roleaclwaserda::create([
          'mod_kd' => $module->kode,
          'role_id' => $role->id,
          'create_acl' => $r->input($module->kode.'_create'),
          'read_acl' => $r->input($module->kode.'_read'),
          'update_acl' => $r->input($module->kode.'_update'),
          'delete_acl' => $r->input($module->kode.'_delete')
        ]);
      }
      $msg = "Data Berhasil di Tambahkan";
      $alert = Toastr::success($msg, $title = "Tambah Role", $options = []);
      return redirect(url('pengaturan/role'))->with('alert', $alert);
    }

    public function edit($id)
    {
      $role = DB::table('roles')->where('id', $id)->first();
      $modules = Module::where('menu_parent', '0')->get();

      return view('role/edit')->with('role', $role)->with('module', $modules);
    }

    public function update($id, Request $r)
    {
      $role_name = $r->input('role_name');
      $desc = $r->input('desc');

      $role = Role::find($id)->update([
        'role_name' => $role_name,
        'desc' => $desc,
          'akses' => $r->akses
      ]);

//      $roles = DB::table('roles')->where('id', $id)->first();
      $roles = Module::where('menu_parent', '!=', 0)->get();
      $roles2 = Modwaserda::all();
//      foreach (DB::table('modules')->where('menu_parent','!=','0')->get() as $module) {
//        DB::table('role_acl')->where('role_id',$id)->where('module_id',$module->id)->delete();
//      }

      foreach ($roles as $modules) {
          $data = [
              'module_id' => $modules->id,
              'role_id' => $id,
              'create_acl' => $r->input($modules->id.'_create'),
              'read_acl' => $r->input($modules->id.'_read'),
              'update_acl' => $r->input($modules->id.'_update'),
              'delete_acl' => $r->input($modules->id.'_delete'),
              'module_parent' => $modules->menu_parent,
          ];
          $cek = RoleAcl::where('module_id', $modules->id)->where('role_id', $id)->first();
          if ($cek == null) {
              $rolenya = RoleAcl::create($data);
          } else {
              $rolenya = RoleAcl::find($cek->id);
              $rolenya->update($data);
          }
      }

      foreach ($roles2 as $module) {
        $data2 = [
            'mod_kd' => $module->kode,
            'role_id' => $id,
            'create_acl' => $r->input($module->kode.'_create'),
            'read_acl' => $r->input($module->kode.'_read'),
            'update_acl' => $r->input($module->kode.'_update'),
            'delete_acl' => $r->input($module->kode.'_delete')
        ];
        $cek2 = Roleaclwaserda::where('mod_kd', $module->kode)->where('role_id', $id)->first();
        if ($cek2 == null) {
          $rolenya2 = Roleaclwaserda::create($data2);
        } else {
          $rolenya2 = Roleaclwaserda::find($cek2->id);
          $rolenya2->update($data2);
        }
      }


      $msg = "Data Berhasil di Ubah";
      $alert = Toastr::success($msg, $title = "Ubah Role", $options = []);
//      return redirect(url('pengaturan/role'))->with('alert', $alert);
      return redirect($r->urlnya)->with('alert', $alert);
    }

    public function delete($id)
    {
      DB::table('roles')->where('id', $id)->delete();
      DB::table('role_acl')->where('role_id', $id)->delete();
      $msg = "Data Berhasil di Hapus";
      $alert = Toastr::success($msg, $title = "Hapus Role", $options = []);
      return redirect(url()->previous())->with('alert', $alert);
    }
}
