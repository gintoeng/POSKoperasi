<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableAset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyusutan_aset', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_aset');
            $table->string('nama_aset');
            $table->decimal('nominal_harga', 20, 2);
            $table->decimal('penyusutan', 20, 2);
            $table->integer('bulan');
            $table->tinyInteger('status');
            $table->unsignedInteger('akun_kas');
            $table->unsignedInteger('akun_aset');
            $table->unsignedInteger('akun_biaya_penyusutan');
            $table->unsignedInteger('akun_akumulasi_penyusutan');
            $table->unsignedInteger('akun_keuntungan_aset');
            $table->unsignedInteger('akun_kerugian_aset');
            $table->foreign('akun_kas')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_aset')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_biaya_penyusutan')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_akumulasi_penyusutan')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_keuntungan_aset')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_kerugian_aset')->references('id')->on('perkiraan')->onDelete('CASCADE');
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
        Schema::drop('penyusutan_aset');
    }
}
