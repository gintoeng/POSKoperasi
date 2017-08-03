<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeHariKolek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kolektibilitas', function(Blueprint $table){
            $table->dropColumn('batas_hari');
        });

        Schema::table('kolektibilitas', function(Blueprint $table){
            $table->integer('batas_hari')->after('keterangan');
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
