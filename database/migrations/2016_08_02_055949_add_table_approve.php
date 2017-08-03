<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableApprove extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvel', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_for');
            $table->enum('for', ['simpanan', 'pinjaman', 'waserda']);
            $table->tinyInteger('lev1');
            $table->tinyInteger('lev2');
            $table->tinyInteger('lev3');
            $table->tinyInteger('release');
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
        Schema::drop('approvel');
    }
}
