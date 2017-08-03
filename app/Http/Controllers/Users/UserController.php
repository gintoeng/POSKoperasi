<?php

namespace App\Http\Controllers\Users;

use App\Model\Master\Cabang;
use App\Role;
use Illuminate\Http\Request;

use App\User;
use App\RoleAcl;
use Gate;
use Auth;
use DB;
use narutimateum\Toastr\Facades\Toastr;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getUser(Request $request)
    {
        $no = 1;
        $users = DB::table('users')->orderBy('id','asc')->paginate(10);
        $jml = DB::table('users')->count();
        return view('users.home',['no'=>$no,'users'=>$users, 'jml'=>$jml]);
    }

    public function deleteUser($id)
    {
        DB::table('users')->where(['id'=>$id])->delete();
        $msg = "Data Berhasil di Hapus";
        $alert = Toastr::success($msg, $title = "Hapus User", $options = []);
        return redirect(url()->previous())->with('alert', $alert);
    }

    public function addUser()
    {
        $roles = DB::table('roles')->get();
        $cabang = Cabang::all();
        return view('users.add',['roles'=>$roles, 'cabang' => $cabang]);
    }

    public function postUser(Request $r)
    {
        $username =   $r->input('username');
        $password = $r->input('password');
        $role = $r->input('role_id');
        $status = $r->input('status');
        $cabang = $r->input('cabang');

        if ($r->hasFile('foto'))
        {
            $file     = $r->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/user/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = "ava";
        }

        if ($r->posting == 1) {
            $auto = $r->posting;
        } else {
            $auto = 0;
        }
        
        $validator = Validator::make($r->all(),[
            'username'  =>    'required',
            'password'  =>  'required',
            'role_id'  =>  'required',
            'status'  =>  'required',
        ]);

        if ($validator->fails()) {
            return redirect('pengaturan/user/add');
        }

        $valu = User::where('username', $username)->first();
        if ($valu == null) {
            DB::table('users')->insert(['username' => $username, 'password' => bcrypt($password), 'role_id' => $role, 'status' => $status, 'cabang' => $cabang, 'photo' => $filename, 'posting' => $auto]);
            $msg = "Data Berhasil di Tambahkan";
            $alert = Toastr::success($msg, $title = "Tambah User", $options = []);
        } else {
            if ($username == $valu->username) {
                $dg = "dengan username : ".$username;
            }
            $msg = "Data Gagal di Tambahkan. <br> Data ".$dg." sudah ada";
            $alert = Toastr::error($msg, $title = "Tambah User", $options = []);
        }
        return redirect('pengaturan/user')->with('alert', $alert);
    }

    public function showUser($id)
    {
        $roles = DB::table('roles')->get();
        $user = User::find($id);
        $cabang = Cabang::all();
        return view('users.data',['user'=>$user,'roles'=>$roles, 'cabang' => $cabang]);
    }

    public function updateUser(Request $r)
    {
        $id =   $r->input('id');
        $username = $r->input('username');
        $password = $r->input('password');
        $role = $r->input('role_id');
        $status = $r->input('status');
        $cabang = $r->input('cabang');

        if ($r->hasFile('foto'))
        {
            $file     = $r->foto;
            $filename = $file->getClientOriginalName();

            $destinationPath = 'foto/user/';
            $file->move($destinationPath, $filename);

        } else {
            $filename = $r->gambar;
        }

        if ($r->posting == 1) {
            $auto = $r->posting;
        } else {
            $auto = 0;
        }
        $validator = Validator::make($r->all(),[
            'id'  =>  'required',
            'username'  =>  'required',
//            'password'  =>  'required',
            'role_id'  =>  'required',
            'status'  =>  'required',
        ]);

        if ($validator->fails()) {
            return redirect('pengaturan/user'.'/'.$id);
        }



            $valu = User::where('id', '!=', $id)->where('username', $username)->first();
            if ($valu == null) {
                if ($password!='') {
                    DB::table('users')->where('id', $id)->update(['username' => $username, 'password' => bcrypt($password), 'role_id' => $role, 'status' => $status, 'cabang' => $cabang, 'photo' => $filename, 'posting' => $auto]);
                } else {
                    DB::table('users')->where('id', $id)->update(['username' => $username, 'role_id' => $role, 'status' => $status, 'cabang' => $cabang, 'photo' => $filename, 'posting' => $auto]);
                }
                $msg = "Data Berhasil di Ubah";
                $alert = Toastr::success($msg, $title = "Ubah User", $options = []);
            } else {
                if ($username == $valu->username) {
                    $dg = "dengan username : ".$username;
                }
                $msg = "Data Gagal di Ubah. <br> Data ".$dg." sudah ada";
                $alert = Toastr::error($msg, $title = "Tambah User", $options = []);
            }
//        return redirect('pengaturan/user')->with('alert', $alert);
            return redirect($r->urlnya)->with('alert', $alert);

//        $validator = Validator::make($r->all(),[
//            'id'  =>    'required',
//            'username'  =>    'required',
//            'role_id'  =>  'required',
//            'status'  =>  'required',
//        ]);
//
//        if ($validator->fails()) {
//            return redirect('pengaturan/user'.'/'.$id);
//        }
//
//        DB::table('users')->where('id',$id)->update(['username'=>$username,'role_id'=>$role,'status'=>$status]);
//        $msg = "Data Berhasil di Hapus";
//        $alert = Toastr::success($msg, $title = "Uapus User", $options = []);
//        return redirect('pengaturan/user')->with('alert', $alert);
    }

    public function searchUser(Request $r)
    {
        $no = 1;
        $query = $r->input('query');
        $users = User::where('username','like','%'.$query.'%')->orWhereHas('roleid', function ($querys) use ($query) {
            $querys->where('role_name','like','%'.$query.'%');
        })->paginate(10);
        $jml = User::where('username','like','%'.$query.'%')->orWhereHas('roleid', function ($querys) use ($query) {
            $querys->where('role_name','like','%'.$query.'%');
        })->count();
        return view('users.search',['no'=>$no,'users'=>$users,'query'=>$query, 'jml'=>$jml]);
    }

    public function ajax($rid) {
        $role = Role::find($rid);

        $data[] = array(
            'tipe' => $role->akses
        );

        return json_encode($data);
    }
}
