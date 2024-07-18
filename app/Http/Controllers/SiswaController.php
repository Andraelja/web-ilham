<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::orderBy('nama', 'asc')->get();
        $kelas = Kelas::all();
        return view('pages.admin.siswa.index', compact('siswa', 'kelas'));
    }

    public function dashboardIndex()
    {

        $siswa = Siswa::where('nisn', Auth::user()->nisn)->first();
        if (!$siswa) {
            // Handle the case when the student is not found
            return redirect()->route('siswa.dashboard')->with('error', 'Siswa tidak ditemukan.');
        }

        $kelas = Kelas::findOrFail($siswa->kelas_id);
        return view('pages.siswa.dashboard', compact('siswa', 'kelas'));

    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findOrFail($id);
        return view('pages.admin.siswa.profile', compact('siswa'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'nama' => 'required',
            'nis' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kelas_id' => 'required'

        ]);

        if (isset($request->foto)) {
            $file = $request->file('foto');
            $namaFoto = time() . '.' . $file->getClientOriginalExtension();
            $foto = $file->storeAs('images/siswa', $namaFoto, 'public');
        }

        $siswa = new Siswa;
        $siswa->nama = $request->nama;
        $siswa->nis = $request->nis;
        $siswa->telp = $request->telp;
        $siswa->alamat = $request->alamat;
        $siswa->foto = $foto;
        $siswa->kelas_id = $request->kelas_id;
        $siswa->save();


        return redirect()->route('siswa.index')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $kelas = Kelas::all();
        $siswa = Siswa::findOrFail($id);
        return view('pages.admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        if ($request->nis != $siswa->nis) {
            $this->validate($request, [
                'nis' => 'unique:siswas'
            ], [
                'nis.unique' => 'NIS sudah terdaftar',
            ]);
        }

        $siswa->nama = $request->nama;
        $siswa->nis = $request->nis;
        $siswa->telp = $request->telp;
        $siswa->alamat = $request->alamat;
        $siswa->kelas_id = $request->kelas_id;

        if ($request->hasFile('foto')) {
            $lokasi = 'img/siswa/' . $siswa->foto;
            if (File::exists($lokasi)) {
                File::delete($lokasi);
            }
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $tujuanFoto = public_path('/img/siswa');
            $foto->move($tujuanFoto, $namaFoto);
            $siswa->foto = $namaFoto;
        }

        $siswa->update();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diubah');
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $lokasi = 'img/siswa/' . $siswa->foto;
        if (File::exists($lokasi)) {
            File::delete($lokasi);
        }

        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}
