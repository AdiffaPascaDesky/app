<?php

namespace App\Http\Controllers;

use App\Models\Penilaian_cs;
use App\Models\Penilaian_teller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // dd($request['filter'] === null);
        $ada = '';
        $tidak = '';
        $tidakramahtidak = '';
        $tidakramah = '';
        $ramahtidak = '';
        $ramah = '';
        $kecepatantransaksi = '';
        $tidakbersih = '';
        $kurangbersih = '';
        $bersih = '';
        $sangatbersih = '';
        $jelas = '';
        $kurangjelas = '';
        $jelastidaktepat = '';
        $tidakjelas = '';
        $sangatramah = '';
        $kurangramah = '';
        if (($request['filter'] === 'cs' && $request['filter'] !== 'teller') || $request['filter'] === null) {
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
        }

        // dd($kecepatantransaksi);
        // penilaiann teller
        $dimintaimbalan = '';
        $pendapatpelayansatpam = '';
        $kebersihantempat = '';
        $kecepatanteller = '';
        $pelayananteller = '';
        if (($request['filter'] === 'teller' && $request['filter'] !== 'cs') || $request['filter'] === null) {
            $years = Penilaian_teller::selectRaw('YEAR(created_at) as tahun')
                ->distinct()
                ->whereNot('created_at', null)
                ->orderBy('tahun') // Mengurutkan tahun sejak awal pengambilan data
                ->pluck('tahun');
            // dd($years);

            // Kategori default
            $defaultCategories = [
                'Sangat Ramah',
                'Ramah',
                'Kurang Ramah',
                'Tidak Ramah'
            ];

            // Query untuk menghitung jumlah setiap kategori per tahun
            $pelayananteller = Penilaian_teller::select(
                DB::raw("CASE
        WHEN LOWER(pendapat_tentang_pelayanan_teler) LIKE '%sangat ramah%' THEN 'Sangat Ramah'
        WHEN LOWER(pendapat_tentang_pelayanan_teler) LIKE '%ramah%' THEN 'Ramah'
        WHEN LOWER(pendapat_tentang_pelayanan_teler) LIKE '%kurang ramah%' THEN 'Kurang Ramah'
        WHEN LOWER(pendapat_tentang_pelayanan_teler) LIKE '%tidak ramah%' THEN 'Tidak Ramah'
        ELSE pendapat_tentang_pelayanan_teler
    END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            );
            if ($request['tampilan'] === 'tahun') {
                $pelayananteller->addSelect(DB::raw('YEAR(created_at) as tahun'));
            }
            $pelayananteller->whereNot('created_at', null)
                ->whereNot('pendapat_tentang_pelayanan_teler', null);
            if ($request['tampilan'] === 'tahun') {
                $pelayananteller->groupBy('tahun', 'kecepatan');
            } else {
                $pelayananteller->groupBy('kecepatan');

            }
            $pelayananteller = $pelayananteller->get();
            $result = [];
            
            if ($request['tampilan']=== 'tahun') {

                foreach ($pelayananteller as $item) {
                    if (!isset($groupedData[$item->tahun])) {
                        $groupedData[$item->tahun] = [];
                    }
                    $groupedData[$item->tahun][$item->kecepatan] = $item->jumlah;
                }
                // $result = [];
                foreach ($years as $year) {
                    $yearData = ['tahun' => $year, 'data' => []];
                    foreach ($defaultCategories as $category) {
                        $yearData['data'][] = [
                            'kecepatan' => $category,
                            'jumlah' => isset($groupedData[$year][$category]) ? $groupedData[$year][$category] : 0
                        ];
                    }
                    $result[] = $yearData;
                }
            }

            // Hasil akhir yang sudah dikelompokkan
            // dd($pelayananteller);
            if ($request['tampilan'] === 'tahun') {
                # code...
                $pelayananteller = collect($result)->sortBy('tahun')->values()->all();
            } else {
                // $pelayananteller = $pelayananteller->groupBy('kecepatan');
                $pelayananteller = $pelayananteller->toArray();
            }
            $defaultCategories = [
                'Sangat Cepat',
                'Cepat',
                'Lambat',
                'Sangat Lambat'
            ];
            $kecepatanteller = Penilaian_teller::select(
                DB::raw("CASE
        WHEN LOWER(pendapat_tentang_kecepatan_transaksi_teler) LIKE '%sangat cepat%' THEN 'Sangat Cepat'
        WHEN LOWER(pendapat_tentang_kecepatan_transaksi_teler) LIKE '%cepat%' THEN 'Cepat'
        WHEN LOWER(pendapat_tentang_kecepatan_transaksi_teler) LIKE '%lambat%' THEN 'Lambat'
        WHEN LOWER(pendapat_tentang_kecepatan_transaksi_teler) LIKE '%sangat lambat%' THEN 'Sangat Lambat'
        ELSE pendapat_tentang_kecepatan_transaksi_teler
    END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            );
            if ($request['tampilan'] === 'tahun') {
                $kecepatanteller->addSelect(DB::raw('YEAR(created_at) as tahun'));
            }
            $kecepatanteller->whereNot('created_at', null)
                ->whereNot('pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi', null);
            if ($request['tampilan'] === 'tahun') {
                $kecepatanteller->groupBy('tahun', 'kecepatan');
            } else {
                $kecepatanteller->groupBy('kecepatan');

            }
            $kecepatanteller = $kecepatanteller->get();
            $groupedData = [];
            if ($request['tampilan'] === 'tahun') {

                foreach ($kecepatanteller as $item) {
                    if (!isset($groupedData[$item->tahun])) {
                        $groupedData[$item->tahun] = [];
                    }
                    $groupedData[$item->tahun][$item->kecepatan] = $item->jumlah;
                }
                $result = [];
                foreach ($years as $year) {
                    $yearData = ['tahun' => $year, 'data' => []];
                    foreach ($defaultCategories as $category) {
                        $yearData['data'][] = [
                            'kecepatan' => $category,
                            'jumlah' => isset($groupedData[$year][$category]) ? $groupedData[$year][$category] : 0
                        ];
                    }
                    $result[] = $yearData;
                }
            }

            // Hasil akhir yang sudah dikelompokkan
            // dd($kecepatanteller);
            if ($request['tampilan'] === 'tahun') {
                # code...
                $kecepatanteller = collect($result)->sortBy('tahun')->values()->all();
            } else {
                // $kecepatanteller = $kecepatanteller->groupBy('kecepatan');
                $kecepatanteller = $kecepatanteller->toArray();
            }
            $defaultCategories = [
                'Sangat bersih dan Sangat Nyaman',
                'Bersih dan Nyaman',
                'Kurang bersih',
                'Bersih tetapi kurang nyaman',
                'Kurang bersih dan tidak nyaman',
            ];
            $kebersihantempat = Penilaian_teller::select(
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw("CASE
        WHEN LOWER(pendapat_kebersihan_dan_kenyamanan_tempat) LIKE '%sangat bersih dan sangat nyaman%' THEN 'Sangat bersih dan Sangat Nyaman'
        WHEN LOWER(pendapat_kebersihan_dan_kenyamanan_tempat) LIKE '%bersih dan nyaman%' THEN 'Bersih dan Nyaman'
        WHEN LOWER(pendapat_kebersihan_dan_kenyamanan_tempat) LIKE '%kurang bersih%' THEN 'Kurang Bersih'
        WHEN LOWER(pendapat_kebersihan_dan_kenyamanan_tempat) LIKE '%bersih tetapi kurang nyaman%' THEN 'Bersih tetapi kurang nyaman'
        WHEN LOWER(pendapat_kebersihan_dan_kenyamanan_tempat) LIKE '%Kurang bersih dan tidak nyaman%' THEN 'Kurang bersih dan tidak nyaman'
        ELSE pendapat_kebersihan_dan_kenyamanan_tempat
    END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            )
                ->whereNot('created_at', null)
                ->whereNot('pendapat_kebersihan_dan_kenyamanan_tempat', null)
                ->groupBy('tahun', 'kecepatan')
                ->get();
            $groupedData = [];
            foreach ($kebersihantempat as $item) {
                if (!isset($groupedData[$item->tahun])) {
                    $groupedData[$item->tahun] = [];
                }
                $groupedData[$item->tahun][$item->kecepatan] = $item->jumlah;
            }
            // dd($kebersihantempat);
            $result = [];
            foreach ($years as $year) {
                $yearData = ['tahun' => $year, 'data' => []];
                foreach ($defaultCategories as $category) {
                    $yearData['data'][] = [
                        'kecepatan' => $category,
                        'jumlah' => isset($groupedData[$year][$category]) ? $groupedData[$year][$category] : 0
                    ];
                }
                $result[] = $yearData;
            }

            // Hasil akhir yang sudah dikelompokkan
            $kebersihantempat = collect($result)->sortBy('tahun')->values()->all();
            $defaultCategories = [
                'Ramah dan sigap',
                'Ramah tetapi tidak sigap',
                'Tidak ramah tetapi sigap',
                'Tidak ramah dan Tidak sigap',
            ];
            $pendapatpelayansatpam = Penilaian_teller::select(



                DB::raw("CASE
        WHEN LOWER(pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi) LIKE '%ramah dan sigap%' THEN 'Ramah dan sigap'
        WHEN LOWER(pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi) LIKE '%ramah tetapi tidak sigap%' THEN 'Ramah tetapi tidak sigap'
        WHEN LOWER(pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi) LIKE '%tidak ramah tetapi sigap%' THEN 'Tidak ramah tetapi sigap'
        WHEN LOWER(pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi) LIKE '%tidak ramah dan tidak sigap%' THEN 'Tidak ramah dan Tidak sigap' 
        ELSE pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi
    END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            );
            if ($request['tampilan'] === 'tahun') {
                $pendapatpelayansatpam->addSelect(DB::raw('YEAR(created_at) as tahun'));
            }
            $pendapatpelayansatpam->whereNot('created_at', null)
                ->whereNot('pendapat_tentang_pelayanan_satpam_mengarahkan_untuk_transaksi', null);
            if ($request['tampilan'] === 'tahun') {
                $pendapatpelayansatpam->groupBy('tahun', 'kecepatan');
            } else {
                $pendapatpelayansatpam->groupBy('kecepatan');

            }
            $pendapatpelayansatpam = $pendapatpelayansatpam->get();
            $groupedData = [];
            if ($request['tampilan'] === 'tahun') {

                foreach ($pendapatpelayansatpam as $item) {
                    if (!isset($groupedData[$item->tahun])) {
                        $groupedData[$item->tahun] = [];
                    }
                    $groupedData[$item->tahun][$item->kecepatan] = $item->jumlah;
                }
                $result = [];
                foreach ($years as $year) {
                    $yearData = ['tahun' => $year, 'data' => []];
                    foreach ($defaultCategories as $category) {
                        $yearData['data'][] = [
                            'kecepatan' => $category,
                            'jumlah' => isset($groupedData[$year][$category]) ? $groupedData[$year][$category] : 0
                        ];
                    }
                    $result[] = $yearData;
                }
            }

            // Hasil akhir yang sudah dikelompokkan
            // dd($pendapatpelayansatpam);
            if ($request['tampilan'] === 'tahun') {
                # code...
                $pendapatpelayansatpam = collect($result)->sortBy('tahun')->values()->all();
            } else {
                // $pendapatpelayansatpam = $pendapatpelayansatpam->groupBy('kecepatan');
                $pendapatpelayansatpam = $pendapatpelayansatpam->toArray();
            }
            // dd($pendapatpelayansatpam);
            $defaultCategories = [
                'Tidak ada',
                'ada',
            ];
            $dimintaimbalan = Penilaian_teller::select(
                DB::raw("CASE
        WHEN LOWER(apakah_diminta_imbalan) LIKE '%tidak ada%' THEN 'Tidak ada'
        WHEN LOWER(apakah_diminta_imbalan) LIKE '%ada%' THEN 'Ada' 
        ELSE apakah_diminta_imbalan
    END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            );
            if ($request['tampilan'] === 'tahun') {
                $dimintaimbalan->addSelect(DB::raw('YEAR(created_at) as tahun'));
            }
            $dimintaimbalan->whereNot('created_at', null)
                ->whereNot('apakah_diminta_imbalan', null);
            if ($request['tampilan'] === 'tahun') {
                $dimintaimbalan->groupBy('tahun', 'kecepatan');
            } else {
                $dimintaimbalan->groupBy('kecepatan');

            }
            $dimintaimbalan = $dimintaimbalan->get();

            $groupedData = [];
            if ($request['tampilan'] === 'tahun') {

                foreach ($dimintaimbalan as $item) {
                    if (!isset($groupedData[$item->tahun])) {
                        $groupedData[$item->tahun] = [];
                    }
                    $groupedData[$item->tahun][$item->kecepatan] = $item->jumlah;
                }
                $result = [];
                foreach ($years as $year) {
                    $yearData = ['tahun' => $year, 'data' => []];
                    foreach ($defaultCategories as $category) {
                        $yearData['data'][] = [
                            'kecepatan' => $category,
                            'jumlah' => isset($groupedData[$year][$category]) ? $groupedData[$year][$category] : 0
                        ];
                    }
                    $result[] = $yearData;
                }
            }
            if ($request['tampilan'] === 'tahun') {
                # code...
                $dimintaimbalan = collect($result)->sortBy('tahun')->values()->all();
            } else {
                // $pendapatpelayansatpam = $pendapatpelayansatpam->groupBy('kecepatan');
                $dimintaimbalan = $dimintaimbalan->toArray();
            }
        }

        // dd($dimintaimbalan);
        return view('dashboard', compact('request', 'dimintaimbalan', 'pendapatpelayansatpam', 'kebersihantempat', 'kecepatanteller', 'pelayananteller', 'ada', 'tidak', 'tidakramahtidak', 'tidakramah', 'ramahtidak', 'ramah', 'kecepatantransaksi', 'tidakbersih', 'kurangbersih', 'bersih', 'sangatbersih', 'ramah', 'jelas', 'kurangjelas', 'jelastidaktepat', 'tidakjelas', 'sangatramah', 'tidakramah', 'kurangramah', 'kecepatantransaksi'));
    }
}
