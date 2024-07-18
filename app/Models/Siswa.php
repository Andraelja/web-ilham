<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'kelas_id',
        'nama',
        'nipd',
        'jenis_kelamin',
        'nisn',
        'foto'
    ];

    public $timestamps = true;

    public function rapor()
    {
        return $this->hasMany(Rapor::class, 'nama', 'nama');
    }

    
}