<?php

namespace App\Imports;

use App\Models\Penilaian_cs;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class PenilaianCsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        if (
            is_null($row['nama_unit_kantor_bank_sumut']) &&
            is_null($row['nama_nasabah']) &&
            is_null($row['nomor_handphone_nasabah']) &&
            is_null($row['bagaimana_pendapat_saudarai_tentang_pelayanan_yang_diberikan_customer_service']) &&
            is_null($row['bagaimana_pendapat_saudarai_tentang_kecepatan_transaksi_customer_service']) &&
            is_null($row['bagaimana_pendapat_saudarai_tentang_penjelasan_yang_diberikan_customer_service_tentang_kebutuhan_transaksi_saudarai']) &&
            is_null($row['sebutkan_nama_customer_service_yang_dinilai']) &&
            is_null($row['bagaimana_pendapat_saudarai_tentang_kebersihan_dan_kenyamanan_bank_sumut_tempat_saudara_bertransaksi']) &&
            is_null($row['bagaimana_pendapat_saudarai_tentang_pelayanan_yang_diberikan_satpam_dalam_mengarahkan_anda_untuk_bertransaksi_ke_customer_service']) &&
            is_null($row['sebutkan_nama_satpam_yang_dinilai']) &&
            is_null($row['apakah_dalam_bertransaksi_di_bank_sumut_ini_saudarai_ada_diminta_uang_imbalan_atas_pelayanan_yang_saudarai_dapatkan']) &&
            is_null($row['sebutkan_nama_pegawai_bank_sumut_jika_minta_uang_imbalan_atas_pelayanan_yang_saudarai_dapatkan']) &&
            is_null($row['saran_untuk_perbaikan_layanan_bank_sumut']) &&
            is_null($row['email_address'])
        ) {
            return null; // Tidak menyimpan data ke database
        }
        return new Penilaian_cs([
            'nama_unit' => $row['nama_unit_kantor_bank_sumut'],
            'nama_nasabah' => $row['nama_nasabah'],
            'nomor_handphone' => $row['nomor_handphone_nasabah'],
            'pendapat_tentang_pelayanan_yang_diberikan' => $row['bagaimana_pendapat_saudarai_tentang_pelayanan_yang_diberikan_customer_service'],
            'pendapat_tentang_kecepatan_transaksi' => $row['bagaimana_pendapat_saudarai_tentang_kecepatan_transaksi_customer_service'],
            'pendapat_tentang_penjelasan_yang_diberikan' => $row['bagaimana_pendapat_saudarai_tentang_penjelasan_yang_diberikan_customer_service_tentang_kebutuhan_transaksi_saudarai'],
            'nama_cs' => $row['sebutkan_nama_customer_service_yang_dinilai'],
            'pendapat_tentang_kebersihan' => $row['bagaimana_pendapat_saudarai_tentang_kebersihan_dan_kenyamanan_bank_sumut_tempat_saudara_bertransaksi'],
            'pendapat_tentang_pelayanan_satpam' => $row['bagaimana_pendapat_saudarai_tentang_pelayanan_yang_diberikan_satpam_dalam_mengarahkan_anda_untuk_bertransaksi_ke_customer_service'],
            'nama_satpam' => $row['sebutkan_nama_satpam_yang_dinilai'],
            'diminta_uang_imbalan' => $row['apakah_dalam_bertransaksi_di_bank_sumut_ini_saudarai_ada_diminta_uang_imbalan_atas_pelayanan_yang_saudarai_dapatkan'],
            'nama_pegawai_meminta_imbalan' => $row['sebutkan_nama_pegawai_bank_sumut_jika_minta_uang_imbalan_atas_pelayanan_yang_saudarai_dapatkan'],
            'saran_perbaikan' => $row['saran_untuk_perbaikan_layanan_bank_sumut'],
            'email' => $row['email_address'],
            'created_at' => $this->convertTimestamp($row['timestamp']),
        ]);
    }
    private function convertTimestamp($timestamp)
    {
        try {
            if (is_numeric($timestamp)) {
                // Tambahkan jumlah hari dari basis waktu Excel (1 Januari 1900)
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($timestamp));
            } else {
                // Jika bukan angka, maka coba parsing sebagai tanggal biasa
                return Carbon::createFromFormat('d/m/Y H:i:s', $timestamp);
            }
        } catch (\Exception $e) {
            // Jika gagal, kembalikan null atau tangani sesuai kebutuhan
            return now();
        }
    }
}
