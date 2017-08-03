<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahPostingDijurnalHeaderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jurnal_header', function(Blueprint $table){
            $table->enum('posting', ['0', '1'])->default('0');
        });

        Schema::table('jurnal_detail', function(Blueprint $table){
            $table->enum('posting', ['0', '1'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
