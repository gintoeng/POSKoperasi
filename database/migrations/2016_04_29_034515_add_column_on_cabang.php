<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnCabang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::table('cabang', function ( Blueprint $table) {
            $table->string('alamat')->after('nama')->nullable();
            $table->string('kota')->after('alamat')->nullable();
            $table->string('provinsi')->after('kota')->nullable();
            $table->integer('kode_pos')->after('provinsi')->nullable();
            $table->string('telepon')->after('kode_pos')->nullable();
            $table->string('pesawat')->after('telepon')->nullable();
            $table->string('fax')->after('pesawat')->nullable();
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
