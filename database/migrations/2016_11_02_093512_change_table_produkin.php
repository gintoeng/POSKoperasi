<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableProdukin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produkin', function (Blueprint $table) {
            $table->dropColumn('barcode');
            $table->dropColumn('nama');
            $table->dropColumn('jumlah');
            $table->dropColumn('tanggal');
            $table->dropColumn('id_koperasi');
            $table->dropColumn('type_masuk');
            $table->dropColumn('pj');
            $table->dropColumn('sub_harga');
        });
        Schema::table('produkin', function (Blueprint $table) {
            $table->string('barcode');
            $table->string('nama');
            $table->string('merk');
            $table->integer('qty');
            $table->decimal('harga',20,2);
            $table->date('tanggal');
            $table->date('expired');
            $table->decimal('sub_harga',20,2);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
