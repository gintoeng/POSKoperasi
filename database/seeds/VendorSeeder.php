<?php

use Illuminate\Database\Seeder;

use App\Model\Inventory\Vendor as Vendor;
class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::insert( [
     	'id' 			=> '1',
    	'kode'			=> '1T',    
    	'nama_vendor'	=> 'Test',
    	'nama_kontak'   => 'Tester',  
    	'alamat_1'		=> 'Jl. Tester',
    	'alamat_2'		=> 'Jl. Tester 2',
    	'phone'			=> '087884938814',
    	'fax'			=> '+217884938814',    
    	'nomor_akun'	=> '1234567891011',
    	'nama_akun'		=> 'Testerer',
    	'keterangan'	=> 'Tukang Test',
            ]);
    }
}
