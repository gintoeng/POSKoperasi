<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TableJurnalDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_header');
            $table->integer('id_transaksi');
            $table->integer('id_akun');
            $table->decimal('debet', 10, 0);
            $table->decimal('kredit', 10, 0);
            $table->decimal('nominal', 10, 0);
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
        Schema::drop('jurnal_detail');
    }
}
