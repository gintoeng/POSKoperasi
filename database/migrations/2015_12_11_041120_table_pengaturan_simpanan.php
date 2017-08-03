<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TablePengaturanSimpanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_simpanan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 20);
            $table->string('jenis_simpanan', 50);
            $table->decimal('suku_bunga', 5, 2);
            $table->unsignedInteger('sistem_bunga');
            $table->decimal('saldo_minimum_bunga', 20, 2);
            $table->decimal('saldo_minimum', 20, 2);
            $table->decimal('setoran_minimum',20, 2);
            $table->decimal('saldo_minimum_pajak',20, 2);
            $table->decimal('saldo_minimum_shu', 20, 2);
            $table->tinyInteger('menerima_shu');
            $table->decimal('administrasi', 20, 2);
            $table->decimal('persen_pajak', 5, 2);
            $table->unsignedInteger('akun_kas_bank');
            $table->unsignedInteger('akun_setoran');
            $table->unsignedInteger('akun_penarikan');
            $table->unsignedInteger('akun_bunga');
            $table->unsignedInteger('akun_administrasi');
            $table->unsignedInteger('akun_pajak');
            $table->string('kode_awal_rekening', 20);
            $table->tinyInteger('jumlah_digit_rekening');
            $table->string('nomor_akhir_rekening', 10);
            $table->foreign('sistem_bunga')->references('id')->on('sistem_bunga')->onDelete('CASCADE');
            $table->foreign('akun_kas_bank')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_setoran')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_penarikan')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_bunga')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_administrasi')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_pajak')->references('id')->on('perkiraan')->onDelete('CASCADE');
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
        Schema::drop('pengaturan_simpanan');
    }
}
