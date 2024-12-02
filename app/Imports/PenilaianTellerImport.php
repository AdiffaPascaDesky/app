<?php

namespace App\Imports;
use App\Models\Penilaian_teller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class PenilaianTellerImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        // dd($this->convertTimestamp($row['timestamp']));
        if (
            is_null($row['nama_unit_kantor_bank_sumut']) &&
            is_null($row['nama_nasabah']) &&
            is_null($row['nomor_handphone_nasabah']) &&
            is_null($row['bagaimana_pendapat_saudarai_tentang_pelayanan_yang_diberikan_teller']) &&
            is_null($row['bagaimana_pendapat_saudarai_tentang_kecepatan_transaksi_teller']) &&
            is_null($row['sebutkan_nama_petugas_teller_bank_sumut_yang_dinilai']) &&
            is_null($row['bagaimana_pendapat_saudarai_tentang_kebersihan_dan_kenyamanan_bank_sumut_tempat_saudara_bertransaksi']) &&
            is_null($row['bagaimana_pendapat_saudarai_tentang_pelayanan_yang_diberikan_satpam_dalam_mengarahkan_anda_untuk_bertransaksi_ke_teller']) &&
            is_null($row['sebutkan_nama_satpam_yang_dinilai']) &&
            is_null($row['apakah_dalam_bertransaksi_di_bank_sumut_ini_saudarai_ada_diminta_uang_imbalan_atas_pelayanan_yang_saudarai_dapatkan']) &&
            is_null($row['sebutkan_nama_pegawai_bank_sumut_jika_minta_uang_imbalan_atas_pelayanan_yang_saudarai_dapatkan']) &&
            is_null($row['saran_untuk_perbaikan_layanan_bank_sumut']) &&
            is_null($row['email_address'])
        ) {
            return null; // Tidak menyimpan data ke database
        }
        return new Penilaian_teller([
            'nama_unit' => $row['nama_unit_kantor_bank_sumut'],
            'nama_nasabah' => $row['nama_nasabah'],
            'nomor_telepon' => $row['nomor_handphone_nasabah'],
            'pendapat_tentang_pelayanan_teler' => $row['bagaimana_pendapat_saudarai_tentang_pelayanan_yang_diberikan_teller'],
            'pendapat_tentang_kecepatan_transaksi_teler' => $row['bagaimana_pendapat_saudarai_tentang_kecepatan_transaksi_teller'],
            'nama_petugas_teler' => $row['sebutkan_nama_petugas_teller_bank_sumut_yang_dinilai'],
            'pendapat_kebersihan_dan_kenyamanan_tempat' => $row['bagaimana_pendapat_saudarai_tentang_kebersihan_dan_kenyamanan_bank_sumut_tempat_saudara_bertransaksi'],
            'pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi' => $row['bagaimana_pendapat_saudarai_tentang_pelayanan_yang_diberikan_satpam_dalam_mengarahkan_anda_untuk_bertransaksi_ke_teller'],
            'nama_satpam' => $row['sebutkan_nama_satpam_yang_dinilai'],
            'apakah_diminta_imbalan' => $row['apakah_dalam_bertransaksi_di_bank_sumut_ini_saudarai_ada_diminta_uang_imbalan_atas_pelayanan_yang_saudarai_dapatkan'],
            'nama_pegawai_yang_meminta' => $row['sebutkan_nama_pegawai_bank_sumut_jika_minta_uang_imbalan_atas_pelayanan_yang_saudarai_dapatkan'],
            'saran_perbaikan' => $row['saran_untuk_perbaikan_layanan_bank_sumut'],
            'email' => $row['email_address'],
            'created_at' => $this->convertTimestamp($row['timestamp']),
        ]);

    }
    private function convertTimestamp($timestamp)
    {
        try {
            if (is_numeric($timestamp)) {
                // Jika timestamp berupa angka, gunakan konversi dari PhpSpreadsheet
                return Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($timestamp)
                );
            } elseif (is_string($timestamp)) {
                // Jika timestamp berupa string, coba beberapa format umum
                $formats = ['d/m/Y H:i:s', 'Y-m-d H:i:s', 'd/m/Y', 'Y-m-d'];
                foreach ($formats as $format) {
                    $date = Carbon::createFromFormat($format, $timestamp, 'UTC');
                    if ($date !== false) {
                        return $date;
                    }
                }
            }
        } catch (\Exception $e) {
            // Jika gagal, kembalikan null atau tangani sesuai kebutuhan
            return now();
        }
    }

}
