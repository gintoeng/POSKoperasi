<?php
/**
 * Created by PhpStorm.
 * User: ichsan
 * Date: 12/01/16
 * Time: 10:05
 */

use Illuminate\Database\Seeder;
use App\User as User;

class UserTableSeeder extends Seeder {
    public function run()
    {
         User::create([
            'name'       =>  'admin',
            'email'      =>  'admin@localhost.com',
            'username'   =>  'admin',
            'password'   =>  bcrypt('admin'),
            'status'     =>  1,
            'id_anggota' =>  1,
            'role_id'    =>  1,
            'photo'      =>  'admin.png',
        ]);
    }
}
