<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAkunOnCabang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cabang', function (Blueprint $table) {
            $table->unsignedInteger('akun_kas')->nullable();
            $table->unsignedInteger('akun_persediaan_wsd')->nullable();
            $table->unsignedInteger('akun_piutang_wsd')->nullable();
            $table->unsignedInteger('akun_penjualan_wsd')->nullable();
            $table->unsignedInteger('akun_pendapatan_wsd')->nullable();
            $table->unsignedInteger('akun_penampungan_retur')->nullable();
            $table->unsignedInteger('akun_biaya_selisih_opname')->nullable();
            $table->foreign('akun_kas')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_persediaan_wsd')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_piutang_wsd')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_penjualan_wsd')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_pendapatan_wsd')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_penampungan_retur')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_biaya_selisih_opname')->references('id')->on('perkiraan')->onDelete('CASCADE');
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
