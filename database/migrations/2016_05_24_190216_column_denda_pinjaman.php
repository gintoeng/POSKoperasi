<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumnDendaPinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengaturan_pinjaman', function (Blueprint $table) {
            $table->dropColumn('tipe_denda_perhari');
        });

        Schema::table('pengaturan_pinjaman', function (Blueprint $table) {
            $table->enum('tipe_denda_perhari', ['denda_nominal', 'saldo_X_perser%_X_hari', 'angsuran_X_persen%_X_hari', '']);
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
