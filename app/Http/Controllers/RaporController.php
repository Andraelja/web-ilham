<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Models\Rapor;
use App\Models\Siswa;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class RaporController extends Controller
{
    public function index()
    {
        $rapors = Rapor::all(); // Mengambil semua data rapor
        $files = File::all();
        return view('pages.admin.rapor.upload', compact('rapors', 'files')); // Mengirim data ke view
    }

    public function siswa()
    {
        $rapors = Rapor::with('siswa')->get(); // Mengambil semua data rapor beserta data siswa
        return view('pages.admin.rapor.hasil', compact('rapors')); // Mengirim data ke view
    }
    public function upload()
    {
        $rapors = Rapor::all(); // Mengambil semua data rapor
        return view('pages.admin.rapor.upload', compact('rapors')); // Mengirim data ke view
    }

    public function show($id)
    {
        $siswa = Siswa::with('nama')->findOrFail($id);
        $rapors = Rapor::select('semester')->distinct()->get(); // Mengambil data rapor

        return view('siswa.show', compact('siswa', 'rapors'));
    }

    public function showSiswa($id)
    {
        $rapor = Rapor::with('siswa')->findOrFail($id);
        return view('pages.admin.rapor.hasil', compact('rapor'));
    }

    public function generatePdf($id)
    {
        $rapor = Rapor::with('siswa')->findOrFail($id);

        if (!$rapor) {
            return redirect()->back()->withErrors(['error' => 'Rapor not found']);
        }

        $dompdf = new Dompdf();
        $html = view('admin.rapor.pdf', compact('rapor'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('rapor.pdf');
    }

    public function showUploadForm()
    {
        $rapors = Rapor::orderBy('nama')->get();
        return view('pages.admin.rapor.upload', compact('rapors'));
    }

    public function uploadPdf(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'tahun_ajaran' => 'required|string|max:9', // Adjust length if needed
            'semester' => 'required|string',
            'nip_nisn' => 'required|string',
            'rapor_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->file('rapor_pdf')) {
            $file = $request->file('rapor_pdf');
            $filePath = $file->store('rapors', 'public');
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getClientMimeType();
            $fileSize = $file->getSize();

            $rapor = new Rapor();
            $rapor->nama = $request->input('nama');
            $rapor->tahun_ajaran = $request->input('tahun_ajaran');
            $rapor->semester = $request->input('semester');
            $rapor->nip_nisn = $request->input('nip_nisn');
            $rapor->file_path = $filePath;
            $rapor->file_name = $fileName;
            $rapor->file_type = $fileType;
            $rapor->file_size = $fileSize;
            $rapor->save();

            return redirect()->route('rapor.showUploadForm')
                ->with('success', 'File uploaded successfully.')
                ->with('file_path', $filePath);
        }

        return redirect()->route('rapor.showUploadForm')->with('error', 'File upload failed.');
    }
}
