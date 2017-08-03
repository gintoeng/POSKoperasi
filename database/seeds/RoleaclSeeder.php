<?php

use Illuminate\Database\Seeder;

class RoleaclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //MASTER
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 8, 'module_parent' => 1,
            'create_acl' => 8, 'read_acl' => 8, 'update_acl' => 8, 'delete_acl' => 8
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 9, 'module_parent' => 1,
            'create_acl' => 9, 'read_acl' => 9, 'update_acl' => 9, 'delete_acl' => 9
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 10, 'module_parent' => 1,
            'create_acl' => 10, 'read_acl' => 10, 'update_acl' => 10, 'delete_acl' => 10
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 11, 'module_parent' => 1,
            'create_acl' => 11, 'read_acl' => 11, 'update_acl' => 11, 'delete_acl' => 11
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 12, 'module_parent' => 1,
            'create_acl' => 12, 'read_acl' => 12, 'update_acl' => 12, 'delete_acl' => 12
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 13, 'module_parent' => 1,
            'create_acl' => 13, 'read_acl' => 13, 'update_acl' => 13, 'delete_acl' => 13
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 14, 'module_parent' => 1,
            'create_acl' => 14, 'read_acl' => 14, 'update_acl' => 14, 'delete_acl' => 14
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 15, 'module_parent' => 1,
            'create_acl' => 15, 'read_acl' => 15, 'update_acl' => 15, 'delete_acl' => 15
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 16, 'module_parent' => 1,
            'create_acl' => 16, 'read_acl' => 16, 'update_acl' => 16, 'delete_acl' => 16
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 71, 'module_parent' => 1,
            'create_acl' => 71, 'read_acl' => 71, 'update_acl' => 71, 'delete_acl' => 71
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 72, 'module_parent' => 1,
            'create_acl' => 72, 'read_acl' => 72, 'update_acl' => 72, 'delete_acl' => 72
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 73, 'module_parent' => 1,
            'create_acl' => 73, 'read_acl' => 73, 'update_acl' => 73, 'delete_acl' => 73
        ]);


        //SIMPANAN
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 17, 'module_parent' => 2,
            'create_acl' => 17, 'read_acl' => 17, 'update_acl' => 17, 'delete_acl' => 17
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 18, 'module_parent' => 2,
            'create_acl' => 18, 'read_acl' => 18, 'update_acl' => 18, 'delete_acl' => 18
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 19, 'module_parent' => 2,
            'create_acl' => 19, 'read_acl' => 19, 'update_acl' => 19, 'delete_acl' => 19
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 20, 'module_parent' => 2,
            'create_acl' => 20, 'read_acl' => 20, 'update_acl' => 20, 'delete_acl' => 20
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 21, 'module_parent' => 2,
            'create_acl' => 21, 'read_acl' => 21, 'update_acl' => 21, 'delete_acl' => 21
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 22, 'module_parent' => 2,
            'create_acl' => 22, 'read_acl' => 22, 'update_acl' => 22, 'delete_acl' => 22
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 23, 'module_parent' => 2,
            'create_acl' => 23, 'read_acl' => 23, 'update_acl' => 23, 'delete_acl' => 23
        ]);


        //PINJAMAN
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 24, 'module_parent' => 3,
            'create_acl' => 24, 'read_acl' => 24, 'update_acl' => 24, 'delete_acl' => 24
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 25, 'module_parent' => 3,
            'create_acl' => 25, 'read_acl' => 25, 'update_acl' => 25, 'delete_acl' => 25
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 26, 'module_parent' => 3,
            'create_acl' => 26, 'read_acl' => 26, 'update_acl' => 26, 'delete_acl' => 26
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 27, 'module_parent' => 3,
            'create_acl' => 27, 'read_acl' => 27, 'update_acl' => 27, 'delete_acl' => 27
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 28, 'module_parent' => 3,
            'create_acl' => 28, 'read_acl' => 28, 'update_acl' => 28, 'delete_acl' => 28
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 29, 'module_parent' => 3,
            'create_acl' => 29, 'read_acl' => 29, 'update_acl' => 29, 'delete_acl' => 29
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 30, 'module_parent' => 3,
            'create_acl' => 30, 'read_acl' => 30, 'update_acl' => 30, 'delete_acl' => 30
        ]);


        //AKUNTANSI
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 31, 'module_parent' => 4,
            'create_acl' => 31, 'read_acl' => 31, 'update_acl' => 31, 'delete_acl' => 31
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 32, 'module_parent' => 4,
            'create_acl' => 32, 'read_acl' => 32, 'update_acl' => 32, 'delete_acl' => 32
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 33, 'module_parent' => 4,
            'create_acl' => 33, 'read_acl' => 33, 'update_acl' => 33, 'delete_acl' => 33
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 34, 'module_parent' => 4,
            'create_acl' => 34, 'read_acl' => 34, 'update_acl' => 34, 'delete_acl' => 33
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 35, 'module_parent' => 4,
            'create_acl' => 35, 'read_acl' => 35, 'update_acl' => 35, 'delete_acl' => 33
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 36, 'module_parent' => 4,
            'create_acl' => 36, 'read_acl' => 36, 'update_acl' => 36, 'delete_acl' => 33
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 37, 'module_parent' => 4,
            'create_acl' => 37, 'read_acl' => 37, 'update_acl' => 37, 'delete_acl' => 33
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 38, 'module_parent' => 4,
            'create_acl' => 38, 'read_acl' => 38, 'update_acl' => 38, 'delete_acl' => 38
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 39, 'module_parent' => 4,
            'create_acl' => 39, 'read_acl' => 39, 'update_acl' => 39, 'delete_acl' => 39
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 40, 'module_parent' => 4,
            'create_acl' => 40, 'read_acl' => 40, 'update_acl' => 40, 'delete_acl' => 40
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 41, 'module_parent' => 4,
            'create_acl' => 41, 'read_acl' => 41, 'update_acl' => 41, 'delete_acl' => 41
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 42, 'module_parent' => 4,
            'create_acl' => 42, 'read_acl' => 42, 'update_acl' => 42, 'delete_acl' => 42
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 43, 'module_parent' => 4,
            'create_acl' => 43, 'read_acl' => 43, 'update_acl' => 43, 'delete_acl' => 43
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 44, 'module_parent' => 4,
            'create_acl' => 44, 'read_acl' => 44, 'update_acl' => 44, 'delete_acl' => 44
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 67, 'module_parent' => 4,
            'create_acl' => 67, 'read_acl' => 67, 'update_acl' => 67, 'delete_acl' => 67
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 68, 'module_parent' => 4,
            'create_acl' => 68, 'read_acl' => 68, 'update_acl' => 68, 'delete_acl' => 68
        ]);


        //LAPORAN
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 45, 'module_parent' => 5,
            'create_acl' => 45, 'read_acl' => 45, 'update_acl' => 45, 'delete_acl' => 45
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 46, 'module_parent' => 5,
            'create_acl' => 46, 'read_acl' => 46, 'update_acl' => 46, 'delete_acl' => 46
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 47, 'module_parent' => 5,
            'create_acl' => 47, 'read_acl' => 47, 'update_acl' => 47, 'delete_acl' => 47
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 48, 'module_parent' => 5,
            'create_acl' => 48, 'read_acl' => 48, 'update_acl' => 48, 'delete_acl' => 48
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 49, 'module_parent' => 5,
            'create_acl' => 49, 'read_acl' => 49, 'update_acl' => 49, 'delete_acl' => 49
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 50, 'module_parent' => 5,
            'create_acl' => 50, 'read_acl' => 50, 'update_acl' => 50, 'delete_acl' => 50
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 51, 'module_parent' => 5,
            'create_acl' => 51, 'read_acl' => 51, 'update_acl' => 51, 'delete_acl' => 51
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 52, 'module_parent' => 5,
            'create_acl' => 52, 'read_acl' => 52, 'update_acl' => 52, 'delete_acl' => 52
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 53, 'module_parent' => 5,
            'create_acl' => 53, 'read_acl' => 53, 'update_acl' => 53, 'delete_acl' => 53
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 54, 'module_parent' => 5,
            'create_acl' => 54, 'read_acl' => 54, 'update_acl' => 54, 'delete_acl' => 54
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 55, 'module_parent' => 5,
            'create_acl' => 55, 'read_acl' => 55, 'update_acl' => 55, 'delete_acl' => 55
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 56, 'module_parent' => 5,
            'create_acl' => 56, 'read_acl' => 56, 'update_acl' => 56, 'delete_acl' => 56
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 57, 'module_parent' => 5,
            'create_acl' => 57, 'read_acl' => 57, 'update_acl' => 57, 'delete_acl' => 57
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 58, 'module_parent' => 5,
            'create_acl' => 58, 'read_acl' => 57, 'update_acl' => 58, 'delete_acl' => 58
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 59, 'module_parent' => 5,
            'create_acl' => 59, 'read_acl' => 59, 'update_acl' => 59, 'delete_acl' => 59
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 60, 'module_parent' => 5,
            'create_acl' => 60, 'read_acl' => 60, 'update_acl' => 60, 'delete_acl' => 60
        ]);

        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 61, 'module_parent' => 5,
            'create_acl' => 61, 'read_acl' => 61, 'update_acl' => 61, 'delete_acl' => 61
        ]);


        //PENGATURAN
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 62, 'module_parent' => 6,
            'create_acl' => 62, 'read_acl' => 62, 'update_acl' => 62, 'delete_acl' => 62
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 63, 'module_parent' => 6,
            'create_acl' => 63, 'read_acl' => 63, 'update_acl' => 63, 'delete_acl' => 63
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 64, 'module_parent' => 6,
            'create_acl' => 64, 'read_acl' => 64, 'update_acl' => 64, 'delete_acl' => 64
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 65, 'module_parent' => 6,
            'create_acl' => 65, 'read_acl' => 65, 'update_acl' => 65, 'delete_acl' => 65
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 66, 'module_parent' => 6,
            'create_acl' => 66, 'read_acl' => 66, 'update_acl' => 66, 'delete_acl' => 66
        ]);

        //APPROVE
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 69, 'module_parent' => 7,
            'create_acl' => 69, 'read_acl' => 69, 'update_acl' => 69, 'delete_acl' => 69
        ]);
        \App\RoleAcl::create([
            'role_id' => 1, 'module_id' => 70, 'module_parent' => 7,
            'create_acl' => 70, 'read_acl' => 70, 'update_acl' => 70, 'delete_acl' => 70
        ]);
    }
}
