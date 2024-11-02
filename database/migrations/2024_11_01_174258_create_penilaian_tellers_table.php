<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penilaian_tellers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_unit');
            $table->string('nama_nasabah');
            $table->string('nomor_telepon');
            $table->string('pendapat_tentang_pelayanan_teler');
            $table->string('pendapat_tentang_kecepatan_transaksi_teler');
            $table->string('nama_petugas_teler');
            $table->string('pendapat_kebersihan_dan_kenyamanan_tempat');
            $table->string('pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi');
            $table->string('nama_satpam');
            $table->string('apakah_diminta_imbalan');
            $table->string('nama_pegawai_yang_meminta');
            $table->string('saran_perbaikan');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_tellers');
    }
};
