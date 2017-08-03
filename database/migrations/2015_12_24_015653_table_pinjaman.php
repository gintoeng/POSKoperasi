<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablePinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('nama_pinjaman');
            $table->string('nomor_pinjaman', 50);
            $table->unsignedInteger('anggota');
            $table->tinyInteger('sistem_bunga');
            $table->tinyInteger('suku_bunga');
            $table->date('tanggal_pengajuan');
            $table->decimal('jumlah_pengajuan', 20, 2);
            $table->tinyInteger('jangka_waktu');
            $table->date('jatuh_tempo');
            $table->decimal('jumlah_angsuran_pokok', 20, 2);
            $table->enum('perhitungan_bunga', ['bulanan', 'harian']);
            $table->string('digunakan_untuk', 50);
            $table->string('sumber_dana', 50);
            $table->unsignedInteger('kolektibilitas');
            $table->text('keterangan');
            $table->string('status_realisasi', 10);
            $table->string('status_lunas', 10);
            $table->enum('status_pasangan', ['Suami', 'Istri']);
            $table->string('nama_pasangan', 50);
            $table->string('pekerjaan_pasangan', 30);
            $table->string('alamat_pasangan');
            $table->string('nomor_telepon_pasangan', 20);
            $table->string('nama_penjamin', 50);
            $table->string('pekerjaan_penjamin', 30);
            $table->string('alamat_penjamin');
            $table->string('nomor_telepon_penjamin', 20);
            $table->string('nomor_ktp_penjamin', 20);
            $table->foreign('nama_pinjaman')->references('id')->on('pengaturan_pinjaman')->onDelete('CASCADE');
            $table->foreign('anggota')->references('id')->on('anggota')->onDelete('CASCADE');
            $table->foreign('kolektibilitas')->references('id')->on('kolektibilitas')->onDelete('CASCADE');
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
        Schema::drop('pinjaman');
    }
}
