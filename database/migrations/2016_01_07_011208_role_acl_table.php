<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleAclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('role_acl', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('role_id')->nullable();
        $table->unsignedInteger('module_id')->nullable();
        $table->string('create_acl')->nullable();
        $table->integer('read_acl')->nullable();
        $table->integer('update_acl')->nullable();
        $table->integer('delete_acl')->nullable();
        $table->integer('module_parent');
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
        Schema::drop('role_acl');
    }
}
