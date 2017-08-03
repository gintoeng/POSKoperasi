<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableAutodebetPinjamanDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('autodebet_pinjaman_detail', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_auto_header');
            $table->unsignedInteger('id_pinjaman');
            $table->unsignedInteger('id_bayar');
            $table->decimal('debet', 20, 2);
            $table->tinyInteger('status');
            $table->foreign('id_auto_header')->references('id')->on('autodebet_pinjaman_header')->onDelete('CASCADE');
            $table->foreign('id_pinjaman')->references('id')->on('pinjaman')->onDelete('CASCADE');
            $table->foreign('id_bayar')->references('id')->on('pembayaran_pinjaman')->onDelete('CASCADE');
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
        //
    }
}
