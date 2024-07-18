<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $siswa = Siswa::all();
        return view('pages.admin.kelas.index', compact('kelas', 'siswa'));
    }

    public function show($id)
    {
        // Mengambil siswa berdasarkan kelas
        $siswa = Siswa::where('kelas_id', $id)->get();
        $kelas = Kelas::find($id); // Mengambil kelas yang dipilih
        return view('pages.admin.kelas.daftar-siswa', compact('kelas', 'siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::find($id);
        $kelas = Kelas::all();
        return view('pages.admin.kelas.edit-siswa', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipd' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'nisn' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa = Siswa::find($id);
        $siswa->update($request->all());
        return redirect()->route('daftar-siswa.show', $siswa->kelas_id)->with('success', 'Siswa berhasil diperbarui');
    }


    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete();
        return redirect()->route('daftar-siswa.show', $siswa->kelas_id)->with('success', 'Siswa berhasil dihapus');
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('pages.admin.kelas.tambah-siswa', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipd' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'nisn' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',

        ]);

        Siswa::create($request->all());
        return redirect()->route('daftar-siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    public function createKelas()
    {
        return view('pages.admin.kelas.tambah-kelas');
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string|max:255',
        ]);

        $kelas = new Kelas;
        $kelas->kelas = $request->kelas;
        $kelas->save();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    

    public function destroyKelas($id)
    {
        // Temukan kelas berdasarkan ID dan hapus
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        // Redirect atau beri respons sesuai kebutuhan
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function editKelas($id)
    {
        $kelas = Kelas::findOrFail($id); // Temukan data kelas berdasarkan ID
        return view('pages.admin.kelas.edit', compact('kelas')); // Kirim data ke view
    }

    // Mengupdate data kelas
    public function updateKelas(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('kelas.edit', $id)
                             ->withErrors($validator)
                             ->withInput();
        }

        // Temukan kelas berdasarkan ID
        $kelas = Kelas::findOrFail($id);

        // Update data kelas
        $kelas->nama_kelas = $request->input('nama_kelas');
        $kelas->save();

        // Redirect dengan pesan sukses
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }
}
