<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnPembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembayaran_pinjaman', function (Blueprint $table) {
            $table->dropColumn(['cara_bayar', 'statusauto']);
        });

        Schema::table('pembayaran_pinjaman', function (Blueprint $table) {
            $table->enum('cara_bayar', ['TUNAI', 'SIMPANAN', 'AUTODEBET']);
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
