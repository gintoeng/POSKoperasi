<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $fillable = [
        'cabang',
        'id_bank',
        'nama_akun',
        'nomor_akun',
        'pin',
        'kode',
        'nomor_rekening',
        'nama',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'telepon',
        'account_card',
        'nomor_ktp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'jenis_nasabah',
        'tanggal_registrasi',
        'keterangan',
        'pekerjaan',
        'jabatan',
        'nama_saudara',
        'alamat_saudara',
        'telepon_saudara',
        'hubungan',
        'foto',
        'tanda_tangan',
        'status',
        'saldo',
        'departemen',
        'npk',
        'email',
        'limit_transaksi',
        'kode_rekening'
    ];



    public function simpananid() {
        return $this->hasMany('App\Model\Simpanan\Simpanan', 'anggota');
    }

    public function docid() {
        return $this->hasMany('App\Attach', 'id_anggota');
    }

    public function recabid() {
        return $this->belongsTo('App\Model\Master\Koderecab', 'kode_rekening');
    }

    public function bankid() {
        return $this->belongsTo('App\Model\Master\Bank', 'id_bank');
    }

}
