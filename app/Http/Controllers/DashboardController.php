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
        $pendapatcs = '';
        $kecepatancs = '';
        $penjelasancs = '';
        $kebersihancs = '';
        $satpamcs = '';
        $imbalancs = ''; 
        if (($request['filter'] === 'cs' && $request['filter'] !== 'teller') || $request['filter'] === null) {
            $years = Penilaian_cs::selectRaw('YEAR(created_at) as tahun')
                ->distinct()
                ->orderBy('tahun') // Mengurutkan tahun sejak awal pengambilan data
                ->pluck('tahun');

            $defaultCategories = [
                'Sangat Ramah',
                'Ramah',
                'Kurang ramah',
                'Tidak ramah'
            ];
            $pendapatcs = Penilaian_cs::select(
                DB::raw("CASE
        WHEN LOWER(pendapat_tentang_pelayanan_yang_diberikan) LIKE '%sangat ramah%' THEN 'Sangat ramah'
        WHEN LOWER(pendapat_tentang_pelayanan_yang_diberikan) LIKE '%ramah%' THEN 'Ramah'
        WHEN LOWER(pendapat_tentang_pelayanan_yang_diberikan) LIKE '%Kurang ramah%' THEN 'Kurang ramah'
        WHEN LOWER(pendapat_tentang_pelayanan_yang_diberikan) LIKE '%tidak ramah%' THEN 'Tidak ramah'
        ELSE pendapat_tentang_pelayanan_yang_diberikan
    END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            );
            // dd($pendapatcs);
            if ($request['tampilan'] === 'tahun') {
                $pendapatcs->addSelect(DB::raw('YEAR(created_at) as tahun'));
            }
            $pendapatcs->whereNot('created_at', null)
                ->whereNot('pendapat_tentang_pelayanan_yang_diberikan', null);
            if ($request['tampilan'] === 'tahun') {
                $pendapatcs->groupBy('tahun', 'kecepatan');
            } else {
                $pendapatcs->groupBy('kecepatan');

            }
            $pendapatcs = $pendapatcs->get();
            $groupedData = [];
            if ($request['tampilan'] === 'tahun') {

                foreach ($pendapatcs as $item) {
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
            // dd($pendapatcs);
            if ($request['tampilan'] === 'tahun') {
                # code...
                $pendapatcs = collect($result)->sortBy('tahun')->values()->all();
            } else {
                // $pendapatcs = $pendapatcs->groupBy('kecepatan');
                $pendapatcs = $pendapatcs->toArray();
            }
            $defaultCategories = [
                'Sangat Cepat',
                'Cepat',
                'Lambat',
                'Sangat lambat',
            ];
            $kecepatancs = Penilaian_cs::select(
                DB::raw("CASE
                WHEN LOWER(pendapat_tentang_kecepatan_transaksi) LIKE '%sangat cepat%' THEN 'Sangat Cepat'
                WHEN LOWER(pendapat_tentang_kecepatan_transaksi) LIKE '%cepat%' THEN 'Cepat'
                WHEN LOWER(pendapat_tentang_kecepatan_transaksi) LIKE '%lambat%' THEN 'Lambat'
                WHEN LOWER(pendapat_tentang_kecepatan_transaksi) LIKE '%sangat lambat%' THEN 'Sangat lambat'
                ELSE pendapat_tentang_kecepatan_transaksi
                END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            );
            if ($request['tampilan'] === 'tahun') {
                $kecepatancs->addSelect(DB::raw('YEAR(created_at) as tahun'));
            }
            $kecepatancs->whereNot('created_at', null)
                ->whereNot('pendapat_tentang_kecepatan_transaksi', null);
            if ($request['tampilan'] === 'tahun') {
                $kecepatancs->groupBy('tahun', 'kecepatan');
            } else {
                $kecepatancs->groupBy('kecepatan');

            }
            $kecepatancs = $kecepatancs->get();
            $groupedData = [];
            if ($request['tampilan'] === 'tahun') {

                foreach ($kecepatancs as $item) {
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
                $kecepatancs = collect($result)->sortBy('tahun')->values()->all();
            } else {
                // $pendapatcs = $pendapatcs->groupBy('kecepatan');
                $kecepatancs = $kecepatancs->toArray();
            }
            // Hasil akhir yang sudah dikelompokkan
            // dd($kecepatancs); 
            $defaultCategories = [
                'Jelas dan tepat',
                'Jelas tetapi kurang tepat',
                'Jelas tetapi berbelit belit',
                'Jelas tetapi kurang tepat',
                'Tidak jelas',
            ];
            $penjelasancs = Penilaian_cs::select(
                DB::raw("CASE
                WHEN LOWER(pendapat_tentang_penjelasan_yang_diberikan) LIKE '%jelas dan tepat%' THEN 'Jelas dan tepat'
                WHEN LOWER(pendapat_tentang_penjelasan_yang_diberikan) LIKE '%jelas tetapi kurang tepat%' THEN 'Jelas tetapi kurang tepat'
                WHEN LOWER(pendapat_tentang_penjelasan_yang_diberikan) LIKE '%jelas tetapi berbelit belit%' THEN 'Jelas tetapi berbelit belit'
                WHEN LOWER(pendapat_tentang_penjelasan_yang_diberikan) LIKE '%tidak jelas%' THEN 'Tidak jelas'
                ELSE pendapat_tentang_penjelasan_yang_diberikan
                END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            );
            if ($request['tampilan'] === 'tahun') {
                $penjelasancs->addSelect(DB::raw('YEAR(created_at) as tahun'));
            }
            $penjelasancs->whereNot('created_at', null)
                ->whereNot('pendapat_tentang_penjelasan_yang_diberikan', null);
            if ($request['tampilan'] === 'tahun') {
                $penjelasancs->groupBy('tahun', 'kecepatan');
            } else {
                $penjelasancs->groupBy('kecepatan');

            }
            $penjelasancs = $penjelasancs->get();
            $groupedData = [];
            if ($request['tampilan'] === 'tahun') {

                foreach ($penjelasancs as $item) {
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
                $penjelasancs = collect($result)->sortBy('tahun')->values()->all();
            } else {
                // $penjelasancs = $penjelasancs->groupBy('kecepatan');
                $penjelasancs = $penjelasancs->toArray();
            }
            $defaultCategories = [
                'Sangat bersih dan Sangat nyaman',
                'Bersih dan Nyaman',
                'Bersih tetapi kurang nyaman',
                'Kurang bersih dan Tidak nyaman',
            ];
            $kebersihancs = Penilaian_cs::select(
                DB::raw("CASE
                WHEN LOWER(pendapat_tentang_kebersihan) LIKE '%sangat bersih dan sangat nyaman%' THEN 'Sangat bersih dan Sangat nyaman'
                WHEN LOWER(pendapat_tentang_kebersihan) LIKE '%bersih dan nyaman%' THEN 'Bersih dan Nyaman'
                WHEN LOWER(pendapat_tentang_kebersihan) LIKE '%bersih tetapi kurang nyaman%' THEN 'Bersih tetapi kurang nyaman'
                WHEN LOWER(pendapat_tentang_kebersihan) LIKE '%kurang bersih dan tidak nyaman%' THEN 'Kurang bersih dan Tidak nyaman'
                ELSE pendapat_tentang_kebersihan
                END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            );
            if ($request['tampilan'] === 'tahun') {
                $kebersihancs->addSelect(DB::raw('YEAR(created_at) as tahun'));
            }
            $kebersihancs->whereNot('created_at', null)
                ->whereNot('pendapat_tentang_kebersihan', null);
            if ($request['tampilan'] === 'tahun') {
                $kebersihancs->groupBy('tahun', 'kecepatan');
            } else {
                $kebersihancs->groupBy('kecepatan');

            }
            $kebersihancs = $kebersihancs->get();
            $groupedData = [];
            if ($request['tampilan'] === 'tahun') {

                foreach ($kebersihancs as $item) {
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
                $kebersihancs = collect($result)->sortBy('tahun')->values()->all();
            } else {
                // $kebersihancs = $kebersihancs->groupBy('kecepatan');
                $kebersihancs = $kebersihancs->toArray();
            }
            $defaultCategories = [
                'Ramah dan Sigap',
                'Ramah tetapi tidak sigap',
                'Tidak ramah tetapi sigap',
                'Tidak ramah dan Tidak sigap',
            ];
            $satpamcs = Penilaian_cs::select(
                DB::raw("CASE
                WHEN LOWER(pendapat_tentang_pelayanan_satpam) LIKE '%ramah dan sigap%' THEN 'Ramah dan Sigap'
                WHEN LOWER(pendapat_tentang_pelayanan_satpam) LIKE '%ramah tetapi tidak sigap%' THEN 'Ramah tetapi tidak sigap'
                WHEN LOWER(pendapat_tentang_pelayanan_satpam) LIKE '%tidak ramah tetapi sigap%' THEN 'Tidak ramah tetapi Sigap'
                WHEN LOWER(pendapat_tentang_pelayanan_satpam) LIKE '%tidak ramah dan tidak sigap%' THEN 'Tidak ramah dan Tidak sigap'
                ELSE pendapat_tentang_pelayanan_satpam
                END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            );
            if ($request['tampilan'] === 'tahun') {
                $satpamcs->addSelect(DB::raw('YEAR(created_at) as tahun'));
            }
            $satpamcs->whereNot('created_at', null)
                ->whereNot('pendapat_tentang_pelayanan_satpam', null);
            if ($request['tampilan'] === 'tahun') {
                $satpamcs->groupBy('tahun', 'kecepatan');
            } else {
                $satpamcs->groupBy('kecepatan');

            }
            $satpamcs = $satpamcs->get();
            $groupedData = [];
            if ($request['tampilan'] === 'tahun') {

                foreach ($satpamcs as $item) {
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
                $satpamcs = collect($result)->sortBy('tahun')->values()->all();
            } else {
                // $satpamcs = $satpamcs->groupBy('kecepatan');
                $satpamcs = $satpamcs->toArray();
            }
            $defaultCategories = [
                'Ada',
                'Tidak ada',
            ];
            $imbalancs = Penilaian_cs::select(
                DB::raw("CASE
                WHEN LOWER(diminta_uang_imbalan) LIKE '%ada%' THEN 'Ada'
                WHEN LOWER(diminta_uang_imbalan) LIKE '%tidak ada%' THEN 'Tidak ada' 
                ELSE diminta_uang_imbalan
                END as kecepatan"),
                DB::raw('COUNT(*) as jumlah')
            );
            if ($request['tampilan'] === 'tahun') {
                $imbalancs->addSelect(DB::raw('YEAR(created_at) as tahun'));
            }
            $imbalancs->whereNot('created_at', null)
                ->whereNot('diminta_uang_imbalan', null);
            if ($request['tampilan'] === 'tahun') {
                $imbalancs->groupBy('tahun', 'kecepatan');
            } else {
                $imbalancs->groupBy('kecepatan');

            }
            $imbalancs = $imbalancs->get();
            $groupedData = [];
            if ($request['tampilan'] === 'tahun') {

                foreach ($imbalancs as $item) {
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
                $imbalancs = collect($result)->sortBy('tahun')->values()->all();
            } else {
                // $imbalancs = $imbalancs->groupBy('kecepatan');
                $imbalancs = $imbalancs->toArray();
            }
            // dd($imbalancs);
            // Kategori default
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

            if ($request['tampilan'] === 'tahun') {

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
        return view('dashboard', compact('request', 'dimintaimbalan', 'pendapatpelayansatpam', 'kebersihantempat', 'kecepatanteller', 'pelayananteller', 'pendapatcs', 'kecepatancs', 'penjelasancs', 'kebersihancs', 'satpamcs', 'imbalancs'));
    }
}
