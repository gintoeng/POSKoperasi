<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableJurnalHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_header', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_jurnal', 50);
            $table->timestamp('tanggal');
            $table->text('keterangan');
            $table->enum('status', ['AKTIF', 'VOID']);
            $table->enum('tipe', ['MANUAL', 'TABUNGAN', 'KREDIT', 'KAS']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jurnal_header');
    }
}
