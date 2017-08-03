<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('modules', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('menu_parent')->nullable();
          $table->string('module_name');
          $table->string('menu_mask');
          $table->string('menu_path');
          $table->string('menu_icon');
          $table->integer('menu_order');
          $table->integer('divider');
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
        Schema::drop('modules');
    }
}
