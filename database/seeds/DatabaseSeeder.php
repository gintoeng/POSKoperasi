<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(Kolektibilitas::class);
        $this->call(Sistembunga::class);
        $this->call(ModuleTableSeeder::class);
        $this->call(ModSeeder::class);
        $this->call(newModuleSeeder::class);
                //$this->call(AnggotaTableSeeder::class);
                //$this->call(PerkiraanTableSeeder::class);
        $this->call(ProfilTableSeeder::class);
        $this->call(RoleTableSeeder::class);
                //$this->call(UserTableSeeder::class);
        $this->call(Jenisjaminan::class);
        $this->call(JenisSeeder::class);
        $this->call(IklanSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(IconSeeder::class);
        $this->call(RoleaclSeeder::class);
        $this->call(perkiraanSeeder::class);
        $this->call(pengaturanakunSeeder::class);
        $this->call(pengaturanakunRelasiSeeder::class);
        $this->call(StokMinimumSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(CurrSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(SimpSeeder::class);
        $this->call(CabangSeeder::class);
        $this->call(ShuSeeder::class);
        $this->call(NomorSeeder::class);
        $this->call(Modulewaserda::class);
//        $this->call(JenisPos::class);

        Model::reguard();
    }
}
