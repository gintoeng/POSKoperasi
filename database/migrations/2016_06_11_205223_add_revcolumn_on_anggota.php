<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRevcolumnOnAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn('nomor_ktp');
        });

        Schema::table('anggota', function (Blueprint $table) {
            $table->bigInteger('nomor_ktp')->after('account_card')->nullable();
            $table->enum('status_anggota', ['Hold', 'Tutup'])->nullable();
            $table->date('tanggal_status')->nullable();
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
