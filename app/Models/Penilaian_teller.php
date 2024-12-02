<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian_teller extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_unit',
        'nama_nasabah',
        'nomor_telepon',
        'pendapat_tentang_pelayanan_teler',
        'pendapat_tentang_kecepatan_transaksi_teler',
        'nama_petugas_teler',
        'pendapat_kebersihan_dan_kenyamanan_tempat',
        'pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi',
        'nama_satpam',
        'apakah_diminta_imbalan',
        'nama_pegawai_yang_meminta',
        'saran_perbaikan',
        'email',
        'created_at',

    ];
}
