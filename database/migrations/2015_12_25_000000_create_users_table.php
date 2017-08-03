<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('username', 50)->unique();
            $table->string('password', 200);
            $table->tinyInteger('status');
            $table->unsignedInteger('id_anggota')->nullable();
            $table->unsignedInteger('role_id');
            $table->string('photo');
            $table->rememberToken();
            //$table->foreign('id_anggota')->references('id')->on('anggota')->onDelete('CASCADE');
            //$table->foreign('role_id')->references('id')->on('roles')->onDelete('CASCADE');
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
        Schema::drop('users');
    }
}
