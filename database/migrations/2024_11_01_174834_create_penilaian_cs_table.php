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
        Schema::create('penilaian_cs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_unit')->nullable();
            $table->string('nama_nasabah')->nullable();
            $table->string('nomor_handphone')->nullable();
            $table->text('pendapat_tentang_pelayanan_yang_diberikan')->nullable();
            $table->text('pendapat_tentang_kecepatan_transaksi')->nullable();
            $table->text('pendapat_tentang_penjelasan_yang_diberikan')->nullable();
            $table->string('nama_cs')->nullable();
            $table->text('pendapat_tentang_kebersihan')->nullable();
            $table->text('pendapat_tentang_pelayanan_satpam')->nullable();
            $table->string('nama_satpam')->nullable();
            $table->text('diminta_uang_imbalan')->nullable();
            $table->string('nama_pegawai_meminta_imbalan')->nullable();
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
        Schema::dropIfExists('penilaian_cs');
    }
};
