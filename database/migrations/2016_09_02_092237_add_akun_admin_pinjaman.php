<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAkunAdminPinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengaturan_pinjaman', function(Blueprint $table){
            $table->unsignedInteger('akun_administrasi_bank')->nullable();
            $table->unsignedInteger('akun_administrasi_tambahan')->nullable();
            $table->foreign('akun_administrasi_bank')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_administrasi_tambahan')->references('id')->on('perkiraan')->onDelete('CASCADE');
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
