<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SimpinBunga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simpanan', function (Blueprint $table) {
            $table->dropColumn('suku_bunga');
        });

        Schema::table('simpanan', function (Blueprint $table) {
            $table->decimal('suku_bunga', 5, 2);
            $table->unsignedInteger('sistem_bunga')->nullable();
            $table->foreign('sistem_bunga')->references('id')->on('sistem_bunga')->onDelete('CASCADE');
        });

        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn(['suku_bunga', 'sistem_bunga']);
        });

        Schema::table('pinjaman', function (Blueprint $table) {
            $table->decimal('suku_bunga', 5, 2);
            $table->unsignedInteger('sistem_bunga')->nullable();
            $table->foreign('sistem_bunga')->references('id')->on('sistem_bunga')->onDelete('CASCADE');
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
