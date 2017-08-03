<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableKategoriShuDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_shu_detail', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('id_header');
            $table->string('nama');
            $table->tinyInteger('masuk_shu');
            $table->decimal('percent', 5,2);
            $table->string('fieldnya');
            $table->foreign('id_header')->references('id')->on('kategori_shu_header')->onDelete('CASCADE');
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
        Schema::drop('kategori_shu_detail');
    }
}
