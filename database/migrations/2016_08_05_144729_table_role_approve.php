<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableRoleApprove extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvel_role', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_user');
            $table->integer('id_for');
            $table->tinyInteger('level');
            $table->enum('for', ['simpanan', 'pinjaman', 'waserda']);
            $table->foreign('id_user')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::drop('approvel_role');
    }
}
