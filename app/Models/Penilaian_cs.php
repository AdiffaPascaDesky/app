<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian_cs extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_unit',
        'nama_nasabah',
        'nomor_handphone',
        'pendapat_tentang_pelayanan_yang_diberikan',
        'pendapat_tentang_kecepatan_transaksi',
        'pendapat_tentang_penjelasan_yang_diberikan',
        'nama_cs',
        'pendapat_tentang_kebersihan',
        'pendapat_tentang_pelayanan_satpam',
        'nama_satpam',
        'diminta_uang_imbalan',
        'nama_pegawai_meminta_imbalan',
        'saran_perbaikan',
        'email',
        'created_at',
    ];
}
