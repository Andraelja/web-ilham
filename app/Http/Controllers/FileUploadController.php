<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;

class FileUploadController extends Controller
{
    public function create()
    {
        $files = File::all();
        return view('pages.admin.rapor.upload', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'semester' => 'required|in:ganjil,genap',
        ]);

        $fileName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $fileName);

        // Simpan informasi file ke dalam database
        $file = new File();
        $file->file_name = $fileName;
        $file->semester = $request->semester;
        $file->save();

        return back()->with('success', 'File berhasil diunggah.')->with('file', $fileName);
    }

    public function download($file)
    {
        $filePath = public_path('uploads/' . $file);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    }

    public function destroy($file)
    {
        $filePath = public_path('uploads/' . $file);
        if (file_exists($filePath)) {
            // Hapus file dari folder uploads
            unlink($filePath);

            // Hapus informasi file dari database
            File::where('file_name', $file)->delete();

            return back()->with('success', 'File berhasil dihapus.');
        } else {
            return back()->with('error', 'File tidak ditemukan.');
}
}
}