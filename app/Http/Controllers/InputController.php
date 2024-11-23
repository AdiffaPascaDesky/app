<?php

namespace App\Http\Controllers;

use App\Imports\PenilaianCsImport;
use App\Models\Penilaian_cs;
use Illuminate\Http\Request;
use App\Models\File;
use Maatwebsite\Excel\Facades\Excel;
class InputController extends Controller
{
    public function penilaiancs(Request $request)
    {
        $displayColumns = [
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
        ];
        $filterColumns = [ 
            'pendapat_tentang_pelayanan_yang_diberikan',
            'pendapat_tentang_kecepatan_transaksi',
            'pendapat_tentang_penjelasan_yang_diberikan', 
            'pendapat_tentang_kebersihan',
            'pendapat_tentang_pelayanan_satpam', 
            'diminta_uang_imbalan',  
        ];

        // Retrieve distinct values for filtering columns
        $distinctValues = [];
        foreach ($filterColumns as $column) {
            $distinctValues[$column] = Penilaian_cs::distinct()->pluck($column);
        }

        // Build query with value filters
        $query = Penilaian_cs::query();
        foreach ($filterColumns as $column) {
            if ($request->has($column)) {
                $query->whereIn($column, $request->input($column));
            }
        }

        // Get results
        $penilaian = $query->paginate(50)->appends($request->all());
        return view('pages.formpenilaian.cs', compact('penilaian', 'distinctValues', 'displayColumns', 'filterColumns'));
    }
    public function inputpenilaiancs()
    {
        return view('pages.formpenilaian.input-cs');
    }
    public function actioninputpenilaiancs(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|unique:files,nama_file|max:2048'
        ]);
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        if (file_exists('penilaiancs/' . $fileName)) {
            return redirect()->back()->withErrors(['file' => 'File dengan nama yang sama sudah ada di database.']);
        }
        $file->move(public_path('penilaiancs'), $fileName);
        Excel::import(new PenilaianCsImport, 'penilaiancs/' . $fileName);
        File::create([
            'nama_file' => $fileName,
        ]);
        return redirect('/penilaian-cs');
    }
    public function penilaianteller()
    {
        return view('pages.formpenilaian.teller');
    }
}
