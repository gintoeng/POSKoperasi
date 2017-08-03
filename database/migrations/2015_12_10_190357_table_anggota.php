<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('pin');
            $table->string('kode', 20);
            $table->string('nik', 20)->nullable();
            $table->string('nama', 50)->nullable();
            $table->string('alamat')->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('provinsi', 50)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('account_card', 20)->nullable();
            $table->bigInteger('nomor_ktp');
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('jenis_nasabah', 20)->nullable();
            $table->date('tanggal_registrasi')->nullable();
            $table->text('keterangan');
            $table->string('pekerjaan', 20)->nullable();
            $table->string('jabatan', 20)->nullable();
            $table->string('nama_saudara', 50)->nullable();
            $table->string('alamat_saudara')->nullable();
            $table->string('telepon_saudara', 20)->nullable();
            $table->string('hubungan', 20)->nullable();
            $table->string('foto');
            $table->string('tanda_tangan', 50)->nullable();
            $table->tinyInteger('status');
            $table->double('saldo', 12, 2);
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
        Schema::drop('anggota');
    }
}
