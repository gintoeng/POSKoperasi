<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeJenisAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anggota', function(Blueprint $table){
            $table->dropColumn('jenis_nasabah');
        });

        Schema::table('anggota', function(Blueprint $table){
            $table->enum('jenis_nasabah', ['BIASA','LUAR BIASA','UMUM']);
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
