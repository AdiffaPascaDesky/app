<?php

namespace App\Http\Controllers;

use App\Imports\PenilaianCsImport;
use App\Models\Penilaian_cs;
use Illuminate\Http\Request;
use App\Models\File;
use Maatwebsite\Excel\Facades\Excel;
class InputController extends Controller
{
    public function penilaiancs(){
        $penilaians = Penilaian_cs::paginate(30);
        return view('pages.formpenilaian.cs', compact('penilaians'));
    }
    public function inputpenilaiancs(){
        return view('pages.formpenilaian.input-cs');
    }
    public function actioninputpenilaiancs(Request $request){
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|unique:files,nama_file|max:2048'
        ]);  
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        if (file_exists('penilaiancs/'.$fileName)) {
            return redirect()->back()->withErrors(['file' => 'File dengan nama yang sama sudah ada di database.']);
        }
        $file->move(public_path('penilaiancs'), $fileName);
        Excel::import(new PenilaianCsImport, 'penilaiancs/'.$fileName);
        File::create([
            'nama_file' => $fileName,
        ]);
        return redirect('/penilaian-cs');
    }
    public function penilaianteller(){
        return view('pages.formpenilaian.teller');
    }
}
