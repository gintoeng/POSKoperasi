<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use Hash;
use Auth;
use Validator;
use DB;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function showAccount()
    {
      $user = DB::table('users')->where('id',Auth::user()->id)->first();
      // $anggota = DB::table('anggota')->where('id',Auth::user()->id_anggota)->first();
      $roles = DB::table('roles')->orderBy('id','desc')->get();
      return view('account.profile',['user'=>$user,'roles'=>$roles]);
    }

    public function updateAccount(Request $r)
    {
       $username = $r->input('username');
      $password = $r->input('password');
      $role = $r->input('role_id');
      $status = $r->input('status');
      $foto = $r->file('foto');

      if ($foto) {
          $validator = Validator::make($r->all(),[
          'username'  =>  'required|max:255',
          'role_id' =>  'required',
          'status'  =>  'required',
          'foto'  =>  'required|required|mimes:jpeg,jpg,png',
        ]);

        if ($validator->fails()) {
          return redirect('account')->withErrors($validator)->withInput();
        }

        $user = DB::table('users')->where('id',Auth::user()->id)->first();

        File::delete('foto/user/'.$user->photo);
        $filename = str_replace(array('/','.','$'),array('','',''),bcrypt(date('Ymd')));
        $ext = $foto->getClientOriginalExtension();
        $image_name = $filename.'.'.$ext;
        $folder = 'foto/user';
        $foto->move($folder,$image_name);

        if ($password=='') {
          DB::table('users')->where('id',Auth::user()->id)->update(['username'=>$username,'role_id'=>$role,'status'=>$status,'photo'=>$image_name]);
        }

        else {
          DB::table('users')->where('id',Auth::user()->id)->update(['username'=>$username,'password'=>bcrypt($password),'role_id'=>$role,'status'=>$status,'photo'=>$image_name]);
          }
        $msgclass = "success";
        $msg = "Data Berhasil di Ubah";
        return redirect('account')->with('msgclass',$msgclass)->with('msg',$msg);
      }

      $validator = Validator::make($r->all(),[
         'username'  =>  'required|max:255',
        'role_id' =>  'required',
        'status'  =>  'required',
      ]);

      if ($validator->fails()) {
        return redirect('account')->withErrors($validator)->withInput();
      }

      if ($password=='') {
        DB::table('users')->where('id',Auth::user()->id)->update(['username'=>$username,'role_id'=>$role,'status'=>$status]);
      }

      else{
        DB::table('users')->where('id',Auth::user()->id)->update(['username'=>$username,'password'=>bcrypt($password),'role_id'=>$role,'status'=>$status]);
      }

       $msgclass = "success";
      $msg = "Data Berhasil di Ubah";
      return redirect('account')->with('msgclass',$msgclass)->with('msg',$msg);
    }
}
