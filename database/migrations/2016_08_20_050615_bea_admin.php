<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeaAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengaturan_pinjaman', function(Blueprint $table){
            $table->decimal('biaya_admin_bank', 20, 2);
            $table->decimal('biaya_admin_fee', 5, 2);
            $table->decimal('biaya_admin_tambahan', 5, 2);
        });

//        Schema::table('pinjaman', function(Blueprint $table){
//            $table->decimal('biaya_admin_tambahan', 5, 2);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
