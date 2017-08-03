<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn(['nik', 'kota', 'provinsi', 'kode_pos', 'telepon']);
        });

        Schema::table('anggota', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->after('kode');
            $table->string('kota', 50)->nullable()->after('alamat');
            $table->string('provinsi', 50)->nullable()->after('kota');
            $table->integer('kode_pos')->nullable()->after('provinsi');
            $table->string('telepon', 20)->nullable()->after('kode_pos');
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