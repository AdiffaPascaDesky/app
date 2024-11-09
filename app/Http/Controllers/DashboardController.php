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
        // dd($kecepatantransaksi);
        return view('dashboard', compact('ramah','jelas','kurangjelas','jelastidaktepat','tidakjelas', 'sangatramah', 'tidakramah', 'kurangramah', 'kecepatantransaksi'));
    }
}
