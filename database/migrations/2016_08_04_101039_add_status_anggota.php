<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anggota', function(Blueprint $table){
            $table->dropColumn(['status', 'limit_transaksi']);
        });

        Schema::table('anggota', function(Blueprint $table){
            $table->decimal('limit_transaksi', 20, 2);
            $table->enum('status', ['AKTIF', 'NONAKTIF', 'BLOCK']);
        });
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
