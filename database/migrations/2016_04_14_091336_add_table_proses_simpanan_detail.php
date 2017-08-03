<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableProsesSimpananDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('proses_simpanan_detail', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_proses_header');
            $table->unsignedInteger('id_simpanan');
            $table->decimal('bunga', 20, 2);
            $table->decimal('pajak', 20, 2);
            $table->decimal('diterima', 20, 2);
            $table->tinyInteger('kena_pajak');
            $table->foreign('id_proses_header')->references('id')->on('proses_simpanan_header')->onDelete('CASCADE');
            $table->foreign('id_simpanan')->references('id')->on('simpanan')->onDelete('CASCADE');
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
        \Illuminate\Support\Facades\Schema::drop('proses_simpanan_detail');
    }
}
