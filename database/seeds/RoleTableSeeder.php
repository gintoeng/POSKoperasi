<?php
/**
 * Created by PhpStorm.
 * User: ichsan
 * Date: 12/01/16
 * Time: 09:57
 */

use Illuminate\Database\Seeder;
use App\Role as Role;

class RoleTableSeeder extends Seeder {
    public function run()
    {
        //Role::truncate();

        Role::create([
            'role_name' =>  'Administrator',
            'desc'  =>  'Admin',
            'akses' => 'koperasi'
        ]);

        Role::create([
            'role_name' =>  'SuperVisor',
            'desc'  =>  'Supervisor',
            'akses' => 'pos'
        ]);

        Role::create([
            'role_name' =>  'Operator',
            'desc'  =>  'Operator',
            'akses' => 'koperasi'
        ]);

        Role::create([
            'role_name' => 'Kasir',
            'desc' => 'Kasir',
            'akses' => 'kasir'
        ]);
    }
}
