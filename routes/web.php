<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\GaleriController;
use App\Models\Kelas;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Auth::routes();


Route::get('/', function () {
    return view('index');
});





Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [UserController::class, 'edit'])->name('profile');
    Route::put('/update-profile', [UserController::class, 'update'])->name('update.profile');
    Route::get('/edit-password', [UserController::class, 'editPassword'])->name('ubah-password');
    Route::patch('/update-password', [UserController::class, 'updatePassword'])->name('update-password');
});
Route::group(['middleware' => ['auth', 'checkRole:guru']], function () {
    Route::get('/guru/dashboard', [HomeController::class, 'guru'])->name('guru.dashboard');
    Route::get('/siswa', [GuruController::class, 'GuruController@indexSiswa'])->name('pages.guru.siswa.index');
    Route::resource('materi', MateriController::class);
    Route::resource('tugas', TugasController::class);
    Route::get('/jawaban-download/{id}', [TugasController::class, 'downloadJawaban'])->name('guru.jawaban.download');
});
Route::group(['middleware' => ['auth', 'checkRole:siswa']], function () {
    
    Route::get('/siswa/materi', [MateriController::class, 'siswa'])->name('siswa.materi');
    Route::get('/materi-download/{id}', [MateriController::class, 'download'])->name('siswa.materi.download');
    Route::get('/siswa/tugas', [TugasController::class, 'siswa'])->name('siswa.tugas');
    Route::get('/tugas-download/{id}', [TugasController::class, 'download'])->name('siswa.tugas.download');
    Route::post('/kirim-jawaban', [TugasController::class, 'kirimJawaban'])->name('kirim-jawaban');
});
Route::group(['middleware' => ['auth', 'checkRole:admin']], function () {
    Route::get('/admin/dashboard', [HomeController::class, 'admin'])->name('admin.dashboard');
    Route::resource('mapel', MapelController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('user', UserController::class);
    Route::resource('jadwal', JadwalController::class);

});

Route::get('/hasil-rapor', [RaporController::class, 'index'])->name('hasil.index');
Route::get('/rapor/upload', [RaporController::class, 'showUploadForm'])->name('rapor.showUploadForm');
Route::post('/rapor/upload', [RaporController::class, 'uploadPdf'])->name('rapor.uploadPdf');
Route::get('/upload', [FileUploadController::class, 'create'])->name('upload.create');
;
Route::post('/upload', [FileUploadController::class, 'store']);

Route::get('/download/{file}', [FileUploadController::class, 'download']);
Route::delete('/delete/{file}', [FileUploadController::class, 'destroy']);

Route::get('/rapor', [FileUploadController::class, 'showRapor']);

Route::get('/cetak/{file}', [FileUploadController::class, 'printRapor']);
Route::get('/upload-rapor', [RaporController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload-rapor', [RaporController::class, 'upload'])->name('upload.submit');

Route::get('/siswa/{id}/rapor', [RaporController::class, 'show']);
Route::get('/rapor/{id}', [RaporController::class, 'index'])->name('rapor.index');

//kelas
Route::get('/daftar-kelas', [KelasController::class, 'index'])->name('daftar-siswa.index');
Route::get('/kelas/{id}', [KelasController::class, 'show'])->name('daftar-siswa.show');
Route::resource('daftar-siswa', KelasController::class);
Route::resource('daftar-siswa', KelasController::class);
Route::get('/kelas/create', [KelasController::class, 'createKelas'])->name('kelas.createKelas');
Route::post('/kelas', [KelasController::class, 'storeKelas'])->name('kelas.storeKelas');
Route::delete('/kelas/{id}', [KelasController::class, 'destroyKelas'])->name('kelas.destroyKelas');

Route::get('/kelas/{id}/edit', [KelasController::class, 'editKelas'])->name('kelas.editKelas');
Route::put('/kelas/{id}', [KelasController::class, 'updateKelas'])->name('kelas.updateKelas');

Route::get('/siswa/dashboard', [SiswaController::class, 'dashboardIndex'])->name('siswa.dashboard');

Route::get('/galeri', [GaleriController::class, 'index'])->name('view.galeri');