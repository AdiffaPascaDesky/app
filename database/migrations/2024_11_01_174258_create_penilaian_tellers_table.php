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
            $table->string('nama_unit')->nullable();
            $table->string('nama_nasabah')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->text('pendapat_tentang_pelayanan_teler')->nullable();
            $table->text('pendapat_tentang_kecepatan_transaksi_teler')->nullable();
            $table->text('nama_petugas_teler')->nullable();
            $table->text('pendapat_kebersihan_dan_kenyamanan_tempat')->nullable();
            $table->text('pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi')->nullable();
            $table->text('nama_satpam')->nullable();
            $table->text('apakah_diminta_imbalan')->nullable();
            $table->text('nama_pegawai_yang_meminta')->nullable();
            $table->text('saran_perbaikan')->nullable();
            $table->string('email')->nullable();
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
