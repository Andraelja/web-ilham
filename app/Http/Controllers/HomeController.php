<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Siswa;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $siswa = Siswa::orderBy('nama', 'asc')->get();
        $kelas = Kelas::all();
        return view('home', compact('siswa', 'kelas'));
    }

    public function admin()
    {
        $siswa = Siswa::count();
        $guru = Guru::count();
        $kelas = Kelas::count();
        $mapel = Mapel::count();
        $siswaBaru = Siswa::orderByDesc('id')->take(5)->orderBy('id')->first();

        return view('pages.admin.dashboard', compact('siswa', 'guru', 'kelas', 'mapel', 'siswaBaru'));
    }

    public function guru()
    {
        $siswaDashboard = Siswa::count();
        $guruDashboard = Guru::count();
        $guru = Guru::where('user_id', Auth::user()->id)->first();
        $materi = Materi::where('guru_id', $guru->id)->count();
        $jadwal = Jadwal::where('mapel_id', $guru->mapel_id)->get();
        $tugas = Tugas::where('guru_id', $guru->id)->count();
        $siswa = Siswa::where('nisn', $guru->nis)->get();
        $kelas = Kelas::count();
        $hari = Carbon::now()->locale('id')->isoFormat('dddd');

        return view('pages.guru.dashboard', compact('guru', 'materi', 'jadwal', 'hari', 'tugas', 'siswa', 'kelas', 'guruDashboard', 'siswaDashboard'));
    }

    public function siswa()
    {
        $siswa = Siswa::where('nisn', Auth::user()->nisn)->first();
        return view('pages.siswa.dashboard', compact('siswa'));
    }


}
