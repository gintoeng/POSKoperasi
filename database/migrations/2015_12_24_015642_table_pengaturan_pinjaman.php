<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TablePengaturanPinjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_pinjaman', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 20);
            $table->string('nama_pinjaman', 50);
            $table->decimal('suku_bunga', 5, 2);
            $table->unsignedInteger('sistem_bunga');
            $table->bigInteger('maksimum_waktu');
            $table->enum('tipe_maksimum_waktu', ['hari', 'bulan']);
            $table->enum('tipe_denda_perhari', ['denda nominal', 'saldo X perser% X hari', 'angsuran X persen% X hari', '']);
            $table->decimal('jumlah_denda_perhari', 20, 2);
            $table->tinyInteger('toleransi_denda');
            $table->unsignedInteger('akun_kas_bank');
            $table->unsignedInteger('akun_realisasi');
            $table->unsignedInteger('akun_angsuran');
            $table->unsignedInteger('akun_bunga');
            $table->unsignedInteger('akun_administrasi');
            $table->unsignedInteger('akun_denda');
            $table->unsignedInteger('biaya_provinsi');
            $table->unsignedInteger('akun_lain_lain');
            $table->unsignedInteger('akun_hapus_pinjaman');
            $table->string('kode_awal_rekening', 20);
            $table->tinyInteger('jumlah_digit_rekening');
            $table->string('nomor_akhir_rekening', 10);
            $table->foreign('sistem_bunga')->references('id')->on('sistem_bunga')->onDelete('CASCADE');
            $table->foreign('akun_kas_bank')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_realisasi')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_angsuran')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_bunga')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_administrasi')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_denda')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('biaya_provinsi')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_lain_lain')->references('id')->on('perkiraan')->onDelete('CASCADE');
            $table->foreign('akun_hapus_pinjaman')->references('id')->on('perkiraan')->onDelete('CASCADE');
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
        Schema::drop('pengaturan_pinjaman');
    }
}
