<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableRoleAclWaserda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_acl_waserda', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->nullable();
            $table->unsignedBigInteger('mod_kd')->nullable();
            $table->bigInteger('create_acl')->nullable();
            $table->bigInteger('read_acl')->nullable();
            $table->bigInteger('update_acl')->nullable();
            $table->bigInteger('delete_acl')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('CASCADE');
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
        Schema::drop('role_acl_waserda');
    }
}
