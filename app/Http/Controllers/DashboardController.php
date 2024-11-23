<?php

namespace App\Http\Controllers;

use App\Models\Penilaian_cs;
use Illuminate\Http\Request;
use DB;
class DashboardController extends Controller
{
    public function index()
    {
        $ramah = Penilaian_cs::select('pendapat_tentang_pelayanan_yang_diberikan')->where('pendapat_tentang_pelayanan_yang_diberikan', 'Ramah')->orWhere('pendapat_tentang_pelayanan_yang_diberikan', 'c. Ramah')->count();
        $sangatramah = Penilaian_cs::select('pendapat_tentang_pelayanan_yang_diberikan')->where('pendapat_tentang_pelayanan_yang_diberikan', 'Sangat Ramah')->orWhere('pendapat_tentang_pelayanan_yang_diberikan', 'd. Sangat Ramah')->count();
        $tidakramah = Penilaian_cs::select('pendapat_tentang_pelayanan_yang_diberikan')->where('pendapat_tentang_pelayanan_yang_diberikan', 'Tidak Ramah')->orWhere('pendapat_tentang_pelayanan_yang_diberikan', 'a. Tidak Ramah')->count();
        $kurangramah = Penilaian_cs::select('pendapat_tentang_pelayanan_yang_diberikan')->where('pendapat_tentang_pelayanan_yang_diberikan', 'Kurang Ramah')->orWhere('pendapat_tentang_pelayanan_yang_diberikan', 'b. Kurang Ramah')->count();
        $jelas = Penilaian_cs::select('pendapat_tentang_penjelasan_yang_diberikan')->where('pendapat_tentang_penjelasan_yang_diberikan', 'Jelas dan tepat')->orWhere('pendapat_tentang_penjelasan_yang_diberikan', 'd. Jelas dan tepat')->count();
        $kurangjelas = Penilaian_cs::select('pendapat_tentang_penjelasan_yang_diberikan')->where('pendapat_tentang_penjelasan_yang_diberikan', 'Kurang jelas')->orWhere('pendapat_tentang_penjelasan_yang_diberikan', 'b. Kurang jelas')->count();
        $jelastidaktepat = Penilaian_cs::select('pendapat_tentang_penjelasan_yang_diberikan')->where('pendapat_tentang_penjelasan_yang_diberikan', 'Jelas tetapi kurang tepat')->orWhere('pendapat_tentang_penjelasan_yang_diberikan', 'c. Jelas tetapi kurang tepat')->count();
        $tidakjelas = Penilaian_cs::select('pendapat_tentang_penjelasan_yang_diberikan')->where('pendapat_tentang_penjelasan_yang_diberikan', 'Tidak jelas')->orWhere('pendapat_tentang_penjelasan_yang_diberikan', 'a. Tidak jelas')->count();

        $years = Penilaian_cs::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun') // Mengurutkan tahun sejak awal pengambilan data
            ->pluck('tahun');

        // Kategori default
        $defaultCategories = [
            'Sangat Lambat',
            'Lambat',
            'Cepat'
        ];

        // Query untuk menghitung jumlah setiap kategori per tahun
        $data = Penilaian_cs::select(
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw("CASE
        WHEN LOWER(pendapat_tentang_kecepatan_transaksi) LIKE '%sangat lambat%' THEN 'Sangat Lambat'
        WHEN LOWER(pendapat_tentang_kecepatan_transaksi) LIKE '%lambat%' THEN 'Lambat'
        WHEN LOWER(pendapat_tentang_kecepatan_transaksi) LIKE '%cepat%' THEN 'Cepat'
        ELSE pendapat_tentang_kecepatan_transaksi
    END as kecepatan"),
            DB::raw('COUNT(*) as jumlah')
        )
            ->groupBy('tahun', 'kecepatan')
            ->get();

        // Atur data dalam format yang diinginkan
        $result = [];
        foreach ($years as $year) {
            foreach ($defaultCategories as $category) {
                $filtered = $data->first(function ($item) use ($year, $category) {
                    return $item->tahun == $year && $item->kecepatan == $category;
                });

                // Jika data ditemukan, ambil jumlahnya; jika tidak, setel ke 0
                $result[] = [
                    'tahun' => $year,
                    'kecepatan' => $category,
                    'jumlah' => $filtered ? $filtered->jumlah : 0
                ];
            }
        }
        $kecepatantransaksi = collect($result)->sortBy('tahun')->values()->all();
        $tidakbersih = Penilaian_cs::select('pendapat_tentang_kebersihan')->where('pendapat_tentang_kebersihan', 'Tidak Bersih dan Tidak Nyaman')->orWhere('pendapat_tentang_kebersihan', 'a. Tidak Bersih dan Tidak Nyaman')->count();
        $kurangbersih = Penilaian_cs::select('pendapat_tentang_kebersihan')->where('pendapat_tentang_kebersihan', 'Kurang Bersih dan Tidak Nyaman')->orWhere('pendapat_tentang_kebersihan', 'b. Kurang Bersih dan Tidak Nyaman')->count();
        $bersih = Penilaian_cs::select('pendapat_tentang_kebersihan')->where('pendapat_tentang_kebersihan', 'Bersih dan Nyaman')->orWhere('pendapat_tentang_kebersihan', 'c. Bersih dan Nyaman')->count();
        $sangatbersih = Penilaian_cs::select('pendapat_tentang_kebersihan')->where('pendapat_tentang_kebersihan', 'Sangat Bersih dan Sangat Nyaman')->orWhere('pendapat_tentang_kebersihan', 'd. Sangat Bersih dan Sangat nyaman')->orWhere('pendapat_tentang_kebersihan', 'd. Sangat Bersih dan Tidak nyaman')->count();
        $tidakramahtidak = Penilaian_cs::select('pendapat_tentang_pelayanan_satpam')->where('pendapat_tentang_pelayanan_satpam', 'Tidak ramah dan Tidak sigap')->orWhere('pendapat_tentang_pelayanan_satpam', 'a. Tidak ramah dan Tidak sigap')->count();
        $tidakramah = Penilaian_cs::select('pendapat_tentang_pelayanan_satpam')->where('pendapat_tentang_pelayanan_satpam', 'Tidak ramah tetapi sigap')->orWhere('pendapat_tentang_pelayanan_satpam', 'b. Tidak ramah tetapi sigap')->count();
        $ramahtidak = Penilaian_cs::select('pendapat_tentang_pelayanan_satpam')->where('pendapat_tentang_pelayanan_satpam', 'Ramah tetapi tidak sigap')->orWhere('pendapat_tentang_pelayanan_satpam', 'c. Ramah tetapi tidak sigap')->count();
        $ramah = Penilaian_cs::select('pendapat_tentang_pelayanan_satpam')->where('pendapat_tentang_pelayanan_satpam', 'Ramah dan sigap')->orWhere('pendapat_tentang_pelayanan_satpam', 'd. Ramah dan sigap')->count();
        $ada = Penilaian_cs::select('diminta_uang_imbalan')->where('diminta_uang_imbalan', 'Ada')->orWhere('diminta_uang_imbalan', 'b. Ada')->count();
        $tidak = Penilaian_cs::select('diminta_uang_imbalan')->where('diminta_uang_imbalan', 'Tidak ada')->orWhere('pendapat_tentang_pelayanan_satpam', 'a. Tidak ada')->count();
        // dd($kecepatantransaksi);
        return view('dashboard', compact('ada','tidak','tidakramahtidak','tidakramah','ramahtidak','ramah','kecepatantransaksi','tidakbersih', 'kurangbersih', 'bersih', 'sangatbersih','ramah','jelas','kurangjelas','jelastidaktepat','tidakjelas', 'sangatramah', 'tidakramah', 'kurangramah', 'kecepatantransaksi'));
    }
}
