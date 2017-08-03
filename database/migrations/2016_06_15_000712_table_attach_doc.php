<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableAttachDoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attach_doc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_anggota')->nullable();
            $table->integer('id_pengaturan')->nullable();
            $table->string('ketarangan');
            $table->string('doc');
            $table->string('mime');
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
        Schema::drop('attach_doc');
    }
}
