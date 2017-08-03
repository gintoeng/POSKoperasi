<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixJurnalPinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengaturan_pinjaman', function(Blueprint $table) {
            $table->dropColumn(['akun_pinjaman', 'akun_piutang_baru', 'akun_piutang_lama']);
        });

        Schema::table('pengaturan_pinjaman', function(Blueprint $table) {
            $table->unsignedInteger('akun_piutang_pinjaman')->nullable();
            $table->unsignedInteger('akun_tampungan_pinjaman')->nullable();
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
