<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRekCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn(['nik', 'jabatan', 'departemen', 'npk']);
        });

        Schema::table('anggota', function (Blueprint $table) {
            $table->bigInteger('nomor_rekening')->nullable()->after('kode');
            $table->string('jabatan', 30)->nullable()->after('keterangan');
            $table->string('departemen', 30)->nullable()->after('jabatan');
            $table->string('npk', 30)->nullable()->after('departemen');
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
